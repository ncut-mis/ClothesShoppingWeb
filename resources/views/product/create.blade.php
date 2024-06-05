<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>商品新增</h1>

{{--        @if($errors->any())--}}
{{--            <ul>--}}
{{--                @foreach($errors->all() as $error)--}}
{{--                    <li>{{$error)}}</li>--}}
{{--                @endforeach--}}
{{--            </ul>--}}
{{--        @endif--}}
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
                            <input type = "text" name = "price" id = "price"　class = "ml-4">
                            <br>
                            <label for="description">商品描述</label>
                            <textarea name = "description" id = "description"></textarea>
                            <br>
                            <label for="image">選擇圖片:</label>
                            <input type="file" class="form-control" name="images[]" id="image" multiple>
                            <br>
                            <label for="category_id">類別編號</label>
                            <input type = "text" name = "category_id" id = "category_id">
                            <br>
                        </div>
                        <input type="submit" class="bg-blue-500" value = "上傳">
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
