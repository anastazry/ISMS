@php($user = Auth::user())
@if($user->role === 'Admin')
@extends('layouts.app') <!-- Extend the app.blade.php file -->
@section('content') <!-- Start the content section -->
<div class="py-12">
  <div class=" flex justify-center sm:px-6 lg:px-8"; style="margin-left: 14%">
        {{-- <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white text-gray-900">
                {{ __("You're logged in!") }}
            </div>
        </div> --}}
        <div class="bg-white border rounded shadow mx-auto" style="width: 100%">
          <div class="border-b p-2">
            <!-- Header content goes here -->
            List of all users
          </div>
          <div class="p-2">
            <!-- Body content goes here -->
            @if(Session::has('message'))
                <div id="alert-3" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                  <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                  </svg>
                  <span class="sr-only">Info</span>
                  <div class="ms-3 text-sm font-medium">
                    {{ Session::get('message') }}
                  </div>
                  <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-3" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                  </button>
                </div>
                
             
            @endif

            @if(Session::has('error'))
              <div class="bg-red-500 text-white px-4 py-2 rounded">
                <!-- Error content goes here -->
                {{ Session::get('error') }}
              </div>
            @endif
            <div class="p-2"><a href="{{ route('admin-users-registration-form')}}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Add New Users</a></div>      
            <div class="flex flex-col">
              <div class="overflow-x-auto sm:-mx-6 lg:-mx-8 w-full">
                <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                  <div class="overflow-hidden">
                    <table class="min-w-full text-left text-sm font-light">
                      <thead
                        class="border-b font-medium dark:border-neutral-500">
                        <tr>
                          <th scope="col" class="px-6 py-4">#</th>
                          <th scope="col" class="px-6 py-4">Name</th>
                          <th scope="col" class="px-6 py-4">Email</th>
                          <th scope="col" class="px-6 py-4">Worker ID</th>
                          <th scope="col" class="px-6 py-4">Phone No</th>
                          <th scope="col" class="px-6 py-4">Role</th>
                          <th scope="col" class="px-6 py-4">Date Registered</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php($i=0)
                        @foreach($users as $user)
                            <tr class="
                                border-b transition duration-300 ease-in-out 
                                @if($user->accessToken == 0) opacity-20 @endif
                                hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600"
                            >
                                <td class="whitespace-nowrap px-6 py-4 font-medium">{{ ++$i }}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{ $user->name }}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{ $user->email }}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{ $user->worker_id }}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{ $user->phone_no }}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{ $user->role }}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{ $user->created_at }}</td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <!-- Reset Password Form -->
                                    <form method="post" action="{{ route('admin-reset-password', ['id' => $user->id]) }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Reset Password</button>
                                    </form>
                    @if($user->accessToken == 0)
                                    <form method="post" action="{{ route('admin-disable-user', ['id' => $user->id]) }}" style="display: inline;">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Enable</button>
                                    </form>
                    @else
                                  <form method="post" action="{{ route('admin-disable-user', ['id' => $user->id]) }}" style="display: inline;">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Disable</button>
                                </form>
                    @endif
                                </td>
                            </tr>
                        @endforeach
                    
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>
@endsection <!-- End the content section -->
@else
    <!-- If the user is not an admin, show a popup and redirect -->
    <script>
        alert("Access Not Allowed");
        window.location.href = "{{ route('dashboard') }}"; // Replace 'specific-page' with the actual route you want to redirect to
    </script>
    <script src="../path/to/flowbite/dist/flowbite.min.js"></script>
@endif




