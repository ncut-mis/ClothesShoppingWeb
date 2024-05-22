@if(session('message'))    
    <script>
        alert("{{ session('message') }}");
    </script>
@endif 

<x-admin.app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">               
                <div class="p-6 text-gray-900">
                    <h1 class = "text-2xl font-bold inline-block">管理員清單</h1>

                    <!-- 新增人員頁面連結 -->
                    <a href = "{{route('admin.admin.create')}}" class = "text-blue-500">新增人員</a>

                    <div class = "mt-4 mb-4 flex flex-row">
                        <h1 class = "text-xl font-bold basis-1/3">姓名</h1>
                        <h1 class = "text-xl font-bold basis-1/3">職稱</h1>
                        <h1 class = "text-xl font-bold basis-1/3">操作</h1>
                    </div>
                    <hr>
                    @foreach($admins as $admin)                     
                        <div class = "mt-4 mb-4 flex flex-row">
                            <h1 class = "text-xl basis-1/3 mt-2">{{$admin->FirstName}} {{$admin->LastName}}</h1>
                            <h1 class = "text-xl basis-1/3 mt-2">{{$admin->title}}</h1>
                            <form method = "POST" action = "{{route('admin.admin.destroy')}}" class = "basis-1/3">
                                @csrf
                                @method('DELETE')
                                <input type = "hidden" id = "adminID" name = "adminID" value = "{{$admin->id}}">
                                <input type = "submit" value = "刪除" class = "w-20 h-10 text-white rounded bg-red-500 hover:bg-red-700 cursor-pointer">
                            </form>
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-admin.app-layout>
