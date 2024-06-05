<x-admin.app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mt-4 font-bold text-2xl">新增商品</h1>
                    <form action="{{ route('admin.product.adminStore') }}" method="POST" enctype="multipart/form-data">
                        　　　@csrf
                        <div class="form-group">
                            <label for="name">商品名稱</label>
                            <input type = "text" name = "name" id = "name">
                            <br>
                            <label for="category_id">商品類別</label>
                            <input type = "text" name = "category_id" id = "category_id"  class = "mt-4">
                            <br>
                            <label for="price">商品價格</label>
                            <input type = "text" name = "price" id = "price" class = "mt-4">
                            <br>
                            <label for="description">商品描述</label>
                            <textarea name = "description" id = "description" class = "mt-4"></textarea>
                            <br>
                            <label for="image">選擇圖片</label>
                            <input type="file" class="form-control mt-4" name="images[]"  id="image" multiple>
                            <br>
                        </div>
                        <input type="submit" class="bg-blue-500" value = "上傳">
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin.app-layout>
