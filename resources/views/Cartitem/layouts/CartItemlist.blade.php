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
                        <h1 class = "basis-1/3 font-bold">商品名稱</h1>
                        <h1 class = "basis-1/3 font-bold">數量</h1>
                        <h1 class = "basis-1/3 font-bold">操作</h1>
                    </div>  
                    <hr>    
                    @foreach($items as $item)
                        @php
                            $itemID = $item->id;
                        @endphp
                        <div class = "flex flex-row mt-4">
                            <div class = "basis-1/3 flex items-center pb-4">{{$item->product->name}}</div >
                            <div  class = "basis-1/3 flex items-center pb-4">{{$item->quantity}}</div >
                            <div class = "basis-1/3 flex flex-row">
                                <div class = "basis-1/2 mb-4">
                                    <button id="update" class="bg-blue-500 hover:bg-blue-700 text-white font-bold w-20 h-10 rounded ">修改數量</button>
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
                                
                                <form method = "POST" action = "{{route('cartitem.destroy')}}" class = "basis-1/2 mb-4">
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
  function closePopup() {
    document.getElementById('popup').classList.add('hidden');
  }

  document.getElementById('update').addEventListener('click', function() {
    document.getElementById('popup').classList.remove('hidden');
  });
</script>
