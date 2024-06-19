<nav class="bg-gray-100 flex items-center py-4">
    <div class = "basis-1/3 flex justify-end">
        <h1 class="text-xl text-black ml-4 font-bold">穿搭建議購衣網站</h1>
    </div>
    
    <div class="basis-1/3"></div>

    <div class="basis-1/3 flex justify-end mr-4">
        @if (Route::has('login'))
            <div class="flex items-center">
                @auth
                    <a href="{{ url('/home') }}" class="text-xl font-semibold text-black hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Home</a>
                @else
                    <a href="{{ route('login') }}" class="text-xl font-semibold text-black hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">登入</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-xl ml-4 font-semibold text-black hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">註冊</a>
                    @endif
                @endauth
            </div>
        @endif
    </div>
</nav>