<x-admin.app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mt-4 font-bold text-2xl">編輯商品</h1>
                    <form action="{{route('admin.product.update',['product' => $product->id])}}">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label>商品名稱</label>
                            <input type="text" name="name" placeholder="Name" value="{{$product->name}}"/>
                            <br>
                            <label>商品顏色</label>
                            <input type="text" name="color" placeholder="Color" value="{{$product->color}}"/>
                            <br>
                            <label>商品類別</label>
                            <select name="category_id">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <br>
                            <label>商品價格</label>
                            <input type="text" name="price" placeholder="Price" value="{{$product->price}}"/>
                            <br>
                            <label for="description">商品描述</label>
                            <textarea name = "description" id = "description" class = "mt-4" value="{{$product->description}}"></textarea>
                            <br>
                            {{-- 上傳圖片欄位（可以上傳新的） --}}
                            @for ($i = 0; $i < 3; $i++)
                                <div class="mb-3">
                                    <label class="form-label">選擇圖片</label>
                                    <input type="file" name="photos[]" class="form-control">
                                </div>
                            @endfor
                            {{-- 已有圖片區塊（可拖曳排序） --}}
                            @if(isset($photos) && count($photos))
                                <div class="mb-3">
                                    <label>目前圖片（可拖曳排序）</label>
                                    <div style="display: flex; gap: 10px;">
                                        <div id="sortable-photos" style="display: flex; gap: 10px;">
                                            @foreach ($photos as $photo)
                                                <div class="photo-item" data-id="{{ $photo->id }}">
                                                    <img src="{{ asset('images/' . $photo->file_address) }}" width="100">
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                </div>
                            @else
                                <p style="color: red;">⚠ 沒有抓到圖片資料</p>
                            @endif

                        </div>
                        <input type="submit" class="bg-blue-500" value = "更新">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
    <script>
        new Sortable(document.getElementById('sortable-photos'), {
            animation: 150
        });
    </script>
</x-admin.app-layout>
