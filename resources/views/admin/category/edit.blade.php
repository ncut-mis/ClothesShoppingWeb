<x-admin.app-layout>
    <div class="container-fluid px-4">
        <h1 class="mt-4">商品類別管理</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">編輯商品類別</li>
        </ol>

        <form action="{{ route('admin.category.update',$categories->id) }}" method="POST" role="form" >
            @method('PATCH')
            @csrf
            <div class="form-group">
                <label for="name" class="form-label">商品類別名稱：</label>
                <input id="name" name="name" type="text" class="form-control" value="{{ old('name',$category->name) }}" placeholder="請輸入修改類別名稱">
            </div>
            <div class="form-group">
                <label for="category_id" class="form-label">商品父類別：	</label>
                <input id="category_id" name="category_id" type="text" class="form-control" value="{{ old('name',$category->category_id) }}" placeholder="請輸入修改父類別">
            </div>
            <div class="form-group">
                <label for="name" class="form-label">是否上架：</label>
                <input id="name" name="name" type="text" class="form-control">

            </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary btn-sm">儲存</button>
                </div>

        </form>
    </div>

</x-admin.app-layout>
