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
                        <h1 class = "basis-1/4 font-bold">商品名稱</h1>
                        <h1 class = "basis-1/4 font-bold">尺寸</h1>
                        <h1 class = "basis-1/4 font-bold">數量</h1>
                        <h1 class = "basis-1/4 font-bold">操作</h1>
                    </div>  
                    <hr>    
                    @foreach($items as $item)
                        @php
                            $itemID = $item->id;
                        @endphp
                        <div class = "flex flex-row mt-4">
                            <div class = "basis-1/4 flex items-center pb-4">{{$item->product->name}}</div >
                            <div  class = "basis-1/4 flex items-center pb-4">{{$item->size}}</div >
                            <div  class = "basis-1/4 flex items-center pb-4">{{$item->quantity}}</div >
                            <div class = "basis-1/4 flex flex-row">
                                <div class = "basis-1/3 mb-4">
                                    <button id="updateSize" class="bg-blue-500 hover:bg-blue-700 text-white font-bold w-20 h-10 rounded ">修改尺寸</button>
                                    <div id="popup2" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-8 border border-black shadow-lg rounded-md hidden">
                                        <span class="absolute top-0 right-0 cursor-pointer" onclick="closePopup2()">&times;</span>
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
                                            <x-primary-button >{{ __('修改尺寸') }}</x-primary-button>
                                        </form>
                                    </div>
                                </div>

                                <div class = "basis-1/3 mb-4">
                                    <button id="updateQuantity" class="bg-blue-500 hover:bg-blue-700 text-white font-bold w-20 h-10 rounded ">修改數量</button>
                                    <div id="popup1" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-8 border border-black shadow-lg rounded-md hidden">
                                        <span class="absolute top-0 right-0 cursor-pointer" onclick="closePopup1()">&times;</span>
                                        <p>請選擇數量</p>
                                        <form method="POST" action="{{route('cartitem.update')}}">
                                            @csrf  
                                            @method('patch')
                                            <input type = "hidden" name = "CartID" value = "{{$itemID}}">
                                            <input type = "number" name = "quantity" min = "1" max = "50" value = "{{$item->quantity}}">
                                            <x-primary-button >{{ __('修改數量') }}</x-primary-button>
                                        </form>
                                    </div>
                                </div>
                           
                                <form method = "POST" action = "{{route('cartitem.destroy')}}" class = "basis-1/3 mb-4">
                                    @csrf
                                    @method('DELETE')
                                    <input type = "hidden" name = "CartID" value = "{{$item->id}}">
                                    <input type = "submit" value = "移出購物車" class = "bg-red-500 w-20 h-10 text-white font-bold rounded">
                                </form>                                
                            </div>
                        </div>
                        <hr>                       
                    @endforeach
                    {{$items->links()}}
                    <div class = "flex">
                        <button onclick="window.location='{{ route('order.create') }}'" class = "bg-blue-800 text-white font-bold w-20 h-10 rounded-lg ml-auto mt-4 mr-4">結帳</button>                       
                    </div>
                    
            </div>
        </div>
    </div>
</div>


<script>
  function closePopup1() {
    document.getElementById('popup1').classList.add('hidden');
  }

  document.getElementById('updateQuantity').addEventListener('click', function() {
    document.getElementById('popup1').classList.remove('hidden');
  });

  function closePopup2() {
    document.getElementById('popup2').classList.add('hidden');
  }

  document.getElementById('updateSize').addEventListener('click', function() {
    document.getElementById('popup2').classList.remove('hidden');
  });
</script>
