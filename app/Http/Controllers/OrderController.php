<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\order_detial;
use App\Models\CartItem;
use App\Models\stock;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($status)
    {
        $orders = Order::Where([
                               ['user_id','=', Auth::user()->id],
                               ['status','=',$status]
                               ])->get();
        
        switch($status){
            case 0 :
                $statusName = "已成立";
                break;
            case 1 :
                $statusName = "已出貨";
                break;
            case 2 :
                $statusName = "已到貨";
                break;
            case 3 :
                $statusName = "已完成";
                break;
            case 4 :
                $statusName = "申請取消";
                break;
            case 5 :
                $statusName = "已取消";
                break;
        }
        return view('Order.index',['orders' => $orders , 'Status' => $statusName]);
    }

    public function admin_index()
    {
        $items = Order::Where('status','=',0)->get();
                 
        return view('admin.order.index', ['items' => $items]);
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
        $order->remit = 1; //暫定為已付款
        $order->staff_id = 1; //暫定為1
        $order->save();

        $cartItems = CartItem::where('user_id', '=', Auth()->user()->id)->get();
        foreach($cartItems as $cartItem){
            $order_detial = new order_detial();
            $order_detial->order_id = $order->id;
            $order_detial->product_id = $cartItem->product_id;
            $order_detial->quantity = $cartItem->quantity;
            $order_detial->size = $cartItem->size;
            $order_detial->color = $cartItem->color;

            $order_detial->save();
            $cartItem->delete();

            $stock = stock::Where([
                                  ['product_id' , '=', $order_detial->product_id],
                                  ['size' , '=' , $order_detial->size],
                                  ['color' , '=' ,$order_detial->color]
            ])->first();
            $stock->stock = ($stock->stock)-($order_detial->quantity);
            $stock->save();
        }
        return redirect(route('order.index',['status' => 0]));
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order_detials = order_detial::Where('order_id','=',$order->id)->get();

        return view('order.show', ['order' => $order , 'order_detials' => $order_detials]);
    }

    public function admin_show(Order $order)
    {
        $order_detials = order_detial::Where('order_id','=',$order->id)->get();

        return view('admin.order.show', ['order' => $order , 'order_detials' => $order_detials]);
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
    public function update(Request $request)
    {
        $orderID = $request['OrderID'];
        $status = $request['status'];
        $order = Order::find($orderID);
        $order->status = $status;

        $order->save();

        if($order->status == 4)
        {
            session()->flash('message', '取貨成功');           
        }
        if($order->status == 5)
        {
            session()->flash('message', '已完成訂單');           
        }
        if($order->status == 6)
        {
            session()->flash('message', '取消成功');
        }      
        return redirect(route('order.index' , ['status' => $order->status]));  
    }

    public function comment(Request $request)
    {
        $comment = $request['comment'];
        $OrderID = $request['OrderID'];
        $order = Order::find($OrderID);

        if ($order !== null) {
            $order->comment = $comment;
            $order->save();
            session()->flash('message', '新增評論成功');
        } else {
            session()->flash('message', '新增評論失敗');
        }
    
        $order_detials = order_detial::Where('order_id','=',$OrderID)->get();
        return view('order.show', ['order' => $order , 'order_detials' => $order_detials]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
