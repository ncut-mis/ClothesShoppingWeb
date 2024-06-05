<x-admin.app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center">
                        <h1 class="text-2xl mb-4 font-bold">產品類別列表</h1>
                        <a href="{{route('admin.category.create')}}" class="ml-4 text-blue-500"><p class = "pb-4">新增類別</p></a>
                    </div>
                    @foreach($categories as $category)
                        <hr>
                        <div class = "mt-4 mb-4 flex flex-row">
                            <div class = "basis-1/3 flex items-center">
                                <h1 class = "text-xl">{{$category->name}}</h1>
                            </div>
                            <div class = "basis-1/3">
                            </div>
                            <div class = "basis-1/3 flex flex-row">
                                <div class = "basis-1/2 mt-4">
                                    <a class="btn btn-sm btn-primary basis-1/2 ml-auto mr-8 bg-blue-500 hover:bg-blue-700 text-white font-bold w-200 h-10 rounded-lg" href="{{route('admin.category.edit',$category->id)}}" >修改類別</a>
                                </div>
                                <div class = "basis-1/2 mt-4">
{{--                                    若已上架--}}
                                    @if($category->status == 1)
                                        <form action="{{route('admins.category.stop',$category->id)}}" method="POST" style="display: inline-block">
                                            @method('patch')
                                            @csrf
                                            <button class="btn btn-sm btn-warning" type="submit">下架</button>
                                        </form>
                                    @else
                                        <form action="{{route('admins.category.launch',$category->id)}}" method="POST" style="display: inline-block">
                                            @method('patch')
                                            @csrf
                                            <button class="btn btn-sm btn-warning" type="submit">下架</button>
                                        </form>
                                    @endif
                                </div>
                                <form action = "{{route('admin.category.destroy')}}" method = "POST" class = "basis-1/2 mt-4">
                                    @csrf
                                    @method('DELETE')
                                    <input type = "hidden" name = "Category_ID" value = "{{ $category->id }}">
                                    <input type = "submit" value = "刪除類別" class = "mb-4 text-white bg-red-500 hover:bg-red-800 w-20 h-10 rounded-lg cursor-pointer">
                                </form>
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
