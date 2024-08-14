<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends BackEndController
{
    public function index()
    {
        $orders = Order::all();
        return $this->render('admin.order.index', compact(
            'orders',));
    }

    public function detail($id)
    {

        $order = Order::find($id);
        if ($order->order_status=='Chờ xác nhận'){
            $order->order_status = 'Đã xác nhận';
            $order->save();
        }
        $contents = json_decode($order->content, true);
        $order_status = json_decode($order->order_status, true);
        return $this->render('admin.order.detail', compact(
            'order',
            'contents',
            'order_status',
        ));
    }

    public function update_status_order(Request $request, $id)
    {
        $order = Order::find($id);
        $status = $request->input('option');
        $other = $request->input('other');

        if ($other != null && $status == 'other') {
            $order->order_status = $other;
            $order->save();
        }

        if( $status != null && $status != 'other'){ 
            $order->order_status = $status;
            $order->save();
        }

        return redirect()->back();
    }
}
