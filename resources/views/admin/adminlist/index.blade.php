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
                    <a href = "{{route('admin.admin.create')}}" class = "text-blue-500">新增人員</a>
                    @foreach($admins as $admin)
                        <div class = "mt-4 mb-4">
                            <h1 class = "text-xl">{{$admin->name}}</h1>
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-admin.app-layout>
