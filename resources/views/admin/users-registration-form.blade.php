{{-- @php($user = Auth::user())
@if($user->role === 'Admin') --}}
@extends('layouts.app') <!-- Extend the master.blade.php file -->

@section('content') <!-- Start the content section -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border rounded shadow p-4">
              <div class="border-b p-2">
                <!-- Header content goes here -->
                Add new users
              </div>
              <div class="p-2">
                <!-- Body content goes here -->
                @if(Session::has('message'))
                  <div class="bg-green-500 text-white px-4 py-2 rounded">
                    <!-- Alert content goes here -->
                    {{ Session::get('message') }}
                  </div>
                @endif
                    <form method="POST" action="{{ route('admin.register.post') }}">
                        @csrf
                
                        <!-- Full Name -->
                        <div>
                            <x-input-label for="name" :value="__('Full Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                
                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                
                        <!-- Worker ID -->
                        <div class="mt-4">
                            <x-input-label for="worker_id" :value="__('Worker ID')" />
                            <x-text-input id="worker_id" class="block mt-1 w-full" type="text" name="worker_id" :value="old('worker_id')" required autocomplete="username" />
                            <x-input-error :messages="$errors->get('worker_id')" class="mt-2" />
                        </div>
                
                        <!-- Phone Number -->
                        <div class="mt-4">
                            <x-input-label for="phone_no" :value="__('Phone Number')" />
                            <x-text-input id="phone_no" class="block mt-1 w-full" type="text" name="phone_no" :value="old('phone_no')" required autocomplete="username" />
                            <x-input-error :messages="$errors->get('phone_no')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="role" :value="__('Role')" />
                            <select id="role" name="role" class="block mt-1 w-full" required autocomplete="role">
                                <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                                <option value="Super" {{ old('role') == 'Super' ? 'selected' : '' }}>Supervisor</option>
                                <option value="IO" {{ old('role') == 'IO' ? 'selected' : '' }}>Project Manager</option>
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>
                        
                        
                        
                
                        <!-- Password -->
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
                            <x-primary-button class="ms-4">
                                {{ __('Register') }}
                            </x-primary-button>
                        </div>
                    </form>
                

              </div>
            </div>
        </div>
    </div>
@endsection <!-- End the content section -->
{{-- @else
    <!-- If the user is not an admin, show a popup and redirect -->
    <script>
        alert("Access Not Allowed");
        window.location.href = "{{ route('dashboard') }}"; // Replace 'specific-page' with the actual route you want to redirect to
    </script>
@endif --}}

