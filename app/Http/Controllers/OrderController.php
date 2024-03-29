<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\order_detial;
use App\Models\CartItem;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::all();
        return view('Order.index',['orders' => $orders]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user_id = Auth()->user()->id;
        $cartItem = CartItem::where('user_id', '=', $user_id)->get();
        return view('Order.create',['CartItems'=>$cartItem]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        
        $order = new Order();
        
        $order->user_id = Auth()->user()->id;
        $order->amount = $request['amount'];
        $order->paymentmethodid = $request['choose'];
        $order->status = 0;
        $order->address = $request['address'];
        $order->phone = $request['phone'];
        $order->trains_time = Carbon::now(); //暫定為下訂單時間，平台人員再另行修改
        $order->comment = "";
        $order->remit = 0; //暫定為未付款
        $order->staff_id = 1; //暫定為1
        $order->save();

        $cartItems = CartItem::where('user_id', '=', Auth()->user()->id)->get();
        foreach($cartItems as $cartItem){
            $order_detial = new order_detial();
            $order_detial->order_id = $order->id;
            $order_detial->product_id = $cartItem->product_id;
            $order_detial->quantity = $cartItem->quantity;

            $order_detial->save();
            $cartItem->delete();
        }
        return redirect(route('order.index'));
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    public function cancel(Request $request)
    {
        $orderID = $request['OrderID'];
        $order = Order::find($orderID);
        $order->status = 6;

        $order->save();
        session()->flash('message', '取消成功');
        return redirect(route('order.index'));     
    }
}
