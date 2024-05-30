<x-app-layout>
    <script>
        // 新增DIV的函數
        function insertDIV(divId , ID){
            var newDiv = document.createElement('div'); // 创建一个新的 div 元素
            newDiv.id = ID; // 设置ID
            newDiv.className = 'inline-block border w-40 h-40';
            document.getElementById(divId).appendChild(newDiv);
        }

        // 用于插入图片的函数
        function insertImage(divId, imagePath) {        
            var img = document.createElement("img");
            img.src = imagePath; // 使用变量 imagePath 作为图片地址
            img.alt = "描述文字"; // 替代文本
            img.classList.add("w-40", "h-40");

            // 将创建的 img 元素插入到指定的 div 中
            document.getElementById(divId).appendChild(img);
        }  
        
    </script>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class = "mt-4 ml-4">
                        <h1 class = "ml-4 mb-4 text-2xl font-bold">推薦搭配</h1>
                        <hr>
                        <div class = "flex flex-row">
                            <div class = "mt-4 mb-4 grid grid-cols-1 basis-1/2">
                                <div class="border h-40 ml-4 md:col-span-2" id = "cap">
                                </div>
                                <div class="border h-40 ml-4 md:col-span-2" id = "top">
                                </div>
                                <div class="border h-40 ml-4 md:col-span-2" id = "pant">
                                </div>
                                <div class="border h-40 ml-4 md:col-span-2" id = "sock">
                                </div>
                                <div class="border h-40 ml-4 md:col-span-2" id = "shoe">
                                </div>

                                <!--加載主要商品-->
                                
                                @switch($combination->product->Category->image_position)
                                    @case(0)
                                        <script>
                                            insertDIV("cap" , "{{$combination->product->id}}");
                                            insertImage("{{$combination->product->id}}", "{{ asset('images/' . $combination->product->firstPhoto->file_address) }}");
                                        </script>
                                        @break
                                    @case(1)
                                        <script>
                                            insertDIV("top" , "{{$combination->product->id}}");
                                            insertImage("{{$combination->product->id}}", "{{ asset('images/' . $combination->product->firstPhoto->file_address) }}");
                                        </script>
                                        @break
                                    @case(2)
                                        <script>
                                            insertDIV("pant" , "{{$combination->product->id}}");
                                            insertImage("{{$combination->product->id}}", "{{ asset('images/' . $combination->product->firstPhoto->file_address) }}");
                                        </script>
                                        @break
                                    @case(3)
                                        <script>
                                            insertDIV("sock" , "{{$combination->product->id}}");
                                            insertImage("{{$combination->product->id}}", "{{ asset('images/' . $combination->product->firstPhoto->file_address) }}");
                                        </script>
                                        @break
                                    @case(4)
                                        <script>
                                            insertDIV("shoe" , "{{$combination->product->id}}");
                                            insertImage("{{$combination->product->id}}", "{{ asset('images/' . $combination->product->firstPhoto->file_address) }}");
                                        </script>
                                        @break
                                    @endswitch

                                <!--加載搭配商品-->
                                @foreach($combination->combinations_detail as $item)
                                    @switch($item->product->Category->image_position)
                                        @case(0)
                                            <script>
                                                insertDIV("cap" , "{{$item->product->id}}");
                                                insertImage("{{ $item->product->id }}", "{{ asset('images/' . $item->product->firstPhoto->file_address) }}");
                                            </script>
                                            @break
                                        @case(1)
                                            <script>
                                                insertDIV("top" , "{{$item->product->id}}");
                                                insertImage("{{ $item->product->id }}", "{{ asset('images/' . $item->product->firstPhoto->file_address) }}");
                                            </script>
                                            @break
                                        @case(2)
                                            <script>
                                                insertDIV("pant" , "{{$item->product->id}}");
                                                insertImage("{{ $item->product->id }}", "{{ asset('images/' . $item->product->firstPhoto->file_address) }}");
                                            </script>
                                            @break
                                        @case(3)
                                            <script>
                                                insertDIV("sock" , "{{$item->product->id}}");
                                                insertImage("{{ $item->product->id }}", "{{ asset('images/' . $item->product->firstPhoto->file_address) }}");
                                            </script>
                                            @break
                                        @case(4)
                                            <script>
                                                insertDIV("shoe" , "{{$item->product->id}}");
                                                insertImage("{{ $item->product->id }}", "{{ asset('images/' . $item->product->firstPhoto->file_address) }}");
                                            </script>
                                            @break
                                    @endswitch
                                @endforeach
                            </div>
                            <div class = "basis-1/2">   
                                <h1 class = "text-xl ml-4 mt-4">穿搭單品</h1>                             
                                <form  method="POST" action="{{route('cartitem.store')}}" class = "ml-4 basis-1/2">
                                    @csrf

                                    <!--主要商品選擇規格選單-->
                                    <div class = "mt-4 mb-4 flex flex-row border bg-gray-100">
                                        <div class = "basis-1/3 mt-4 mb-4">                                            
                                            <img src="{{ asset('images/' . $combination->product->firstPhoto->file_address) }}" class = "w-40 h-40 border ml-4">
                                        </div>
                                        <div class = "basis-1/3 text-center mt-4 mb-4"> 
                                            <h1 class = "text-xl mt-4">{{$combination->product->name}}</h1>
                                            <br>
                                            <h1 class = "text-xl font-bold text-red-500">${{$combination->product->price}}</h1>
                                        </div>
                                        <div class = "basis-1/3 ml-4 mt-4 mb-4">
                                            <label for = "sizeMain">尺寸</label>
                                            <select id = "sizeMain" name = "sizes[{{$combination->product->id}}]" class = "rounded">
                                                @foreach($combination->product->specification as $specification)
                                                    @if($specification->specification_type === 'size')
                                                        <option value = "{{$specification->name}}">{{$specification->name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>

                                            <br>

                                            <label for = "colorMain">顏色</label>
                                            <select id = "colorMain" name = "colors[{{$combination->product->id}}]" class = "mt-4 rounded">
                                                @foreach($combination->product->specification as $specification)
                                                    @if($specification->specification_type === 'color')
                                                        <option value = "{{$specification->name}}">{{$specification->name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <h1 class = "text-red-500 mt-8">主要商品</h1>
                                        </div>
                                    </div>


                                    <!--搭配商品選擇尺寸選單-->
                                    @foreach($combination->combinations_detail as $item)
                                        <div class = "mt-4 mb-4 flex flex-row">
                                            <div class = "basis-1/3">                                            
                                                <img src="{{ asset('images/' . $item->product->firstPhoto->file_address) }}" class = "w-40 h-40 border ml-4">
                                            </div>
                                            <div class = "basis-1/3 text-center"> 
                                                <h1 class = "text-xl mt-4">{{$item->product->name}}</h1>
                                                <br>
                                                <h1 class = "text-xl font-bold text-red-500">${{$item->product->price}}</h1>
                                            </div>
                                            <div class = "mt-4 mb-4">
                                                <label for = "size-{{$item->product->id}}">尺寸</label>
                                                <select id = "size-{{$item->product->id}}" name = "sizes[{{$item->product->id}}]" class = "rounded">
                                                    @foreach($item->product->specification as $specification)
                                                        @if($specification->specification_type === 'size')
                                                            <option value = "{{$specification->name}}">{{$specification->name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>

                                                <br>

                                                <label for = "color-{{$item->product->id}}">顏色</label>
                                                <select id = "color-{{$item->product->id}}" name = "colors[{{$item->product->id}}]" class = "mt-4 rounded">
                                                    @foreach($item->product->specification as $specification)
                                                        @if($specification->specification_type === 'color')
                                                            <option value = "{{$specification->name}}">{{$specification->name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <hr>
                                    @endforeach
                                    <div class = "flex mt-4">
                                        <input type = "submit" value = "加入購物車" class = "rounded-lg bg-blue-500 hover:bg-blue-700 text-white text-xl w-40 h-10 ml-auto mt-4 ml-auto cursor-pointer">
                                    </div>
                                </form>                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>