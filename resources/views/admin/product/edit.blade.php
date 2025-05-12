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
                            {{-- 上傳圖片欄位 --}}
                            <div class="mb-3">
                                <label class="form-label">選擇圖片（可複選）</label>
                                <input type="file" name="photos[]" class="form-control image-input" multiple>
                            </div>

                            {{-- 圖片顯示區域 --}}
                            <div id="sortable-photos" style="display: flex; gap: 10px; flex-wrap: wrap;">
                                {{-- 顯示已上傳圖片 --}}
                                @if(isset($photos) && count($photos))
                                    @foreach ($photos as $photo)
                                        <div class="photo-item" data-id="{{ $photo->id }}">
                                            <img src="{{ asset('images/' . $photo->file_address) }}" style="width: 100px; height: 100px; object-fit: cover; border: 1px solid #ccc; border-radius: 5px;">
                                        </div>
                                    @endforeach
                                @else
                                    <p style="color: red;">尚未抓到圖片資料</p>
                                @endif
                                {{-- 新選圖片會即時加進來 --}}
                            </div>
                        </div>
                        <input type="submit" class="bg-blue-500" value = "更新">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.querySelector('.image-input');
            const container = document.getElementById('sortable-photos');
            let totalImageCount = container.querySelectorAll('.photo-item').length; // 初始圖數（原有圖片）

            // 初始化 Sortable 拖曳
            Sortable.create(container, {
                animation: 150
            });

            // 當使用者選擇新圖片時
            input.addEventListener('change', function (event) {
                const files = event.target.files;

                // 如果加上這次選的檔案，會超過 5 張，就阻止
                if (totalImageCount + files.length > 5) {
                    alert("最多只能上傳 5 張圖片（含原有圖片）！");
                    input.value = ''; // 清空選擇的檔案
                    return;
                }

                // 正常處理：新增圖片縮圖
                Array.from(files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const wrapper = document.createElement('div');
                        wrapper.classList.add('photo-item');
                        wrapper.style.marginRight = '10px';

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.width = '100px';
                        img.style.height = '100px';
                        img.style.objectFit = 'cover';
                        img.style.border = '1px solid #ccc';
                        img.style.borderRadius = '5px';

                        wrapper.appendChild(img);
                        container.appendChild(wrapper);
                        totalImageCount++; // 增加總數計數
                    };
                    reader.readAsDataURL(file);
                });
            });
        });
    </script>
</x-admin.app-layout>
