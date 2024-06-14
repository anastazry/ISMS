@extends('layouts.app') <!-- Extend the master.blade.php file -->

@section('content') <!-- Start the content section -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border rounded shadow p-4">
              <div class="border-b p-2">
                <!-- Header content goes here -->
                Edit training
              </div>
              <div class="p-2">
                <!-- Body content goes here -->
                @if(Session::has('message'))
                  <div class="bg-green-500 text-white px-4 py-2 rounded">
                    <!-- Alert content goes here -->
                    {{ Session::get('message') }}
                  </div>
                @endif
                <form method="post" action="" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
                @csrf
                    <table class="min-w-full divide-y divide-gray-200">
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">Training Name</td>
                            <td class="px-6 py-4">
                                <input type="text" name="name" value="{{ old('name', $training->name) }}" class="p-2 border rounded-md w-full">
                                @error('name')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <!-- ... similar for other rows ... -->
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">Description</td>
                            <td class="px-6 py-4">
                                <textarea name="description" rows="4" class="p-2 border rounded-md w-full">{{ old('description', $training->description) }}</textarea>
                                @error('description')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>                    
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">Trainer</td>
                            <td class="px-6 py-4">
                                <input type="text" name="trainer" value="{{ old('trainer', $training->trainer) }}" class="p-2 border rounded-md w-full">
                                @error('trainer')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">Photo</td>
                            <td class="px-6 py-4">
                                <input type="file" name="photo" class="p-2 border rounded-md w-full">
                                @error('photo')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">Price</td>
                            <td class="px-6 py-4">
                                <input type="number" name="price" value="{{ old('price', $training->price) }}" class="p-2 border rounded-md w-full" min="0.00" max="10000.00" step="0.01">
                                @error('price')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">Date</td>
                            <td class="px-6 py-4">
                                <input type="date" name="date" value="{{ old('date', $training->date) }}" class="p-2 border rounded-md w-full">
                                @error('date')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">Time</td>
                            <td class="px-6 py-4">
                                <input type="time" name="time" value="{{ old('time', $training->time) }}" class="p-2 border rounded-md w-full">
                                @error('time')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">Place</td>
                            <td class="px-6 py-4">
                                <input type="text" name="place" value="{{ old('place', $training->place) }}" class="p-2 border rounded-md w-full">
                                @error('place')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">Capacity</td>
                            <td class="px-6 py-4">
                                <input type="number" name="capacity" value="{{ old('capacity', $training->capacity) }}" class="p-2 border rounded-md w-full" min="0">
                                @error('capacity')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">Duration</td>
                            <td class="px-6 py-4">
                                <input type="number" name="duration" value="{{ old('duration', $training->duration) }}" class="p-2 border rounded-md w-full" min="0">
                                @error('duration')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">Status</td>
                            <td class="px-6 py-4">
                                <select name="status" class="p-2 border rounded-md w-full">
                                    <option value="available" {{ old('status', $training->status) == 'available' ? 'selected' : '' }}>Available</option>
                                    <option value="not available" {{ old('status', $training->status) == 'not available' ? 'selected' : '' }}>Not Available</option>
                                </select>
                                @error('status')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4"></td>
                            <td class="px-6 py-4">
                                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
                                    Save
                                </button>
                                
                                <button onclick="event.preventDefault(); location.href='{{ route('admin.training-list') }}';" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
                                    Cancel
                                </button>
                                
                            </td>
                        </tr>
                    </tbody>
                    </table>
                </form>

              </div>
            </div>
        </div>
    </div>
@endsection <!-- End the content section -->














<nav x-data="{ open: false }" class="w-1/8 bg-white border-r border-gray-100 fixed left-0 top-0 h-full text-lg">
    <!-- Primary Navigation Menu -->
    <div class="max-h-screen h-full overflow-y-auto">
        <div class="flex flex-col justify-between h-full">
            <div class="flex flex-col">
                <!-- Profile Picture and User Name -->
                <div class="shrink-0 flex items-center justify-center flex-col bg-">
                    @auth
                        <a href="{{ route('profile.edit') }}">
                            @php($user = Auth::user())
                
                            @if($user && $user->profile_photo)
                                <img class="mt-4 md:mt-8 lg:mt-12 w-20 h-20 rounded-full object-cover mx-auto block"
                                     src="{{ asset('storage/profile_photos/' . $user->profile_photo) }}?v={{ $user->updated_at->timestamp }}"
                                     alt="Profile Image">
                            @else
                                <img class="mt-4 md:mt-8 lg:mt-12 w-20 h-20 rounded-full object-cover mx-auto block"
                                     src="{{ asset('storage/profile_photos/default-user.png') }}"
                                     alt="Profile Image">
                            @endif
                        </a>
                        <label for="user-fullname" class="mt-2 ml-2 mr-2 text-lg">{{$user->name}}</label>
                </div>
                
                <!-- Navigation Links -->
                    @if($user->role == 'Admin')
                <div class="w-60 space-y-8 sm:mt-10 sm:flex sm:flex-col">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('admin.users-list')"
                        class="w-full text-left px-3 py-2 border border-transparent text-base leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <x-nav-link :href="route('admin.users-list')" :active="request()->routeIs('admin.users-list')" class="w-full text-base px-3 py-1 border border-transparent leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">
                        {{ __('Manage Users') }}
                    </x-nav-link>

                    <x-nav-link :href="route('admin-users-registration-form')" :active="request()->routeIs('admin-users-registration-form')" class="w-full text-left px-3 py-1 border border-transparent text-base leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">
                        {{ __('Register') }}
                    </x-nav-link>

                    <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')" class="w-full text-left px-3 py-1 border border-transparent text-lg leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">
                        {{ __('Profile') }}
                    </x-nav-link>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: block;">
                        @csrf
                        <button type="submit" class="w-full text-left px-3 py-1 border border-transparent text-lg leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                    
                    
                </div>
                @else
                <div class="w-60 space-y-8 sm:mt-10 sm:flex sm:flex-col">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                        class="{{ request()->routeIs('dashboard') ? 'w-full text-left px-3 py-1 border border-transparent text-base leading-4 font-medium rounded-md text-gray-700 bg-gray-200 focus:outline-none focus:bg-gray-200 transition' : 'w-full text-left px-3 py-1 border border-transparent text-lg leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition' }}">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    
                    <x-nav-link :href="route('user.hirarc-list')" :active="request()->routeIs('admin.users-list')"
                        class="{{ request()->routeIs('user.hirarc-list') ? 'w-full text-left px-3 py-1 border border-transparent text-lg leading-4 font-medium rounded-md text-gray-700 bg-gray-200 focus:outline-none focus:bg-gray-200 transition' : 'w-full text-left px-3 py-1 border border-transparent text-lg leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition' }}">
                        {{ __('HIRARC') }}
                    </x-nav-link>

                    <x-nav-link :href="route('user-incident-list')" :active="request()->routeIs('admin.users-list')" 
                        class="{{ request()->routeIs('user-incident-list') ? 'w-full text-left px-3 py-1 border border-transparent text-lg leading-4 font-medium rounded-md text-gray-700 bg-gray-200 focus:outline-none focus:bg-gray-200 transition' : 'w-full text-left px-3 py-1 border border-transparent text-lg leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition' }}">
                        {{ __('Incident') }}
                    </x-nav-link>

                    <div class="relative w-full text-left px-3 py-1 border border-transparent text-lg leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">
                        <button id="dropdownButton" class="class="{{ request()->routeIs('user-incident-analysis') ? 'w-full text-left px-3 py-1 border border-transparent text-lg leading-4 font-medium rounded-md text-gray-700 bg-gray-200 focus:outline-none focus:bg-gray-200 transition' : 'w-full text-left px-3 py-1 border border-transparent text-lg leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition' }}"
                        
                        >
                            {{ __('Safety Analysis') }}
                        </button>
                        <div id="dropdownContent" class="hidden absolute bg-white border rounded-md mt-1 z-10">
                            <a href="{{ route('user-incident-analysis') }}" class="block px-4 py-2 text-lg text-gray-700 hover:bg-gray-100">Overall Safety Analysis</a>
                            <a href="{{ route('user-incident-analysis-monthly') }}" class="block px-4 py-2 text-lg text-gray-700 hover:bg-gray-100">Monthly Safety Analysis</a>
                        </div>
                    </div>
                    @if($user->role != 'Admin' && $user->role != 'Supervisor')
                    <x-nav-link :href="route('user.management-approval-list')" :active="request()->routeIs('user.management-approval-list')" 
                        class="{{ request()->routeIs('user.management-approval-list') ? 'w-full text-left px-3 py-1 border border-transparent text-lg leading-4 font-medium rounded-md text-gray-700 bg-gray-200 focus:outline-none focus:bg-gray-200 transition' : 'w-full text-left px-3 py-1 border border-transparent text-lg leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition' }}">
                        {{ __('Approve Forms') }}
                    </x-nav-link>
                    @endif

                    <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')" 
                        class="{{ request()->routeIs('profile.edit') ? 'w-full text-left px-3 py-1 border border-transparent text-lg leading-4 font-medium rounded-md text-gray-700 bg-gray-200 focus:outline-none focus:bg-gray-200 transition' : 'w-full text-left px-3 py-1 border border-transparent text-lg leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition' }}">
                        {{ __('Profile') }}
                    </x-nav-link>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: block;">
                        @csrf
                        <button type="submit" class="w-full text-left px-3 py-1 border border-transparent text-lg leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>

                
                @endif
            </div>
            @endauth
        </div>
    </div>
    <!-- Script for dropdown -->
    <script>
        document.getElementById('dropdownButton').onclick = function() {
            var content = document.getElementById('dropdownContent');
            if(content.classList.contains('hidden')) {
                content.classList.remove('hidden');
            } else {
                content.classList.add('hidden');
            }
        };
    </script>
</nav>

{{-- 




<nav x-data="{ open: false }" class="w-1/7 bg-white border-r border-gray-100 fixed left-0 top-0 h-full">
    <!-- Primary Navigation Menu -->
    <div class="max-h-screen h-full overflow-y-auto">
        <div class="flex flex-col justify-between h-full">
            <div class="flex flex-col">
                <!-- PP -->
                <div class="shrink-0 flex items-center justify-center flex-col">
                    @auth
                        <a href="{{ route('profile.edit') }}">
                            @php($user = Auth::user())
                
                            @if($user && $user->profile_photo)
                                <!-- Append the updated_at timestamp or a unique identifier to the image URL -->
                                <img class="mt-4 md:mt-8 lg:mt-12 w-20 h-20 rounded-full object-cover mx-auto block"
                                     src="{{ asset('storage/profile_photos/' . $user->profile_photo) }}?v={{ $user->updated_at->timestamp }}"
                                     alt="Profile Image">
                            @else
                                <img class="mt-4 md:mt-8 lg:mt-12 w-20 h-20 rounded-full object-cover mx-auto block"
                                     src="{{ asset('storage/profile_photos/default-user.png') }}"
                                     alt="Profile Image">
                            @endif
                        </a>
                        <label for="user-fullname" class="mt-2 ml-2 mr-2">{{$user->name}}</label>

                </div>
                
                
                <!-- Navigation Links -->
                
                @if($user->role == 'Admin')
                <div class="w-32 space-y-8 sm:mt-10 sm:flex sm:flex-col">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('admin.users-list')" class="w-full text-left px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <x-nav-link :href="route('admin.users-list')" :active="request()->routeIs('admin.users-list')" class="w-full text-left px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">
                        {{ __('Manage Users') }}
                    </x-nav-link>

                    <x-nav-link :href="route('admin-users-registration-form')" :active="request()->routeIs('admin-users-registration-form')" class="w-full text-left px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">
                        {{ __('Register') }}
                    </x-nav-link>

                    <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')" class="w-full text-left px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">
                        {{ __('Profile') }}
                    </x-nav-link>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: block;">
                        @csrf
                        <button type="submit" class="w-full text-left px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                    
                    
                </div>
                @else
                <div class="w-32 space-y-8 sm:mt-10 sm:flex sm:flex-col">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                        class="{{ request()->routeIs('dashboard') ? 'w-full text-left px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 bg-gray-200 focus:outline-none focus:bg-gray-200 transition' : 'w-full text-left px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition' }}">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    
                    <x-nav-link :href="route('user.hirarc-list')" :active="request()->routeIs('admin.users-list')"
                        class="{{ request()->routeIs('user.hirarc-list') ? 'w-full text-left px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 bg-gray-200 focus:outline-none focus:bg-gray-200 transition' : 'w-full text-left px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition' }}">
                        {{ __('HIRARC') }}
                    </x-nav-link>

                    <x-nav-link :href="route('user-incident-list')" :active="request()->routeIs('admin.users-list')" 
                        class="{{ request()->routeIs('user-incident-list') ? 'w-full text-left px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 bg-gray-200 focus:outline-none focus:bg-gray-200 transition' : 'w-full text-left px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition' }}">
                        {{ __('Incident') }}
                    </x-nav-link>

                    <div class="relative w-full text-left px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">
                        <button id="dropdownButton" class="class="{{ request()->routeIs('user-incident-analysis') ? 'w-full text-left px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 bg-gray-200 focus:outline-none focus:bg-gray-200 transition' : 'w-full text-left px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition' }}"
                        
                        >
                            {{ __('Safety Analysis') }}
                        </button>
                        <div id="dropdownContent" class="hidden absolute bg-white border rounded-md mt-1 z-10">
                            <a href="{{ route('user-incident-analysis') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Overall Safety Analysis</a>
                            <a href="{{ route('user-incident-analysis-monthly') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Monthly Safety Analysis</a>
                        </div>
                    </div>
                    @if($user->role != 'Admin' && $user->role != 'Supervisor')
                    <x-nav-link :href="route('user.management-approval-list')" :active="request()->routeIs('user.management-approval-list')" 
                        class="{{ request()->routeIs('user.management-approval-list') ? 'w-full text-left px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 bg-gray-200 focus:outline-none focus:bg-gray-200 transition' : 'w-full text-left px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition' }}">
                        {{ __('Approve Forms') }}
                    </x-nav-link>
                    @endif

                    <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')" 
                        class="{{ request()->routeIs('profile.edit') ? 'w-full text-left px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 bg-gray-200 focus:outline-none focus:bg-gray-200 transition' : 'w-full text-left px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition' }}">
                        {{ __('Profile') }}
                    </x-nav-link>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: block;">
                        @csrf
                        <button type="submit" class="w-full text-left px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>

                
                @endif
            </div>
            @endauth

        </div>
    </div>
    <script>
        document.getElementById('dropdownButton').onclick = function() {
            var content = document.getElementById('dropdownContent');
            if(content.classList.contains('hidden')) {
                content.classList.remove('hidden');
            } else {
                content.classList.add('hidden');
            }
        };
    </script>
</nav> --}}
