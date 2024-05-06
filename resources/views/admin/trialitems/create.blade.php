<x-admin.app-layout>
    <!-- 有回傳值就顯示 -->
    @if(session('message'))    
        <script>
            alert("{{ session('message') }}");
        </script>
    @endif 

    <script>
        // 用于插入图片的function
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

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">   
            <h1 class = "text-3xl font-bold">試搭</h1>
            <button id = "reset" class = " inline-block bg-red-500 hover:bg-blue-700 text-white font-bold w-20 h-10 rounded-lg ml-auto mt-8 cursor-pointer" onclick="removeImage({{$MainProduct->Category->category_type}})"> 重設 </button>
        </div>
        <div class = "flex flex-row h-full">
            <form id = "trail" method = "POST" action = "{{route('admin.trialitem.store')}}" class = "w-1/4 h-full mb-4 basis-1/2">
                @csrf
                <input type = "hidden" name = "productID" value = "{{$MainProduct->id}}">
                
                @foreach($groupedProducts as $category_type => $products)
                    @php
                        switch($category_type){
                            case 0:
                                $TypeName = '帽子';
                                break;
                            case 1:
                                $TypeName = '上衣';
                                break;
                            case 2:
                                $TypeName = '褲子';
                                break;
                            case 3:
                                $TypeName = '襪子';
                                break;
                            case 4:
                                $TypeName = '鞋子';
                                break;
                        }
                    @endphp

                    <div class = "ml-6">
                        <label class="block text-xl font-medium text-gray-700">{{ $TypeName }}</label>
                        <select id = "productlist{{$category_type}}" name = "productlist[]" onchange="addPhoto({{$category_type}})" class = "rounded">
                            <option value="" disabled selected></option>
                            @foreach($products as $product)
                                <option value="{{$product->id}}">{{$product->name}}</option>
                            @endforeach
                        </select>
                    </div>
                @endforeach
            </form>
            <div class = "grid grid-cols-1 md:grid-cols-2 gap-4 basis-1/2 border">
                <div class="border w-40 h-40 mx-auto md:col-span-2 mt-4" id = "cap">
                </div>
                <div class="border w-40 h-40 mx-auto md:col-span-2" id = "top">
                </div>
                <div class="border w-40 h-40 mx-auto md:col-span-2" id = "pant">
                </div>
                <div class="border w-40 h-40 mx-auto md:col-span-2" id = "sock">
                </div>
                <div class="border w-40 h-40 mx-auto md:col-span-2 mb-4" id = "shoe">
                </div>
            </div>

            <!--加載主要商品-->
            @switch($MainProduct->Category->category_type)
                @case(0)
                    <script>
                        insertImage("cap", "{{ asset('images/' . $MainProduct->firstPhoto->file_address) }}");
                    </script>
                    @break
                @case(1)
                    <script>
                        insertImage("top", "{{ asset('images/' . $MainProduct->firstPhoto->file_address) }}");
                    </script>
                    @break
                @case(2)
                    <script>
                        insertImage("pant", "{{ asset('images/' . $MainProduct->firstPhoto->file_address) }}");
                    </script>
                    @break
                @case(3)
                    <script>
                        insertImage("sock", "{{ asset('images/' . $MainProduct->firstPhoto->file_address) }}");
                    </script>
                    @break
                @case(4)
                    <script>
                        insertImage("shoe", "{{ asset('images/' . $MainProduct->firstPhoto->file_address) }}");
                    </script>
                    @break
            @endswitch
        </div>
        <div class = "flex">
            <button id="formSubmit" class = "bg-blue-500 hover:bg-blue-700 text-white font-bold w-20 h-10 rounded-lg ml-auto mt-16 mr-4 mb-4 cursor-pointer">加入試搭</button>      
        </div>
        </div>
        </div>
    </div>
</div>   

    <script>
        function addPhoto(category_type) {
            const productID = document.getElementById('productlist' + category_type).value;
            const categoryType = ['cap','top','pant','sock','shoe'];

            // 使用 fetch 发送请求到服务器
            fetch(`/admin/Photo/${productID}`)
            .then(response => response.json())
            .then(data => {
                insertImage(categoryType[data.category_type] , data.photoUrl);
            })
            .catch(error => {
                console.error('Error adding product:', error);
            });
        }

        function removeImage(category_type) {
        // 设定的 div ID 数组
            const categoryTypes = ['cap', 'top', 'pant', 'sock', 'shoe'];
            const divId = categoryTypes[category_type];
            
            // 遍历所有的 categoryType
            categoryTypes.forEach(function(currentCategoryType) {
                if(currentCategoryType === divId){
                // 如果当前迭代的 categoryType 与传入的 category_type 相同，则跳过
                return;
                }
          
                // 通过 currentCategoryType 获取相应的 div 元素
                var div = document.getElementById(currentCategoryType);
                // 在该 div 元素中查找 img 元素
                var img = div ? div.querySelector('img') : null;

                if (img) {
                // 如果找到 img 元素，则移除
                        img.remove();               
                }                       
            });

            // 將選項復原
            for(let i = 0 ; i < 5 ; i++){
                var select = document.getElementById('productlist' + i);
                if (select) {
                    select.selectedIndex = 0;
                }  
            } 
        }

        document.getElementById('formSubmit').addEventListener('click', function() {
            document.getElementById('trail').submit();
        });
    </script>
</x-admin.app-layout>