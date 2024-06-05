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

<x-admin.app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class = "text-2xl font-bold ml-4">修改搭配組合</h1>
                    <div class = "flex flex-row">
                        <div class = "basis-1/2 mt-4 mb-4 grid grid-cols-1">
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
                            <form  method="POST" action="{{route('admin.combination.adminUpdate')}}">
                                @csrf
                                @method('patch')
                                <input type = "hidden" id = "combinationID" name = "combinationID" value = "{{$combination->id}}">
                                <label for = "combinationName">組合名稱</label>
                                <input type = "text" id = "combinationName" name = "combinationName" value = "{{$combination->name}}">
                                <br>
                                <label for = "combinationName">價格</label>
                                <input type = "text" id = "combinationPrice" name = "combinationPrice" value = "{{$combination->price}}" class = "mt-4">
                                <input type="submit" value="修改" class = "bg-blue-500 hover:bg-blue-700 text-white font-bold w-20 h-10 rounded-lg cursor-pointer">
                            </form>
                            <hr>
                            <h1>組合內的商品</h1>
                            <h1>主商品：{{$combination->product->name}}</h1>
                            <img src="{{ asset('images/' . $combination->product->firstPhoto->file_address) }}" class = "w-40 h-40 border ml-4">
                            @foreach($combination->combinations_detail as $detail)
                                <h1>{{$detail->product->name}}</h1>
                                <img src="{{ asset('images/' . $detail->product->firstPhoto->file_address) }}" class = "w-40 h-40 border ml-4">
                                <hr>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-admin.app-layout>
