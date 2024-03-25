<script>
    @if(session('message'))    
        alert("{{ session('message') }}");
    @endif 
</script>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class = "text-4xl mb-4">結帳</h1>
                <div class = "flex flex-row pb-4">
                    <div class = "basis-1/2">
                        <h1 class = "text-2xl">產品名稱</h1>
                    </div>
                    <div class = "basis-1/2">
                        <h1 class = "text-2xl">數量</h1>
                    </div>
                </div>

                </div>

                @php
                    $amount = 0; 
                @endphp

                @foreach($CartItems as $item)
                    @php
                        $itemID = $item->id;
                        $product = \App\Models\Product::find($item->product_id);
                        $productName = $product->name;
                        $amount += ($item->quantity)*($product->price);
                    @endphp
                    <div class = "flex flex-row pb-8 ml-8">
                        <div class = "basis-1/2">
                            <h1>{{$productName}}</h1>
                        </div>
                        <div class = "basis-1/2">
                            <h1>{{$item->quantity}}</h1>
                        </div>
                    </div>
                @endforeach
                <h1 class = "text-red-500 text-xl mb-4">總價：{{$amount}}</h1>
                
                <hr>
                
                <form method = "POST" action = "{{route('order.store')}}">
                    @csrf
                    <input type = "hidden" name = "amount" value = "{{$amount}}">
                    <h1 class = "text-2xl mt-4 ml-4">付款方式</h1>
                        <div class = "mt-4 ml-4">
                            <input type="radio"  name="choose" value="1" >
                            <label for="choose_1" class = "mt-4">貨到付款</label>
                        </div>
                        <div class = "mt-4 ml-4 mb-4">
                            <input type="radio"  name="choose" value="2">
                            <label for="choose_1" class = "mt-4">信用卡</label>
                        </div>             
                        <div class = "mt-4 ml-4 mb-4">
                            <input type="radio"  name="choose" value="3">
                            <label for="choose_1" class = "mt-4">轉帳</label>
                        </div>    
                        <hr>

                        <h1 class = "text-2xl mt-4 ml-4">收件人資料</h1>
                        <div class = "ml-4 mt-4">
                            <label for = "address">收件人地址</label>
                            <input type = "text" id = "address" name = "address" class = "rounded ml-4">
                        </div>
                        <div class = "ml-4 mt-4 mb-4">
                            <label for = "phone">收件人電話</label>
                            <input type = "text" id = "phone" name = "phone" class = "rounded ml-4">
                        </div>
                        <input type = "submit" value = "送出訂單" class = "ml-4 mb-4 rounded-lg bg-blue-500 text-white w-20 h-10">
                </form>
            </div>
        </div>
    </div>
</div>
