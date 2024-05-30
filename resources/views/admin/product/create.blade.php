@extends('admins.layouts.master')

@section('page-title', '新增商品')

@section('page-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">新增商品</h1>

        <!-- Main Content -->
        <form action="{{route('admin.product.adminStore')}}" method="post"  enctype="multipart/form-data">
            @method('post')
            <!--csrf驗證機制，產生隱藏的input，包含一組驗證密碼-->
            @csrf
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <form action="{{ route('admin.product.adminStore') }}" method="POST" enctype="multipart/form-data">
                                　　　@csrf
                                <div class="form-group">
                                    <label for="name">商品名稱</label>
                                    <input type = "text" name = "name" id = "name">
                                    <br>
                                    <label for="price">商品顏色</label>
                                    <input type = "text" name = "price" id = "price">
                                    <br>
                                    <label for="price">商品尺寸</label>
                                    <input type = "text" name = "price" id = "price">
                                    <br>
                                    <label for="price">商品價格</label>
                                    <input type = "text" name = "price" id = "price">
                                    <br>
                                    <label for="category_id">商品類別</label>
                                    <input type = "text" name = "category_id" id = "category_id">
                                    <br>
                                    <label for="description">商品描述</label>
                                    <textarea name = "description" id = "description"></textarea>
                                    <br>
                                    <label for="image">選擇圖片</label>
                                    <input type="file" class="form-control" name="images[]" id="image" multiple>
                                    <br>

                                </div>
                                <input type="submit" class="bg-blue-500" value = "上傳">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
@endsection
