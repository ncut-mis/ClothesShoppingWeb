<x-admin.app-layout>
    @php 
        $shelf_status = ($product->	is_shelf == 0) ? '未上架' : '已上架';
    @endphp

    @if(session('message'))    
        <script>
            alert("{{ session('message') }}");
        </script>
    @endif 

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

    <!-- 操作區域 -->
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 ">
                    <h1 class = "text-3xl font-bold mb-4">操作區域</h1>
                    <hr>
                  
                    <button onclick="location.href='/admin/TrialItem/{{$product->id}}';" class="basis-1/2 ml-auto mt-4 mr-8 bg-blue-500 hover:bg-blue-700 text-white font-bold w-20 h-10 rounded-lg cursor-pointer">試搭</button>
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

    <!-- 試搭清單 -->
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 ">
                    <h1 class = "text-3xl font-bold mb-4">試搭清單</h1>    
                    @forelse($TrialItems as $TrialItem)
                        <div class = "border">
                            <h1 class = "text-xl font-bold mt-4 ml-4">試搭{{$TrialItem->id}}</h1>
                            <h1 class = "mt-4 ml-4">{{$product->name}}</h1>
                            <h1 class = "mt-4 ml-4 mb-4">{{$TrialItem->trialProduct->name}}</h1>
                            <div class = "flex">
                                <form method = "POST" class = "">
                                    <input type = "hidden" name = "product_id" value = "{{ $product->id }}">
                                    <input type = "hidden" name = "trial_product_id" value = "{{ $TrialItem->trialProduct->id }}">
                                    <input type = "submit" class = "bg-blue-500 hover:bg-blue-700 text-white font-bold w-40 h-10 rounded-lg ml-4 mb-4 cursor-pointer" value = "加入搭配清單">
                                </form>  
                                <form method = "POST" action = "{{route('admin.trialitem.destroy')}}" class = "">
                                    @csrf
                                    @method('DELETE')
                                    <input type = "hidden" name = "TrialitemID" value = "{{ $TrialItem->id }}">
                                    <input type = "submit" class = "bg-red-500 hover:bg-blue-700 text-white font-bold w-20 h-10 rounded-lg ml-4 mb-4 cursor-pointer" value = "刪除">
                                </form> 
                            </div>
                        </div>
                    @empty  
                        <p class = "text-red-500 mt-4">查無試搭</p>
                    @endforelse 
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

    <script>
        function closeStocklist() {
            document.getElementById('stocklist').classList.add('hidden');
        }

        document.getElementById('stockcheck').addEventListener('click', function() {
            document.getElementById('stocklist').classList.remove('hidden');
            
        });

       
    </script>
</x-admin.app-layout>
