<script>
    function handleTypeChange() {
        var categoryType = document.getElementById('type').value;

        fetch(`/admin/TrialItem/categorySearch/${categoryType}`)
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

                            <div class = "mt-8">
                                <h1 class = "text-red-500">按下Ctrl以多選</h1>
                                <form method = "POST" action = "{{route('admin.combination.detail_add')}}">
                                    @csrf
                                    <select multiple id = "product" name = "product" class = "w-80">
                                    </select>    
                                    <input type = "hidden" name = "combinationID" value = "{{ $combination->id }}"> 
                                    <br>
                                    <input type = "submit" value = "加入組合" class = "mt-4 bg-blue-500 hover:bg-blue-700 w-20 h-10 cursor-pointer rounded-lg text-white"> 
                                </form>       
                            </div>

                            <hr>
                            <h1>組合內的商品</h1>
                            <h1>主商品：{{$combination->product->name}}</h1>
                            <img src="{{ asset('images/' . $combination->product->firstPhoto->file_address) }}" class = "w-40 h-40 border ml-4">
                            <hr>
                            @foreach($combination->combinations_detail as $detail)
                                <h1>{{$detail->product->name}}</h1>
                                <img src="{{ asset('images/' . $detail->product->firstPhoto->file_address) }}" class = "w-40 h-40 border ml-4">
                                <form method = "POST" action = "{{route('admin.combination.detail_delete')}}">
                                    @csrf
                                    @method('DELETE')    
                                    <input type = "hidden" id = "detail_id" name = "detail_id" value = "{{$detail->id}}">
                                    <input type = "submit" value = "刪除" class = "rounded bg-red-500 hover:bg-red-500 w-20 h-10 text-white cursor-pointer">
                                </form>
                                <hr>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-admin.app-layout>
