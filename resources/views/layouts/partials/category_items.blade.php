<div class="product_area grid grid-cols-4 gap-4">
    <!--顯示商品-->
    @foreach ($products as $product)
        <!--可添加判斷商品是否有圖片的if-else判斷式-->      
        <div class="py-12 w-200 h-250">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <a href = "{{route('Products.show', ['product' => $product]) }}">
                        <div class="p-6 text-gray-900 h-full">
                            <div id="category-items-display h-full">
                                <h1 class = "text-lg">{{ $product->name }}</h1>
                                <br>
                                <div class = "photo">
                                    <img src="{{ asset('images/' . $product->firstPhoto->file_address) }}" alt="" class="object-cover w-full h-full border" style="height:auto;">
                                </div>
                                <h1 class = "mt-2 text-xl text-red-500">NT ${{ $product->price }}</h1>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!--顯示分頁連結-->
<div class = "flex">
       <div class = "mx-auto">{{ $products->links('vendor.pagination.simple-tailwind') }}</div>
</div>
