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

    public function getOrderByUser()
    {
        //get userId from session
        $user = Auth::user();
        $userId = $user->id;

        $orders = Order::where('userId', $userId)->get();
        
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

        $order['order'] = Order::where('userId', $userId)->where('status', Order::STATUS_CART)->first();
        $order['orderProduct'] = OrderProduct::where('orderId', $order['order']->id)->get();

        return $this->getResponse($order, [
            'userId' => $userId
        ]);
    }

    public function addToCart(Request $request)
    {
        //get userId from session
        $user = Auth::user();
        $userId = $user->id;

        $orderProductId = null;
        $order = Order::where('userId', $userId)->where('status', Order::STATUS_CART)->first();

        if(empty($order)) {
            $order = new Order;

            $order->userId = $userId;
            $order->orderCode = $order->generateOrderCode();
            $order->status = 0;

            $order->save();
        }

        $quantity = $request->input('quantity');
        $orderProduct = OrderProduct::where('orderId', $order['order']->id)->where('productId', $productId)->get();
        if (!empty($orderProduct)) {
            $orderProductId = $orderProduct->id;
            $quantity = $quantity + $orderProduct->quantity;
        }

        $order->updateCart($userId, $request->input('productId'), $quantity, $orderProductId);

        return $this->getResponse($order, [
            'userId' => $userId
        ]);
    }

    public function updateCart(Request $request)
    {
        //get userId from session
        $user = Auth::user();
        $userId = $user->id;

        $order = Order::where('userId', $userId)->where('status', Order::STATUS_CART)->first();

        foreach($request->input('orderProduct') as $orderProduct) {
            $order->updateCart($userId, $orderProduct['productId'], $orderProduct['quantity'], $orderProduct['id']);
        }

        return $this->getResponse($order, [
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

        $order = Order::where('userId', $userId)->where('id', $request->input('orderId'))->first();
        
        $order->name = $request->input('name');
        $order->address = $request->input('address');
        $order->phone = $request->input('phone');
        $order->status = Order::STATUS_PENDING;

        $order->save();

        return $this->getResponse($order, [
            'userId' => $userId,
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'orderId' => $request->input('orderId'),
        ]);
    }

    public function setPaidOrder(Request $request)
    {

        $order = Order::find($request->input('orderId'));
        
        $order->status = Order::STATUS_PAID;
        $order->paymentDate = date("Y-m-d H:i:s");

        $order->save();

        return $this->getResponse($order, 
            $request->input()
        );
    }

    public function checkSession() {
        return $this->getResponse(Auth::user());
    }
}
