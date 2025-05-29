<x-admin.app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mt-4 font-bold text-2xl">新增商品</h1>
                    <form action="{{ route('admin.product.create') }}" method="POST" enctype="multipart/form-data">
                        　　　@csrf
                        <div class="form-group">
                            <label for="name">商品名稱</label>
                            <input type="text" name="name" id="name">
                            <br>
                            <label for="category_id">商品類別</label>
                            <select id="category_id" name="category_id">
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <br>
                            <label for="price">商品價格</label>
                            <input type="text" name="price" id="price" class="mt-4">
                            <br>
                            <label for="description">商品描述</label>
                            <textarea name="description" id="description" class="mt-4"></textarea>
                            <br>
                            <label for="image1">選擇圖片</label>
                            <input type="file" name="photos[]" class="form-control image-input" multiple>
                            <br>
                        </div>
                        <input type="submit" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold w-20 h-10 rounded-lg cursor-pointer" value="新增">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.staticfile.net/jquery/1.10.2/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $("input[type='file']").on("change", function(event) {
                const files = event.target.files;
                if (files.length > 5) {
                    alert('最多只能選擇 5 張圖片！');
                    $(this).val(''); // 清空選擇
                } else {
                    console.log(`你選擇了 ${files.length} 張圖片`);
                }
            });
        });
    </script>
</x-admin.app-layout>