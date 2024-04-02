<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('Products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group">                        
                            <label for="name">商品名稱</label>
                            <input type = "text" name = "name" id = "name">
                            <br>
                            <label for="price">價格</label>
                            <input type = "text" name = "price" id = "price">
                            <br>
                            <label for="description">商品描述</label>
                            <textarea name = "description" id = "description"></textarea>
                            <br>
                            <label for="image">選擇圖片:</label>
                            <input type="file" class="form-control" name="image" id="image">
                            <br>
                            <label for="category_id">類別編號</label>
                            <input type = "text" name = "category_id" id = "category_id">
                            <br>
                        </div>
                        <button type="submit" class="btn btn-primary bg-color-blue">上傳</button>
                    </form>
                </div>
            </div>
        </div>
    </div>    
</x-app-layout>

