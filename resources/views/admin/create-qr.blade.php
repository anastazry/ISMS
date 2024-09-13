{{-- @php($user = Auth::user())
@if($user->role === 'Admin') --}}
@extends('layouts.app') <!-- Extend the master.blade.php file -->

@section('content') <!-- Start the content section -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border rounded shadow p-4">
              <div class="border-b p-2">
                <!-- Header content goes here -->
                Generate QR
              </div>
              <div class="p-2">
                <!-- Body content goes here -->
                @if(Session::has('message'))
                  <div class="bg-green-500 text-white px-4 py-2 rounded">
                    <!-- Alert content goes here -->
                    {{ Session::get('message') }}
                  </div>
                @endif
                <form method="POST" action="{{ route('admin.assign-task') }}">
                    @csrf

                    {{-- Peringkat --}}
                    <div class="mt-4">
                        <x-input-label for="Peringkat" :value="__('Peringkat')" />
                        <x-text-input id="peringkat" class="block mt-1 w-full" type="text" name="peringkat" :value="old('peringkat')" required />
                        <x-input-error :messages="$errors->get('peringkat')" class="mt-2" />
                    </div>
                    {{-- Peringkat End --}}

                    <br>

                    {{-- Blok --}}
                    <div class="mt-4">
                        <x-input-label for="Blok" :value="__('Blok')" />
                        <x-text-input id="blok" class="block mt-1 w-full" type="text" name="blok" :value="old('blok')" required />
                        <x-input-error :messages="$errors->get('blok')" class="mt-2" />
                    </div>
                    {{-- Blok End --}}

                    <br>

                    {{-- No Lot --}}
                    <div class="mt-4">
                        <x-input-label for="n_lot" :value="__('No Lot')" />
                        <x-text-input id="n_lot" class="block mt-1 w-full" type="text" name="n_lot" :value="old('n_lot')" required />
                        <x-input-error :messages="$errors->get('n_lot')" class="mt-2" />
                    </div>
                    {{-- No Lot--}}

                    <br>

                    {{-- No Lot --}}
                    <div class="mt-4">
                        <x-input-label for="n_p_tuai" :value="__('No Pentas Tuai')" />
                        <x-text-input id="n_p_tuai" class="block mt-1 w-full" type="text" name="n_p_tuai" :value="old('n_p_tuai')" required />
                        <x-input-error :messages="$errors->get('n_p_tuai')" class="mt-2" />
                    </div>
                    {{-- No Lot--}}

                    <br>

                    {{-- Mandor --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Mandor</label>
                        <select name="mandor_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @foreach($users as $user)
                                @if($user->role == 'Mandor')
                                    <option value="{{ $user->id }}">{{ $user->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    {{-- Mandor End --}}

                    <br>

                    {{-- Kumpulan Penuai --}}
                    <div class="mt-4">
                        <x-input-label for="k_penuai" :value="__('Kumpulan Penuai')" />
                        <x-text-input id="k_penuai" class="block mt-1 w-full" type="text" name="k_penuai" :value="old('k_penuai')" required />
                        <x-input-error :messages="$errors->get('k_penuai')" class="mt-2" />
                    </div>
                    {{-- Kumpulan Penuai End --}}

                    <br>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ml-4">
                            {{ __('Register') }}
                        </x-primary-button>
                    </div>
                </form>
              </div>
            </div>
        </div>
    </div>
@endsection <!-- End the content section -->
{{-- @endif --}}
