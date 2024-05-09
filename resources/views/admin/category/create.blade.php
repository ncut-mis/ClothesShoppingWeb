<x-admin.app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center">
                        <h1 class="text-2xl mb-4 font-bold">新增產品類別</h1>
                    </div>
                    <form action="{{route('admin.category.store')}}" method="POST" role="form">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label for="name" class="form-label">類別名稱</label>
                            <input id="name" name="name" type="text" class="form-control" value="{{ old('name') }}" placeholder="請輸入類別名稱">
                        </div>
                        <div class="form-group">
                            <label for="name" class="form-label">部位</label>
                            <input id="category_type" name="category_type" type="text" class="form-control" value="{{ old('category_type') }}" placeholder="上半身為1，下班身為2">
                        </div>
                        <input type="hidden" name="status" value=1>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary btn-sm">儲存</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</x-admin.app-layout>
