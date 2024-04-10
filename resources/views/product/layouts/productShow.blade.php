<script>
    @if(session('message'))
        alert("{{ session('message') }}");
    @endif

     // 用于插入图片的函数
    function insertImage(divId, imagePath) {
        var img = document.createElement("img");
        img.src = imagePath; // 使用变量 imagePath 作为图片地址
        img.alt = "描述文字"; // 替代文本

        // 将创建的 img 元素插入到指定的 div 中
        document.getElementById(divId).appendChild(img);
    }

    <script src="//unpkg.com/alpinejs" defer></script>
</script>

<!--單品顯示區域-->
<div class = "flex flex-row">
    <div class = "bg-white max-w-lg mt-4 ml-4 rounded-lg basis-1/3">
        <div class = "product pl-8 pr-8">
            <h1 class = "text-4xl pt-4 pl-4 pb-4">  {{$product->name}} </h1>

            <div class="relative" x-data="{ activePhoto: 0, photos: [
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
                    <button
                        class="mx-1 text-xl bg-gray-300 rounded w-5"
                        @click="activePhoto = activePhoto === 0 ? photos.length - 1 : activePhoto - 1"
                    >&lt;</button>

                    <button
                        class="mx-1 text-xl bg-gray-300 rounded w-5"
                        @click="activePhoto = activePhoto === photos.length - 1 ? 0 : activePhoto + 1"
                    >&gt;</button>
                </div>
            </div>



            <h1 class = "text-3xl text-red-500 pt-4 bottom-0 right-0">NT {{ $product->price }}</h1>
        </div>
        <div class = "opration grid grid-cols-2 gap-2 pl-8 pt-8">
            @if(\App\Models\Product::Track_isExist($product->id))
                <form method="POST" action="{{route('trackeditem.destroy')}}" class = "pb-4">
                    @csrf
                    @method('DELETE')
                    <input type = "hidden" name = "Product_ID" value = "{{$product->id}}">
                    <input type = "submit" value = "解除追蹤" class = "bg-pink-500 hover:bg-pink-800 w-40 h-10 text-white rounded-lg font-bold cursor-pointer">
                </form>
            @else
                <form method="POST" action="{{route('trackeditem.store')}}" class = "pb-4">
                    @csrf
                    <input type = "hidden" name = "ProductID" value = "{{$product->id}}">
                    <input type = "submit" value = "追蹤" class = "bg-pink-500 hover:bg-pink-800 w-20 h-10 text-white rounded-lg font-bold cursor-pointer">
                </form>
            @endif

            <div class = "flex">
                <button id="add" class="ml-auto mr-8 bg-blue-500 hover:bg-blue-700 text-white font-bold w-40 h-10 rounded-lg">加入購物車</button>
            </div>
        </div>
    </div>

    <!--搭配組合顯示區域-->
    @if($combinations->count()>0)
        @foreach($combinations as $combination)
            <div class = "bg-white max-w-lg mt-4 ml-4 rounded-lg basis-1/3 relative">
                <div class = "text-4xl pt-4 pl-4 pb-4">{{$combination->name}}</div>
                <div class = "grid grid-cols-3 gap-3 mt-4">
                    <div class = "photo">
                        <img src="{{ asset('images/' . $combination->product->firstPhoto->file_address) }}">
                    </div>
                    @foreach($combination->combinations_detail as $item)
                        <div class = "photo">
                            <img src="{{ asset('images/' . $item->product->firstPhoto->file_address) }}">
                        </div>
                    @endforeach
                </div>

                <div class = "absolute bottom-20 w-full">
                    <h1 class = "text-3xl text-red-500 pt-4 mb-2 ml-4">NT {{ $combination->price }}</h1>
                </div>

                <div class = "flex flex-row absolute bottom-4 w-full">
                    <div class = "basis-1/2">
                        <button id="Preview" class="basis-1/2 ml-8 bg-blue-500 hover:bg-blue-700 text-white font-bold w-20 h-10 rounded-lg">預覽</button>
                    </div>
                    <div class = "basis-1/2 flex">
                        <button id="combination_add" class="basis-1/2 ml-auto mr-8 bg-blue-500 hover:bg-blue-700 text-white font-bold w-40 h-10 rounded-lg">加入購物車</button>
                    </div>
                </div>
            </div>

            <!--搭配組合加入購物車時選擇尺寸的區塊-->
            <div id="popup2" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-8 border border-black shadow-lg rounded-md hidden">
                <span class="absolute top-1 right-2 cursor-pointer" onclick="closePopup2()">&times;</span>
                <h1 class = "text-4xl pt-4 pl-4 pb-4">{{$combination->name}}</h1>
                <div>
                    <form  method="POST" action="{{route('cartitem.store')}}">
                        @csrf

                        <!--主要商品選擇尺寸選單-->
                        <div class = "mt-4">
                            <label for = "sizeMain">{{$combination->product->name}}</label>
                            <select id = "sizeMain" name = "sizes[{{$combination->product->id}}]">
                                <option value = "XS">XS</option>
                                <option value = "S">S</option>
                                <option value = "M">M</option>
                                <option value = "L">L</option>
                                <option value = "XL">XL</option>
                                <option value = "2XL">2XL</option>
                            </select>
                        </div>

                        <!--搭配商品選擇尺寸選單-->
                        @foreach($combination->combinations_detail as $item)
                        <div class = "mt-4">
                            <label for = "size-{{$item->product->id}}">{{$item->product->name}}</label>
                            <select id = "size-{{$item->product->id}}" name = "sizes[{{$item->product->id}}]">
                                <option value = "XS">XS</option>
                                <option value = "S">S</option>
                                <option value = "M">M</option>
                                <option value = "L">L</option>
                                <option value = "XL">XL</option>
                                <option value = "2XL">2XL</option>
                            </select>
                        </div>
                        @endforeach
                        <div class = "flex mt-4">
                            <input type = "submit" value = "加入購物車" class = "rounded-lg bg-blue-500 hover:bg-blue-700 text-white text-xl w-40 h-10 ml-auto mt-4 ml-auto">
                        </div>
                    </form>
                </div>
            </div>

            <!--預覽搭配組合區塊-->
            <div id="popup3" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-8 border border-black shadow-lg rounded-md hidden">
                <span class="absolute top-1 right-2 cursor-pointer" onclick="closePopup3()">&times;</span>
                <h1 class = "text-4xl pt-4 pl-4 pb-4">{{$combination->name}}預覽</h1>
                <div class = "grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-300 w-40 h-40 mx-auto md:col-span-2" id = "cap">
                    </div>
                    <div class="bg-gray-300 w-40 h-40 mx-auto md:col-span-2" id = "top">
                    </div>
                    <div class="bg-gray-300 w-40 h-40" id = "pant">
                    </div>
                    <div class="bg-gray-300 w-40 h-40" id = "sock">
                    </div>
                    <div class="bg-gray-300 w-40 h-40 mx-auto md:col-span-2" id = "shoe">
                    </div>

                    <!--加載主要商品-->
                    @switch($combination->product->Category->category_type)
                        @case(0)
                            <script>
                                insertImage("cap", "{{ asset('images/' . $combination->product->firstPhoto->file_address) }}");
                            </script>
                            @break
                        @case(1)
                            <script>
                                insertImage("top", "{{ asset('images/' . $combination->product->firstPhoto->file_address) }}");
                            </script>
                            @break
                        @case(2)
                            <script>
                                insertImage("pant", "{{ asset('images/' . $combination->product->firstPhoto->file_address) }}");
                            </script>
                            @break
                        @case(3)
                            <script>
                                insertImage("sock", "{{ asset('images/' . $combination->product->firstPhoto->file_address) }}");
                            </script>
                            @break
                        @case(4)
                            <script>
                                insertImage("shoe", "{{ asset('images/' . $combination->product->firstPhoto->file_address) }}");
                            </script>
                            @break
                        @endswitch

                    <!--加載搭配商品-->
                    @foreach($combination->combinations_detail as $item)
                        @switch($item->product->Category->category_type)
                            @case(0)
                                <script>
                                    insertImage("cap", "{{ asset('images/' . $item->product->firstPhoto->file_address) }}");
                                </script>
                                @break
                            @case(1)
                                <script>
                                    insertImage("top", "{{ asset('images/' . $item->product->firstPhoto->file_address) }}");
                                </script>
                                @break
                            @case(2)
                                <script>
                                    insertImage("pant", "{{ asset('images/' . $item->product->firstPhoto->file_address) }}");
                                </script>
                                @break
                            @case(3)
                                <script>
                                    insertImage("sock", "{{ asset('images/' . $item->product->firstPhoto->file_address) }}");
                                </script>
                                @break
                            @case(4)
                                <script>
                                    insertImage("shoe", "{{ asset('images/' . $item->product->firstPhoto->file_address) }}");
                                </script>
                                @break
                            @endswitch
                    @endforeach
                </div>
            </div>
        @endforeach
    @else
        <div class = "bg-white max-w-lg mt-4 ml-4 rounded-lg basis-1/3">
            <div class = "text-4xl pt-4 pl-4 pb-4">此商品暫無搭配組合</div>
        </div>
    @endif
</div>

<!--單品選擇尺寸及數量區塊-->
<div id="popup" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-8 border border-black shadow-lg rounded-md hidden">
    <span class="absolute top-1 right-2 cursor-pointer" onclick="closePopup()">&times;</span>

    <div class = "flex flex-row">
        <div class = "basis-1/2">
            <h1 class = "text-4xl pt-4 pl-4 pb-4">  {{$product->name}} </h1>
            <div class = "photo">
                <img src="{{ asset('images/' . optional($product->firstPhoto)->file_address) }}" alt="Product Image" class = "max-w-sm max-h-sm">
            </div>
        </div>

        <div class = "basis-1/2 ml-8">
            <form method="POST" action="{{route('cartitem.store')}}" id = "cartitem" class = "mt-8">
                @csrf
                <div>
                    <label for = "quantity">請選擇數量</label>
                    <input type = "number" name = "quantity" min = "1" max = "50">
                </div>
                <br>

                <div class = "mt-4">
                    <label for = "size">請選擇尺寸</label>
                    <select id = "size" name = "size">
                        <option value = "XS">XS</option>
                        <option value = "S">S</option>
                        <option value = "M">M</option>
                        <option value = "L">L</option>
                        <option value = "XL">XL</option>
                        <option value = "2XL">2XL</option>
                    </select>
                </div>

                <input type = "hidden" name = "ProductID" value = "{{$product->id}}">
            </form>
        </div>
    </div>

    <div class = "flex flex-row">
        <div class = "basis-1/2">
            <h1 class = "text-3xl text-red-500 pt-4 mb-4 right-0">NT {{ $product->price }}</h1>
        </div>

        <div class = "basis-1/2 flex">
             <button type = "submit" form = "cartitem" class = "rounded-lg bg-blue-500 hover:bg-blue-700 text-white text-xl w-40 h-10 ml-auto mt-4">
                加入購物車
            </button>
        </div>
    </div>
</div>


<script>
  function closePopup() {
    document.getElementById('popup').classList.add('hidden');
  }

  document.getElementById('add').addEventListener('click', function() {
    document.getElementById('popup').classList.remove('hidden');
  });

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
</script>



