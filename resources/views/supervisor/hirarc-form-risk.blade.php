@extends('layouts.app')

@section('content')
<style>
    /* CSS for green background */
    .green-background {
        background-color: lightgreen;
    }
</style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white border rounded shadow p-4">

                <form method="post" action="{{ route('user-add-risks') }}" enctype="multipart/form-data">
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
                    <div class="bg-green-500 relative flex items-center border-t-6 border-b-6 border-r-6 border-black">
                        <div class=" text-white p-2 border-black">
                            Risk Assessment
                        </div>
                        <div class="absolute -right-2 bg-green-500  h-full w-4 flex items-center justify-center">
                            <div class="border-t-6 border-b-6 border-transparent border-r-6 border-black"></div>
                        </div>
                    </div>
                    <div class=" text-black p-2 rounded-r-lg">
                        Control
                    </div>
                </div>
                
                <div id="witnesses">
                    <h5>Particulars of Risks</h5>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th>Hazard</th>
                                <th>Risk</th>
                                <th>Current Control</th>
                                <th>Likelihood</th>
                                <th>Severity</th>
                                <th>Score</th>
                                <th>Index</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($hazard_data->isNotEmpty())
                            @foreach($hazard_data as $data)
                                <tr class="witness">
                                    <td><input type="text" name="hazard_name[]" value="{{ $data->hazard }}" class="p-2 border rounded-md w-full h-20"></td>
                                    <td><textarea name="risk[risk_desc][]" class="p-2 border rounded-md w-full h-20" style="margin-top: 7px;"></textarea></td>
                                    <td><textarea name="risk[current_control][]" class="p-2 border rounded-md w-full h-20" style="margin-top: 7px;"></textarea></td>
                                    <td><input type="number" name="risk[likelihood][]" class="border rounded-md w-full h-20 "></td>
                                    <td><input type="number" name="risk[severity][]" class="p-2 border rounded-md w-full h-20"></td>
                                    <td><input type="number" name="risk[score][]" class="p-2 border rounded-md w-full h-20" readonly></td>
                                    <td><input type="text" name="risk[index][]" class="p-2 border rounded-md w-full h-20 risk-index-input"></td>
                                    {{-- <td><input type="text" id="riskInput" name="risk[index][]" class="p-2 border rounded-md w-full h-20"></td> --}}
                                    <input type="hidden" name="hazard_id[]" value="{{ $data->hazard_id }}">
                                    <input type="hidden" name="hirarc_id[]" value="{{ $data->hirarc_id }}">
                                </tr>
                            @endforeach
                        @else
                            <td><input type="text" name="hazard_name[]" value="" class="p-2 border rounded-md w-full h-20"></td>
                            <td><textarea name="risk[name][]" class="p-2 border rounded-md w-full h-20" style="margin-top: 7px;"></textarea></td>
                            <td><textarea name="risk[curr_control][]" class="p-2 border rounded-md w-full h-20" style="margin-top: 7px;"></textarea></td>
                            <td><input type="number" name="risk[likelihood][]" class="border rounded-md w-full h-20 "></td>
                            <td><input type="number" name="risk[severity][]" class="p-2 border rounded-md w-full h-20"></td>
                            <td><input type="number" name="risk[score][]" class="p-2 border rounded-md w-full h-20"></td>
                            <td><input type="text" name="risk[index][]" class="p-2 border rounded-md w-full h-20 risk-index-input"></td>
                            {{-- <td><input type="text" id="riskInput" name="risk[index][]" class="p-2 border rounded-md w-full h-20"></td> --}}
                    
                        @endif
                            </tr>
                        </tbody>
                        
                    </table>
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
                                
                                {{-- <button onclick="event.preventDefault(); location.href='{{ route('user-incident-list') }}';
" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
                                    Cancel
                                </button> --}}
                                
                            </td>
                        </tr>
                        {{-- <input type="hidden" name="hirarc_id" value="{{ {{ $hazard_data->hirarc_id }} }}" class="p-2 border rounded-md w-full"> --}}

                    </form>
                    <div style="display: flex; justify-content: flex-end; margin-top: -40px">
                        <form id="editHirarcForm" action="{{ route('user-backto-hazard-details', ['hirarc_id' => $data->hirarc_id]) }}" method="POST">
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
        // Get all input fields for likelihood, severity, score, and index
        const likelihoodInputs = document.querySelectorAll('input[name="risk[likelihood][]"]');
        const severityInputs = document.querySelectorAll('input[name="risk[severity][]"]');
        const scoreInputs = document.querySelectorAll('input[name="risk[score][]"]');
        const indexInputs = document.querySelectorAll('input[name="risk[index][]"]');
    
            // Add event listener to each severity input field
            severityInputs.forEach(input => {
                input.addEventListener('input', () => {
                    // Check if the input value exceeds the maximum allowed value (5)
                    if (input.value > 5) {
                        input.value = 5; // Set the value to 5 if it exceeds the limit
                    }
                });
            });

            // Add event listener to each score input field
            likelihoodInputs.forEach(input => {
                input.addEventListener('input', () => {
                    // Check if the input value exceeds the maximum allowed value (5)
                    if (input.value > 5) {
                        input.value = 5; // Set the value to 5 if it exceeds the limit
                    }
                });
            });
        // Add event listener to each likelihood and severity input field
        likelihoodInputs.forEach((input, index) => {
            input.addEventListener('input', () => calculateScoreAndIndex(index));

        });
    
        severityInputs.forEach((input, index) => {
            input.addEventListener('input', () => calculateScoreAndIndex(index));

        });

        // severityIndex.forEach((input, index) => {
        //     input.addEventListener('input', () => calculateScoreAndIndex(index));
        // });
    
        // Function to calculate score and index based on likelihood and severity
        function calculateScoreAndIndex(index) {
            const likelihood = parseFloat(likelihoodInputs[index].value);
            const severity = parseFloat(severityInputs[index].value);
    
            // Check if likelihood and severity are valid numbers
            if (!isNaN(likelihood) && !isNaN(severity)) {
                // Calculate the score
                const score = likelihood * severity;
    
                // Update the score input field
                scoreInputs[index].value = score;
    
                // Determine the index based on the score
                let indexValue;
                if (score >= 1 && score <= 5) {
                    indexValue = 'L';
                } else if (score >= 6 && score <= 14) {
                    indexValue = 'M';
                } else if (score >= 15 && score <= 25) {
                    indexValue = 'H';
                } else {
                    indexValue = ''; // Handle cases outside the defined ranges
                }
    
                // Update the index input field
                indexInputs[index].value = indexValue;
                        // Change the background color based on the index value
                if (indexValue === 'L') {
                    indexInputs[index].style.backgroundColor = 'lightgreen'; // Set background color to light green
                } else if (indexValue === 'M'){
                    indexInputs[index].style.backgroundColor = 'yellow'; // Reset background color
                }else if( indexValue === 'H'){
                    indexInputs[index].style.backgroundColor = 'red'; // Reset background color
                }else{
                    indexInputs[index].style.backgroundColor = ''; // Reset background color
                }
            }
        }

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