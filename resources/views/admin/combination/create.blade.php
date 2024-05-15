<x-admin.app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class = "text-2xl mb-4 font-bold">新增搭配組合</h1>
                    <form method = "POST" action = "{{route('admin.combination.store')}}">
                        @csrf
                        <label for = "CombinationName" class = "text-xl">組合名稱</label>
                        <input type = "text" id = "CombinationName" name = "CombinationName" class = "rounded"></input>
                        <input type = "hidden" id = "MainProductID" name = "MainProductID" value = "{{$MainProduct->id}}"></input>
                        <input type = "submit" value = "加到搭配清單" class = "text-white bg-blue-500 hover:bg-blue-700 rounded-lg w-40 h-10 cursor-pointer">
                    </form>
                    
                    <div class = "mt-4 border border-black w-1/2">
                        <div class = "flex flex-row">
                            <div class = "basis-1/2">
                                <img src="{{ asset('images/' . $MainProduct->firstPhoto->file_address) }}" class = "w-20 h-20 basis-1/3">
                            </div>
                            <h1 class = "basis-1/2 flex items-center justify-center">{{$MainProduct->name}} (主商品)</h1>                                                         
                        </div>

                        @foreach($trialItems as $trialItem)
                            <hr class = "border-t-1 border-black">
                            <div class = "flex flex-row">
                                <div class = "basis-1/2">
                                    <img src="{{ asset('images/' . $trialItem->trialProduct->firstPhoto->file_address) }}" class = "w-20 h-20 basis-1/3">
                                </div>
                                <h1 class = "basis-1/2 flex items-center justify-center">{{$trialItem->trialProduct->name}}</h1>                    
                            </div>                         
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin.app-layout>
