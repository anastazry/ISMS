{{-- @php($user = Auth::user())
@if($user->role === 'Admin') --}}
@extends('layouts.app') <!-- Extend the master.blade.php file -->

@section('content') <!-- Start the content section -->
    <div class="py-12" style="width: 100%">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="width: 100%">
            <div class="bg-white border rounded shadow p-4" >
              <div class="border-b p-2">
                <!-- Header content goes here -->
                Kategori BTS
              </div>
              <div>
                {!! $qrCode !!}
                camam
            </div>
              <div class="p-2">
                <!-- Body content goes here -->
                @if(Session::has('message'))
                  <div class="bg-green-500 text-white px-4 py-2 rounded">
                    <!-- Alert content goes here -->
                    {{ Session::get('message') }}
                  </div>

                @endif
                    <form method="POST" action="{{ route('mandor-insert-fruit-details') }}" enctype="multipart/form-data">
                        @csrf
                
                        <!-- dituai  -->
                        <div>
                            <x-input-label for="dituai" :value="__('Tandan Dituai')" />
                            
                            <x-text-input id="dituai" class="block mt-1 w-full" type="text" name="dituai" :value="old('dituai')" required autofocus autocomplete="username" />
                            <x-input-error :messages="$errors->get('dituai')" class="mt-2" />
                        </div>
                
                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-input-label for="muda" :value="__('Tandan Muda')" />
                            <x-text-input id="muda" class="block mt-1 w-full" type="text" name="muda" :value="old('muda')" required autocomplete="username" />
                            <x-input-error :messages="$errors->get('muda')" class="mt-2" />
                        </div>
                
                        <!-- Worker ID -->
                        <div class="mt-4">
                            <x-input-label for="busuk" :value="__('Tandan Busuk')" />
                            <x-text-input id="busuk" class="block mt-1 w-full" type="text" name="busuk" :value="old('busuk')" required autocomplete="username" />
                            <x-input-error :messages="$errors->get('busuk')" class="mt-2" />
                        </div>

                        <!-- Username -->
                        <div class="mt-4">
                            <x-input-label for="kosong" :value="__('Tandan Kosong')" />
                            <x-text-input id="kosong" class="block mt-1 w-full" type="text" name="kosong" :value="old('kosong')" required autocomplete="username" />
                            <x-input-error :messages="$errors->get('kosong')" class="mt-2" />
                        </div>
                        <!-- Phone Number -->
                        <div class="mt-4">
                            <x-input-label for="panjang" :value="__('Tandan Panjang')" />
                            <x-text-input id="panjang" class="block mt-1 w-full" type="text" name="panjang" :value="old('panjang')" required autocomplete="username" />
                            <x-input-error :messages="$errors->get('panjang')" class="mt-2" />
                        </div>
                    </div>
                    <br>
                    <div class="bg-white border rounded shadow p-4">
                        <div class="border-b p-2">
                            <!-- Header content goes here -->
                            Serangan Tikus
                          </div>
                          <div class="p-2">
                    </div>

                    <!-- Phone Number -->
                    <div class="mt-4">
                        <x-input-label for="s_lama" :value="__('Serangan Lama')" />
                        <x-text-input id="s_lama" class="block mt-1 w-full" type="text" name="s_lama" :value="old('s_lama')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('s_lama')" class="mt-2" />
                    </div>
                    <!-- Phone Number -->
                    <div class="mt-4">
                        <x-input-label for="s_baru" :value="__('Serangan Baru')" />
                        <x-text-input id="s_baru" class="block mt-1 w-full" type="text" name="s_baru" :value="old('s_baru')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('s_baru')" class="mt-2" />
                    </div>
                </div>
<br>

<br>
                        <div class="bg-white border rounded shadow p-4">
                            <div class="border-b p-2">
                                <!-- Header content goes here -->
                                Maklumat Berkenaan
                              </div>
                              <div class="p-2">
                        </div>

                        <!-- Phone Number -->
                        <div class="mt-4">
                            <x-input-label for="gambar" :value="__('Gambar')" />
                            <x-text-input id="gambar" class="block mt-1 w-full" type="file" name="gambar" :value="old('gambar')" required autocomplete="username" />
                            <x-input-error :messages="$errors->get('gambar')" class="mt-2" />
                        </div>
                        <!-- Phone Number -->

                        <br><br>
                        <div class="mt-4">
                            <input type="hidden" id="latitude" name="latitude">
                            <input type="hidden" id="longitude" name="longitude">
                    
                            <!-- Button to trigger location fetch -->
                            <button type="button" onclick="getLocation()">Get My Location</button>
                        </div>

                        <input type="hidden" name="object" value="{{ json_encode($metadataMandor) }}" />
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
    <script>
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    // Set latitude and longitude in the hidden form inputs
                    document.getElementById('latitude').value = position.coords.latitude;
                    document.getElementById('longitude').value = position.coords.longitude;
                    // Enable the submit button after getting location
                    alert("Location found!");
                }, function(error) {
                    alert("Unable to retrieve location.");
                });
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }
    </script>
@endsection <!-- End the content section -->
{{-- @else
    <!-- If the user is not an admin, show a popup and redirect -->
    <script>
        alert("Access Not Allowed");
        window.location.href = "{{ route('dashboard') }}"; // Replace 'specific-page' with the actual route you want to redirect to
    </script>
@endif --}}

