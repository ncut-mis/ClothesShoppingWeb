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
                    <h1 class = "text-4xl mb-4">訂單一覽</h1>
                    <br>
                    <div class = "mb-4">
                        <a href = "{{route('order.index',['status' => 0])}}" class = "mr-4 text-blue-500">待確認</a>
                        <a href = "{{route('order.index',['status' => 1])}}" class = "mr-4 text-blue-500">已確認</a>
                        <a href = "{{route('order.index',['status' => 2])}}" class = "mr-4 text-blue-500">已出貨</a>
                        <a href = "{{route('order.index',['status' => 3])}}" class = "mr-4 text-blue-500">已到貨</a>
                        <a href = "{{route('order.index',['status' => 4])}}" class = "mr-4 text-blue-500">已領貨</a>
                        <a href = "{{route('order.index',['status' => 5])}}" class = "mr-4 text-blue-500">已完成</a>
                        <a href = "{{route('order.index',['status' => 6])}}" class = "mr-4 text-blue-500">申請取消</a>
                        <a href = "{{route('order.index',['status' => 7])}}" class = "mr-4 text-blue-500">已取消</a>
                    </div>
                    <hr>      
                    <!--顯示所有訂單-->          
                    @foreach($orders as $order)
                        @php
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
                        @endphp

                        <h1 class = "text-xl font-semibold mt-4 mb-4">訂單編號：{{$order->id}}</h1>
                        <a href = "{{route('order.show',['order' => $order])}}">
                            @foreach($order->order_detials as $detial)
                                <div class = "border flex flex-row w-1/2">
                                    <div class = "basis-1/3 mt-4 mb-4 ml-4">
                                        <img src="{{ asset('images/' . $detial->product->firstPhoto->file_address) }}" alt="" class="object-cover w-20 h-20 border" style="height:auto;">
                                    </div>
                                    <div class = "basis-1/3 ">
                                        <h1 class = "font-bold mt-4">{{ $detial->product->name}}</h1>
                                        <h1 class = "text-gray-400">規格：{{ $detial->size}} , {{ $detial->color}}</h1>
                                        <h1>x{{ $detial->quantity}}</h1>
                                    </div>
                                    <div class = "basis-1/3">
                                        <h1 class = "mt-10 text-red-500">${{ $detial->product->price}}</h1>
                                    </div>
                                </div>
                            @endforeach
                        </a>
                        
                        <h1 class = "mt-4">訂單狀態：{{$status}}</h1>
             
                        @switch($order->status)
                            @case(0)
                            @case(1)
                                <div class = "flex">
                                    <form method = "POST" action = "{{route('order.update')}}" class = "ml-auto mb-4">
                                        @csrf
                                        @method('patch')
                                        <input type = "hidden" name = "OrderID" value = "{{$order->id}}">
                                        <input type = "hidden" name = "status" value = "6">
                                        <input type = "submit" value = "申請取消訂單" class = "bg-red-500 hover-red-800 w-30 h-10 text-white font-bold rounded cursor-pointer">
                                    </form>
                                </div>
                                <hr>
                                @break
                            @case(2)
                                @break
                            @case(3)
                                <div class = "flex">
                                    <form method = "POST" action = "{{route('order.update')}}" class = "ml-auto mb-4">
                                        @csrf
                                        @method('patch')
                                        <input type = "hidden" name = "OrderID" value = "{{$order->id}}">
                                        <input type = "hidden" name = "status" value = "4">
                                        <input type = "submit" value = "取貨" class = "bg-blue-500 hover-blue-500 w-20 h-10 text-white font-bold rounded cursor-pointer">
                                    </form>
                                </div>
                                <hr>
                                @break
                            @case(4)
                                <div class = "flex">
                                    <form method = "POST" action = "{{route('order.update')}}" class = "ml-auto mb-4">
                                        @csrf
                                        @method('patch')
                                        <input type = "hidden" name = "OrderID" value = "{{$order->id}}">
                                        <input type = "hidden" name = "status" value = "5">
                                        <input type = "submit" value = "完成訂單" class = "bg-blue-500 hover-blue-500 w-40 h-10 text-white font-bold rounded cursor-pointer">
                                    </form>
                                </div>
                                <hr>
                                @break
                            @case(5)
                            @case(6)
                            @case(7)
                        @endswitch
                        
                    @endforeach              
                </div>
            </div>
        </div>
    </div>
</x-app-layout>