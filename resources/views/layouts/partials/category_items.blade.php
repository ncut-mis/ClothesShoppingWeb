<div class="grid grid-cols-4 gap-1">
    <!--顯示商品-->
    @foreach ($products as $product)
        <!--可添加判斷商品是否有圖片的if-else判斷式-->      
        <div class = "p-12 w-250 h-400">
            <a href = "{{route('Products.show', ['product' => $product]) }}"　>
                <div class="p-4 bg-white text-gray-900 h-full rounded-lg">
                    <div id="category-items-display h-full">
                        <h1 class = "text-lg">{{ $product->name }}</h1>
                        <br>
                        <div class = "w-full h-3/4 border">
                            <img src="{{ asset('images/' . $product->firstPhoto->file_address) }}" alt="" class="object-cover mx-auto w-auto h-full">
                        </div>
                        <h1 class = "mt-2 text-2xl font-bold text-red-500">NT ${{ $product->price }}</h1>
                    </div>
                </div>
            </a>       
        </div>           
    @endforeach
</div>

<!--顯示分頁連結-->
<div class = "flex">
       <div class = "mx-auto">{{ $products->links('vendor.pagination.simple-tailwind') }}</div>
</div>
<!-- style="height:auto;" -->