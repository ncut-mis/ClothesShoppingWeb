@if(session('message'))    
    <script>
        alert("{{ session('message') }}");
    </script>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const categoryLinks = document.querySelectorAll('.category-link');

    categoryLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const categoryId = this.getAttribute('data-category-id');

            // 发起 AJAX 请求到指定的端点
            fetch(`/categories/${categoryId}`)
                .then(response => response.text())
                .then(html => {
                    // 将响应的 HTML 更新到页面中
                    document.getElementById('category-items-display').innerHTML = html;
                });
        });
    });
});
</script>

<style>
    /* 隱藏下拉選單 */
    .dropdown-content {
            display: none;
    }

    /* 顯示下拉選單當 hover 時 */
    .dropdown:hover .dropdown-content,
        .dropdown:focus-within .dropdown-content {
            display: block;
        }
</style>

@extends($layout)

@section('content')
    <div class="bg-gray-100 pt-4 flex justify-between">
        <!--顯示服裝類別導覽鍵-->
        <div class="relative flex flex-row mx-auto">
            <a href="{{route('/home')}}" class="text-lg text-black font-bold hover:text-gray-500 ml-4 mt-2">所有商品</a>
            
            <!-- 先將大類別列出來 -->
            @foreach ($categories as $ParentCategory)
                <!-- 檢查是否為大類別 -->
                @if ($ParentCategory->category_id == null)
                    <div class="relative dropdown ml-4 mt-2">
                        <a href="#" class="text-lg text-black font-bold hover:text-gray-500">{{ $ParentCategory->name }}</a>
                        <div class="absolute left-0 mt-2 w-48 bg-white border rounded shadow-lg dropdown-content z-50">
                            @foreach ($categories as $category)
                                <!-- 檢查是否為該大類別的子類別 -->
                                @if ($category->category_id == $ParentCategory->id)
                                    <a href="{{ route('Categorys.show', ['category' => $category]) }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">{{ $category->name }}</a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
            <!--顯示搜尋欄-->
            <form method="GET" action = "{{route('Products.search')}}" class = "">
                @csrf
                <input type = "text" id = "keyword" name = "keyword" class = "rounded-lg ml-4" placeholder="請輸入關鍵字">
                <input type="submit" value="搜尋" class = "bg-gray-500 hover:bg-gray-700 text-white rounded-lg w-20 h-10 cursor-pointer">
            </form>
        </div>
    </div>

    <!-- 商品顯示區 -->
    <div class = "flex flex-row">
        <div class = "basis-1/4">
        </div>
        <div class="grid grid-cols-4 basis-1/2 mt-4">
        <!--顯示商品-->
        @foreach ($products as $product)
            <!--可添加判斷商品是否有圖片的if-else判斷式-->  
            <div class="w-300 h-600 p-1">
                <a href="{{ route('Products.show', ['product' => $product]) }}">
                    <div class="p-4 bg-white rounded-lg hover:shadow-lg w-full h-full flex flex-col border">
                        <div class="w-full h-full relative flex-grow">
                            <div class="w-200 h-400 overflow-y-hidden">
                                <img src="{{ asset('images/' . $product->firstPhoto->file_address) }}" alt="" class="object-contain w-full max-h-60">
                            </div>
                        </div>
                        <div class="mt-auto">
                            <h1 class="text-lg font-bold block">{{ $product->name }}</h1>
                            <h1 class="mt-2 text-2xl font-bold text-red-500 block">NT ${{ $product->price }}</h1>
                        </div>
                    </div>
                </a>
            </div>           
        @endforeach
    </div>
        <div class = "basis-1/4">
        </div>
    </div>
    

    <!--顯示分頁連結-->
    <div class = "flex mt-4">
        <div class = "mx-auto">{{ $products->links('vendor.pagination.simple-tailwind') }}</div>
    </div>

    
@endsection

