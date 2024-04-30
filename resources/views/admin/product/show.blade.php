<x-admin.app-layout>
    @php 
        $shelf_status = ($product->	is_shelf == 0) ? '未上架' : '已上架';
    @endphp

    @if(session('message'))    
        <script>
            alert("{{ session('message') }}");
        </script>
    @endif 

    <style>
        /* 自定义样式 */
        .selected-option {
            background-color: lightblue;
        }
    </style>

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
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex flex-row">
                    <div class = "basis-1/2">
                        <h1 class = "text-3xl font-bold">{{$product->name}}</h1>
                        <div class = "photo mt-4">
                            <img src="{{ asset('images/' . $product->firstPhoto->file_address) }}" class = "w-80 h-80 border">
                        </div>
                    </div>
                    <div class = "basis-1/2">
                        <h1 class = "text-3xl font-bold">商品明細</h1>
                        <h1 class = "text-xl font-bold mt-8 inline-block">庫存：</h1> <button id="stockcheck" class="basis-1/2 ml-auto mt-4 mr-8 bg-blue-500 hover:bg-blue-700 text-white font-bold w-20 h-10 rounded-lg cursor-pointer">查看庫存</button>  
                        <br>
                        <h1 class = "text-xl font-bold mt-4 inline-block">價格：</h1> <p class = "text-xl text-red-500 inline-block">{{$product->price}}</p>
                        <br>
                        <h1 class = "text-xl font-bold mt-4 inline-block">上架狀態：</h1> <p class = "text-xl inline-block">{{$shelf_status}}</p>
                        <br>
                        <h1 class = "text-xl font-bold mt-4 inline-block">服裝類別：</h1> <p class = "text-xl inline-block">{{$product->Category->name}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>    

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 ">
                    <h1 class = "text-3xl font-bold mb-4">操作區域</h1>
                    <hr>
                    <button id="trialItemsBtn" class="basis-1/2 ml-auto mt-4 mr-8 bg-blue-500 hover:bg-blue-700 text-white font-bold w-20 h-10 rounded-lg cursor-pointer">試搭</button> 
                    <button id="" class="basis-1/2 ml-auto mt-4 mr-8 bg-blue-500 hover:bg-blue-700 text-white font-bold w-20 h-10 rounded-lg cursor-pointer">修改商品</button>    
                    <button id="" class="basis-1/2 ml-auto mt-4 mr-8 bg-blue-500 hover:bg-blue-700 text-white font-bold w-20 h-10 rounded-lg cursor-pointer">刪除商品</button>    
                    @if($product->	is_shelf == 0)
                        <button id="" class="basis-1/2 ml-auto mt-4 mr-8 bg-blue-500 hover:bg-blue-700 text-white font-bold w-20 h-10 rounded-lg">上架</button>   
                    @else
                        <button id="" class="basis-1/2 ml-auto mt-4 mr-8 bg-blue-500 hover:bg-blue-700 text-white font-bold w-20 h-10 rounded-lg">下架</button>   
                    @endif
                </div>
            </div>
        </div>
    </div> 

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 ">
                    <div class = "flex flex-row">
                        <div class = "basis-1/3 flex items-center">
                            <h1 class = "text-3xl font-bold mb-4">搭配清單</h1>
                        </div>
                        <div class = "basis-1/3">
                            <form method="GET" action = "{{route('admin.combination.adminSearch')}}" class = "mb-6">
                                @csrf
                                <label for = "keyword" class = "text-white text-xl">搜尋</label>
                                <input type = "hidden" name = "productID" value = "{{$product->id}}">
                                <input type = "text" id = "keyword" name = "keyword" class = "rounded-lg ml-4">
                                <input type="submit" value="搜尋" class = "bg-orange-800 hover:bg-orange-900 text-white rounded-lg w-20 h-10 cursor-pointer">
                            </form>
                        </div>
                        <div class = "basis-1/3">
                        </div>
                    </div>
                    <hr>
                    @forelse($combinations as $combination)
                        <div class = "flex flex-row">
                            <h1 class = "basis-1/2 text-xl mt-4 mb-4 pt-2 inline-block">{{$combination->name}}</h1>
                            <div class = "basis-1/2">
                                <button id="" class="basis-1/2 ml-auto mt-4 mr-8 mb-4 bg-blue-500 hover:bg-blue-700 text-white font-bold w-20 h-10 rounded-lg cursor-pointer">組合明細</button>
                                <button id="" class="basis-1/2 ml-auto mt-4 mr-8 mb-4 bg-blue-500 hover:bg-blue-700 text-white font-bold w-20 h-10 rounded-lg cursor-pointer">編輯組合</button>
                                <button id="" class="basis-1/2 ml-auto mt-4 mr-8 mb-4 bg-blue-500 hover:bg-blue-700 text-white font-bold w-20 h-10 rounded-lg cursor-pointer">刪除組合</button>
                            </div>
                        </div>
                        <hr>
                        @empty
                            <p class = "text-red-500 mt-4">查無搭配組合</p>
                        @endforelse 
                </div>
            </div>
        </div>
    </div> 

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 ">
                    <h1 class = "text-3xl font-bold">商品描述</h1>
                    <div class = "description bg-white mt-4 rounded-lg">
                        <p>{!! nl2br(e($product->description)) !!} </p>
                    </div>
                </div>
            </div>
        </div>
    </div> 

    <!-- 庫存清單 -->
    <div id="stocklist" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-8 border border-black shadow-lg rounded-md hidden w-1/4 h-80 overflow-y-scroll">
        <span class="absolute top-1 right-2 cursor-pointer w-5 h-5 text-2xl" onclick="closeStocklist()">&times;</span>
        <h1 class = "text-3xl font-bold">庫存管理</h1>
        <div class = "flex flex-row w-80 mt-4">
            <h1 class = "basis-1/4 text-xl">尺寸</h1>
            <h1 class = "basis-1/4 text-xl">顏色</h1>
            <h1 class = "basis-1/4 text-xl">庫存</h1>
            <h1 class = "basis-1/4 text-xl">操作</h1>
        </div>
        <hr>
        @foreach($stocks as $stock)
            <div class = "flex flex-row w-80 mt-4">
                <div class = "basis-1/4 flex items-center w-20 h-10">
                    <h1 class = "text-xl">{{$stock->size}}</h1>
                </div>
                <div class = "basis-1/4 flex items-center ml-14 w-20 h-10">
                    <h1 class = "text-xl">{{$stock->color}}</h1>
                </div>
                <div class = "basis-1/4 flex items-center ml-16 w-20 h-10">
                    <h1 class = "text-xl">{{$stock->stock}}</h1>
                </div>           
                <div class = "basis-1/4">
                    <form method = "POST" action = "{{route('admin.stock.update')}}" class = "ml-16">
                        @csrf  
                        @method('patch')
                        <div class = "flex flex-row">
                            <input type = "hidden" name = "stockID" value = "{{$stock->id}}">
                            <input type="number" name = "quantity" step="1" required class = "basis-1/2 w-20 h-10 inline-block rounded-lg">
                            <input type="submit" value = "進貨" class = "basis-1/2 bg-blue-500 hover:bg-blue-700 text-white font-bold w-20 h-10 rounded-lg ml-4 cursor-pointer">
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <!-- 試搭視窗 -->
    <div id="trialItems" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-8 border border-black shadow-lg rounded-md hidden w-1/2 h-1/2 overflow-y-scroll">
        <span class="absolute top-1 right-2 cursor-pointer w-5 h-5 text-2xl" onclick="closeTrialItems()">&times;</span>
        <div class = flex>
            <h1 class = "text-3xl font-bold">試搭</h1>
            <button id = "reset" class = " inline-block bg-red-500 hover:bg-blue-700 text-white font-bold w-20 h-10 rounded-lg ml-auto mt-8 cursor-pointer" onclick="removeImage({{$product->Category->category_type}})"> 重設 </button>
        </div>
        <div class = "flex flex-row h-full">
            <form id = "trail" method = "POST" action = "{{route('admin.trialitem.store')}}" class = "w-1/4 h-full mb-4 basis-1/2">
                @csrf
                <p class = "text-red-500">要按Ctrl才能多選，但請勿選擇多個一樣部位的衣服</p>
                <input type = "hidden" name = "productID" value = "{{$product->id}}">
                <select multiple name="product[]" size="2" id = "product" class = "w-full h-full" onchange="addPhoto()">
                    
                </select>
            </form>
            <div class = "grid grid-cols-1 md:grid-cols-2 gap-4 basis-1/2">
                <div class="bg-gray-300 w-40 h-40 mx-auto md:col-span-2" id = "cap">
                </div>
                <div class="bg-gray-300 w-40 h-40 mx-auto md:col-span-2" id = "top">
                </div>
                <div class="bg-gray-300 w-40 h-40 ml-20" id = "pant">
                </div>
                <div class="bg-gray-300 w-40 h-40 ml-2" id = "sock">
                </div>
                <div class="bg-gray-300 w-40 h-40 mx-auto md:col-span-2" id = "shoe">
                </div>
            </div>

            <!--加載主要商品-->
            @switch($product->Category->category_type)
                @case(0)
                    <script>
                        insertImage("cap", "{{ asset('images/' . $product->firstPhoto->file_address) }}");
                    </script>
                    @break
                @case(1)
                    <script>
                        insertImage("top", "{{ asset('images/' . $product->firstPhoto->file_address) }}");
                    </script>
                    @break
                @case(2)
                    <script>
                        insertImage("pant", "{{ asset('images/' . $product->firstPhoto->file_address) }}");
                    </script>
                    @break
                @case(3)
                    <script>
                        insertImage("sock", "{{ asset('images/' . $product->firstPhoto->file_address) }}");
                    </script>
                    @break
                @case(4)
                    <script>
                        insertImage("shoe", "{{ asset('images/' . $product->firstPhoto->file_address) }}");
                    </script>
                    @break
            @endswitch
        </div>
        <div class = "flex">
            <button id="formSubmit" class = "bg-blue-500 hover:bg-blue-700 text-white font-bold w-20 h-10 rounded-lg ml-auto mt-16 cursor-pointer">加入試搭</button>      
        </div>
    </div>

    <script>
        function Allproduct(){
            const productID = @json($product->id);
            fetch(`/admin/AllProduct/${productID}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                const display = document.getElementById('product');
                display.innerHTML = ''; 
                data.forEach(item => {
                    display.innerHTML += `<option value="${item.id}"> ${item.name}</option>`; 
                });
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
        }

        function addPhoto() {
            const productID = document.getElementById('product').value;
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
                } else {
                console.log('没有找到图片元素以供删除。');
                }
            });
        }
    </script>

    <script>
        function closeStocklist() {
            document.getElementById('stocklist').classList.add('hidden');
        }

        document.getElementById('stockcheck').addEventListener('click', function() {
            document.getElementById('stocklist').classList.remove('hidden');
            
        });

        function closeTrialItems() {
            document.getElementById('trialItems').classList.add('hidden');
        }

        document.getElementById('trialItemsBtn').addEventListener('click', function() {
            document.getElementById('trialItems').classList.remove('hidden');
            Allproduct();
        });

        document.getElementById('formSubmit').addEventListener('click', function() {
            document.getElementById('trail').submit();
        });
    </script>
</x-admin.app-layout>
