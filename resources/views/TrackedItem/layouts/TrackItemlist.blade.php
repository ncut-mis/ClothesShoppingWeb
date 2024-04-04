<script>
    @if(session('message'))    
        alert("{{ session('message') }}");
    @endif 
</script>

<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class = "text-2xl font-semibold">追蹤清單</h1>
                    <div class = "flex flex-row pb-4 mt-5">
                        <div class = "basis-1/3 font-semibold">商品名稱</div>
                        <div class = "basis-1/3 font-semibold"></div>
                        <div class = "basis-1/3 font-semibold">操作</div>
                    </div>
                    <hr>
                          
                    @foreach($items as $item)
                        @php
                            $product = \App\Models\Product::find($item->product_id);
                            $productName = $product->name;
                        @endphp
                        <div class = "flex flex-row mt-4">
                            <div class = "basis-1/3 flex items-center pb-4">{{$productName}}</div>
                            <div class = "basis-1/3 flex items-center pb-4"></div>
                            <div class = "basis-1/3">
                                <form method="POST" action = "{{route('trackeditem.destroy')}}">
                                    @csrf
                                    @method('DELETE')
                                    <input type = "hidden" name = "Track_ID" value = "{{ $item->id }}">
                                    <input type = "submit" value = "解除追蹤" class = "mb-4 text-white bg-red-500 hover:bg-red-800 w-20 h-10 rounded cursor-pointer">
                                </form>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                    {{$items->links()}}
            </div>
        </div>
    </div>
</div>