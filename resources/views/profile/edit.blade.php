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
    </head>
</head>
<body>
    @include('layouts.navigation')

    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Profile') }}
    </h2>
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

        </div>
    </div>
</body>
</html>


