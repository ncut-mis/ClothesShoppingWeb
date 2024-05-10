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
                $status = "已成立";
                break;
            case 1 :
                $status = "已出貨";
                break;
            case 2 :
                $status = "已到貨";
                break;
            case 3 :
                $status = "已完成";
                break;
            case 4 :
                $status = "申請取消";
                break;
            case 5 :
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
                    <h1 class = "text-lg mt-4">買家地址：{{$order->address}}</h1>
                    <h1 class = "text-lg mt-4">買家電話：{{$order->phone}}</h1>
                    <h1 class = "text-lg mt-4">下訂時間：{{$order->created_at}}</h1>
                    <h1 class = "text-lg mt-4">付款狀態：{{$remit}}</h1>
                </div>
            </div>
        </div>
    </div>
</x-admin.app-layout>