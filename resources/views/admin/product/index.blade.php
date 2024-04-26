<script>
    function handleCategoryChange() {
        // 獲取選中的分類ID
        const categoryID = document.getElementById('category').value;

        // 使用獲取的分類ID來執行 AJAX 請求
        fetch(`/admin/CategoryShow/${categoryID}`)
            .then(response => response.text())  // 假設後端返回 HTML
            .then(html => {
                // 將返回的 HTML 設置到顯示區域
                document.getElementById('category-items-display').innerHTML = html;
            })
            .catch(error => {
                console.error('Error fetching the category data:', error);
            });
    }
</script>
<div id = "category-items-display">   
    <x-admin.app-layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">               
                    <div class="p-6 text-gray-900">
                        <div class = "flex flex-row">
                            <h1 class = "basis-1/3 text-xl mb-4 font-bold">商品列表</h1>
                            <div class = "basis-1/3 mb-4">
                                <select id = "category" name = "category" onchange="handleCategoryChange()" class = "rounded-lg">
                                    @foreach($categories as $category)                                
                                        <option value = "{{$category->id}}">{{$category->name}}</option>                                
                                    @endforeach
                                </select>
                                <a href="{{ route('admin.product.adminIndex') }}" class = "ml-4 text-blue-500">重設</a>
                            </div>
                            <div class = "basis-1/3"></div>
                        </div>
                        @foreach($products as $product)                       
                                <hr>                      
                                <div class = "mt-4 mb-4 flex flex-row" >                                                
                                    <div class = "basis-1/3">
                                        <img src="{{ asset('images/' . $product->firstPhoto->file_address) }}" class = "w-20 h-20 basis-1/3"> 
                                    </div>     
                                    <h1 class = "basis-1/3">{{$product->name}}</h1>                      
                                    <div class = "basis-1/3"></div>
                                </div>
                        @endforeach                   
                    </div>
                </div>
            </div>
        </div>
    </x-admin.app-layout>
</div>  
