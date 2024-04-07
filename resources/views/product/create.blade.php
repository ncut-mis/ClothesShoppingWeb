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
    <div>
{{--        @if($errors->any())--}}
{{--            <ul>--}}
{{--                @foreach($errors->all() as $error)--}}
{{--                    <li>{{$error)}}</li>--}}
{{--                @endforeach--}}
{{--            </ul>--}}
{{--        @endif--}}
    </div>
    <form method="post" action="{{route('product.store')}}">
        @csrf
        @method('post')
        <div>
            <label>商品名稱</label>
            <input type="text" name="name" placeholder="Name" />
        </div>
        <div>
            <label>商品庫存</label>
            <input type="text" name="stock" placeholder="Stock" />
        </div>
        <div>
            <label>商品價格</label>
            <input type="text" name="price" placeholder="Price" />
        </div>
        <div>
            <label>商品描述</label>
            <input type="text" name="description" placeholder="Description" />
        </div>
        <div>
            <input type="submit" value="新增" />
        </div>
    </form>
</body>
</html>
