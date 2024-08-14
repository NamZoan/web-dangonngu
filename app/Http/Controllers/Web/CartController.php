<?php

namespace App\Http\Controllers\Web;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends FontEndController
{
    /**
     * @Description : 
     *
     * @throws 	: NotFoundException
     * @param 	: int data
     * @return 	: array
     * @Author 	: DRaja
     */
    public function cart()
    {
        $cart = Cart::content();
        return $this->render('web.order.cart',$cart);
    }
    /**
     * @Description : Thêm sản phẩm vào giỏ hàng
     *
     * @throws 	: NotFoundException
     * @param 	: int data
     * @return 	: array
     * @Author 	: DRaja
     */


    public function addToCart(Request $request)
    {
        $id = $request->input('id');
        $quantity = $request->input('qty', 1);

        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found',
            ]);
        } else {
            Cart::add($product->code, 'product', $quantity, 0, 0, [
                'name' => $product->getTranslations('name'),
                'price' => $product->getTranslations('price'),
                'image' => asset($product->image),
                'slug' => $product->slug,
                'unit' => $product->getTranslations('unit'),
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Product added to cart',
            ]);
        }
    }

    public function getCartData(Request $request)
    {
        $locale = $request->input('locale');
        $cartItems = Cart::Content();
        $total = $cartItems->count();
        $totalPrice = 0;
        $cartData = [];
        foreach ($cartItems as $item) {
            $cartData[$item->rowId] = [
                'rowId' => $item->rowId,
                'code' => $item->id,
                'name' => $item->options->name[$locale],
                'price' => $item->options->price[$locale],
                'image' => asset($item->options->image),
                'url' => route('web_product_detail', $item->options->slug, true, $locale),
                'unit' => $item->options->unit[$locale],
                'qty' => $item->qty,
            ];
            $totalPrice += $item->options->price[$locale] * $item->qty;
        }

        return response()->json([
            'status' => 'success',
            'cartData' => $cartData,
            'total' => $total,
            'totalPrice' => $totalPrice,
        ]);
    }

    public function updateCart(Request $request)
    {
        $status = $request->input('status');
        $rowId = $request->input('rowId');
        $qty = $request->input('qty');

        if ($status == 'delete') {
            Cart::remove($rowId);
            return response()->json([
                'status' => 200,
                'message' => 'Product removed from cart',
            ]);
        } elseif ($status == 'update') {
            Cart::update($rowId, $qty);
            return response()->json([
                'status' => 200,
                'message' => 'Cart updated',
            ]);
        }
    }
}
