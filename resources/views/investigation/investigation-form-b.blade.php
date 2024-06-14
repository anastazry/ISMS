@extends('layouts.app')

@section('content')
<style>
    .status-box {
    display: inline-block;
    width: 100px;
    height: 50px;
    border: 1px solid #ccc;
    background-color: #fff;
    cursor: pointer;
    text-align: center;
    line-height: 50px;
    margin-right: 10px;
}

.status-box input[type="checkbox"] {
    display: none;
}

.status-box input[type="checkbox"]:checked + span {
    background-color: green;
    color: white;
}

.status-box input[type="radio"] {
    display: none;
}

.status-box {
    display: inline-block;
    padding: 5px;
    transition: background-color 0.3s ease;
    cursor: pointer;
}

.status-box input[type="radio"]:checked + span {
    background-color: green;
}

.status-box span {
    display: inline-block;
    padding: 5px;
    border-radius: 5px;
}

.status-box input[type="radio"]:checked + span {
    background-color: green;
}

#results {
            position: absolute;
            background-color: white;
            border: 1px solid #ccc;
            z-index: 1000;
            width: 35%; /* Adjust width as necessary */
            display: none; /* Initially hidden */
        }
        #results div {
            padding: 10px;
            cursor: pointer;
        }
        #results div:hover {
            background-color: #f0f0f0;
        }

        .results {
            position: absolute;
            background-color: white;
            border: 1px solid #ccc;
            z-index: 1000;
            width: calc(100% - 42px); /* Adjust width based on input and button */
            margin-top: 40%;
            display: none; /* Initially hidden */
        }
        .results div {
            padding: 10px;
            cursor: pointer;
        }
        .results div:hover {
            background-color: #f0f0f0;
        }
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white border rounded shadow p-4">
                <div class="border-b p-2">
                    <!-- Header content goes here -->
                    Incident Investigation (Part B)
                </div>
                <div class="p-2">
                    <!-- Body content goes here -->
                    @if(Session::has('message'))
                        <div class="bg-green-500 text-white px-4 py-2 rounded">
                            <!-- Alert content goes here -->
                            {{ Session::get('message') }}
                        </div>
                    @endif
                    @if(isset($crudOperation))
                    <form method="post" action="{{ route('update-investigation-form-b', ['id' => $investigation->id]) }}" enctype="multipart/form-data">
                    @else
                    <form method="post" action="{{ route('submit-investigation-form-b', ['reportNo' => $reportNo]) }}" enctype="multipart/form-data">
                    @endif
                        @csrf
                        <table class="min-w-full divide-y divide-gray-200">
                            <tbody class="bg-white divide-y divide-gray-200">
                                <!-- ... existing rows ... -->
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap" style="width: 30%;">Report No</td>
                                    <td class="px-6 py-4">
                                        <input type="text" name="reportNo" value="{{ $reportNo }}" class="p-2 border rounded-md w-full" readonly>
                                        @error('reportNo')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap" style="vertical-align: top">Non Corrective Actions</td>
                                    <td class="px-6 py-4">

                                        <div id="ncrContainer">
                                            @if(isset($investigation->ncr) && !empty($investigation->ncr))
                                            @foreach($investigation->ncr as $team)
                                            <div class="flex items-center mb-2" style="position: relative;">
                                                <input type="text" name="ncr[]" value="{{ $team }}" class="p-2 border rounded-md w-full mr-2" placeholder="Enter NCR" autocomplete="off">
                                                <button type="button" onclick="removeNCR(this)">
                                                    <img src="{{ asset('images/icons/removeIcon.png') }}" width="30px" height="30px">
                                                </button>
                                                <div class="results"></div>
                                            </div>
                                            @endforeach
                                            @else
                                            <div class="flex items-center mb-2" style="position: relative;">
                                                <input type="text" name="ncr[]" value="" class="p-2 border rounded-md w-full mr-2" placeholder="Enter NCR" autocomplete="off">
                                                <button type="button" onclick="removeNCR(this)">
                                                    <img src="{{ asset('images/icons/removeIcon.png') }}" width="30px" height="30px">
                                                </button>
                                                <div class="results"></div>
                                            </div>
                                            @endif
                                        </div>

                                        <div class="flex justify-center mt-4">
                                            <button type="button" onclick="addNCR()">
                                                <img src="{{ asset('images/icons/addNewIcon.png') }}" width="30px" height="30px">
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap" style="vertical-align: top">Mitigative Actions</td>
                                    <td class="px-6 py-4">

                                        <div id="maContainer">
                                            @if(isset($investigation->mitigative_actions) && !empty($investigation->mitigative_actions))
                                                @foreach($investigation->mitigative_actions as $mitigative_actions)
                                                    <div class="flex items-center mb-2" style="position: relative;">
                                                        <input type="text" name="mitigative_actions[]" value="{{ $mitigative_actions }}" class="p-2 border rounded-md w-full mr-2" placeholder="Enter Mitigative Actions" autocomplete="off">
                                                        <button type="button" onclick="removeMitigativeActions(this)">
                                                            <img src="{{ asset('images/icons/removeIcon.png') }}" width="30px" height="30px">
                                                        </button>
                                                        <div class="results"></div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="flex items-center mb-2" style="position: relative;">
                                                    <input type="text" name="mitigative_actions[]" value="" class="p-2 border rounded-md w-full mr-2" placeholder="Enter Mitigative Actions" autocomplete="off">
                                                    <button type="button" onclick="removeMitigativeActions(this)">
                                                        <img src="{{ asset('images/icons/removeIcon.png') }}" width="30px" height="30px">
                                                    </button>
                                                    <div class="results"></div>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="flex justify-center mt-4">
                                            <button type="button" onclick="addMitigativeActions()">
                                                <img src="{{ asset('images/icons/addNewIcon.png') }}" width="30px" height="30px">
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap" style="vertical-align: top">Opportunities for continual improvements</td>
                                    <td class="px-6 py-4">

                                        <div id="cont_improveContainer">
                                            @if(isset($investigation->cont_improve) && !empty($investigation->cont_improve))
                                                @foreach($investigation->cont_improve as $cont_improve)
                                                    <div class="flex items-center mb-2" style="position: relative;">
                                                        <input type="text" name="cont_improve[]" value="{{ $cont_improve }}" class="p-2 border rounded-md w-full mr-2" placeholder="Enter Continual Improvements that can be made.." autocomplete="off">
                                                        <button type="button" onclick="removeContImprove(this)">
                                                            <img src="{{ asset('images/icons/removeIcon.png') }}" width="30px" height="30px">
                                                        </button>
                                                        <div class="results"></div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div id="cont_improveContainer">
                                                    <div class="flex items-center mb-2" style="position: relative;">
                                                        <input type="text" name="cont_improve[]" value="" class="p-2 border rounded-md w-full mr-2" placeholder="Enter Continual Improvements that can be made.." autocomplete="off">
                                                        <button type="button" onclick="removeContImprove(this)">
                                                            <img src="{{ asset('images/icons/removeIcon.png') }}" width="30px" height="30px">
                                                        </button>
                                                        <div class="results"></div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex justify-center mt-4">
                                            <button type="button" onclick="addContImprove()">
                                                <img src="{{ asset('images/icons/addNewIcon.png') }}" width="30px" height="30px">
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap" style="vertical-align: top">Penalty</td>
                                    <td class="px-6 py-4">

                                        <div id="penaltyContainer">
                                            @if(isset($investigation->penalty) && !empty($investigation->penalty))
                                                @foreach($investigation->penalty as $penalty)
                                                    <div class="flex items-center mb-2" style="position: relative;">
                                                        <input type="text" name="penalty[]" value="{{ $penalty }}" class="p-2 border rounded-md w-full mr-2" placeholder="Enter Penalty.." autocomplete="off">
                                                        <button type="button" onclick="removePenalty(this)">
                                                            <img src="{{ asset('images/icons/removeIcon.png') }}" width="30px" height="30px">
                                                        </button>
                                                        <div class="results"></div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="flex items-center mb-2" style="position: relative;">
                                                    <input type="text" name="penalty[]" value="" class="p-2 border rounded-md w-full mr-2" placeholder="Enter Penalty.." autocomplete="off">
                                                    <button type="button" onclick="removePenalty(this)">
                                                        <img src="{{ asset('images/icons/removeIcon.png') }}" width="30px" height="30px">
                                                    </button>
                                                    <div class="results"></div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex justify-center mt-4">
                                            <button type="button" onclick="addPenalty()">
                                                <img src="{{ asset('images/icons/addNewIcon.png') }}" width="30px" height="30px">
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">Results has been communicated to :</td>
                                    
                                    <td class="px-6 py-4">

                                        @if(isset($investigation->safety_comittee_know))
                                        <label for="safety_comittee_know" class="flex items-center justify-between">
                                            Safety Comittee
                                            <input type="checkbox" name="safety_comittee_know" id="safety_comittee_know" class="ml-2" @if(isset($investigation->safety_comittee_know) && $investigation->safety_comittee_know == 1) checked @endif>
                                        </label>                                        
                                        @else
                                        <label for="safety_comittee_know" class="flex items-center justify-between">
                                            Safety Comittee
                                            <input type="checkbox" name="safety_comittee_know" id="safety_comittee_know" class="ml-2">
                                        </label>
                                        @endif
                                        
                                        @error('safety_comittee_know')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror

                                        @if(isset($investigation->pm_know))
                                        <label for="pm_know" class="flex items-center justify-between">
                                            Project Manager
                                            <input type="checkbox" name="pm_know" id="pm_know" class="ml-2" @if(isset($investigation->pm_know) && $investigation->pm_know == 1) checked @endif>
                                        </label>                                        
                                        @else
                                        <label for="pm_know" class="flex items-center justify-between">
                                            Project Manager
                                            <input type="checkbox" name="pm_know" id="pm_know" class="ml-2">
                                        </label>
                                        @endif
                                        
                                        @error('pm_know')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror

                                        @if(isset($investigation->staff_know))
                                        <label for="staff_know" class="flex items-center justify-between">
                                            Staff
                                            <input type="checkbox" name="staff_know" id="staff_know" class="ml-2" @if(isset($investigation->staff_know) && $investigation->staff_know == 1) checked @endif>
                                        </label>                                        
                                        @else
                                        <label for="staff_know" class="flex items-center justify-between">
                                            Staffs
                                            <input type="checkbox" name="staff_know" id="staff_know" class="ml-2">
                                        </label>
                                        @endif
                                        
                                        @error('staff_know')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror

                                        @if(isset($investigation->others_know))
                                        <label for="others_know" class="flex items-center justify-between">
                                            Others 
                                            <input type="checkbox" name="others_know" id="others_know" class="ml-2" @if(isset($investigation->others_know) && $investigation->others_know == 1) checked @endif>
                                        </label>                                        
                                        @else
                                        <label for="others_know" class="flex items-center justify-between">
                                            Others
                                            <input type="checkbox" name="others_know" id="others_know" class="ml-2">
                                        </label>
                                        @endif
                                        
                                        @error('others_know')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror

                                    </td>
                                </tr>

                
                                @auth
                                {{-- @if(isset($investigation->sho_signature) && Auth::user()->role == "SHO") --}}
                                @if(Auth::user()->role == "SHO")
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">SHO Signature:</td>
                                            <td>
                                                @if(isset($investigation->sho_signature))
                                                    <div id="signatureImage" class="flex flex-col items-center justify-center">
                                                        <h6 id="newSignatureTrigger" class="self-end cursor-pointer text-right" style="color: red">Remove Signature?</h6>
                                                        <img src="{{$investigation->sho_signature}}" alt="" class="max-w-full h-auto" style="outline: auto">
                                                        
                                                    </div>

                                                    <div id="newSignature" style="display: none;" class="flex flex-col items-center justify-center">
                                                        <div id="signature-pad-app" class="signature-pad">
                                                            <div class="signature-pad-footer" style="text-align: right">
                                                                <button type="button" id="clear-signature-app" class="btn btn-danger" style="color: red">Clear</button>
                                                            </div>
                                                        </div>
                                                        <div class="canvas-container max-w-full h-auto flex items-center justify-center"> <!-- Applied Tailwind classes here -->
                                                            <input type="text" name="approved_by_signature" id="approved_by_signature" value="" style="display: none">
                                                            <canvas id="signatureCanvas-app" class="border border-black" width="400px" height="200px"></canvas>
                                                        </div>
                                                        <div class="flex justify-end"> <!-- Added Tailwind class here -->
                                                            <button id="saveSignatureBtn-app" class="btn btn-primary" style="color: #0BDA51">Save Signature</button> <!-- Modified class here -->
                                                        </div>   

                                                    </div>

                                                    <div class="flex justify-between" style="margin-top: 4%">
                                                        <div>
                                                            <label for="sho_name">Name : </label>
                                                            <input type="text" name="sho_name" value="{{$investigation->sho_name}}">
                                                        </div>
                                                        <div>
                                                            <label for="sho_signature_date">Date : </label>
                                                            <input type="date" name="sho_signature_date" value="{{$investigation->sho_signature_date}}">
                                                        </div>
                                                    </div>
                                                    
                                                @else
                                                    <div>
                                                        <div id="signature-pad-app" class="signature-pad">
                                                            <div class="signature-pad-footer" style="text-align: right">
                                                                <button type="button" id="clear-signature-app" class="btn btn-danger">Clear</button>
                                                            </div>
                                                        </div>
                                                        {{-- <textarea id="verified_by_signature" name="verified_by_signature" style="display: none"></textarea> --}}
                                                        <div class="canvas-container max-w-full h-auto flex items-center justify-center"> <!-- Applied Tailwind classes here -->
                                                            <input type="text" name="approved_by_signature" id="approved_by_signature" value="" style="display: none">
                                                            <canvas id="signatureCanvas-app" class="border border-black" width="400" height="200"></canvas>
                                                        </div>                                            
                                                        {{-- <canvas id="signatureCanvas" class="border border-black w-full" height="500"></canvas> --}}
                                                        <div class="flex justify-end"> <!-- Added Tailwind class here -->
                                                            <button id="saveSignatureBtn-app" class="btn btn-primary" style="color: #0BDA51">Save Signature</button> <!-- Modified class here -->
                                                        </div>   
                                                        <div class="flex justify-between">
                                                            <div>
                                                                <label for="sho_name">Name : </label>
                                                                <input type="text" name="sho_name">
                                                            </div>
                                                            <div>
                                                                <label for="sho_signature_date">Date : </label>
                                                                <input type="date" name="sho_signature_date">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                            </td>
                                        </tr>
                                    @endif
                                @endauth
                                
                            </tbody>
                        </table>

                        <!-- Dynamic fields for injured persons -->

                        </div>


                        <tr>
                            <td class="px-6 py-4"></td>
                            <td class="px-6 py-4">
                                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
                                    Submit
                                </button>
                                
                                <button onclick="event.preventDefault(); location.href='{{ route('incident-investigation-list') }}';
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
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>

    <script>
if(document.getElementById('newSignatureTrigger')){
    document.getElementById('newSignatureTrigger').addEventListener('click', function() {
        if (confirm('Are you sure you want to create a new signature?')) {
            // Hide the signatureImage div
            document.getElementById('signatureImage').style.display = 'none';
            
            // Show the newSignature div
            document.getElementById('newSignature').style.display = 'block';
        }
    });
}


    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-btn');
        const modal = document.getElementById('deleteImageModal');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
        let imageIndexToDelete;

        deleteButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                imageIndexToDelete = this.getAttribute('data-index');
                modal.style.display = 'block';
            });
        });

            // JavaScript to handle deletion of images
            // confirmDeleteBtn.addEventListener('click', function () {
    // Get the report number
    var reportNo = document.querySelector('input[name="reportNo"]').value;

    fetch('/delete-image', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ index: imageIndexToDelete, reportNo: reportNo })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Image deleted successfully
            // Update the view to remove the deleted image
            const imageContainer = document.querySelector(`.image-container[data-index="${imageIndexToDelete}"]`);
            if (imageContainer) {
                imageContainer.remove();
            }
        } else {
            // Error occurred while deleting the image
            console.error('Error deleting image:', data.message);
        }
    })
    .catch(error => {
        console.error('Error deleting image:', error);
    })
    .finally(() => {
        // Close the modal
        // modal.style.display = 'none';
    });



    //signaturepad
    var canvas = document.getElementById('signatureCanvas');
        var canvas_app = document.getElementById('signatureCanvas-app');
        // var signaturePad = new SignaturePad(canvas);
        var signaturePad_app = new SignaturePad(canvas_app);
        var saveButton = document.getElementById('saveSignatureBtn');
        var saveButton_app = document.getElementById('saveSignatureBtn-app');
        var cancelButton = document.getElementById('clear-signature');
        var cancelButton_app = document.getElementById('clear-signature-app');
        var signatureInputField = document.getElementById('verified_by_signature');
        var signatureInputField_app = document.getElementById('approved_by_signature');

        // saveButton.addEventListener('click', function(event) {
        //     event.preventDefault();

        //     if (!signaturePad.isEmpty()) {
        //         var dataURL = signaturePad.toDataURL();

        //         // Update the value of the hidden input field with the signature data URL
        //         signatureInputField.value = dataURL;

        //         console.log('Signature data URL:', dataURL);
        //         alert('Signature saved successfully!');
        //     } else {
        //         alert('Please provide a signature before saving.');
        //     }
        // });

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

        // cancelButton.addEventListener('click', function(event) {
        //     signaturePad.clear();
        //     // Clear the value of the hidden input field when cancelling
        //     signatureInputField.value = '';
        // });

        cancelButton_app.addEventListener('click', function(event) {
            signaturePad_app.clear();
            // Clear the value of the hidden input field when cancelling
            signatureInputField_app.value = '';
        });
});

        // cancelDeleteBtn.addEventListener('click', function () {
        //     // Close the modal without deleting the image
        //     modal.style.display = 'none';
        // });

        
    // });
        $(document).ready(function() {
            $('#search').on('keyup', function() {
                var query = $(this).val();
                if (query !== '') {
                    $.ajax({
                        url: "{{ route('searchHirarc') }}",
                        type: "GET",
                        data: {'query': query},
                        success: function(data) {
                            $('#results').html('');
                            $.each(data, function(index, item) {
                                $('#results').append('<div data-id="'+item.hirarc_id+'">'+item.hirarc_id+' '+item.desc_job+'</div>');
                            });
                            $('#results').show();
                        }
                    });
                } else {
                    $('#results').hide();
                }
            });

            $(document).on('click', function(event) {
                if (!$(event.target).closest('#search').length) {
                    $('#results').hide();
                }
            });

            $(document).on('click', '#results div', function() {
                var hirarcId = $(this).data('id');
                var descJob = $(this).text();
                $('#search').val(descJob);
                $('#hirarc_id').val(hirarcId);
                $('#results').hide();
            });

            $('.search-user').on('keyup', function() {
                var query = $(this).val();
                var $this = $(this);
                var $resultsDiv = $this.siblings('.results');
                if (query !== '') {
                    $.ajax({
                        url: "{{ route('searchUser') }}",
                        type: "GET",
                        data: {'query': query},
                        success: function(data) {
                            $resultsDiv.html('');
                            $.each(data, function(index, item) {
                                $resultsDiv.append('<div data-name="'+item.name+'">'+item.name+ '(' + item.role + ')'+'</div>');
                            });
                            $resultsDiv.show();
                        }
                    });
                } else {
                    $resultsDiv.hide();
                }
            });

            $(document).on('click', function(event) {
                if (!$(event.target).closest('.search-user').length) {
                    $('.results').hide();
                }
            });

            $(document).on('click', '.results div', function() {
                var userName = $(this).data('name');
                var $parentDiv = $(this).closest('.flex');
                $parentDiv.find('.search-user').val(userName);
                $parentDiv.find('.results').hide();
            });
        });

        function addNCR() {
            var ncrInputs = document.querySelectorAll('input[name="ncr[]"]');
            if(ncrInputs.length == 5){
                return;
            }
            const container = document.getElementById('ncrContainer');
            const newInput = document.createElement('div');
            newInput.classList.add('flex', 'items-center', 'mb-2');
            newInput.innerHTML = `
                <input type="text" name="ncr[]" class="p-2 border rounded-md w-full mr-2" placeholder="">
                <button type="button" onclick="removeNCR(this)">
                    <img src="{{ asset('images/icons/removeIcon.png') }}" width="30px" height="30px">
                </button>
                <div class="results"></div>

            `;
            container.appendChild(newInput);
        }

        function addMitigativeActions () {
            var maInputs = document.querySelectorAll('input[name="mitigative_actions[]"]');
            if(maInputs.length == 5){
                return;
            }
            const container = document.getElementById('maContainer');
            const newInput = document.createElement('div');
            newInput.classList.add('flex', 'items-center', 'mb-2');
            newInput.innerHTML = `
                <input type="text" name="mitigative_actions[]" class="p-2 border rounded-md w-full mr-2" placeholder="">
                <button type="button" onclick="removeMitigativeActions(this)">
                    <img src="{{ asset('images/icons/removeIcon.png') }}" width="30px" height="30px">
                </button>
                <div class="results"></div>

            `;
            container.appendChild(newInput);
        }

        function addContImprove() {
            var cont_improveInputs = document.querySelectorAll('input[name="cont_improve[]"]');
            if(cont_improveInputs.length == 5){
                return;
            }
            const container = document.getElementById('cont_improveContainer');
            const newInput = document.createElement('div');
            newInput.classList.add('flex', 'items-center', 'mb-2');
            newInput.innerHTML = `
                <input type="text" name="cont_improve[]" class="p-2 border rounded-md w-full mr-2" placeholder="">
                <button type="button" onclick="removeContImprove(this)">
                    <img src="{{ asset('images/icons/removeIcon.png') }}" width="30px" height="30px">
                </button>
                <div class="results"></div>

            `;
            container.appendChild(newInput);
        }

        function addPenalty() {
            var penaltyInputs = document.querySelectorAll('input[name="penalty[]"]');
            if(penaltyInputs.length == 5){
                return;
            }
            const container = document.getElementById('penaltyContainer');
            const newInput = document.createElement('div');
            newInput.classList.add('flex', 'items-center', 'mb-2');
            newInput.innerHTML = `
                <input type="text" name="penalty[]" class="p-2 border rounded-md w-full mr-2" placeholder="">
                <button type="button" onclick="removePenalty(this)">
                    <img src="{{ asset('images/icons/removeIcon.png') }}" width="30px" height="30px">
                </button>
                <div class="results"></div>

            `;
            container.appendChild(newInput);
        }


        function removeNCR(button) {
            var ncrInputs = document.querySelectorAll('input[name="ncr[]"]');
            if(ncrInputs.length == 1){
                return;
            }
            const container = document.getElementById('ncrContainer');
            container.removeChild(button.parentNode);
        }

        function removeMitigativeActions(button) {
            var maInputs = document.querySelectorAll('input[name="mitigative_actions[]"]');
            if(maInputs.length == 1){
                console.log(maInputs.length);
                return;
            }
            const container = document.getElementById('maContainer');
            container.removeChild(button.parentNode);
        }

        function removeContImprove(button) {
            var cont_improveInputs = document.querySelectorAll('input[name="cont_improve[]"]');
            if(cont_improveInputs.length == 1){
                return;
            }
            const container = document.getElementById('cont_improveContainer');
            container.removeChild(button.parentNode);
        }

        function removePenalty(button) {
            var penaltyInputs = document.querySelectorAll('input[name="penalty[]"]');
            if(penaltyInputs.length == 1){
                return;
            }
            const container = document.getElementById('penaltyContainer');
            container.removeChild(button.parentNode);
        }


        function deleteImage(imagePath) {
        if(confirm('You will never recover this even if you cancel! Are you sure you want to delete this image?')) {
            fetch('{{ route('delete-image') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ imagePath: imagePath })
            }).then(response => response.json())
            .then(data => {
                if (data.message) {
                    alert(data.message);
                    window.location.reload();
                }
            }).catch(error => {
                console.error('Error:', error);
            });
        }
        else{
            window.history.back();
        }
    }



        function updateLabelBackground(radio) {
            // Reset the background color of all labels
            const labels = document.querySelectorAll('#status-cell .status-box');
            labels.forEach(label => label.style.backgroundColor = '');

            // Set the background color of the selected label
            const label = radio.parentElement;
            if (radio.checked) {
                label.style.backgroundColor = 'green';
            }
        }

    </script>
@endsection



<!-- End the content section -->
{{-- 
function deleteRow(btn) {
    var injuredPeopleRows = document.querySelectorAll('#injuredPersons .injuredPerson');
    if (injuredPeopleRows.length > 1) {
        var row = btn.parentNode.parentNode;
        row.parentNode.removeChild(row);
        updateIndices();
    }
}


function updateIndices() {
    var injuredPeopleRows = document.querySelectorAll('#injuredPersons .injuredPerson');
    injuredPeopleRows.forEach((row, index) => {
        row.querySelectorAll('input').forEach(input => {
            var name = input.name;
            var newName = name.replace(/\[\d+\]/, '[' + index + ']'); // Update the index
            input.name = newName;
        });
    });
}

function deleteWitnessRow(btn) {
    var witnessRows = document.querySelectorAll('#witnesses .witness');
    if (witnessRows.length > 1) {
        var row = btn.parentNode.parentNode;
        row.parentNode.removeChild(row);
        updateWitnessIndices();
    }
}

function updateWitnessIndices() {
    var witnessRows = document.querySelectorAll('#witnesses .witness');
    witnessRows.forEach((row, index) => {
        row.querySelectorAll('input').forEach(input => {
            var name = input.name;
            var newName = name.replace(/\[\d+\]/, '[' + index + ']'); // Update the index
            input.name = newName;
        });
    });
}

function addInjuredPerson() {
    var tbody = document.querySelector('#injuredPersons tbody');
    var newRow = tbody.getElementsByClassName('injuredPerson')[0].cloneNode(true);
    newRow.querySelectorAll('input').forEach(input => input.value = '');
    tbody.appendChild(newRow);
}

function addWitness() {
    var tbody = document.querySelector('#witnesses tbody');
    var newRow = tbody.getElementsByClassName('witness')[0].cloneNode(true);
    newRow.querySelectorAll('input').forEach(input => input.value = '');
    tbody.appendChild(newRow);
} --}}
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

