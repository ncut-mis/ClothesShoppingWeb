<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>新增搭配組合</title>
</head>
<h1>新增搭配組合</h1>
<form action="{{ route('combinations.store') }}" method="POST" enctype="multipart/form-data">
    　　　@csrf
    <div class="form-group">
        <label for="image">選擇圖片:</label>
        <input type="file" class="form-control" name="images[]" id="image" multiple>
        <br>
        <label for="name">組合名稱</label>
        <input type = "text" name = "name" id = "name">
        <br>
        <label for="price">價格</label>
        <input type = "text" name = "price" id = "price" class = "ml-4">
        <br>
        <label for="description">商品描述</label>
        <textarea name = "description" id = "description"></textarea>
        <br>
        <label for="combination_product">選擇圖片:</label>
        <input type="file" class="form-control" name="images[]" id="combination_product" multiple>
        <br>
    </div>
    <input type="submit" class="bg-blue-500" value = "上傳">
</form>

</html>
