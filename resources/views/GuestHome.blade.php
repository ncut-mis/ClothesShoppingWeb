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
    <div class="bg-orange-500 pt-4 flex justify-between">
        <!--顯示服裝類別導覽鍵-->
        <div class="relative flex flex-row">
            <a href="{{route('/')}}" class="text-lg text-white hover:text-gray-500 ml-4 mt-2">所有商品</a>
            
            <!-- 先將大類別列出來 -->
            @foreach ($categories as $FirstCategory)
                <!-- 檢查是否為大類別 -->
                @if ($FirstCategory->category_type == -1)
                    <div class="relative dropdown ml-4 mt-2">
                        <a href="#" class="text-lg text-white hover:text-gray-500">{{ $FirstCategory->name }}</a>
                        <div class="absolute left-0 mt-2 w-48 bg-white border rounded shadow-lg dropdown-content">
                            @foreach ($categories as $category)
                                <!-- 檢查是否為該大類別的子類別 -->
                                @if ($category->category_type == ($FirstCategory->id - 1))
                                    <a href="{{ route('Categorys.show', ['category' => $category]) }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">{{ $category->name }}</a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <!--顯示搜尋欄-->
        <form method="GET" action = "{{route('Products.search')}}">
            @csrf
            <label for = "keyword" class = "text-white text-xl">搜尋</label>
            <input type = "text" id = "keyword" name = "keyword" class = "rounded-lg ml-4">
            <input type="submit" value="搜尋" class = "bg-orange-800 hover:bg-orange-900 text-white rounded-lg w-20 h-10 cursor-pointer">
        </form>
    </div>

    @include('layouts.partials.category_items')
    
@endsection

