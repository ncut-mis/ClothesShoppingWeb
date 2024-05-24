<x-admin.app-layout>
    @if(session('message'))    
        <script>
            alert("{{ session('message') }}");
        </script>
    @endif
    
    <script>
       function handleTypeChange() {
            var categoryType = document.getElementById('type').value;

            fetch(`/admin/ProductTypeSearch/${categoryType}`)
            .then(response => response.json())
            .then(data => {
                const selectElement = document.getElementById('product');
                selectElement.innerHTML = '';  // 清空现有的选项

                if (data && Array.isArray(data)) {
                    data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id;
                        option.text = item.name;
                        selectElement.appendChild(option);
                    });
                } else {
                    console.error('Search failed.');
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function handleSearch(event) {
            event.preventDefault(); // 阻止表单的默认提交行为

            const form = event.target;
            const formData = new FormData(form);
            const action = form.action;
            const csrfToken = form.querySelector('input[name="_token"]').value;

            fetch(action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const selectElement = document.getElementById('product');
                selectElement.innerHTML = ''; // 清空现有的选项

                if (data && Array.isArray(data)) {
                    data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id;
                        option.text = item.name;
                        selectElement.appendChild(option);
                    });
                } else {
                    console.error('Search failed.');
                }
            })
            .catch(error => console.error('Error:', error));
        }

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
                    <h1 class = "text-2xl font-bold">試搭</h1>
                
                    <div class = "flex flex-row">
                        <div class = basis-1/2>
                            <div class = "mt-4">
                                <div class = "mb-4">
                                    <h1>主要商品：{{$MainProduct->name}}</h1>
                                    <img src="{{ asset('images/' . $MainProduct->firstPhoto->file_address) }}" class = "border w-80 h-80"> 
                                </div>  
                                 
                                <div class = "flex flex-row">
                                    <div class = "basis-1/5">
                                        <label for = "type" class = "text-xl font-bold">搜尋商品</label>
                                        <br>
                                        <select id = "type" name = "type" class = "rounded-lg" onchange="handleTypeChange()">
                                            <option value = "0">頭部飾品</option>
                                            <option value = "1">衣類</option>
                                            <option value = "2">褲裙</option>
                                            <option value = "3">襪類</option>
                                            <option value = "4">鞋類</option>
                                        </select>
                                    </div>

                                    <div class = "basis-4/5 mt-7">
                                        <form method = "POST" action = "{{route('admin.product.TrialProuctSearch')}}" id = "search" name = "search" onsubmit="handleSearch(event)">
                                            @csrf
                                            <label for = "keyword" class = "text-white text-xl">搜尋</label>
                                            <input type = "text" id = "keyword" name = "keyword" class = "rounded-lg ml-4" placeholder="請輸入關鍵字">
                                            <input type="submit" value="搜尋" class = "bg-orange-800 hover:bg-orange-900 text-white rounded-lg w-20 h-10 cursor-pointer">
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class = "mt-8">
                                <h1 class = "text-red-500">按下Ctrl以多選</h1>
                                <form method = "POST" action = "{{route('admin.trialitem.store')}}">
                                    @csrf
                                    <select multiple id = "product" name = "product" class = "w-80">
                                    </select>     
                                    <input type = "hidden" name = "MainProductID" value = "{{$MainProduct->id}}">
                                    <br>
                                    <input type = "submit" value = "加入試搭" class = "mt-4 bg-blue-500 hover:bg-blue-700 w-20 h-10 cursor-pointer rounded-lg text-white"> 
                                </form>       
                            </div>
                            <div>
                                <h1 class = "text-2xl font-bold mt-4 mb-4">試搭商品清單</h1>
                                <hr>
                                @foreach($TrialTtems as $TrialTtem)
                                <div class = "flex flex-row mt-4">
                                    <div class = "basis-1/3">
                                        <img src="{{ asset('images/' . $TrialTtem->trialProduct->firstPhoto->file_address) }}" class = "w-10 h-10 basis-1/3"> 
                                    </div>    
                                    <h1 class = "text-xl basis-1/3">{{$TrialTtem->trialProduct->name}}</h1>
                                    <form method = "POST" action = "{{route('admin.trialitem.destroy')}}" class = "basis-1/3">
                                        @csrf
                                        @method('DELETE')
                                        <input type = "hidden" name = "TrialitemID" value = "{{ $TrialTtem->id }}">
                                        <input type = "hidden" name = "productID" value = "{{ $MainProduct->id }}">
                                        <input type = "submit" class = "bg-red-500 hover:bg-blue-700 text-white font-bold w-20 h-10 rounded-lg ml-4 mb-4 cursor-pointer" value = "刪除">
                                    </form>                               
                                </div>
                                <hr>
                                @endforeach
                                <div class = "relative pb-12">
                                    <a href = "{{route('admin.combination.create',['product' => $MainProduct])}}" class = "absolute right-4 w-40 h-10 bg-blue-500 rounded-lg text-white flex items-center justify-center mt-4 mb-4">加入搭配組合</a>
                                </div>
                            </div>
                        </div>

                        <div class = "basis-1/2">
                            <div class = "grid grid-cols-1 gap-1 border">
                                <div class="h-40 mt-4 ml-4 mr-4 md:col-span-2 border" id = "cap">
                                </div>
                                <div class="h-40 ml-4 mr-4 md:col-span-2 border" id = "top">
                                </div>
                                <div class="h-40 ml-4 mr-4 md:col-span-2 border" id = "pant">
                                </div>
                                <div class="h-40 ml-4 mr-4 md:col-span-2 border" id = "sock">
                                </div>
                                <div class="h-40 mb-4 ml-4 mr-4 md:col-span-2 border" id = "shoe">
                                </div>
                            </div>

                            <!-- 主商品 -->
                            @switch($MainProduct->Category->image_position)
                                @case(0)
                                    <script>
                                        insertDIV("cap" , "{{$MainProduct->id}}");
                                        insertImage("{{$MainProduct->id}}", "{{ asset('images/' . $MainProduct->firstPhoto->file_address) }}");
                                    </script>
                                    @break
                                @case(1)
                                    <script>
                                        insertDIV("top" , "{{$MainProduct->id}}");
                                        insertImage("{{$MainProduct->id}}", "{{ asset('images/' . $MainProduct->firstPhoto->file_address) }}");
                                    </script>
                                    @break
                                @case(2)
                                    <script>
                                        insertDIV("pant" , "{{$MainProduct->id}}");
                                        insertImage("{{$MainProduct->id}}", "{{ asset('images/' . $MainProduct->firstPhoto->file_address) }}");
                                    </script>
                                    @break
                                @case(3)
                                    <script>
                                        insertDIV("sock" , "{{$MainProduct->id}}");
                                        insertImage("{{$MainProduct->id}}", "{{ asset('images/' . $MainProduct->firstPhoto->file_address) }}");
                                    </script>
                                    @break
                                @case(4)
                                    <script>
                                        insertDIV("shoe" , "{{$MainProduct->id}}");
                                        insertImage("{{$MainProduct->id}}", "{{ asset('images/' . $MainProduct->firstPhoto->file_address) }}");
                                    </script>
                                    @break
                            @endswitch
                            
                            @if(isset($TrialTtems))
                                @foreach($TrialTtems as $TrialTtem)
                                    @switch($TrialTtem->trialProduct->Category->image_position)
                                        @case(0)
                                            <script>
                                                insertDIV("cap" , "{{$TrialTtem->trialProduct->id}}");
                                                insertImage("{{$TrialTtem->trialProduct->id}}", "{{ asset('images/' . $TrialTtem->trialProduct->firstPhoto->file_address) }}");
                                            </script>
                                            @break
                                        @case(1)
                                            <script>
                                                insertDIV("top" , "{{$TrialTtem->trialProduct->id}}");
                                                insertImage("{{$TrialTtem->trialProduct->id}}", "{{ asset('images/' . $TrialTtem->trialProduct->firstPhoto->file_address) }}");
                                            </script>
                                            @break
                                        @case(2)
                                            <script>
                                                insertDIV("pant" , "{{$TrialTtem->trialProduct->id}}");
                                                insertImage("{{$TrialTtem->trialProduct->id}}", "{{ asset('images/' . $TrialTtem->trialProduct->firstPhoto->file_address) }}");
                                            </script>
                                            @break
                                        @case(3)
                                            <script>
                                                insertDIV("sock" , "{{$TrialTtem->trialProduct->id}}");
                                                insertImage("{{$TrialTtem->trialProduct->id}}", "{{ asset('images/' . $TrialTtem->trialProduct->firstPhoto->file_address) }}");
                                            </script>
                                            @break
                                        @case(4)
                                            <script>
                                                insertDIV("shoe" , "{{$TrialTtem->trialProduct->id}}");
                                                insertImage("{{$TrialTtem->trialProduct->id}}", "{{ asset('images/' . $TrialTtem->trialProduct->firstPhoto->file_address) }}");
                                            </script>
                                            @break
                                    @endswitch
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin.app-layout>  