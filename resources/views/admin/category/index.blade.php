<x-admin.app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">               
                <div class="p-6 text-gray-900">
                    <div class="flex items-center">
                        <h1 class="text-xl mb-4 font-bold">產品類別列表</h1>           
                        <a href="#" class="ml-4 text-blue-500"><p class = "pb-4">新增類別</p></a>
                    </div>
                    @foreach($categories as $category)
                        <hr>
                        <div class = "mt-4 mb-4 flex flex-row">      
                            <div class = "basis-1/3 flex items-center">                     
                                <h1>{{$category->name}}</h1>   
                            </div>    
                            <div class = "basis-1/3">                     
                            </div>   
                            <div class = "basis-1/3">     
                                <button id="" class="basis-1/2 ml-auto mr-8 bg-blue-500 hover:bg-blue-700 text-white font-bold w-20 h-10 rounded-lg">修改類別</button>              
                            </div>                                             
                        </div>                                               
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class = "flex">
        <div class = "mx-auto">{{ $categories->links('vendor.pagination.simple-tailwind') }}</div>
    </div>
</x-admin.app-layout>