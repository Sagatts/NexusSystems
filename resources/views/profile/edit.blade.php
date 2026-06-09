<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mi Perfil
        </h2>
    </x-slot>

    <div class="container mt-4">

        @include('profile.partials.update-profile-information-form')

        <div class="mt-4">
            @include('profile.partials.update-password-form')
        </div>

    </div>
</x-app-layout>