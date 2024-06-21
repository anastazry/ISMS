@extends('layouts.app')

@section('content')
<style>
    .modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1;
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 400px;
    text-align: center;
    border-radius: 8px;
}

#buttonModal{
    display: flex;
    justify-content: space-between;
}

#confirmCancelButton{
    background-color: red;
    padding: 10px;
    padding-top: 5px; 
    padding-bottom: 5px; 
    color: white;
}
#cancelModalButton{
    background-color: green;
    padding: 10px;
    padding-top: 5px; 
    padding-bottom: 5px; 
    color: white;
}
@media screen and (min-width: 600px) and (max-width: 1200px) {


            #contents {
                width: 80%; /* Adjust width for smaller screens */
                margin-left: 13%; /* Reset margin-left for smaller screens */
                /* padding-left: 30%; Consider adjusting padding for smaller screens if needed */
                /* background-color: #000; */
            }
        }
</style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" id="contents">

            <div class="bg-white border rounded shadow p-4">

                <form method="POST" action="{{ route('user.add-hirarc-form') }}" enctype="multipart/form-data">
                    @csrf
                <div class="flex justify-center items-center gap-2">
                    <div class="relative flex items-center border-t-6 border-b-6 border-r-6 border-black">
                        <div class="bg-green-500 text-white p-2 border-black rounded-l-lg">
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
                                <th>Job Description</th>
                                <td>
                                    <input type="text" name="desc_job" value="{{ old('desc_job') }}" class="p-2 border rounded-md w-full" required>
                                    @error('desc_job')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </td>
                            </tr>

                            <tr>
                                <th>Location</th>
                                <td>
                                    <input type="text" name="location" value="{{ old('location') }}" class="p-2 border rounded-md w-full" required>
                                    @error('location')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </td>
                            </tr>
                            
                        </thead>
                        <tbody>
                            <tr>
                                <th>Prepared By</th>
                                <td>
                                    <input type="text" name="prepared_by" value="{{ old('prepared_by', $userFullName) }}" class="p-2 border rounded-md w-full" required readonly>
                                    @error('prepared_by')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </td>
                                
                            </tr>
                            <tr>
                                <th>Signature</th>
                                <td>
<div id="existingSignature">
                                    @auth
                                    @if(isset(auth()->user()->user_signature))
                                    <div  class="signature-pad-footer" style="text-align: right">
                                        <button type="button" id="clear-signature" class="btn btn-danger">Clear Signature</button>
                                    </div>
                                    <div class="flex justify-center items-center h-full">
                                        <img src="{{ auth()->user()->user_signature }}" alt="User Signature">
                                    </div>
                                    @else
                                    <div>
                                        <div id="signature-pad-app" class="signature-pad">
                                            <div class="signature-pad-footer" style="text-align: right">
                                                <button type="button" id="clear-signature-prepared" class="btn btn-danger">Clear</button>
                                            </div>
                                        </div>
                                        {{-- <textarea id="verified_by_signature" name="verified_by_signature" style="display: none"></textarea> --}}
                                        <input type="text" class="prepared_by_signature" name="prepared_by_signature" id="prepared_by_signature" value="" style="display: none">
                                        <div class="canvas-container">
                                            <canvas id="signatureCanvas" class="border border-black" width="400" height="200"></canvas>
                                        </div>                                            
                                        {{-- <canvas id="signatureCanvas" class="border border-black w-full" height="500"></canvas> --}}
                                        <div class="signature-pad-footer" style="text-align: right">
                                            <button id="saveSignatureBtn" class="btn btn-primary">Save Signature</button>
                                        </div>
                                    </div>
                                    @endif

                                    @endauth
</div>
                                    <div id="newSignature" style="display: none">
                                        <div id="signature-pad-app" class="signature-pad">
                                            <div class="signature-pad-footer" style="text-align: right">
                                                <button type="button" id="clear-signature-prepared" class="btn btn-danger">Clear</button>
                                            </div>
                                        </div>
                                        {{-- <textarea id="verified_by_signature" name="verified_by_signature" style="display: none"></textarea> --}}
                                        <input type="text" class="prepared_by_signature" name="prepared_by_signature" id="prepared_by_signature" value="" style="display: none">
                                        <div class="flex justify-center items-center h-full">
                                            <div class="canvas-container">
                                                <canvas id="signatureCanvas" class="border border-black" width="400" height="200"></canvas>
                                            </div>
                                        </div>                                       
                                        {{-- <canvas id="signatureCanvas" class="border border-black w-full" height="500"></canvas> --}}
                                        <div class="signature-pad-footer" style="text-align: right">
                                            <button id="saveSignatureBtn" class="btn btn-primary">Save Signature</button>
                                        </div>

                                    </div>
                                </td>

                            </tr>
                            <tr>
                                <th>Inspection Date</th>
                                <td>
                                    <input type="date" name="inspection_date" value="{{ old('inspection_date', date('Y-m-d')) }}" class="p-2 border rounded-md w-full" required>
                                    @error('inspection_date')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </td>
                                
                                {{-- <input type="hidden" name="hirarc_id" value="{{ $hirarc_id }}" class="p-2 border rounded-md w-full"> --}}
                            </tr>
                        </tbody>
                        {{-- <input type="hidden" name="tpage_id" value="{{ $tpage_id }}"> --}}

                        {{-- <input type="hidden" name="tpage_id" value="{{ old('tpage_id') }}" class="p-2 border rounded-md w-full"> --}}
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
                                {{-- <a href="{{ route('user-edit-titlepage-hirarc', ['tpage_id' => $tpage_id]) }}" 
                                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50"
                                 >
                                     Back
                                 </a> --}}
                
                                <button id="submitBtn" type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
                                    Next
                                </button>


                            </td>

                        </tr>

                    </form>
                    <a id="cancelButton" style="padding-top: 10px; padding-bottom: 11px; hover: cursor" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-50">
                        Cancel
                    </a>
                    {{-- <a id="cancelButton" style="padding-top: 10px; padding-bottom: 11px; hover: cursor" 
                    onclick=" location.href='{{ route('user.hirarc-list') }}';
                    " class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-50">
                                                        Cancel
                    </a> --}}
                </div>
            </div>
        </div>
    </div>
    <div id="cancelConfirmationModal" class="modal">
        <div class="modal-content">
            <p>Are you sure you want to cancel?</p>
            <div id="buttonModal">
                <button id="confirmCancelButton">Yes</button>
                <button id="cancelModalButton">No</button>
            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var cancelButtonCurrSignature = document.getElementById('clear-signature');
            var canvas = document.getElementById('signatureCanvas');
            var signaturePad = new SignaturePad(canvas);
            var saveButton = document.getElementById('saveSignatureBtn');
            var cancelButton = document.getElementById('clear-signature-prepared');
            var signatureInputField = document.getElementsByClassName('prepared_by_signature');
            const clearSignatureBtnPrepared = document.getElementById('clear-signature-prepared');
            var existingSignature = document.getElementById('existingSignature');
            var newSignature = document.getElementById('newSignature');
            var submitBtn = document.getElementById('submitBtn');
            let clearButtonClicked = false;
            let saveSignatureBtnClicked = false;

            if(cancelButtonCurrSignature){
                cancelButtonCurrSignature.addEventListener('click', function(event){
                console.log('camam');
                event.preventDefault();
                var confirmed = window.confirm("Are you sure you want to remove your own signature?");
                if(confirmed){
                    existingSignature.style.display = 'none';
                    newSignature.style.display = 'block';
                    clearButtonClicked = true;

                }


            });
            }

            clearSignatureBtnPrepared.addEventListener('click', function(event) {
                signaturePad.clear();
                // Clear the value of the hidden input field when cancelling
                signatureInputField.value = '';
            });

            submitBtn.addEventListener('click', function(event){
                if(signaturePad && signaturePad.isEmpty()  && !saveSignatureBtnClicked){
                    if (clearButtonClicked && signatureInputField.value.trim() === '') {
                        console.log(saveSignatureBtnClicked);
                        event.preventDefault();
                        alert('Please provide a signature!');
                    }
                }
            });

            if(cancelButton){
                cancelButton.addEventListener('click', function(event){
                event.preventDefault();
                var confirmed = window.confirm("Are you sure you want to remove your own signature?");
                if(confirmed){
                    existingSignature.style.display = 'none';
                    newSignature.style.display = 'block';
                    clearButtonClicked = true;

                }


            });
            }

            saveButton.addEventListener('click', function(event) {
                event.preventDefault();

                if (!signaturePad.isEmpty()) {
                    var dataURL = signaturePad.toDataURL();

                    // Update the value of the hidden input field with the signature data URL
                    signatureInputField.value = dataURL;
                    for (var i = 0; i < signatureInputField.length; i++) {
                        signatureInputField[i].value = dataURL;
                    }

                    console.log('Signature data URL:', signatureInputField.value);
                    saveSignatureBtnClicked = true;

                    alert('Signature saved successfully!');
                } else {
                    alert('Please provide a signature before saving.');
                }
            });



        cancelButton.addEventListener('click', function(event) {
            signaturePad.clear();
            // Clear the value of the hidden input field when cancelling
            signatureInputField.value = '';
            saveSignatureBtnClicked = false;

        });

        const cancelButtonHirarc = document.getElementById('cancelButton');
        const modal = document.getElementById('cancelConfirmationModal');
        const confirmCancelButton = document.getElementById('confirmCancelButton');
        const cancelModalButton = document.getElementById('cancelModalButton');

        // When cancel button is clicked, show the modal
        cancelButtonHirarc.addEventListener('click', function() {
            modal.style.display = 'block';
        });

        // When Yes is clicked in the modal, proceed to the route
        confirmCancelButton.addEventListener('click', function() {
            // Redirect to the specified route
            window.location.href = '{{ route('user.hirarc-list') }}';
        });

        // When No is clicked in the modal, close the modal
        cancelModalButton.addEventListener('click', function() {
            modal.style.display = 'none';
        });

        // Close the modal if user clicks outside of it
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
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