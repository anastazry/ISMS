<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>                
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="flex items-center justify-center h-screen">
        <form method="POST" action="{{ route('user-reset-password', ['token' => request()->route('token')]) }}">
            @csrf
            <input type="hidden" name="token" value="{{ request()->route('token') }}">
            <div class="bg-gray-100 p-8 rounded-lg w-3/5 h-4/5">
                <h1 class="text-2xl font-bold mb-4">Welcome to ISMS!</h1>
                <h3 class="text-lg mb-4">First-time users will need to update to a new password.</h3>
        
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
        
                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
                <div class="flex items-center justify-end mt-4">
                    <x-primary-button>
                        {{ __('Reset Password') }}
                    </x-primary-button>
                </div>
            </div>
        </form>
    </body>
    
</html>