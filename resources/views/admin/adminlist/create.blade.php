<x-admin.app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">               
                <div class="p-6 text-gray-900">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li class = "text-red-500">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method = "POST" action = "{{route('admin.admin.store')}}" enctype="multipart/form-data">
                        @csrf
                        <label for = "FirstName">名</label>
                        <input type = "text" name = "FirstName" id = "FirstName">
                        <br>
                        <label for = "LastName">姓</label>
                        <input type = "text" name = "LastName" id = "LastName">
                        <br>
                        <label for="title">職稱</label>
                        <select id="title" name="title">
                            <option value="搭配專員">搭配專員</option>
                            <option value="訂單管理員">訂單管理員</option>
                            <option value="商品管理員">商品管理員</option>
                        </select>
                        <br>
                        <label for = "email">電子郵件</label>
                        <input type = "text" name = "email" id = "email">
                        <br>
                        <label for = "password">密碼</label>
                        <input type = "password" name = "password" id = "password">
                        <br>
                        <input type = "submit" value = "確認" class = "bg-blue-300 w-20 h-10 cursor-pointer">
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin.app-layout>