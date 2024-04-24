<x-admin.app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">               
                <div class="p-6 text-gray-900">
                    <h1 class = "text-xl mb-4 font-bold">商品列表</h1>
                    @foreach($products as $product)
                        <hr>
                        <div class = "mt-4 mb-4 flex flex-row">                           
                            <div class = "basis-1/3">
                                <img src="{{ asset('images/' . $product->firstPhoto->file_address) }}" class = "w-20 h-20 basis-1/3"> 
                            </div>     
                            <h1 class = "basis-1/3">{{$product->name}}</h1>                      
                            <div class = "basis-1/3"></div>
                        </div>                                               
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-admin.app-layout>