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

            // 将创建的 img 元素插入到指定的 div 中
            document.getElementById(divId).appendChild(img);
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
                    <div class = "flex">
                        <h1 class = "text-3xl font-bold mb-4">試搭清單</h1>
                        <div>
                            <button id="PreviewBtn" class="basis-1/2 ml-4 mb-4 bg-blue-500 hover:bg-blue-700 text-white font-bold w-20 h-10 rounded-lg cursor-pointer">預覽</button>    
                        </div>
                    </div>
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

    <!-- 搭配清單 -->
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

    <!-- 規格清單 -->
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 ">
                    <div class="flex items-center">
                        <h1 class = "text-3xl font-bold mb-4 inline-block">規格列表</h1>
                        <button id="AddSpecificationBtn" class="ml-auto mr-8 mb-4 bg-blue-500 hover:bg-blue-700 text-white font-bold w-20 h-10 rounded-lg cursor-pointer">新增規格</button>
                    </div>
                    <hr>
                    @foreach($specifications as $specification)
                        <div class = "flex flex-row mt-4 mb-4">
                            <div class = "basis-1/3">
                                <h1 class = "text-xl">{{$specification->specification_type}}</h1>
                            </div>    
                            <div class = "basis-1/3">
                                <h1 class = "text-xl">{{$specification->name}}</h1>
                            </div>    
                            <div class = "basis-1/3">
                                <form action = "{{route('admin.specification.destroy')}}" method = "POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type = "hidden" name = "specification_id" value = "{{ $specification->id }}">
                                    <input type = "hidden" name = "product_id" value = "{{ $product->id }}">
                                    <input type = "submit" value = "刪除" class = "bg-red-500 hover:bg-red-700 text-white font-bold w-20 h-10 rounded-lg cursor-pointer">
                                </form>
                            </div>    
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div> 

    <!-- 商品詳細 -->
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

    <!-- 試搭預覽 -->
    <div id="Preview" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-8 border border-black shadow-lg rounded-md hidden w-1/2 overflow-y-scroll">
        <span class="absolute top-1 right-2 cursor-pointer w-5 h-5 text-2xl" onclick="closePreview()">&times;</span>
        <div class = "grid grid-cols-1 gap-1 border">
            <div class="h-40 mt-4 ml-4 md:col-span-2 border" id = "cap">
            </div>
            <div class="h-40 ml-4 md:col-span-2 border" id = "top">
            </div>
            <div class="h-40 ml-4 md:col-span-2 border" id = "pant">
            </div>
            <div class="h-40 ml-4 md:col-span-2 border" id = "sock">
            </div>
            <div class="h-40 mb-4 ml-4 md:col-span-2 border" id = "shoe">
            </div>
        </div>
        <!-- 主要商品加載圖片 -->
        @switch($product->Category->category_type)
            @case(0)
                <script>
                    insertDIV("cap" , "{{$product->id}}");
                    insertImage("{{$product->id}}", "{{ asset('images/' . $product->firstPhoto->file_address) }}");
                </script>
                @break
            @case(1)
                <script>
                    insertDIV("top" , "{{$product->id}}");
                    insertImage("{{$product->id}}", "{{ asset('images/' . $product->firstPhoto->file_address) }}");
                </script>
                @break
            @case(2)
                <script>
                    insertDIV("pant" , "{{$product->id}}");
                    insertImage("{{$product->id}}", "{{ asset('images/' . $product->firstPhoto->file_address) }}");
                </script>
                @break
            @case(3)
                <script>
                    insertDIV("sock" , "{{$product->id}}");
                    insertImage("{{$product->id}}", "{{ asset('images/' . $product->firstPhoto->file_address) }}");
                </script>
                @break
            @case(4)
                <script>
                    insertDIV("shoe" , "{{$product->id}}");
                    insertImage("{{$product->id}}", "{{ asset('images/' . $product->firstPhoto->file_address) }}");
                </script>
                @break
        @endswitch

        @foreach($TrialItems as $TrialItem)     
            <!-- 搭配商品加載圖片 -->       
            @switch($TrialItem->trialProduct->Category->category_type)
                @case(0)
                    <script>
                        insertDIV("cap" , "{{$product->id}}");
                        insertImage("{{$product->id}}", "{{ asset('images/' . $TrialItem->trialProduct->firstPhoto->file_address) }}");
                    </script>
                    @break
                @case(1)
                    <script>
                        insertDIV("top" , "{{$product->id}}");
                        insertImage("{{$product->id}}", "{{ asset('images/' . $TrialItem->trialProduct->firstPhoto->file_address) }}");
                    </script>
                    @break
                @case(2)
                    <script>
                        insertDIV("pant" , "{{$product->id}}");
                        insertImage("{{$product->id}}", "{{ asset('images/' . $TrialItem->trialProduct->firstPhoto->file_address) }}");
                    </script>
                    @break
                @case(3)
                    <script>
                        insertDIV("sock" , "{{$product->id}}");
                        insertImage("{{$product->id}}", "{{ asset('images/' . $TrialItem->trialProduct->firstPhoto->file_address) }}");
                    </script>
                    @break
                @case(4)
                    <script>
                        insertDIV("shoe" , "{{$product->id}}");
                        insertImage("{{$product->id}}", "{{ asset('images/' . $TrialItem->trialProduct->firstPhoto->file_address) }}");
                    </script>
                    @break
            @endswitch
        @endforeach
    </div>

    <div id="AddSpecification" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-8 border border-black shadow-lg rounded-md hidden overflow-y-scroll">
        <span class="absolute top-1 right-2 cursor-pointer w-5 h-5 text-2xl" onclick="closeAddSpecification()">&times;</span>
        <form action = "{{route('admin.specification.store')}}" method = "POST">
            @csrf
            <input type = "hidden" name = "product_id" value = "{{ $product->id }}">
            <h1 class = "text-xl font-bold">規格種類</h1>
            <input type = "radio" id = "size" name = "type" value = "size">
            <label for="size">尺寸</label>
            <br>
            <input type = "radio" id = "color" name = "type" value = "color">
            <label for="color">顏色</label>
            <br>
            <br>

            <label for = "name" class = "text-xl font-bold">規格名稱</label>
            <br>
            <input type = "text" id = "name" name = "name" class = "rounded">
            <input type = "submit" value = "新增" class = "ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold w-20 h-10 rounded-lg cursor-pointer">
        </form>
    </div>

    <script>
        function closeStocklist() {
            document.getElementById('stocklist').classList.add('hidden');
        }

        document.getElementById('stockcheck').addEventListener('click', function() {
            document.getElementById('stocklist').classList.remove('hidden');
            
        });

        function closePreview() {
            document.getElementById('Preview').classList.add('hidden');
        }

        document.getElementById('PreviewBtn').addEventListener('click', function() {
            document.getElementById('Preview').classList.remove('hidden');
            
        });

        function closeAddSpecification() {
            document.getElementById('AddSpecification').classList.add('hidden');
        }

        document.getElementById('AddSpecificationBtn').addEventListener('click', function() {
            document.getElementById('AddSpecification').classList.remove('hidden');
            
        });

       
    </script>
</x-admin.app-layout>
