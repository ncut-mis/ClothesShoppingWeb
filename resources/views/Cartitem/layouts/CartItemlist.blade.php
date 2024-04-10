<script>
    @if(session('message'))    
        alert("{{ session('message') }}");
    @endif 
</script>

<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class = "text-2xl font-bold">購物車清單</h1>
                    <div class = "flex flex-row pb-4 mt-8">
                        <h1 class = "basis-1/5 font-bold">商品名稱</h1>
                        <h1 class = "basis-1/5 font-bold">單價</h1>
                        <h1 class = "basis-1/5 font-bold">尺寸</h1>
                        <h1 class = "basis-1/5 font-bold">數量</h1>
                        <h1 class = "basis-1/5 font-bold">操作</h1>
                    </div>  
                    <hr>    
                    @php
                      $amount = 0; 
                    @endphp

                    <!--顯示購物車清單-->
                    @foreach($items as $item)
                        @php
                            $itemID = $item->id;
                            $amount += ($item->quantity)*($item->product->price);
                            $product = \App\Models\Product::find($item->product_id);
                        @endphp
                        <div class = "flex flex-row mt-4">
                            <a href = "{{route('Products.show', ['product' => $product]) }}" class = "basis-1/5">
                                <div class = "flex items-center pb-4">
                                    <img src="{{ asset('images/' . $item->product->firstPhoto->file_address) }}" class = "w-20 h-20"> 
                                    <h1 class = "ml-4">{{$item->product->name}}</h1>
                                </div>
                            </a>
                            <div  class = "basis-1/5 flex items-center pb-4 text-red-500">{{$item->product->price}}</div >
                            <div  class = "basis-1/5 flex items-center pb-4">{{$item->size}}</div >
                            <div  class = "basis-1/5 flex items-center pb-4">{{$item->quantity}}</div >

                            <!--操作按鈕區塊-->
                            <div class = "basis-1/5 flex flex-row items-center">
                                <!--修改尺寸區塊-->
                                <div class = "basis-1/3 mb-4">
                                    <button id="updateSize-{{$item->id}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold w-20 h-10 rounded ">修改尺寸</button>
                                    <!--顯示修改尺寸用的小視窗-->
                                    <div id="popupSize-{{$item->id}}" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-8 border border-black shadow-lg rounded-md hidden">
                                        <span class="absolute top-1 right-2 cursor-pointer" onclick="closePopup('popupSize-{{$item->id}}')">&times;</span>
                                        <form method = "POST" action = "{{route('cartitem.update')}}">
                                            @csrf
                                            @method('patch')
                                            <input type = "hidden" name = "CartID" value = "{{$itemID}}">
                                            <div class = "mt-4">
                                                <label for = "size">請選擇尺寸</label>
                                                <select id = "size" name = "size">
                                                    <option value = "XS">XS</option>
                                                    <option value = "S">S</option>
                                                    <option value = "M">M</option>
                                                    <option value = "L">L</option>
                                                    <option value = "XL">XL</option>
                                                    <option value = "2XL">2XL</option>
                                                </select>
                                            </div>
                                            <div class = "flex mt-4">
                                                <input type = "submit" value = "修改尺寸" class = "ml-auto bg-blue-500 rounded-lg text-white w-20 h-10 top-1 right-2">
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!--修改數量區塊-->
                                <div class = "basis-1/3 mb-4">
                                    <button id="updateQuantity-{{$item->id}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold w-20 h-10 rounded ">修改數量</button>
                                    <!--顯示修改數量用的小視窗-->
                                    <div id="popupQuantity-{{$item->id}}" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-8 border border-black shadow-lg rounded-md hidden">
                                        <span class="absolute top-1 right-2 right-0 cursor-pointer" onclick="closePopup('popupQuantity-{{$item->id}}')">&times;</span>
                                        <form method="POST" action="{{route('cartitem.update')}}">
                                            @csrf  
                                            @method('patch')
                                            <label for = "quantity">請選擇數量</label>
                                            <input type = "hidden" name = "CartID" value = "{{$itemID}}">
                                            <input type = "number" name = "quantity" min = "1" max = "50" value = "{{$item->quantity}}">
                                            <div class = "flex mt-4">
                                                <input type = "submit" value = "修改數量" class = "ml-auto bg-blue-500 rounded-lg text-white w-20 h-10 top-1 right-2">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                           
                                <!--移出購物車區塊-->
                                <form method = "POST" action = "{{route('cartitem.destroy')}}" class = "basis-1/3 mb-4">
                                    @csrf
                                    @method('DELETE')
                                    <input type = "hidden" name = "CartID" value = "{{$item->id}}">
                                    <input type = "submit" value = "移出購物車" class = "bg-red-500 hover:bg-red-800 w-20 h-10 text-white font-bold rounded cursor-pointer">
                                </form>                                
                            </div>
                        </div>
                        <hr>                       
                    @endforeach
                    {{$items->links()}}

                    <!--結帳區塊-->
                    <div class = "flex">
                        <h1 class = "text-red-500 text-2xl mt-6">NT {{$amount}}</h1>
                        <button onclick="window.location='{{ route('order.create') }}'" class = "bg-blue-700 hover:bg-blue-900 text-white font-bold w-20 h-10 rounded-lg ml-auto mt-4 mr-4">結帳</button>                       
                    </div>
                    
            </div>
        </div>
    </div>
</div>


 <script>
    document.addEventListener('DOMContentLoaded', function() {
    @foreach ($items as $item)
            document.getElementById('updateQuantity-{{ $item->id }}').addEventListener('click', function() {
                document.getElementById('popupQuantity-{{ $item->id }}').classList.remove('hidden');
        });

        document.getElementById('updateSize-{{ $item->id }}').addEventListener('click', function() {
            document.getElementById('popupSize-{{ $item->id }}').classList.remove('hidden');
        });
    @endforeach
    });

    function closePopup(popupId) {
        document.getElementById(popupId).classList.add('hidden');
}
</script>

