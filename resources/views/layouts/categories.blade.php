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
            {{ \App\Models\Category::paginate(10)->links() }}
        </div>
    </div>

    @include('layouts.partials.category_items')

</x-app-layout>
