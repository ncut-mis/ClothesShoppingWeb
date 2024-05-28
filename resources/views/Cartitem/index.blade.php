@if(session('message'))    
    <script>
        alert("{{ session('message') }}");
    </script>
@endif 

@php
    use Illuminate\Support\Facades\Auth;
@endphp

<x-app-layout>
    <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h1 class = "text-2xl font-bold">購物車清單</h1>
                        <div class = "flex flex-row pb-4 mt-8">
                            <h1 class = "basis-1/6 font-bold">商品名稱</h1>
                            <h1 class = "basis-1/6 font-bold">單價</h1>
                            <h1 class = "basis-1/6 font-bold">尺寸</h1>
                            <h1 class = "basis-1/6 font-bold">顏色</h1>
                            <h1 class = "basis-1/6 font-bold">數量</h1>
                            <h1 class = "basis-1/6 font-bold">操作</h1>
                        </div>  
                        <hr>    
                        @php
                        $amount = 0; 
                        @endphp

                        <!--顯示購物車清單-->
                        @foreach($items as $item)
                            @php
                                $itemID = $item->id;
                                $amount += ($item->quantity)*($item->product->price);
                                $product = \App\Models\Product::find($item->product_id);
                            @endphp
                            <div class = "flex flex-row mt-4">
                                <a href = "{{route('Products.show', ['product' => $product]) }}" class = "basis-1/6">
                                    <div class = "flex items-center pb-4">
                                        <img src="{{ asset('images/' . $item->product->firstPhoto->file_address) }}" class = "w-10 h-10"> 
                                        <h1 class = "ml-4">{{$item->product->name}}</h1>
                                    </div>
                                </a>

                                <h1 class = "basis-1/6 mt-2 text-red-500">{{$item->product->price}}</h1 >

                                <!-- 修改尺寸 -->
                                <div  class = "basis-1/6">
                                    <form method = "POST" action = "{{route('cartitem.update')}}" id = "sizeChange">
                                        @csrf
                                        @method('patch')
                                        <input type = "hidden" name = "CartID" value = "{{$itemID}}">
                                        <select id = "size" name = "size" onchange="submitsizeChangeForm()" class = "rounded">
                                            @foreach($product->specification as $specification)
                                                @if($specification->specification_type === 'size')
                                                    <option value="{{$specification->name}}" {{ $item->size == $specification->name ? 'selected' : '' }}>{{$specification->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </form>
                                </div >

                                <!-- 修改顏色 -->
                                <div  class = "basis-1/6">
                                    <form method = "POST" action = "{{route('cartitem.update')}}" id = "colorChange">
                                        @csrf
                                        @method('patch')
                                        <input type = "hidden" name = "CartID" value = "{{$itemID}}">
                                        <select id = "color" name = "color" onchange="submitcolorChangeForm()" class = "rounded">
                                            @foreach($product->specification as $specification)
                                                @if($specification->specification_type === 'color')
                                                    <option value="{{$specification->name}}" {{ $item->color == $specification->name ? 'selected' : '' }}>{{$specification->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </form>
                                </div >
                                
                                <!-- 修改數量 -->
                                <div  class = "basis-1/6">
                                    <form method="POST" action="{{route('cartitem.update')}}" id = "quantityChange">
                                        @csrf  
                                        @method('patch')
                                        <input type = "hidden" name = "CartID" value = "{{$itemID}}">
                                        <input type = "number" name = "quantity" min = "1" max = "50" value = "{{$item->quantity}}" onchange="submitquantityChangeForm()" class = "rounded">
                                    </form>
                                </div >

                                <!--操作按鈕區塊-->
                                <div class = "basis-1/6">                           
                                    <!--移出購物車區塊-->
                                    <form method = "POST" action = "{{route('cartitem.destroy')}}" class = "mb-4">
                                        @csrf
                                        @method('DELETE')
                                        <input type = "hidden" name = "CartID" value = "{{$item->id}}">
                                        <input type = "submit" value = "移出購物車" class = "bg-red-500 hover:bg-red-800 w-20 h-10 text-white font-bold rounded cursor-pointer">
                                    </form>                                
                                </div>
                            </div>
                            <hr>                       
                        @endforeach
                        {{$items->links()}}

                        <!--結帳區塊-->
                        <div class = "flex">
                            <h1 class = "text-red-500 text-2xl mt-6">NT {{$amount}}</h1>
                            <a href="{{ route('order.create', ['userId' => Auth::id()]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold w-20 h-10 rounded-lg ml-auto mt-4">
                                <h1 class="text-center mt-2">結帳</h1>
                            </a>                       
                        </div>
                        
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function submitsizeChangeForm() {
        document.getElementById("sizeChange").submit();
    }

    function submitcolorChangeForm() {
        document.getElementById("colorChange").submit();
    }

    function submitquantityChangeForm() {
        document.getElementById("quantityChange").submit();
    }
</script>
