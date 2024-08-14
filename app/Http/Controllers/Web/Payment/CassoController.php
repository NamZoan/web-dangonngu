<?php

namespace App\Http\Controllers\Web\Payment;

use App\Http\Controllers\Web\FontEndController;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Pusher\Pusher;

class CassoController extends FontEndController
{
    public function bank()
    {
        $locale = app()->getLocale();
        // get session orderId
        $orderId = session('orderId');
        if (!$orderId) {
            return redirect(route('payment.web.checkout', [], true, $locale))->with('error', 'Payment not completed');
        }

        $order = Order::where('transaction_code', $orderId)->first();
        $order->content = json_decode($order->content, true);
        // get Product with $order->content['code']
        $products = [];
        $total = $order->total;
        foreach ($order->content as $key => $value) {
            $product = Product::where('code', $value['code'])->first();
            $products[$key] = [
                'code' => $value['code'],
                'image' => $product->image,
                'name' => $product->getTranslations('name'),
                'price' => $value['unit_amount']['value'],
                'unit' => $value['unit_amount']['currency_code'],
                'qty' => $value['quantity'],
            ];
        }


        $qr = "https://api.vietqr.io/image/970436-1016992543-ik8wqNy.jpg?accountName=" . config('payment.casso.name') . "&amount=" . $total . "&addInfo=" . $orderId;
        return $this->render(
            'web.order.bank',
            compact(
                'order',
                'products',
                'total',
                'qr'
            )
        );
    }


    public function handle(Request $request)
    {
        try {
            // Khởi tạo websocket
            $pusher = new Pusher('e60a9559084d6fc75eeb', 'd2fa890fb538ee46f2ee', '1721660', [
                'cluster' => 'ap1',
                'useTLS' => true
            ]);

            $secretToken = config('payment.casso.webhook.Secure-Token');
            if ($request->header('Secure-Token') != $secretToken) {
                Log::warning('Sai token bảo mật');
                return response()->json(['status' => 'unauthorized'], 401);
            }

            $payload = $request->all();
            if ($payload['error'] != 0) {
                Log::error("Dữ liệu gửi về bị lỗi");
                return response()->json(['status' => 'error'], 400);
            }

            $orderId = null;
            $eventWs = [
                'status' => 201,
                'message' => 'Không tìm thấy orderId'
            ];

            foreach ($payload['data'] as $key => $value) {
                $start = strpos($value['description'], 'DH');
                if ($start !== false) {
                    $description = substr($value['description'], $start);
                    $orderId = $description;
                    $data = Order::where('transaction_code', $orderId)->first();

                    if ($data) {
                        $price = $value['amount'] - $data->total;

                        if ($price == 0) {
                            if ($data->status == 1) {
                                Log::info('Đơn hàng đã được xử lý trước đó');
                                return response()->json(['status' => 'success', 'message' => 'payment transacted'], 200);
                            } else if ($data->status == 0) {
                                $data->status = 1;
                                $data->save();
                                $eventWs = [
                                    'status' => 200,
                                    'message' => 'Thanh toán thành công'
                                ];
                                // Gửi đến socket
                                $pusher->trigger('payment.' . $orderId, 'success', $eventWs);
                                return response()->json(['status' => 'success'], 200);
                            }
                        }
                    } else {
                        Log::warning('Không tìm thấy đơn hàng trong csdl với orderId: ' . $orderId);
                        return response()->json(['status' => 'missing_data'], 400);
                    }
                }
            }

            // Không có giao dịch nào khớp
            if (!$orderId) {
                Log::info('Không tìm thấy orderId trong mô tả');
            } else {
                Log::info('Không tìm thấy giao dịch khớp với orderId: ' . $orderId);
            }

            // Gửi đến socket
            $pusher->trigger('payment.' . $orderId, 'success', $eventWs);

            return response()->json(['status' => 'no_matching_transaction'], 400);
        } catch (\Exception $e) {
            Log::error('Webhook error: ' . $e->getMessage());
            return response()->json(['status' => 'error'], 500);
        }
    }
}
