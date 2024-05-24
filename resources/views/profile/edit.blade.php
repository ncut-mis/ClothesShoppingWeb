<x-app-layout>
    <div name="header" class = "bg-orange-500 pt-4 pb-4 flex">
        <div class = "basis-1/3">
            <h2 class="text-lg text-white leading-tight text-center">
                {{ __('會員中心') }}
            </h2>
        </div>
        <div class = "basis-1/3"></div>
        <div class = "basis-1/3"></div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
