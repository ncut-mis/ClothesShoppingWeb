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
                    
                    <h1 class = "text-xl font-semibold">訂單編號：{{$order->id}}</h1>

                    <div class = "flex flex-row pb-4 mt-4">
                        <div class = "basis-1/2">
                            <h1>商品名稱</h1>
                        </div>
                        <div class = "basis-1/2">
                            <h1>數量</h1>
                        </div>
                    </div>

                    @foreach($order_detial as $item)
                        @php 
                            $product =  \App\Models\Product::find($item->product_id);
                        @endphp
                        <div class = "flex flex-row pb-4">
                        <div class = "basis-1/2">
                            <h1>{{$product->name}}</h1>
                        </div>
                        <div class = "basis-1/2">
                            <h1>{{$item->quantity}}</h1>
                        </div>
                    </div>
                    @endforeach
                    <h1 class = "text-xl text-red-500">{{$order->amount}}</h1>
                    <hr>
                @endforeach
            </div>
        </div>
    </div>
</div>