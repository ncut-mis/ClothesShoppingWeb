<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>商品管理</title>
</head>
<body>
    <h1>商品</h1>
    <div>
        @if(session()->has('success'))
            <div>
                {{session('success')}}
            </div>
        @endif
    </div>
    <div>
        <table border="1">
            <tr>
                <th>商品編號</th>
                <th>商品名稱</th>
                <th>商品庫存</th>
                <th>商品價格</th>
                <th>商品描述</th>
                <th>編輯</th>
                <th>刪除</th>
            </tr>
            @foreach($products as $product)
                <tr>
                    <td>{{$product->id}}</td>
                    <td>{{$product->name}}</td>
                    <td>{{$product->stock}}</td>
                    <td>{{$product->price}}</td>
                    <td>{{$product->description}}</td>
                    <td>
                        <a href="{{route('product.edit', ['product' => $product])}}">Edit</a>
                    </td>
                    <td>
                        <form method="post" action="{{route('product.destroy',['product' => $product->id])}}">
                            @csrf
                            @method('delete')
                            <input type="submit" value="Delete"/>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</body>
</html>
