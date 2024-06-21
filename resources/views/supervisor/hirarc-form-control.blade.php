@extends('layouts.app')

@section('content')
<style>
    .bg-gray-200 {
        background-color: #d1d5db; /* Change to your desired grey color */
    }
    @media screen and (min-width: 600px) and (max-width: 1200px) {

        #contents {
            width: 87%; /* Adjust width for smaller screens */
            margin-left: 13%; /* Reset margin-left for smaller screens */
            /* padding-left: 30%; Consider adjusting padding for smaller screens if needed */
            /* background-color: #000; */
        }
    }
</style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" id="contents">

            <div class="bg-white border rounded shadow p-4">

                <form method="post" action="{{ route('user-add-control') }}" enctype="multipart/form-data">
                    @csrf
                <div class="flex justify-center items-center gap-2">
                    <div class="relative flex items-center">
                        <div class="bg-white text-black p-2 rounded-l-lg">
                            Title Page
                        </div>
                        <div class="absolute -right-2 bg-white-500 h-full w-4 flex items-center justify-center">
                            <div class="border-t-6 border-b-6 border-r-6 border-black"></div>
                        </div>
                    </div>
                    <div class="relative flex items-center border-t-6 border-b-6 border-r-6 border-black">
                        <div class="bg-white text-black p-2 border-black">
                            HIRARC
                        </div>
                        <div class="absolute -right-2  h-full w-4 flex items-center justify-center">
                            <div class="border-t-6 border-b-6 border-transparent border-r-6 border-black"></div>
                        </div>
                    </div>
                    <div class="relative flex items-center">
                        <div class=" text-black p-2 rounded-l-lg">
                            Hazard Identification
                        </div>
                        <div class="absolute -right-2  h-full w-4 flex items-center justify-center">
                            <div class="border-t-6 border-b-6 border-r-6 border-black"></div>
                        </div>
                    </div>
                    <div class=" relative flex items-center border-t-6 border-b-6 border-r-6 border-black">
                        <div class=" text-black p-2 border-black">
                            Risk Assessment
                        </div>
                        <div class="absolute -right-2  h-full w-4 flex items-center justify-center">
                            <div class="border-t-6 border-b-6 border-transparent border-r-6 border-black"></div>
                        </div>
                    </div>
                    <div class=" bg-green-500 text-black p-2 rounded-r-lg">
                        Control
                    </div>
                </div>
                
                <div id="witnesses">
                    <h5>Particulars of Controls</h5>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th>Hazard</th>
                                <th>Opportunity</th>
                                <th>New Control</th>
                                <th>Responsibility</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($hazard_data->isNotEmpty())
                            @foreach($hazard_data as $data)
                            <tr class="witness">
                                <td><input type="text" name="hazard_name[]" value="{{ $data->hazard }}" class="p-2 border rounded-md w-full h-20" readonly></td>
                                <td><textarea name="control[opportunity][]" class="p-2 border rounded-md w-full h-20" style="margin-top: 7px;"></textarea></td>
                                <td><textarea name="control[new_control][]" class="p-2 border rounded-md w-full h-20" style="margin-top: 7px;"></textarea></td>
                                <td><input type="text" name="control[responsibility][]" class="border rounded-md w-full h-20 "></td>
                                <td>
                                    <select name="control[status][]" class="p-2 border rounded-md w-full">
                                        <option value="Reviewing">Reviewing</option>
                                        <option value="Ongoing">Ongoing</option>
                                        <option value="Finished">Finished</option>
                                    </select>
                                </td>
                                <input type="hidden" name="hazard_id[]" value="{{ $data->hazard_id }}">
                                <input type="hidden" name="hirarc_id[]" value="{{ $data->hirarc_id }}">
                            </tr>
                            @endforeach
                            @else
                            <tr class="witness">
                                <td><input type="text" name="hazard_name[]" value="" class="p-2 border rounded-md w-full h-20" readonly></td>
                                <td><textarea name="control[opportunity][]" class="p-2 border rounded-md w-full h-20" style="margin-top: 7px;"></textarea></td>
                                <td><textarea name="risk[new_control][]" class="p-2 border rounded-md w-full h-20" style="margin-top: 7px;"></textarea></td>
                                <td><input type="text" name="risk[responsibility][]" class="border rounded-md w-full h-20 "></td>
                            </tr>
                            @endif
                            

                        </tbody>
                    </table>
                    {{-- <input type="date" name="control[finish_date][]" class="border rounded-md w-full h-20 "> --}}
                    {{-- <div class="flex justify-center mt-4" id="buttonGroup">
                        <input type="button" class="px-4 py-2 bg-white text-black rounded-md mr-2 border border-blue-500 cursor-pointer" value="Reviewing">
                        <input type="button" class="px-4 py-2 bg-white text-black rounded-md mr-2 border border-blue-500 cursor-pointer" value="Ongoing">
                        <input type="button" class="px-4 py-2 bg-white text-black rounded-md mr-2 border border-blue-500 cursor-pointer" value="Finished">
                    </div> --}}
                    
                    
                </div>
                <div class="p-2">
                    <!-- Body content goes here -->
                    @if(Session::has('message'))
                        <div class="bg-green-500 text-white px-4 py-2 rounded">
                            <!-- Alert content goes here -->
                            {{ Session::get('message') }}
                        </div>
                    @endif
                        <tr>
                            <td class="px-6 py-4"></td>
                            <td class="px-6 py-4">
                                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
                                    Next
                                </button>
                                
                                <button onclick="event.preventDefault(); location.href='{{ route('user.hirarc-list') }}';
" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
                                    Cancel
                                </button>
                                
                            </td>
                        </tr>

                    </form>
                    <div style="display: flex; justify-content: flex-end; margin-top: -40px">
                        <form id="editHirarcForm" action="{{ route('user-backto-risk-details', ['hirarc_id' => $data->hirarc_id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <!-- Add any other form fields if needed -->
                            <button type="submit" id="editHirarcSubmitBtn" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-50">
                                Back
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
    // Get all buttons within the button group
    const buttons = document.querySelectorAll('#buttonGroup input[type="button"]');

    // Add click event listener to each button
    buttons.forEach(button => {
        button.addEventListener('click', () => {
            // Remove 'bg-gray-200' class from all buttons
            buttons.forEach(btn => btn.classList.remove('bg-gray-200'));
            
            // Add 'bg-gray-200' class to the clicked button
            button.classList.add('bg-gray-200');
        });
    });

    </script>
@endsection



<!-- End the content section -->


                            {{-- <table class="px-6 py-4 whitespace-nowrap center">
                                <h5 class="">Particular of Witness</h5>
                                <tr>
                                    <th>Name</th>
                                    <th>Company</th>
                                    <th>Remark</th>
                                </tr>
                                <tr>
                                    {{-- for name --}}
                                    {{-- <td class="px-6 py-4">
                                        <input type="text" name="name" value="{{ old('name') }}" class="p-2 border rounded-md w-full">
                                        @error('name')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </td>

                                    {{-- for company --}}
                                    {{-- <td class="px-6 py-4">
                                        <input type="text" name="company" value="{{ old('company') }}" class="p-2 border rounded-md w-full">
                                        @error('company')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </td> --}}

                                    {{-- for remark --}}
                                    {{-- <td class="px-6 py-4">
                                        <input type="text" name="remark" value="{{ old('remark') }}" class="p-2 border rounded-md w-full">
                                        @error('remark')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </td> --}}
                                {{-- </tr> 
                            </table>  --}}

                                                        {{-- <td class="px-6 py-4 whitespace-nowrap">Price</td>
                            <td class="px-6 py-4">
                                <input type="number" name="price" value="{{ old('price') }}" class="p-2 border rounded-md w-full" min="0.00" max="10000.00" step="0.01">
                                @error('price')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </td> --}}