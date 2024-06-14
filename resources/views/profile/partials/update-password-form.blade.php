<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

    <!-- Current Password -->
    <div>
        <x-input-label for="current_password" :value="__('Current Password')" />
        <div class="relative">
            <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <button type="button" class="opacity-30 absolute right-0 top-1/2 transform -translate-y-1/2 px-2 " onclick="togglePasswordVisibility('current_password')">
                <img src="{{ asset('images/icons/see-password.png') }}" width="30px" height="30px">
            </button>
        </div>
        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
    </div>

    <!-- New Password -->
    <div>
        <x-input-label for="password" :value="__('New Password')" />
        <div class="relative">
            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <button type="button" class="opacity-30 absolute right-0 top-1/2 transform -translate-y-1/2 px-2" onclick="togglePasswordVisibility('password')">
                <img src="{{ asset('images/icons/see-password.png') }}" width="30px" height="30px">
            </button>
        </div>
        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
    </div>

    <!-- Confirm Password -->
    <div>
        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
        <div class="relative">
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <button type="button" class="opacity-30 absolute right-0 top-1/2 transform -translate-y-1/2 px-2" onclick="togglePasswordVisibility('password_confirmation')">
                <img src="{{ asset('images/icons/see-password.png') }}" width="30px" height="30px">
            </button>
        </div>
        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
    </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 5000)"
                    class="text-sm text-green-600"
                >{{ __('Password Successfully Changed!') }}</p>
            @endif
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
</section>
