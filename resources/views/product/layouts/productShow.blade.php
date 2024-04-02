<script>
    @if(session('message'))    
        alert("{{ session('message') }}");
    @endif 
</script>

<div class = "bg-white max-w-lg mt-4 ml-4 rounded-lg">
    <div class = "product pl-8 ">
        <h1 class = "text-4xl pt-4 pl-4 pb-4">  {{$product->name}} </h1>
        <div class = "photo">
            <img src="{{ asset('images/' . $image->file_address) }}" class = "max-w-sm max-h-sm">  
        </div>
        <h1 class = "text-3xl text-red-500 pt-4 bottom-0 right-0">NT {{ $product->price }}</h1>
    </div>
    <div class = "opration grid grid-cols-2 gap-2 pl-8 pt-8">
        <form method="POST" action="{{route('trackeditem.store')}}" class = "pb-4">
            @csrf
            <input type = "hidden" name = "ProductID" value = "{{$product->id}}">
            <input type = "submit" value = "追蹤" class = "bg-pink-500 w-20 h-10 text-white rounded-lg font-bold">
        </form>

        <div class = "flex">
            <button id="add" class="ml-auto mr-8 bg-blue-500 hover:bg-blue-700 text-white font-bold w-40 h-10 rounded-lg">加入購物車</button>
        </div>
    </div>
</div>

<div id="popup" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-8 border border-black shadow-lg rounded-md hidden">
    <span class="absolute top-1 right-2 cursor-pointer" onclick="closePopup()">&times;</span>
    
    <div class = "flex flex-row">
        <div class = "basis-1/2">
            <h1 class = "text-4xl pt-4 pl-4 pb-4">  {{$product->name}} </h1>
            <div class = "photo">
                <img src="{{ asset('images/' . $image->file_address) }}" class = "max-w-sm max-h-sm">  
            </div>
        </div>

        <div class = "basis-1/2 ml-8">
            <form method="POST" action="{{route('cartitem.store')}}" id = "cartitem" class = "mt-8">
                @csrf  
                <div>
                    <label for = "quantity">請選擇數量</label>
                    <input type = "number" name = "quantity" min = "1" max = "50">
                </div>        
                <br>

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
        
                <input type = "hidden" name = "ProductID" value = "{{$product->id}}">      
            </form>
        </div>
    </div>

    <div class = "flex flex-row">
        <div class = "basis-1/2">
            <h1 class = "text-3xl text-red-500 pt-4 mb-4 right-0">NT {{ $product->price }}</h1>
        </div>

        <div class = "basis-1/2 flex">
             <button type = "submit" form = "cartitem" class = "rounded-lg bg-blue-500 hover:bg-blue-700 text-white text-xl w-40 h-10 ml-auto mt-4">
                加入購物車
            </button>
        </div>
    </div>
    
</div>

<script>
  function closePopup() {
    document.getElementById('popup').classList.add('hidden');
  }

  document.getElementById('add').addEventListener('click', function() {
    document.getElementById('popup').classList.remove('hidden');
  });
</script>



