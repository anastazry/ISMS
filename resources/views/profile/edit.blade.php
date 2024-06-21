<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <head>                
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        {{-- <script src="{{ mix('js/app.js') }}" defer></script> --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/howler/2.2.0/howler.min.js"></script>

        <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
        <script>
          // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;
        
        var pusher = new Pusher('a3f694fbe7964ed6b3ba', {
            cluster: 'ap1'
        });

            // Define the success sound using Howler.js
        var successSound = new Howl({
            src: ['https://res.cloudinary.com/dxfq3iotg/video/upload/v1557233524/success.mp3']
        });

        $(function(){
        var channel = pusher.subscribe('new-hirarc-channel');
        channel.bind('NewHirarcAdded', function(data) {
            // alert(JSON.stringify(data));
            console.log(JSON.stringify(data));
            toastr.success(data.hirarc.prepared_by + ' created a HIRARC data!');
            successSound.play();
        });
        });
        </script>

        <style>
            @media screen and (min-width: 600px) and (max-width: 1200px) {

#contents {
    width: 87%; /* Adjust width for smaller screens */
    margin-left: 13%; /* Reset margin-left for smaller screens */
    /* padding-left: 30%; Consider adjusting padding for smaller screens if needed */
    /* background-color: #000; */
}
}
        </style>
    </head>
</head>
<body>
    <div style="margin-left: 14%; background-color: white" class="bg-white border rounded shadow p-4">
        <nav class="flex mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="#" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                        </svg>
                        @if(isset($breadcrumb1))
                            {{$breadcrumb1}}
                        @else
                            Dashboard
                        @endif
                    </a>
                </li>
                @if(isset($breadcrumb2))
                <li>
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <a href="#" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">
                            @if(isset($breadcrumb2))
                                {{$breadcrumb2}}
                            @else
                                Hirarc List
                            @endif
                        </a>
                    </div>
                </li>
                @endif
                @if(isset($breadcrumb3))
                <li>
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <a href="#" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">
                            @if(isset($breadcrumb3))
                                {{$breadcrumb3}}
                            @else
                                Hirarc List
                            @endif
                        </a>
                    </div>
                </li>
                @endif
                @if(isset($breadcrumbs))
                @foreach($breadcrumbs as $breadcrumb)
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <a href="#" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">
                                @if(isset($breadcrumb))
                                    {{$breadcrumb}}
                                @else
                                    Hirarc List
                                @endif
                            </a>
                        </div>
                    </li>
                @endforeach
                @endif
                {{-- <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Flowbite</span>
                    </div>
                </li> --}}
            </ol>
        </nav>
        <h3 class="mb-4 text-3xl font-extrabold leading-none tracking-tight text-gray-900 md:text-4xl dark:text-white">
            @if(isset($headings))
                {{$headings}}
            @else
                Hirarc List
            @endif
        </h3>
    </div>
    @include('layouts.navigation')

    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Profile') }}
    </h2>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6" id="contents">
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

        </div>
    </div>
</body>
</html>


