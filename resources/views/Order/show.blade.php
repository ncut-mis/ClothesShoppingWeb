@if(session('message'))    
    <script>
        alert("{{ session('message') }}");
    </script>
@endif 

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class = "text-xl font-semibold mt-4 mb-4">訂單編號：{{$order->id}}</h1>
                    <div class = "w-1/2 border-2">
                        <div class = "flex flex-row pb-4 mt-4 ml-4">
                            <div class = "basis-1/4">
                                <h1>商品名稱</h1>
                            </div>
                            <div class = "basis-1/4">
                                <h1>尺寸</h1>
                            </div>
                            <div class = "basis-1/4">
                                <h1>顏色</h1>
                            </div>
                            <div class = "basis-1/4">
                                <h1>數量</h1>
                            </div>
                        </div>
                        <hr>

                        <!--顯示訂單明細-->
                        @foreach($order->order_detials as $detial)
                            <div class = "flex flex-row pb-4 mt-4 ml-4">
                                <div class = "basis-1/4">
                                    <h1>{{$detial->product->name}}</h1>
                                </div>
                                <div class = "basis-1/4">
                                    <h1>{{$detial->size}}</h1>
                                </div>
                                <div class = "basis-1/4">
                                    <h1>{{$detial->color}}</h1>
                                </div>
                                <div class = "basis-1/4">
                                    <h1>{{$detial->quantity}}</h1>
                                </div>
                            </div>
                            <hr>
                        @endforeach

                        <!--顯示總價-->
                        <div class = "flex">
                            <h1 class = "text-xl text-red-500 mt-4 mr-4 mb-4 ml-auto">總價：{{$order->amount}}元</h1>
                        </div>                   
                        <hr>
                    </div>

                    <!--因資料庫裡以數字儲存，故先行設定顯示的字-->
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
                                $status = "已領貨";
                                break;
                            case 5 :
                                $status = "已完成";
                                break;
                            case 6 :
                                $status = "申請取消";
                                break;
                            case 7 :
                                $status = "已取消";
                                break;
                        }

                        $remit = $order->remit === 0 ? "未付款" : "已付款";
                    @endphp

                    <!--訂單明細顯示-->
                    <div class = "mt-4">
                        <div class = "mt-4">付款方式：{{$paymentmethodid}}</div>
                        <div class = "mt-4">運送日期：{{$order->trains_time}}</div>
                        <div class = "mt-4">收件人地址：{{$order->address}}</div>
                        <div class = "mt-4">收件人電話：{{$order->phone}}</div>
                        <div class = "mt-4">訂單狀態：{{$status}}</div>
                        <div class = "mt-4 mb-4">付款狀態：{{$remit}}</div>
                    </div>           
                </div>
            </div>
        </div>
    </div>
</x-app-layout>