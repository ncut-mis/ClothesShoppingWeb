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
                <div class="p-6 text-gray-900">
                    <h1 class = "text-2xl font-bold">試搭</h1>

                    <div class = "flex flex-row">
                        <div class = basis-1/2>
                            <div class = "mt-4">
                                <label for = "type" class = "text-xl font-bold">搜尋商品</label>
                                <select id = "type" name = "type" class = "rounded-lg" onchange="handleTypeChange()">
                                    <option value = "0">頭部飾品</option>
                                    <option value = "1">衣類</option>
                                    <option value = "2">褲裙</option>
                                    <option value = "3">襪類</option>
                                    <option value = "4">鞋類</option>
                                </select>
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

                            @switch($MainProduct->Category->category_type)
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
                                    @switch($TrialTtem->trialProduct->Category->category_type)
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