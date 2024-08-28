<x-admin.app-layout>
    @php
        switch ($order->paymentmethodid) {
            case 0:
                $paymentmethodid = "貨到付款";
                break;
            case 1:
                $paymentmethodid = "信用卡";
                break;
            case 2:
                $paymentmethodid = "轉帳";
                break;
            default:
                $paymentmethodid = "其他";
                break;
        }

        switch($order->status){
            case 0 :
                $status = "待確認";
                break;
            case 1 :
                $status = "已確認";
                break;
            case 2 :
                $status = "已出貨";
                break;
            case 3 :
                $status = "已到貨";
                break;
            case 4 :
                $status = "已完成";
                break;
            case 5 :
                $status = "申請取消";
                break;
            case 6 :
                $status = "已取消";
                break;
        }

        $remit = $order->remit ? "已付款" : "未付款" ;
    @endphp
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class = "text-2xl font-bold">訂單詳細</h1>
                    <div class = "border border-black mt-4">
                        <div class = "flex flex-row pt-4 pb-4 bg-gray-300 border border-black">
                            <h1 class = "basis-1/5 font-bold ml-4">商品名稱</h1>
                            <h1 class = "basis-1/5 font-bold">數量</h1>
                            <h1 class = "basis-1/5 font-bold">尺寸</h1>
                            <h1 class = "basis-1/5 font-bold">顏色</h1>
                            <h1 class = "basis-1/5 font-bold">單價</h1>
                        </div>
                        @foreach($order_detials as $order_detial)
                        <div class = "flex flex-row pt-4 pb-4 border border-black">
                            <h1 class = "basis-1/5 ml-4">{{$order_detial->product->name}}</h1>
                            <h1 class = "basis-1/5">{{$order_detial->quantity}}</h1>
                            <h1 class = "basis-1/5">{{$order_detial->size}}</h1>
                            <h1 class = "basis-1/5">{{$order_detial->color}}</h1>
                            <h1 class = "basis-1/5 text-red-500">{{$order_detial->product->price}}</h1>
                        </div>
                        @endforeach
                        <div class = "flex flex-row pt-4 pb-4 border border-black">
                            <h1 class = "basis-1/5"></h1>
                            <h1 class = "basis-1/5"></h1>
                            <h1 class = "basis-1/5"></h1>
                            <h1 class = "basis-1/5">總計：</h1>
                            <h1 class = "basis-1/5 text-red-500">{{$order->amount}}</h1>
                        </div>
                    </div>
                    <h1 class = "text-lg mt-4">買家ID：{{$order->user_id}}</h1>
                    <h1 class = "text-lg mt-4">付款方式：{{$paymentmethodid}}</h1>
                    
                    <h1 class = "text-lg mt-4">訂單狀態：{{$status}}</h1>
                    <form method="POST" action="{{route('admin.order.adminUpdate')}}" class="inline">
                        @csrf
                        @method('patch')
                        <input type="hidden" name="OrderID" value="{{$order->id}}">
                        <select name="status" class="ml-2 p-2 border rounded">
                            <option value="0" {{ $order->status == 0 ? 'selected' : '' }}>待確認</option>
                            <option value="1" {{ $order->status == 1 ? 'selected' : '' }}>已確認</option>
                            <option value="2" {{ $order->status == 2 ? 'selected' : '' }}>已出貨</option>
                            <option value="3" {{ $order->status == 3 ? 'selected' : '' }}>已到貨</option>
                            <option value="4" {{ $order->status == 4 ? 'selected' : '' }}>已完成</option>
                            <option value="5" {{ $order->status == 5 ? 'selected' : '' }}>申請取消</option>
                            <option value="6" {{ $order->status == 6 ? 'selected' : '' }}>已取消</option>
                        </select>
                        <button type="submit" class="ml-2 p-2 bg-blue-500 text-white rounded">更新狀態</button>
                    </form>

                    <h1 class = "text-lg mt-4">買家地址：{{$order->address}}</h1>
                    <h1 class = "text-lg mt-4">買家電話：{{$order->phone}}</h1>
                    <h1 class = "text-lg mt-4">下訂時間：{{$order->created_at}}</h1>
                    <h1 class = "text-lg mt-4">付款狀態：{{$remit}}</h1>
                </div>
                @switch($order->status)
                    @case(0)
                        <div class = "flex mr-4">
                            <form method = "POST" action = "{{route('admin.order.adminUpdate')}}" class = "ml-auto mb-4">
                                @csrf
                                @method('patch')
                                <input type = "hidden" name = "OrderID" value = "{{$order->id}}">
                                <input type = "hidden" name = "status" value = "1">
                                <input type = "submit" value = "確認訂單" class = "bg-blue-500 hover-blue-800 w-30 h-10 text-white font-bold rounded cursor-pointer">
                            </form>
                        </div>
                        @break
                    @case(1)
                        <div class = "flex mr-4">
                            <form method = "POST" action = "{{route('admin.order.adminUpdate')}}" class = "ml-auto mb-4">
                                @csrf
                                @method('patch')
                                <input type = "hidden" name = "OrderID" value = "{{$order->id}}">
                                <input type = "hidden" name = "status" value = "2">
                                <input type = "submit" value = "出貨" class = "bg-blue-500 hover-blue-800 w-30 h-10 text-white font-bold rounded cursor-pointer">
                            </form>
                        </div>
                        @break
                    @case(2)
                        <div class = "flex mr-4">
                            <form method = "POST" action = "{{route('admin.order.adminUpdate')}}" class = "ml-auto mb-4">
                                @csrf
                                @method('patch')
                                <input type = "hidden" name = "OrderID" value = "{{$order->id}}">
                                <input type = "hidden" name = "status" value = "3">
                                <input type = "submit" value = "已到貨" class = "bg-blue-500 hover-blue-800 w-30 h-10 text-white font-bold rounded cursor-pointer">
                            </form>
                        </div>
                        @break
                    @case(3)
                        @break
                    @case(4)
                    @case(5)
                        <div class = "flex mr-4">
                            <form method = "POST" action = "{{route('admin.order.adminUpdate')}}" class = "ml-auto mb-4">
                                @csrf
                                @method('patch')
                                <input type = "hidden" name = "OrderID" value = "{{$order->id}}">
                                <input type = "hidden" name = "status" value = "6">
                                <input type = "submit" value = "同意取消" class = "bg-blue-500 hover-blue-800 w-30 h-10 text-white font-bold rounded cursor-pointer">
                            </form>
                        </div>
                    @case(6)
                @endswitch
                
            </div>
        </div>
    </div>
</x-admin.app-layout>
