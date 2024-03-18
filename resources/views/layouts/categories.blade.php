<x-app-layout>
    <div class="bg-orange-500 pt-4 pb-4 flex justify-between">
        <div class="flex">
            @foreach (\App\Models\Category::paginate(10) as $category)
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-lg">
                    {{ $category->name }}
                </x-nav-link>
            @endforeach
        </div>
        <div class="flex">
            {{ \App\Models\Category::paginate(10)->links() }}
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
