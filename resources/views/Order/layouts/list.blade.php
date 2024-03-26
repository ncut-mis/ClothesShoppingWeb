<script>
    @if(session('message'))    
        alert("{{ session('message') }}");
    @endif 
</script>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class = "text-4xl mb-4">訂單一覽</h1>
                <hr>                
                @foreach($orders as $order)
                    @php
                        $order_detial = \App\Models\order_detial::Where('order_id','=',$order->id)->get();
                    @endphp
                    
                    <h1 class = "text-xl font-semibold mt-4 mb-4">訂單編號：{{$order->id}}</h1>

                    <div class = "w-1/2 border-2">
                        <div class = "flex flex-row pb-4 mt-4 ml-4">
                            <div class = "basis-1/2">
                                <h1>商品名稱</h1>
                            </div>
                            <div class = "basis-1/2">
                                <h1>數量</h1>
                            </div>
                        </div>
                        <hr>

                        @foreach($order_detial as $item)
                            @php 
                                $product =  \App\Models\Product::find($item->product_id);
                            @endphp
                            <div class = "flex flex-row pb-4 mt-4 ml-4">
                                <div class = "basis-1/2">
                                    <h1>{{$product->name}}</h1>
                                </div>
                                <div class = "basis-1/2">
                                    <h1>{{$item->quantity}}</h1>
                                </div>
                            </div>
                            <hr>
                        @endforeach
                        <div class = "flex">
                            <h1 class = "text-xl text-red-500 mt-4 mr-4 mb-4 ml-auto">總價：{{$order->amount}}元</h1>
                        </div>                   
                        <hr>
                    </div>

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
                            case 0:
                                $status = "審核中";
                                break;
                            case 1:
                                $status = "已成立";
                                break;
                            case 2:
                                $status = "出貨中";
                                break;
                            case 3:         
                                $status = "已出貨";     
                                break;
                            case 4:
                                $status = "已送達";
                                break;
                            case 5:
                                $status = "已完成";
                                break;
                            case 6:
                                $status = "已取消";
                                break;
                        }

                        $remit = $order->remit === 0 ? "未付款" : "已付款";
                    @endphp
                    <div class = "mt-4">
                        <div class = "mt-4">付款方式：{{$paymentmethodid}}</div>
                        <div class = "mt-4">運送日期：{{$order->trains_time}}</div>
                        <div class = "mt-4">收件人地址：{{$order->address}}</div>
                        <div class = "mt-4">收件人電話：{{$order->phone}}</div>
                        <div class = "mt-4">訂單狀態：{{$status}}</div>
                        <div class = "mt-4 mb-4">付款狀態：{{$remit}}</div>
                    </div>
                    <div class = "flex">
                        <form method = "POST" action = "{{route('order.cancel')}}" class = "ml-auto mb-4">
                            @csrf
                            @method('patch')
                            <input type = "hidden" name = "OrderID" value = "{{$order->id}}">
                            <input type = "submit" value = "申請取消訂單" class = "bg-red-500 w-30 h-10 text-white font-bold rounded">
                        </form>
                    </div>
                    <hr>
                @endforeach              
            </div>
        </div>
    </div>
</div>