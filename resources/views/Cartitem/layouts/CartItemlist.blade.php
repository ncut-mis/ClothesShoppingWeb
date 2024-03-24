<script>
    @if(session('message'))    
        alert("{{ session('message') }}");
    @endif 
</script>

<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class = "flex flex-row pb-8">
                        <h1 class = "basis-1/3">商品名稱</h1>
                        <p class = "basis-1/3">數量</p>
                        <div class = "basis-1/3">操作</div>
                    </div>      
                    @foreach($items as $item)
                        @php
                            $itemID = $item->id;
                            $product = \App\Models\Product::find($item->product_id);
                            $productName = $product->name;
                        @endphp
                        <div class = "flex flex-row">
                            <h1 class = "basis-1/3">{{$productName}}</h1>
                            <p class = "basis-1/3">{{$item->quantity}}</p>
                            <div class = "basis-1/3 flex flex-row">
                                <div class = "basis-1/2">
                                    <button id="update" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">修改數量</button>
                                    <div id="popup" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-8 border border-black shadow-lg rounded-md hidden">
                                        <span class="absolute top-0 right-0 cursor-pointer" onclick="closePopup()">&times;</span>
                                        <p>請選擇數量</p>
                                        <form method="POST" action="{{route('cartitem.update')}}">
                                            @csrf  
                                            @method('patch')
                                            <input type = "hidden" name = "CartID" value = "{{$itemID}}">
                                            <input type = "number" name = "quantity" min = "1" max = "50">
                                            <x-primary-button >{{ __('修改數量') }}</x-primary-button>
                                        </form>
                                    </div>
                                </div>
                                
                                <form method = "POST" action = "{{route('cartitem.destroy')}}" class = "basis-1/2">
                                    @csrf
                                    @method('DELETE')
                                    <input type = "hidden" name = "CartID" value = "{{$item->id}}">
                                    <x-primary-button >{{ __('移出購物車') }}</x-primary-button>
                                </form>                                
                            </div>
                        </div>
                        <br>
                    @endforeach
                    {{$items->links()}}
            </div>
        </div>
    </div>
</div>


<script>
  function closePopup() {
    document.getElementById('popup').classList.add('hidden');
  }

  document.getElementById('update').addEventListener('click', function() {
    document.getElementById('popup').classList.remove('hidden');
  });
</script>
