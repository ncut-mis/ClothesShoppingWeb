<script>
    function handleCategoryChange() {
        // 獲取選中的分類ID
        const categoryID = document.getElementById('category').value;

        document.getElementsByName('category_id')[0].value = categoryID;

        // 使用獲取的分類ID來執行 AJAX 請求
        /*
        fetch(`/admin/Category/${categoryID}/product`)
            .then(response => response.text())  // 假設後端返回 HTML
            .then(html => {
                // 將返回的 HTML 設置到顯示區域
                document.getElementById('category-items-display').innerHTML = html;
            })
            .catch(error => {
                console.error('Error fetching the category data:', error);
            });
        */
    }
</script>

<div id = "category-items-display">
    <x-admin.app-layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class = "flex flex-row">
                            <div class = "basis-2/3 flex items-center">
                                <h1 class = "text-2xl font-bold pb-4">商品列表</h1>
                                <a href="{{route('admin.product.create')}}" class = "ml-4 text-blue-500"><p class = "pb-4">新增商品</p></a>
                            </div>
                            <!--
                            <div class = "basis-1/3 mb-4">
                                <select id = "category" name = "category" onchange="//handleCategoryChange()" class = "rounded-lg">
                                <option value = "0" selected>全部類別</option>
                                    @foreach($categories as $category)
                                        <option value = "{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                                <a href="{{ route('admin.product.adminIndex') }}" class = "ml-4 text-blue-500">重設</a>
                            </div>
                            -->
                            
                            <div class = "basis-2/3">
                                <form method="GET" action = "{{route('admin.product.adminSearch')}}">
                                    <label for = "keyword" class = "text-white text-xl">搜尋</label>
                                    <select id="category_id" name="category_id" class="rounded-lg ml-2">
                                        <option value="0">全部類別</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <!--<input type="text" name="category_id" value="0" hidden>-->
                                    <input type = "text" id = "keyword" name = "keyword" class = "rounded-lg ml-4">
                                    <a href="{{ route('admin.product.adminIndex') }}" class = "ml-4 text-blue-500">重設</a>
                                    <input type="submit" value="搜尋" class = "bg-orange-800 hover:bg-orange-900 text-white rounded-lg w-20 h-10 cursor-pointer">
                                </form>
                            </div>
                        </div>
                        @forelse($products as $product)
                            <hr>
                            <a href = "{{route('admin.product.adminShow', ['product' => $product]) }}">
                                <div class = "mt-4 mb-4 flex flex-row" >
                                    <div class = "basis-1/3">
                                        <img src="{{ asset('images/' . $product->firstPhoto->file_address) }}" class = "w-20 h-20 basis-1/3">
                                    </div>
                                    <div class = "basis-1/3 flex items-center">
                                        <h1>{{$product->name}}</h1>
                                    </div>
                                    <div class = "basis-1/3 flex items-center">
                                        <h1>{{ $product->category->name ?? '（無分類）' }}</h1>

                                    </div>
                                </div>
                            </a>
                        @empty
                            <hr>
                            <p class = "text-red-500 mt-4">查無產品</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <div class = "flex">
            <div class = "mx-auto">{{ $products->links('vendor.pagination.simple-tailwind') }}</div>
        </div>
    </x-admin.app-layout>
</div>
