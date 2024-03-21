@php            
    $image = \App\Models\ProductPhoto::Where('product_id', '=', $product->id)->first();
@endphp

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
            <x-primary-button >{{ __('追蹤') }}</x-primary-button>
        </form>
        <button id="add" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">加入購物車</button>
    </div>
</div>

<div id="popup" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-8 border border-black shadow-lg rounded-md hidden">
    <span class="absolute top-0 right-0 cursor-pointer" onclick="closePopup()">&times;</span>
    <p>請選擇數量</p>
    <form method="POST" action="{{route('cartitem.store')}}">
        @csrf  
        <input type = "hidden" name = "ProductID" value = "{{$product->id}}">
        <input type = "number" name = "quantity" min = "1" max = "50">
        <x-primary-button >{{ __('加入購物車') }}</x-primary-button>
    </form>
</div>

<script>
  function closePopup() {
    document.getElementById('popup').classList.add('hidden');
  }

  document.getElementById('add').addEventListener('click', function() {
    document.getElementById('popup').classList.remove('hidden');
  });
</script>



