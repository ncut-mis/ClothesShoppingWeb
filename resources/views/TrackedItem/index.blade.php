@if(session('message'))    
    <script>
        alert("{{ session('message') }}");
    </script>
@endif 

<x-app-layout>
    <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h1 class = "text-2xl font-semibold">追蹤清單</h1>
                        <div class = "flex flex-row pb-4 mt-5">
                            <div class = "basis-1/2 font-semibold">商品名稱</div>
                            <div class = "basis-1/2 font-semibold">操作</div>
                        </div>
                        <hr>
                            
                        @forelse($items as $item)
                            @php
                                $product = \App\Models\Product::find($item->product_id);
                                $productName = $product->name;
                            @endphp
                            <div class = "flex flex-row mt-4">
                                <a href = "{{route('Products.show', ['product' => $product]) }}" class = "basis-1/2">
                                    <div class = "flex items-center pb-4">
                                        <img src="{{ asset('images/' . $item->product->firstPhoto->file_address) }}" class = "w-20 h-20"> 
                                        <h1 class = "ml-4">{{$productName}}</h1>
                                    </div>
                                </a>
                                <div class = "basis-1/2 flex items-center">
                                    <form method="POST" action = "{{route('trackeditem.destroy')}}">
                                        @csrf
                                        @method('DELETE')
                                        <input type = "hidden" name = "Product_ID" value = "{{ $item->product_id }}">
                                        <input type = "submit" value = "解除追蹤" class = "mb-4 text-white bg-red-500 hover:bg-red-800 w-20 h-10 rounded cursor-pointer">
                                    </form>
                                </div>
                            </div>
                            <hr>
                        @empty
                            <h1 class = "mt-4 text-gray-500">尚未有追蹤的商品</h1>
                        @endforelse

                        <!--顯示分頁連結-->
                        <div class = "flex mt-4">
                            <div class = "mx-auto">{{ $items->links('vendor.pagination.simple-tailwind') }}</div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>