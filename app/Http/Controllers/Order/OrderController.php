<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Order\Order;
use App\Model\OrderProduct\OrderProduct;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        
        return $this->getResponse($orders);
    }

    public function read($id)
    {
        $order = Order::find($id);

        if (empty($order)) {
            return $this->throwError(404);
        }

        return $this->getResponse($order);
    }

    public function getOrderProduct($id)
    {
        $orderProducts = OrderProduct::where('orderId', $id)->get();

        if (empty($orderProducts)) {
            return $this->throwError(404);
        }

        return $this->getResponse($orderProducts, [
            'orderId' => $id
        ]);
    }

    public function getCart()
    {
        //get userId from session
        $user = Auth::user();
        $userId = $user->id;

        $order['order'] = self::where('userId', $userId)->where('status', 0)->first();
        $order['orderProduct'] = OrderProduct::where('orderId', $order['order']->id)->get();

        return $this->getResponse($order, [
            'userId' => $userId
        ]);
    }

    public function updateCart(Request $request)
    {
        //get userId from session
        $user = Auth::user();
        $userId = $user->id;

        $orderProductId = null;
        $order = self::where('userId', $userId)->where('status', 0)->first();
        if(!empty($order)) {
            $orderProduct = OrderProduct::where('orderId', $order['order']->id)->where('productId', $productId)->get();
            if (!empty($orderProduct)) {
                $orderProductId = $orderProduct->id;
            }
        }

        Order::updateCart($userId, $request->input('productId'), $request->input('quantity'), $orderProductId);

        return $this->getResponse(true, [
            'userId' => $userId
        ]);
    }

    public function checkout()
    {
        //get userId from session
        $user = Auth::user();
        $userId = $user->id;

        $checkout = Order::checkout($userId);

        return $this->getResponse($checkout, [
            'userId' => $userId
        ]);
    }

    public function setUserData(Request $request)
    {
        //get userId from session
        $user = Auth::user();
        $userId = $user->id;

        $order = self::where('userId', $userId)->where('status', 1)->first();
        
        $order->name = $request->input('name');
        $order->address = $request->input('address');
        $order->phone = $request->input('phone');

        $order->save();

        return $this->getResponse($order, [
            'userId' => $userId
        ]);
    }

    public function checkSession() {
        return $this->getResponse(Auth::user());
    }
}
