<?php

namespace App\Model\Order;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\OrderProduct\OrderProduct;
use App\Model\Product\Product;

class Order extends Model
{
    use SoftDeletes;
    
    public static function updateCart($userId, $productId, $quantity, $orderProductId = null)
    {
        $product = Product::find($productId);

        if(empty($product)) {
            //throw error empty product
        }

        $order = self::where('userId', $userId)->where('status', 0)->first();

        if(empty($order)) {
            $order = new self;

            $order->userId = $userId;
            $order->orderCode = $order->generateOrderCode();
            $order->status = 0;

            $order->save();
        }

        $orderProduct = OrderProduct::updateOrderProduct($order->id, $product, $quantity, $orderProductId);

        $order->calculateTotalPrice();
    }

    public function generateOrderCode()
    {
        $prefix = "#AS-" . rand(1000, 9999);
        $postfix = strtotime(date());

        return $prefix . $postfix;
    }

    public function calculateTotalPrice()
    {
        $orderProducts = OrderProduct::where('orderId', $this->id)->get();

        $this->totalQuantity = 0;
        $this->totalPrice = 0;
        $this->totalPayment = 0;
        $this->totalDiscount = 0;

        foreach($orderProducts as $orderProduct)
        {
            $this->totalQuantity = $this->totalQuantity + $orderProduct->quantity;
            $this->totalPrice = $this->totalPrice + $orderProduct->totalPrice;
            $this->totalPayment = $this->totalPayment + $orderProduct->totalDiscountPrice;
            $this->totalDiscount = $this->totalDiscount + $orderProduct->totalDiscount;    
        }

        $this->save();
    }

    public static function checkout($userId)
    {
        $order = self::where('userId', $userId)->where('status', 0)->first();

        $saveToCheckout = $order->checkCheckout();
        if($saveToCheckout){
            $order->status = 1;
            $order->save();
        }

        return $saveToCheckout;
    }

    public function checkCheckout()
    {
        $orderProducts = OrderProduct::where('orderId', $this->id)->get();

        foreach($orderProducts as $orderProduct) {
            $product = Product::find($orderProduct->productId);

            if(empty($product) || $this->quantity > $product->quantity) {
                return false;
            }  
        }

        return true;
    }
}
