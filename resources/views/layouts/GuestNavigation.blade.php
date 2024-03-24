<nav class="bg-orange-300 flex items-center h-screen flex flex-row h-14">
    <h1 class="text-xl text-white mt-4 mb-4 basis-1/3 text-right">購衣網站</h1>
    <div class = "basis-1/3"></div>
    <div class = "basis-1/3 flex justify-end">
        @if (Route::has('login'))
            <div class="flex items-center h-screen">
                @auth
                    <a href="{{ url('/home') }}" class="text-xl font-semibold text-white hover:text-gray-900 dark:text-white dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Home</a>
                @else
                    <a href="{{ route('login') }}" class="text-xl font-semibold text-white hover:text-gray-900 dark:text-white dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">登入</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-xl ml-4 font-semibold text-white hover:text-gray-900 dark:text-white dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">註冊</a>
                    @endif
                @endauth
                <div class = "ml-4"></div>
            </div>
        @endif
    </div>
</nav>