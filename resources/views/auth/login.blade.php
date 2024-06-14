<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="worker_id" :value="__('Worker ID')" />
            <x-text-input id="worker_id" class="block mt-1 w-full" type="text" name="worker_id" :value="old('worker_id')" required autofocus autocomplete="username" />
            
            @error('worker_id')
                <div class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <div>
                        <span class="font-medium">{{ $message }}</span> 
                    </div>
                </div>
            @enderror
        
        </div>
        
{{-- <x-input-error :messages="$errors->get('worker_id')" class="mt-2" /> --}}
        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
        
            <div class="relative">
                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
        
                <button type="button" class="opacity-50 absolute right-0 top-1/2 transform -translate-y-1/2 px-2" onclick="togglePasswordVisibility('password')">
                    <img src="{{ asset('images/icons/see-password.png') }}" width="30px" height="30px">
                </button>
            </div>
        
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <p class="text-sm text-gray-600 py-2">Forgot Password? Call : 0193890124</p>

            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span><br>
            </label>

        </div>
        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
    <script>
        function togglePasswordVisibility(fieldId) {
            var passwordField = document.getElementById(fieldId);
            if (passwordField.type === "password") {
                passwordField.type = "text";

            } else {
                passwordField.type = "password";
            }
        }
    </script>
</x-guest-layout>
