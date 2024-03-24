<script>
    @if(session('message'))    
        alert("{{ session('message') }}");
    @endif 
</script>

<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class = "flex flex-row pb-8">
                        <h1 class = "basis-1/3">商品名稱</h1>
                        <p class = "basis-1/3"></p>
                        <div class = "basis-1/3">操作</div>
                    </div>
                    @php 
                        $user_id = Auth()->user()->id;
$items = \App\Models\Tracked_item::where('user_id', '=', $user_id)->paginate(10);
                    @endphp       
                    @foreach($items as $item)
                        @php
    $product = \App\Models\Product::find($item->product_id);
    $productName = $product->name;
                        @endphp
                        <div class = "flex flex-row pb-8">
                            <h1 class = "basis-1/3">{{$productName}}</h1>
                            <p class = "basis-1/3"></p>
                            <div class = "basis-1/3">
                                <form method="POST" action = "{{route('trackeditem.destroy')}}">
                                    @csrf
                                    @method('DELETE')
                                    <input type = "hidden" name = "Track_ID" value = "{{ $item->id }}">
                                    <x-primary-button >{{ __('解除追蹤') }}</x-primary-button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                    {{$items->links()}}
            </div>
        </div>
    </div>
</div>