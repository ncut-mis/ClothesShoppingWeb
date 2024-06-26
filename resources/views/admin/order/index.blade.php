@if(session('message'))
    <script>
        alert("{{ session('message') }}");
    </script>
@endif

<x-admin.app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class = "text-2xl mb-4 font-bold">訂單列表</h1>
                    <br>
                    <div class = "mb-4">
                        <a href = "{{route('admin.order.adminIndex',['status' => 0])}}" class = "mr-4 text-blue-500">待確認</a>
                        <a href = "{{route('admin.order.adminIndex',['status' => 1])}}" class = "mr-4 text-blue-500">已確認</a>
                        <a href = "{{route('admin.order.adminIndex',['status' => 2])}}" class = "mr-4 text-blue-500">已出貨</a>
                        <a href = "{{route('admin.order.adminIndex',['status' => 3])}}" class = "mr-4 text-blue-500">已到貨</a>
                        <a href = "{{route('admin.order.adminIndex',['status' => 4])}}" class = "mr-4 text-blue-500">已完成</a>
                        <a href = "{{route('admin.order.adminIndex',['status' => 5])}}" class = "mr-4 text-blue-500">申請取消</a>
                        <a href = "{{route('admin.order.adminIndex',['status' => 6])}}" class = "mr-4 text-blue-500">已取消</a>
                    </div>
                    <hr>
                    <div class = "mt-4 mb-4 flex flex-row">
                        <h1 class = "basis-1/5 text-lg font-bold">訂單編號</h1>
                        <h1 class = "basis-1/5 text-lg font-bold">總價</h1>
                        <h1 class = "basis-1/5 text-lg font-bold">付款狀態</h1>
                        <h1 class = "basis-1/5 text-lg font-bold">訂單狀態</h1>
                        <h1 class = "basis-1/5 text-lg font-bold">詳細</h1>
                    </div>
                    @foreach($items as $item)
                        @php
                            $remit = $item->remit ? "已付款" : "未付款" ;

                            switch($item->status){
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
                        @endphp
                        <hr>
                        <div class = "mt-4 mb-4 flex flex-row">
                            <h1 class = "basis-1/5 text-lg">訂單{{$item->id}}</h1>
                            <h1 class = "basis-1/5 text-lg text-red-500">{{$item->amount}}</h1>
                            <h1 class = "basis-1/5 text-lg text-blue-500">{{$remit}}</h1>
                            <h1 class = "basis-1/5 text-lg text-green-500">{{$status}}</h1>
                            <a href = "{{route('admin.order.adminShow', ['order' => $item])}}" class = "text-blue-500">訂單詳細</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-admin.app-layout>
