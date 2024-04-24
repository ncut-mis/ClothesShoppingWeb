<x-admin.app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">               
                <div class="p-6 text-gray-900">
                    <h1 class = "text-xl mb-4 font-bold">產品類別列表</h1>
                    @foreach($items as $item)
                        <hr>
                        <div class = "mt-4 mb-4">                           
                            <h1 class = "basis-1/3">{{$item->name}}</h1>                                                  
                        </div>                                               
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-admin.app-layout>