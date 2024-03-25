<x-app-layout>
    <div class="bg-orange-500 pt-4 pb-4 flex justify-between">
        <div class="flex">
            <x-nav-link :href="route('/home')" class="text-lg">
                所有商品
            </x-nav-link>
            @foreach (\App\Models\Category::paginate(10) as $category)
                <x-nav-link :href="route('Categorys.show' , ['category' => $category])"  class="text-lg">
                    {{ $category->name }}
                </x-nav-link>
            @endforeach
        </div>
        <div class="flex">
            <form method="GET" action = "{{route('Products.search')}}">
                @csrf
                <label for = "keyword" class = "text-white text-xl">搜尋</label>
                <input type = "text" id = "keyword" name = "keyword" class = "rounded-lg ml-4">
                <input type="submit" value="搜尋" class = "bg-orange-800 text-white rounded-lg w-20 h-10">
            </form>
        </div>
        <div class="flex">
            {{ \App\Models\Category::paginate(10)->links('pagination::tailwind') }}
        </div>
    </div>

    @include('layouts.partials.category_items')

</x-app-layout>
