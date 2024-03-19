@php            
    $image = \App\Models\ProductPhoto::Where('product_id', '=', $product->id)->first();
@endphp

<div class = "bg-white max-w-lg mt-4 ml-4 rounded-lg">
    <div class = "product pl-8 ">
        <h1 class = "text-4xl pt-4 pl-4 pb-4">  {{$product->name}} </h1>
        <div class = "photo">
            <img src="{{ asset('images/' . $image->file_address) }}" class = "max-w-sm max-h-sm">  
        </div>
        <h1 class = "text-3xl text-red-500 pt-4 bottom-0 right-0">NT {{ $product->price }}</h1>
    </div>
    <div class = "opration grid grid-cols-2 gap-2 pl-8 pt-8">
        <form method="POST" action="" class = "pb-4">
            <input type = "hidden" name = "ProductID" value = "{{$product->id}}">
            <x-primary-button>{{ __('追蹤') }}</x-primary-button>
        </form>
        <form method="POST" action="" class = "pb-4">
            <input type = "hidden" name = "ProductID" value = "{{$product->id}}">
            <x-primary-button>{{ __('加入購物車') }}</x-primary-button>
        </form>
    </div>
</div>



