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
                    <h1 class = "text-4xl mb-8 font-bold">結帳</h1>
                    <h1 class = "text-2xl mb-4 ml-4 font-bold">購物車清單</h1>
                    <div class = "flex flex-row pb-4">
                        <div class = "basis-1/3 ml-4">
                            <h1 class = "font-bold">產品名稱</h1>
                        </div>
                        <div class = "basis-1/3">
                            <h1 class = "font-bold">尺寸</h1>
                        </div>  
                        <div class = "basis-1/3">
                            <h1 class = "font-bold">數量</h1>
                        </div>                    
                    </div>
                    <hr>

                    <!--計算總金額變數初始化-->
                    @php
                        $amount = 0; 
                    @endphp

                    <!--顯示購物車清單-->
                    @foreach($CartItems as $item)
                        <!--計算總金額-->
                        @php
                            $amount += ($item->quantity)*($item->product->price);
                        @endphp

                        <div class = "flex flex-row pb-4 ml-8 mt-4">
                            <div class = "basis-1/3">
                                <h1>{{$item->product->name}}</h1>
                            </div>
                            <div class = "basis-1/3">
                                <h1>{{$item->size}}</h1>
                            </div>
                            <div class = "basis-1/3">
                                <h1>{{$item->quantity}}</h1>
                            </div>
                        </div>
                        <hr>
                    @endforeach

                    <!--顯示總價-->
                    <div class = "flex">
                        <h1 class = "text-red-500 text-xl mt-4 mb-4 ml-auto">總價：{{$amount}}元</h1>
                    </div>
                    <hr>
                    
                    <form method = "POST" action = "{{route('order.store')}}">
                        @csrf
                        <input type = "hidden" name = "amount" value = "{{$amount}}">

                        <!--選擇付款方式-->
                        <h1 class = "text-2xl mt-4 ml-4 font-bold">付款方式</h1>
                            <div class = "mt-4 ml-4">
                                <input type="radio"  name="choose" value="0" >
                                <label for="choose_1" class = "mt-4">貨到付款</label>
                            </div>
                            <div class = "mt-4 ml-4 mb-4">
                                <input type="radio"  name="choose" value="1">
                                <label for="choose_1" class = "mt-4">信用卡</label>
                            </div>             
                            <div class = "mt-4 ml-4 mb-4">
                                <input type="radio"  name="choose" value="2">
                                <label for="choose_1" class = "mt-4">轉帳</label>
                            </div>    
                            <hr>

                            <!--收件人資料表單-->
                            <h1 class = "text-2xl mt-4 ml-4 font-bold">收件人資料</h1>
                            <div class = "ml-4 mt-4">
                                <label for = "address">收件人地址</label>
                                <input type = "text" id = "address" name = "address" class = "rounded ml-4">
                            </div>
                            <div class = "ml-4 mt-4 mb-4">
                                <label for = "phone">收件人電話</label>
                                <input type = "text" id = "phone" name = "phone" class = "rounded ml-4">
                            </div>
                            <br>
                            <h1 class = "text-red-500 ml-4 mb-4">本網站暫時只提供宅配到府的運送方式</h1>
                            <hr>
                            <div class = "flex">
                                <input type = "submit" value = "送出訂單" class = "mt-4 ml-4 rounded-lg bg-blue-500 hover:bg-blue-800 text-white w-20 h-10 ml-auto cursor-pointer">
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
