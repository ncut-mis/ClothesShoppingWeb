<x-admin.app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">               
                <div class="p-6 text-gray-900">
                    <form method = "POST" action = "{{route('admin.admin.store')}}" enctype="multipart/form-data">
                        @csrf
                        <label for = "name">名稱</label>
                        <input type = "text" name = "name" id = "name">
                        <label for = "email">電子郵件</label>
                        <input type = "text" name = "email" id = "email">
                        <label for = "password">密碼</label>
                        <input type = "password" name = "password" id = "password">
                        <input type = "submit" value = "創建" class = "bg-blue-300 w-20 h-10 cursor-pointer">
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin.app-layout>