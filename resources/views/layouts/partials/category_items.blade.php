<div class="product_area grid grid-cols-4 gap-4">
    @foreach ($products as $product) 
        @php            
            $image = \App\Models\ProductPhoto::Where('product_id', '=', $product->id)->first();
        @endphp
        <a href = "{{route('Products.show', ['product' => $product]) }}">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <div id="category-items-display">
                                <h1 class = "text-lg">{{ $product->name }}</h1>
                                <br>
                                <div class = photo>
                                    <img src="{{ asset('images/' . $image->file_address) }}" style="max-width:100%;height:auto;">  
                                </div>
                                <h1 class = "text-xl text-red-500">NT {{ $product->price }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    @endforeach        
</div>

<div class = "inset-x-0 bottom-0">
        {{ $products->links() }}
</div>  