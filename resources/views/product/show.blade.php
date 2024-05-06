@if(session('message'))
    <script>
        alert("{{ session('message') }}");
    </script>
@endif

<script>
     // 用于插入图片的函数
    function insertImage(divId, imagePath) {
        var img = document.createElement("img");
        img.src = imagePath; // 使用变量 imagePath 作为图片地址
        img.alt = "描述文字"; // 替代文本

        // 将创建的 img 元素插入到指定的 div 中
        document.getElementById(divId).appendChild(img);
    }  
</script>

@extends($layout)

@section('content')
    <!--單品顯示區域-->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class = "bg-white w-full mt-4 ml-4 rounded-lg basis-1/3">
                        <div class = "product pl-8 pr-8 w-full">
                            <div class = "w-full flex flex-row">
                                <!-- 圖片顯示區域 -->
                                <div class="relative basis-2/3" x-data="{ activePhoto: 0, photos: [
                                        @foreach($product->ProductPhoto as $index => $photo)
                                            '{{ asset('images/' . $photo->file_address) }}'@if(!$loop->last),@endif
                                        @endforeach
                                    ] }">

                                    <!-- 图片轮播显示 -->
                                    <template x-for="(photo, index) in photos" :key="index">
                                        <img :src="photo" 
                                            x-show="activePhoto === index" 
                                            class="w-full h-auto block rounded" 
                                            style="display: none;" />
                                    </template>

                                    <!-- 轮播控制按钮 -->
                                    <div class="flex justify-center mt-4">
                                        <button class="mx-1 text-xl bg-gray-300 rounded w-5"            
                                                @click="activePhoto = activePhoto === 0 ? photos.length - 1 : activePhoto - 1">
                                            &lt;
                                        </button>
                                        <button class="mx-1 text-xl bg-gray-300 rounded w-5"
                                                @click="activePhoto = activePhoto === photos.length - 1 ? 0 : activePhoto + 1">
                                            &gt;
                                        </button>
                                    </div>
                                </div>

                                <!--選擇規格區塊-->
                                <form method="POST" action="{{route('cartitem.store')}}" id = "cartitem" class = "mt-8 basis-1/3 ml-8" onSubmit = "return Check_exist(this);">
                                    <!-- 顯示商品名稱 -->
                                    <h1 class = "text-4xl pt-4 pl-4 pb-4">  {{$product->name}} </h1>
                                    <!-- 顯示商品單價 -->
                                    <h1 class = "text-3xl text-red-500 pl-4 mt-4 font-extrabold">NT {{ $product->price }}</h1>
                                    @csrf
                                    <br>

                                    <div class = "ml-4 mt-4">
                                        <label for = "quantity">數量</label>
                                        <input type = "number" id="quantity" name = "quantity" min = "1" max = "50" class = "rounded-lg w-20">
                                    </div>
                                    <br>

                                    <!-- 尺寸選擇 -->
                                    <div class = "mt-4 ml-4">
                                        <label for = "size">尺寸</label>
                                        <select id = "size" name = "size" class = "rounded-lg w-20">
                                            @foreach($product->specification as $specification)
                                                @if($specification->specification_type === 'size')
                                                    <option value = "{{$specification->name}}">{{$specification->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>                           
                                    </div>
                                    <br>

                                    <!-- 顏色選擇 -->
                                    <div class = "mt-4 ml-4">
                                    <label for = "color">顏色</label>
                                        <select id = "color" name = "color" class = "rounded-lg w-20">
                                            @foreach($product->specification as $specification)
                                                @if($specification->specification_type === 'color')
                                                    <option value = "{{$specification->name}}">{{$specification->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <br>

                                    <!-- 傳遞商品id -->
                                    <input type = "hidden" name = "ProductID" value = "{{$product->id}}">
                                </form>
                            </div>
                            
                        </div>
                        
                        <!--操作區塊-->
                        <div class = "flex justify-end gap-2 pl-8 pt-8">
                            @if(\App\Models\Product::Track_isExist($product->id))
                                <form method="POST" action="{{route('trackeditem.destroy')}}" class = "pb-4">
                                    @csrf
                                    @method('DELETE')
                                    <input type = "hidden" name = "Product_ID" value = "{{$product->id}}">
                                    <input type = "submit" value = "解除追蹤" class = "bg-pink-500 hover:bg-pink-800 w-40 h-20 text-white text-2xl rounded-lg font-bold cursor-pointer">
                                </form>
                            @else
                                <form method="POST" action="{{route('trackeditem.store')}}" class = "pb-4">
                                    @csrf
                                    <input type = "hidden" name = "ProductID" value = "{{$product->id}}">
                                    <input type = "submit" value = "追蹤" class = "bg-pink-500 hover:bg-pink-800 w-40 h-20 text-white text-2xl rounded-lg font-bold cursor-pointer">
                                </form>
                            @endif

                            <div class = "flex">
                                <button onclick= "submitForm()" class="ml-auto mr-8 bg-blue-500 hover:bg-blue-700 text-white text-2xl font-bold w-40 h-20 rounded-lg">加入購物車</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
        
    <!--搭配組合顯示區域-->
    
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class = "text-3xl font-bold mb-4">建議的搭配組合</h1>
    </div>
           
    @if($combinations->count()>0)
        @foreach($combinations as $combination)                    
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <a href = "{{route('combination.index',['combination' => $combination])}}"> 
                        <div class="p-6 text-gray-900">
                            <div class = "text-3xl pt-4 pl-4 pb-4">{{$combination->name}}</div>
                            <div class = "grid grid-cols-5 mt-4 mb-4">
                                <div class = "photo w-20 h-20">
                                    <img src="{{ asset('images/' . $combination->product->firstPhoto->file_address) }}">
                                </div>
                                @foreach($combination->combinations_detail as $item)
                                    <div class = "photo w-20 h-20">
                                        <img src="{{ asset('images/' . $item->product->firstPhoto->file_address) }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </a>
                </div>
            </div>           
        @endforeach
    @else
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class = "text-4xl pt-4 pl-4 pb-4">此商品暫無搭配組合</div>
                </div>
            </div>
        </div>
    @endif
  
    <!--商品描述-->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class = "text-3xl font-bold mb-4">商品描述</h1>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p>{!! nl2br(e($product->description)) !!} </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function closePopup2() {
            document.getElementById('popup2').classList.add('hidden');
        }

        document.getElementById('combination_add').addEventListener('click', function() {
            document.getElementById('popup2').classList.remove('hidden');
        });

        function closePopup3() {
            document.getElementById('popup3').classList.add('hidden');
        }

        document.getElementById('Preview').addEventListener('click', function() {
            document.getElementById('popup3').classList.remove('hidden');
        });  

        function submitForm() {
            document.getElementById('cartitem').submit();
        }

        //驗證數量欄位表單是否為空
        document.getElementById('cartitem').addEventListener('submit', function(event) {
        var inputQuantity = document.getElementById('quantity').value;
        if (inputQuantity === '') {
            // 如果输入为空
            alert('請輸入數量！');
            event.preventDefault(); // 阻止表单提交
        } else if (inputQuantity < 1 || inputQuantity > 50) {
            // 如果输入不在1到50之间
            alert('數量必須在1~50之間！');
            event.preventDefault(); // 阻止表单提交
        }
    });
    </script>
@endsection


