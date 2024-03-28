{{-- 引入主布局文件 --}}
@extends('layouts.app')

{{-- 定義內容區域 --}}
@section('content')
    <div class="container">
        <h2>商品管理</h2>

        {{-- 新增商品按鈕 --}}
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addProductModal">
            新增商品
        </button>

        {{-- 商品列表 --}}
        <div class="mt-4">
            <table class="table">
                <thead>
                <tr>
                    <th>商品名稱</th>
                    <th>價格</th>
                    <th>搭配組合</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                {{-- 假設有一個 $products 變數包含所有商品 --}}
{{--                @foreach ($products as $product)--}}
{{--                    <tr>--}}
{{--                        <td>{{ $product->name }}</td>--}}
{{--                        <td>{{ $product->price }}</td>--}}
{{--                        <td>{{ $product->combination }}</td>--}}
{{--                        <td>--}}
{{--                            --}}{{-- 操作按鈕 --}}
{{--                            <button class="btn btn-info">編輯</button>--}}
{{--                            <button class="btn btn-danger">刪除</button>--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                @endforeach--}}
                </tbody>
            </table>
        </div>

        {{-- 新增商品模態框 --}}
        <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductModalLabel">新增商品</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('products.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">商品名稱</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="price">價格</label>
                                <input type="number" class="form-control" id="price" name="price" required>
                            </div>
                            <div class="form-group">
                                <label for="combo">搭配組合</label>
                                <input type="text" class="form-control" id="combo" name="combo">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                            <button type="submit" class="btn btn-primary">新增</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
