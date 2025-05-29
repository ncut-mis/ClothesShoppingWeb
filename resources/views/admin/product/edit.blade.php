<x-admin.app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mt-4 font-bold text-2xl">編輯商品</h1>
                    @if(session('success'))
                    <div class="text-green-600 font-semibold">{{ session('success') }}</div>
                    @endif

                    @if($errors->any())
                    <div class="text-red-600">
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('admin.product.update', $product->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>商品名稱</label>
                            <input id="name" type="text" name="name" placeholder="Name" value="{{ old('name', $product->name) }}" />
                            <br>
                            <!--
                            <label>商品顏色</label>
                            <input id="color" type="text" name="color" placeholder="Color" value="{{ old('color', $product->color) }}"/>
                            <br>
                            -->
                            <label>商品類別</label>
                            <select id="category_id" name="category_id">
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                            <br>
                            <label>商品價格</label>
                            <input id="price" type="text" name="price" placeholder="Price" value="{{ old('price', $product->price) }}" />
                            <br>
                            <label for="description">商品描述</label>
                            <textarea name="description" id="description" class="mt-4">{{ old('description', $product->description) }}</textarea>
                            <br>
                            <div class="mb-3">
                                <label class="form-label">選擇圖片（可複選）</label>
                                <input type="file" name="photos[]" class="form-control image-input" multiple>
                            </div>
                            <div id="sortable-photos" style="display: flex; gap: 10px; flex-wrap: wrap;">
                                @if(isset($photos) && count($photos))
                                @foreach ($photos as $photo)
                                <div class="photo-item indb" data-id="{{ $photo->id }}">
                                    <img src="{{ asset('images/' . $photo->file_address) }}" style="width: 100px; height: 100px; object-fit: cover; border: 1px solid #ccc; border-radius: 5px;">
                                </div>
                                @endforeach
                                @else
                                <p style="color: red;">尚未抓到圖片資料</p>
                                @endif
                            </div>
                            <div id="image-order-container"></div>
                        </div>
                        <input type="submit" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold w-20 h-10 rounded-lg cursor-pointer" value="更新">
                        <input id="goBack" type="button" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold w-20 h-10 rounded-lg cursor-pointer" value="返回">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="https://cdn.staticfile.net/jquery/1.10.2/jquery.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.querySelector('.image-input');
            const container = document.getElementById('sortable-photos');
            const orderContainer = document.getElementById('image-order-container');
            let totalImageCount = container.querySelectorAll('.photo-item').length;

            // 初始化 Sortable 拖曳
            Sortable.create(container, {
                animation: 150,
                onSort: updateOrderInputs // 拖曳時更新排序資料
            });

            // 加入新圖片
            input.addEventListener('change', function(event) {
                const files = event.target.files;

                if (totalImageCount + files.length > 5) {
                    alert("最多只能上傳 5 張圖片！");
                    input.value = '';
                    return;
                }

                Array.from(files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const wrapper = document.createElement('div');
                        wrapper.classList.add('photo-item');
                        wrapper.setAttribute('data-id', 'new_' + Date.now()); // 為新圖片產生唯一 ID

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.width = '100px';
                        img.style.height = '100px';
                        img.style.objectFit = 'cover';
                        img.style.border = '1px solid #ccc';
                        img.style.borderRadius = '5px';

                        wrapper.appendChild(img);
                        container.appendChild(wrapper);
                        totalImageCount++;

                        updateOrderInputs(); // 新增圖片後更新排序欄位
                    };
                    reader.readAsDataURL(file);
                });
            });

            // 更新隱藏欄位內容
            function updateOrderInputs() {
                const photoItems = container.querySelectorAll('.photo-item');
                orderContainer.innerHTML = ''; // 先清空

                photoItems.forEach((item, index) => {
                    const id = item.getAttribute('data-id');
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'sort_order[]';
                    input.value = id;
                    orderContainer.appendChild(input);
                });
            }
            // 初始化時也要跑一次（處理原本圖片）
            updateOrderInputs();
        });

        var e;
        $(document).ready(function() {
            $("#goBack").on("click", function(event) {
                window.location.href = "../{{ $product->id }}/show";
            });
            $("#sortable-photos").on("click", "div.indb", function(event) {
                //刪除圖片
                console.log($(event));
                event.preventDefault();
                if (!confirm("確定要刪除這張圖片嗎？")) return;
                const imageElement = $(this)
                const pid = imageElement.data("id");
                
                $.ajax({
                    url: '{{ route("admin.product.photoDestroy", ":id") }}'.replace(':id', pid),
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            imageElement.remove();
                        } else {
                            alert('刪除失敗');
                        }
                    },
                    error: function() {
                        alert('刪除請求發生錯誤');
                    }
                });
            });
        });
    </script>

</x-admin.app-layout>