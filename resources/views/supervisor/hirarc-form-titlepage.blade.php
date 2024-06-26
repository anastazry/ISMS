@extends('layouts.app')

@section('content')


<style>
    .signature-pad {
border: 1px black;
    }
    .canvas-container {
    display: flex;
    justify-content: center; /* Center content horizontally */
    }

    #saveSignatureBtn {
    /* Button background color */
    margin: 5px;
    background-color: #007bff;
    /* Button text color */
    color: #fff;
    /* Padding around button text */
    padding: 10px 20px;
    /* Rounded corners for button */
    border-radius: 5px;
    /* Hover effect: slightly darker background color */
    transition: background-color 0.3s ease;
}

#saveSignatureBtn:hover {
    background-color: #0056b3; /* Darker background color on hover */
    color: #fff; /* Text color remains white on hover */
    cursor: pointer; /* Show pointer cursor on hover */
}

#saveSignatureBtn-app {
    /* Button background color */
    margin: 5px;
    background-color: #007bff;
    /* Button text color */
    color: #fff;
    /* Padding around button text */
    padding: 10px 20px;
    /* Rounded corners for button */
    border-radius: 5px;
    /* Hover effect: slightly darker background color */
    transition: background-color 0.3s ease;
}

#saveSignatureBtn-app:hover {
    background-color: #0056b3; /* Darker background color on hover */
    color: #fff; /* Text color remains white on hover */
    cursor: pointer; /* Show pointer cursor on hover */
}
</style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white border rounded shadow p-4">
                <div class="border-b p-2">
                    <!-- Header content goes here -->
                    Add HIRARC
                </div>
                <form method="post" action="{{ route('user-add-titlepage') }}" enctype="multipart/form-data">
                    @csrf
                <div class="flex justify-center items-center gap-2">
                    <div class="relative flex items-center">
                        <div class="bg-green-500 text-white p-2 rounded-l-lg">
                            Title Page
                        </div>
                        <div class="absolute -right-2 bg-white-500 h-full w-4 flex items-center justify-center">
                            <div class="border-t-6 border-b-6 border-r-6 border-black"></div>
                        </div>
                    </div>
                    <div class="relative flex items-center border-t-6 border-b-6 border-r-6 border-black">
                        <div class=" text-black p-2 border-black">
                            HIRARC
                        </div>
                        <div class="absolute -right-2  h-full w-4 flex items-center justify-center">
                            <div class="border-t-6 border-b-6 border-transparent border-r-6 border-black"></div>
                        </div>
                    </div>
                    <div class="relative flex items-center">
                        <div class="bg-white text-black p-2 rounded-l-lg">
                            Hazard Identification
                        </div>
                        <div class="absolute -right-2 bg-white h-full w-4 flex items-center justify-center">
                            <div class="border-t-6 border-b-6 border-r-6 border-black"></div>
                        </div>
                    </div>
                    <div class="relative flex items-center border-t-6 border-b-6 border-r-6 border-black">
                        <div class=" text-black p-2 border-black">
                            Risk Assessment
                        </div>
                        <div class="absolute -right-2  h-full w-4 flex items-center justify-center">
                            <div class="border-t-6 border-b-6 border-transparent border-r-6 border-black"></div>
                        </div>
                    </div>
                    <div class=" text-black p-2 rounded-r-lg">
                        Control
                    </div>
                </div>
                
                <div id="witnesses">
                    <h5>Particulars of Hazards</h5>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th>Inspection Date</th>
                                <td class="px-6 py-4">
                                    <input type="date" name="insp_date" value="{{ old('insp_date') }}" class="p-2 border rounded-md w-full">
                                    @error('insp_date')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </td>
                                {{-- <td><input type="text" name="witnesses[witness_name][]" class="p-2 border rounded-md w-full"></td> --}}
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="witness" colspan="2" style="text-align:center">
                                <td colspan="2">
                                    <div style="background-color: red; cursor: pointer;" onclick="toggleOptions()">
                                        <h2>Verified By</h2>
                                    </div>
                                    <div id="options" class="hidden">
                                        <h3 style="text-align:left">Verification Date</h3>
                                        <input type="date" name="verification_date" value="{{ old('verification_date') }}" class="p-2 border rounded-md w-full">
                                        @error('verification_date')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                        <h3 style="text-align:left">Name and Signature</h3>
                                        <input type="text" name="verified_by" value="{{ old('verified_by') }}" class="p-2 border rounded-md w-full">
                                        @error('verified_by')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                        <div>
                                            <h3 style="text-align:left">Signature</h3>
                                            <div id="signature-pad" class="signature-pad">
                                                <div class="signature-pad-footer" style="text-align: right">
                                                    <button type="button" id="clear-signature" class="btn btn-danger">Clear</button>
                                                </div>
                                            </div>
                                            {{-- <textarea id="verified_by_signature" name="verified_by_signature" style="display: none"></textarea> --}}
                                            <input type="text" name="verified_by_signature" id="verified_by_signature" value="" style="display: none">
                                            <div class="canvas-container">
                                                <canvas id="signatureCanvas" class="border border-black" width=400 height=200></canvas>
                                            </div>
                                            {{-- <canvas id="signatureCanvas" class="border border-black w-full" height="500"></canvas> --}}
                                            <button id="saveSignatureBtn" class="btn btn-primary">Save Signature</button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="approval_row" colspan="2" style="text-align:center">
                                <td colspan="2">
                                    <div style="background-color: red; cursor: pointer;" onclick="toggleOptionsApproval()">
                                        <h2>Approved By</h2>
                                    </div>
                                    <div id="optionsApproval" class="hidden">
                                        <h3 style="text-align:left">Approval Date</h3>
                                        <input type="date" name="approval_date" value="{{ old('approval_date') }}" class="p-2 border rounded-md w-full">
                                        @error('approval_date')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                        <h3 style="text-align:left">Name and Signature</h3>
                                        <input type="text" name="approved_by" value="{{ old('approved_by') }}" class="p-2 border rounded-md w-full">
                                        @error('approved_by')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror

                                        <div>
                                            <h3 style="text-align:left">Signature</h3>
                                            <div id="signature-pad-app" class="signature-pad">
                                                <div class="signature-pad-footer" style="text-align: right">
                                                    <button type="button" id="clear-signature-app" class="btn btn-danger">Clear</button>
                                                </div>
                                            </div>
                                            {{-- <textarea id="verified_by_signature" name="verified_by_signature" style="display: none"></textarea> --}}
                                            <input type="text" name="approved_by_signature" id="approved_by_signature" value="" style="display: none">
                                            <div class="canvas-container">
                                                <canvas id="signatureCanvas-app" class="border border-black" width="400" height="200"></canvas>
                                            </div>                                            
                                            {{-- <canvas id="signatureCanvas" class="border border-black w-full" height="500"></canvas> --}}
                                            <button id="saveSignatureBtn-app" class="btn btn-primary">Save Signature</button>
                                        </div>
                                    </div>
                                </td>
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
                                
                                <button onclick="event.preventDefault(); location.href='{{ route('user.hirarc-list') }}';
" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
                                    Cancel
                                </button>
                                
                            </td>
                        </tr>

                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>

    <script> 
    document.addEventListener('DOMContentLoaded', function() {
        var canvas = document.getElementById('signatureCanvas');
        var canvas_app = document.getElementById('signatureCanvas-app');
        var signaturePad = new SignaturePad(canvas);
        var signaturePad_app = new SignaturePad(canvas_app);
        var saveButton = document.getElementById('saveSignatureBtn');
        var saveButton_app = document.getElementById('saveSignatureBtn-app');
        var cancelButton = document.getElementById('clear-signature');
        var cancelButton_app = document.getElementById('clear-signature-app');
        var signatureInputField = document.getElementById('verified_by_signature');
        var signatureInputField_app = document.getElementById('approved_by_signature');

        saveButton.addEventListener('click', function(event) {
            event.preventDefault();

            if (!signaturePad.isEmpty()) {
                var dataURL = signaturePad.toDataURL();

                // Update the value of the hidden input field with the signature data URL
                signatureInputField.value = dataURL;

                console.log('Signature data URL:', dataURL);
                alert('Signature saved successfully!');
            } else {
                alert('Please provide a signature before saving.');
            }
        });

        saveButton_app.addEventListener('click', function(event) {
            event.preventDefault();

            if (!signaturePad_app.isEmpty()) {
                var dataURL_app = signaturePad_app.toDataURL();

                // Update the value of the hidden input field with the signature data URL
                signatureInputField_app.value = dataURL_app;

                console.log('Signature data URL:', dataURL_app);
                alert('Signature saved successfully!');
            } else {
                alert('Please provide a signature before saving.');
            }
        });

        cancelButton.addEventListener('click', function(event) {
            signaturePad.clear();
            // Clear the value of the hidden input field when cancelling
            signatureInputField.value = '';
        });

        cancelButton_app.addEventListener('click', function(event) {
            signaturePad_app.clear();
            // Clear the value of the hidden input field when cancelling
            signatureInputField_app.value = '';
        });
    });



        // // Function to convert the signature to a base64 JPEG string
        // function convertSignatureToBase64() {
        //     var dataURL = signaturePad.toDataURL('image/jpeg');
        //     var textarea = document.getElementById('verified_by_signature');
        //     textarea.value = dataURL;
        // }

        // // Event listener for the Clear button
        // document.getElementById('clear-signature').addEventListener('click', function(){
        //     signaturePad.clear();
        //     var textarea = document.getElementById('verified_by_signature');
        //     textarea.value = '';  // Clear the value
        // });

        // // Call convertSignatureToBase64 to initially set the value
        // convertSignatureToBase64();

        // document.querySelector('form').addEventListener('submit', function(event) {
        //     convertSignatureToBase64(); // Convert signature to base64 just before form submission
        // });
        const dropdownButton = document.getElementById('dropdownDefaultButton');
        const dropdownMenu = document.getElementById('dropdown');

        dropdownButton.addEventListener('click', function() {
        dropdownMenu.classList.toggle('hidden');  // Toggles 'hidden' class on click
        });

        function toggleOptions() {
            var optionsDiv = document.getElementById("options");
            if (optionsDiv.classList.contains("hidden")) {
                optionsDiv.classList.remove("hidden");
            } else {
                optionsDiv.classList.add("hidden");
            }
        }

        function toggleOptionsApproval() {
            var optionsDiv = document.getElementById("optionsApproval");
            if (optionsDiv.classList.contains("hidden")) {
                optionsDiv.classList.remove("hidden");
            } else {
                optionsDiv.classList.add("hidden");
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