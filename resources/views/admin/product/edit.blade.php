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
                            <label for="image1">選擇圖片</label>
                            <input type="file" class="form-control mt-2" name="images[]" id="image1">
                            <br>
                            <label for="image2" class="mt-3">選擇圖片</label>
                            <input type="file" class="form-control mt-2" name="images[]" id="image2">
                            <br>
                            <label for="image3" class="mt-3">選擇圖片</label>
                            <input type="file" class="form-control mt-2" name="images[]" id="image3">
                            <br>
                        </div>
                        <input type="submit" class="bg-blue-500" value = "更新">
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin.app-layout>
