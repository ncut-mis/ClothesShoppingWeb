<x-app-layout>
    <div class="bg-orange-500 pt-4 pb-4 flex">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-lg">
            {{ __('上衣') }}
        </x-nav-link>
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-lg">
            {{ __('褲子') }}
        </x-nav-link>
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
