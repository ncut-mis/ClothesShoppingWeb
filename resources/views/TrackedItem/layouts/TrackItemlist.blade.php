<div class = "bg-white max-w-lg mt-4 ml-4 rounded-lg">
    @php 
        $user_id = Auth()->user()->id;
        $items = \App\Models\Tracked_item::where('user_id','=', $user_id)->paginate(10);
    @endphp       
    @foreach($items as $item)
        @php
            $product = \App\Models\Product::find($item->product_id);
            $productName = $product->name;
        @endphp
        <h1>{{$productName}}</h1>
        <br>
    @endforeach
    {{$items->links()}}
</div>
