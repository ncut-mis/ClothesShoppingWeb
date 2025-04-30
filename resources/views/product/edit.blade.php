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
    <h1>編輯</h1>
    <div>
{{--        @if($errors->any())--}}
{{--            <ul>--}}
{{--                @foreach($errors->all() as $error)--}}
{{--                    <li>{{$error)}}</li>--}}
{{--                @endforeach--}}
{{--            </ul>--}}
{{--        @endif--}}
    </div>
    <form method="post" action="{{route('admin.product.update',['product' => $product->id])}}">
        @csrf
        @method('put')
        <div>
            <label>商品名稱</label>
            <input type="text" name="name" placeholder="Name" value="{{$product->name}}"/>
        </div>
        <div>
            <label>商品顏色</label>
            <input type="text" name="color" placeholder="Color" value="{{$product->color}}"/>
        </div>
        <div>
            <label>商品類別</label>
            <select name="category_id">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        {{--<div>
            <label>商品尺寸</label>
            <input type="text" name="size" placeholder="Size" value="{{$product->size}}"/>
        </div>--}}
        <div>
            <label>商品庫存</label>
            <input type="text" name="stock" placeholder="Stock" value="{{$product->stock}}"/>
        </div>
        <div>
            <label>商品價格</label>
            <input type="text" name="price" placeholder="Price" value="{{$product->price}}"/>
        </div>
        <div>
            <label>商品描述</label>
            <input type="text" name="description" placeholder="Description" value="{{$product->description}}"/>
        </div>
        <div>
            <input type="submit" value="更新" />
        </div>
    </form>
</body>
</html>
