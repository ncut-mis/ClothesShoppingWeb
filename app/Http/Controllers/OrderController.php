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
        $orders = Order::where([
            ['user_id', '=', Auth::user()->id],
            ['status', '=', $status]
        ])->orderBy('created_at', 'desc')->get();

        switch($status){
            case 0 :
                $statusName = "待確認";
                break;
            case 1 :
                $statusName = "已確認";
                break;
            case 2 :
                $statusName = "已出貨";
                break;
            case 3 :
                $statusName = "已到貨";
                break;
            case 4 :
                $statusName = "已完成";
                break;
            case 5 :
                $statusName = "申請取消";
                break;
            case 6 :
                $statusName = "已取消";
                break;
        }
        return view('Order.index',['orders' => $orders , 'Status' => $statusName]);
    }

    public function admin_index($status)
    {
        $items = Order::Where('status','=',$status)->orderBy('created_at', 'desc')->get();

        return view('admin.order.index', ['items' => $items]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($userId)
    {
        $cartItem = CartItem::where('user_id', '=', $userId)->get();
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

        if($order->paymentmethodid == 0){
            $order->remit = 0;
        }
        else{
            $order->remit = 1;
        }

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

        session()->flash('message', '下訂成功');
        return redirect(route('order.index',['status' => 0]));

    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return view('order.show', ['order' => $order]);
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
            $order->remit = 1;
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

    public function admin_update(Request $request)
    {
        $orderID = $request['OrderID'];
        $status = $request['status'];
        $order = Order::find($orderID);
        $order->status = $status;

        $order->save();

        if($order->status == 1)
        {
            session()->flash('message', '訂單確認成功');
        }
        if($order->status == 2)
        {
            session()->flash('message', '出貨成功');
        }
        if($order->status == 3)
        {
            session()->flash('message', '已將訂單修改為已到貨');
        }
        if($order->status == 6)
        {
            session()->flash('message', '取消申請核准成功');
        }
        return redirect(route('admin.order.adminIndex' , ['status' => $order->status]));
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

    /**
     * Update the status of the specified order.
     */
    public function updateStatus(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'status' => 'required|integer|in:0,1,2,3,4,5,6',
        ]);

        // Find the order by ID
        $order = Order::findOrFail($id);

        // Update the order status
        $order->status = $request->input('status');
        $order->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', '訂單狀態已更新');
    }
}
