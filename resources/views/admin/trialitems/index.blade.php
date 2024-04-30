<x-admin.app-layout>
    <script>
        // 用于插入图片的函数
        function insertImage(divId, imagePath) {
            // 获取目标 div 容器
            var div = document.getElementById(divId);

            // 查找 div 容器中的第一个 img 元素
            var img = div.querySelector('img');

            if (img) {
                // 如果 img 元素已经存在，只更新它的 src
                img.src = imagePath;
            } else {
                // 如果不存在，创建新的 img 元素
                img = document.createElement('img');
                img.src = imagePath;
                img.alt = '描述文本'; // 替换为您想要的 alt 文本
                div.appendChild(img);
            }
        }
    </script>

    @foreach ($trailItems as $productId => $groupData)
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">     
                        <h1 class = "text-2xl font-bold">商品編號{{$productId}}的試搭</h1>
                        <div class = "grid grid-cols-1 md:grid-cols-2 gap-4 items-stretch">
                            <div class = "grid grid-cols-1 md:grid-cols-2 gap-4 border h-full">
                                <div class="bg-gray-300 w-40 h-40 mt-4 mx-auto md:col-span-2 border" id = "cap">
                                </div>
                                <div class="bg-gray-300 w-40 h-40 mx-auto md:col-span-2 border" id = "top">
                                </div>
                                <div class="bg-gray-300 w-40 h-40 ml-20 border" id = "pant">
                                </div>
                                <div class="bg-gray-300 w-40 h-40 ml-10 border" id = "sock">
                                </div>
                                <div class="bg-gray-300 w-40 h-40 mb-4 mx-auto md:col-span-2 border" id = "shoe">
                                </div>
                            </div>
                            <div class = "ml-8 h-full relative">
                                <h1 class = "text-xl font-bold">包含商品</h1>
                                @foreach ($groupData as $item)
                                    <!-- 主要服裝 -->
                                    @switch($item['product']->Category->category_type)
                                        @case(0)
                                            <script>
                                                insertImage("cap", "{{ asset('images/' . $item['product']->firstPhoto->file_address) }}");
                                            </script>
                                            @break
                                        @case(1)
                                            <script>
                                                insertImage("top", "{{ asset('images/' . $item['product']->firstPhoto->file_address) }}");
                                            </script>
                                            @break
                                        @case(2)
                                            <script>
                                                insertImage("pant", "{{ asset('images/' . $item['product']->firstPhoto->file_address) }}");
                                            </script>
                                            @break
                                        @case(3)
                                            <script>
                                                insertImage("sock", "{{ asset('images/' . $item['product']->firstPhoto->file_address) }}");
                                            </script>
                                            @break
                                        @case(4)
                                            <script>
                                                insertImage("shoe", "{{ asset('images/' . $item['product']->firstPhoto->file_address) }}");
                                            </script>
                                            @break
                                    @endswitch

                                    <!-- 搭配服裝 -->
                                    @switch($item['trial_product']->Category->category_type)
                                        @case(0)
                                            <script>
                                                insertImage("cap", "{{ asset('images/' . $item['trial_product']->firstPhoto->file_address) }}");
                                            </script>
                                            @break
                                        @case(1)
                                            <script>
                                                insertImage("top", "{{ asset('images/' . $item['trial_product']->firstPhoto->file_address) }}");
                                            </script>
                                            @break
                                        @case(2)
                                            <script>
                                                insertImage("pant", "{{ asset('images/' . $item['trial_product']->firstPhoto->file_address) }}");
                                            </script>
                                            @break
                                        @case(3)
                                            <script>
                                                insertImage("sock", "{{ asset('images/' . $item['trial_product']->firstPhoto->file_address) }}");
                                            </script>
                                            @break
                                        @case(4)
                                            <script>
                                                insertImage("shoe", "{{ asset('images/' . $item['trial_product']->firstPhoto->file_address) }}");
                                            </script>
                                            @break
                                    @endswitch
                                       
                                    <h1 class = "text-xl mt-4">{{ $item['product']->name }}</h1>
                                    <h1 class = "text-xl mt-4">{{ $item['trial_product']->name }}</h1>
                                    <form method = "POST" class = "flex absolute bottom-0 w-full">
                                        <input type = "hidden" name = "product_id" value = "{{ $item['product']->id }}">
                                        <input type = "hidden" name = "trial_product_id" value = "{{ $item['trial_product']->id }}">
                                        <input type = "submit" class = "bg-blue-500 hover:bg-blue-700 text-white font-bold w-40 h-10 rounded-lg ml-auto cursor-pointer" value = "加入搭配清單">
                                    </form>
                                @endforeach
                            </div>                   
                        </div>
                    </div>
                </div>
            </div>
        </div>   
    @endforeach 
</x-admin.app-layout>