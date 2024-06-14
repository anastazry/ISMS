@extends('layouts.app')

@section('content')
<style>
    .flex-container {
    display: flex;  /* Use flexbox layout */
    justify-content: space-between; /* Align items with space between them */
    max-width: 100%; /* Ensure it occupies maximum width available */
}
#firstDiv{
    margin-left: 13%;
    width: 100%;
}
#secondDiv{
    width: 35%;
}
#firstDiv, #secondDiv {
    /* width: 48%; Set width of each div (adjust as needed) */
    /* box-sizing: border-box; Include padding and border within width */
    margin-bottom: 20px; /* Add margin between divs */
}
</style>
<div class="flex-container">
    <div class="py-12" id="firstDiv">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white border rounded shadow p-4">
                <div class="border-b p-2">
                    <!-- Header content goes here -->
                    Add HIRARC
                </div>
                <form method="post" action="{{ route('user-edit-hirarc-details', ['hirarc_id' => $hirarcData['hirarc_items']->hirarc_id]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
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
                                    <input type="text" name="desc_job" value="{{ old('desc_job', $hirarcData['hirarc_items']->desc_job) }}" class="p-2 border rounded-md w-full" required>
                                    @error('desc_job')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </td>
                            </tr>

                            <tr>
                                <th>Location</th>
                                <td>
                                    <input type="text" name="location" value="{{ old('location', $hirarcData['hirarc_items']->location) }}" class="p-2 border rounded-md w-full" required>
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
                                    <input type="text" name="prepared_by" value="{{ old('prepared_by', $hirarcData['hirarc_items']->prepared_by) }}" class="p-2 border rounded-md w-full"required>
                                    @error('prepared_by')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <th>Signature</th>
                                <td>
<div id="existingSignature">
                                    @if(isset($hirarcData['hirarc_items']->prepared_by_signature))
                                    <div  class="signature-pad-footer" style="text-align: right">
                                        <button type="button" id="clear-signature" class="btn btn-danger">Clear Signature</button>
                                    </div>
                                    <div class="flex justify-center items-center h-full">
                                        <img src="{{ $hirarcData['hirarc_items']->prepared_by_signature }}" alt="User Signature">
                                    </div>
                                    @else
                                    <div>
                                        <h3 style="text-align:left">Signature</h3>
                                        <div id="signature-pad-app" class="signature-pad">
                                            <div class="signature-pad-footer" style="text-align: right">
                                                <button type="button" id="clear-signature-prepared" class="btn btn-danger">Clear</button>
                                            </div>
                                        </div>
                                        {{-- <textarea id="verified_by_signature" name="verified_by_signature" style="display: none"></textarea> --}}
                                        <input type="text" name="prepared_by_signature" id="prepared_by_signature" value="" style="display: none" required>
                                        <div class="canvas-container">
                                            <canvas id="signatureCanvas" class="border border-black" width="400" height="200"></canvas>
                                        </div>                                            
                                        {{-- <canvas id="signatureCanvas" class="border border-black w-full" height="500"></canvas> --}}
                                        <button id="saveSignatureBtn" class="btn btn-primary">Save Signature</button>
                                    </div>
                                    @endif

</div>
                                    <div id="newSignature" style="display: none">
                                        <div id="signature-pad-app" class="signature-pad">
                                            <div class="signature-pad-footer" style="text-align: right">
                                                <button type="button" id="clear-signature-prepared" class="btn btn-danger">Clear</button>
                                            </div>
                                        </div>
                                        {{-- <textarea id="verified_by_signature" name="verified_by_signature" style="display: none"></textarea> --}}
                                        <input type="text" name="prepared_by_signature" id="prepared_by_signature" value="" style="display: none">
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
                                    <input type="date" name="inspection_date" value="{{ old('inspection_date', $hirarcData['hirarc_items']->inspection_date) }}" class="p-2 border rounded-md w-full" required>
                                    @error('inspection_date')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </td>
                                {{-- <input type="hidden" name="hirarc_id" value="{{ $hirarc_id }}" class="p-2 border rounded-md w-full"> --}}
                            </tr>
                        </tbody>
                        {{-- <input type="hidden" name="tpage_id" value="{{ $hirarcData['titlePage']->tpage_id }}"> --}}

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
                                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
                                    Next
                                </button>
                                
                                <button onclick="event.preventDefault(); location.href='{{ route('user-incident-list') }}';
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
    <div class="py-12" id="secondDiv">
        <div style="margin-right: 15px" class="">

            <div class="bg-white border rounded shadow p-4">
                <div class="border-b p-2">
                    <!-- Header content goes here -->
                    Audit Trail
                </div>
                @php
                    $counterAudit = 1;
                @endphp

<div class="max-h-10vh overflow-y-scroll" style="max-height: 52.5vh;">
    <ol class="relative border border-gray-200 dark:border-gray-700 divide-y divide-gray-200 dark:divide-gray-700">
        @if (isset($hirarcData['auditData']))
            @foreach ($hirarcData['auditData'] as $audit)
                @php
                    $user = \App\Models\User::find($audit->user_id);
                    $userName = $user ? $user->name : 'User Not Found';
                @endphp
                <li class="py-4">
                    <div class="flex items-center justify-between p-4 bg-white border rounded-lg shadow-sm sm:flex dark:bg-gray-700 dark:border-gray-600 cursor-pointer" id="auditHeading{{ $loop->index }}">
                        <time class="text-xs font-normal text-gray-400 sm:order-last sm:mb-0">{{ date('d-m-Y', strtotime($audit->updated_at)) }}</time>

                        <div class="text-sm font-normal text-gray-500 dark:text-gray-300"><span style="color: blue">{{ $userName }}</span> has <span style="color: #39393A">{{ $audit->event }}</span> the HIRARC data!</div>
                    </div>
                    <div style="display: none" id="auditContent{{ $loop->index }}">
                    @if (isset($audit->old_values))
                        <?php 
                            $oldData = is_array($audit->old_values) ? $audit->old_values : json_decode($audit->old_values, true);
                            $newData = is_array($audit->new_values) ? $audit->new_values : json_decode($audit->new_values, true);
                        ?>
                        @if (isset($audit->updated_at))
                            <div class="text-sm font-normal text-gray-500 dark:text-gray-300" style="margin-left: 15px"><span style="font-weight: bold">Time Updated:</span> {{ date('H:i:s', strtotime($audit->updated_at)) }}</div>
                        @endif
                        @if (isset($oldData['desc_job']))
                            <div class="text-sm font-normal text-gray-500 dark:text-gray-300" style="margin-left: 15px"><span style="font-weight: bold">Description Job:</span> {{ $oldData['desc_job'] }} to {{ $newData['desc_job'] }}</div>
                        @endif
                        @if (isset($oldData['location']))
                            <div class="text-sm font-normal text-gray-500 dark:text-gray-300" style="margin-left: 15px"><span style="font-weight: bold">Location:</span> {{ $oldData['location'] }} to {{ $newData['location'] }}</div>
                        @endif
                        @if (isset($oldData['prepared_by']))
                            <div class="text-sm font-normal text-gray-500 dark:text-gray-300" style="margin-left: 15px"><span style="font-weight: bold">Prepared By:</span> {{ $oldData['prepared_by'] }} to {{ $newData['prepared_by'] }}</div>
                        @endif
                        @if (isset($oldData['inspection_date']))
                            <div class="text-sm font-normal text-gray-500 dark:text-gray-300" style="margin-left: 15px"><span style="font-weight: bold">Inspection Date:</span> 
                                {{ date('d-m-Y', strtotime($oldData['inspection_date'])) }}
                                to
                                {{ date('d-m-Y', strtotime($newData['inspection_date'])) }}
                            </div>
                        @endif
                        @if (isset($oldData['prepared_by_signature']))
                            <div class="text-sm font-normal text-gray-500 dark:text-gray-300" style="margin-left: 15px">A new signature is signed by {{ $userName }}</div>
                        @endif

                    
                    @endif
                </div>

                </li>
                <script>
                    // Add event listener to the auditHeading element
                    document.getElementById('auditHeading{{ $loop->index }}').addEventListener('click', function() {
                        // Toggle the display property of the corresponding auditContent
                        const auditContent = document.getElementById('auditContent{{ $loop->index }}');
                        auditContent.style.display = auditContent.style.display === 'none' ? 'block' : 'none';
                    });
                </script>
            @endforeach
        @endif
    </ol>
</div>





                {{-- <table>
                    @if (isset($hirarcData['auditData']))
                    @foreach ($hirarcData['auditData'] as $audit)
                    @php
                        $user = \App\Models\User::find($audit->user_id);
                        $userName = $user ? $user->name : 'User Not Found';
                    @endphp
                    <tr>
                        <td>{{$counterAudit++}}.</td>
                        @if($audit['event'] == 'updated')
                            <td>
                                {{ $userName }} has {{ $audit['event']}} the HIRARC data!

                                <div>
                                    <p></p> 
                                </div>
                            </td>

                            @endif
                            
                        @else
                            <td>{{ $userName }} has {{ $audit['event']}} the HIRARC data!</td>
                        @endif
                    </tr>
                    @endforeach

                    @endif
                </table> --}}


                
   
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>


    <script>
            var cancelButton = document.getElementById('clear-signature');
            var canvas = document.getElementById('signatureCanvas');
            var signaturePad = new SignaturePad(canvas);
            var saveButton = document.getElementById('saveSignatureBtn');
            console.log(signaturePad);
            var signatureInputField = document.getElementById('prepared_by_signature');
            const clearSignatureBtnPrepared = document.getElementById('clear-signature-prepared');
            var existingSignature = document.getElementById('existingSignature');
            var newSignature = document.getElementById('newSignature');
            var submitBtn = document.getElementById('submitBtn');
            let clearButtonClicked = false;
            let saveSignatureBtnClicked = false;

            clearSignatureBtnPrepared.addEventListener('click', function(event) {
                signaturePad.clear();
                // Clear the value of the hidden input field when cancelling
                signatureInputField.value = '';
            });

            if(submitBtn){
                submitBtn.addEventListener('click', function(event){
                if(signaturePad && signaturePad.isEmpty()  && !saveSignatureBtnClicked){
                    if (clearButtonClicked && signatureInputField.value.trim() === '') {
                        console.log(saveSignatureBtnClicked);
                        event.preventDefault();
                        alert('Please provide a signature!');
                    }
                }
            });
            }


            cancelButton.addEventListener('click', function(event){
                console.log('camam');
                event.preventDefault();
                var confirmed = window.confirm("Are you sure you want to remove your own signature?");
                if(confirmed){
                    existingSignature.style.display = 'none';
                    newSignature.style.display = 'block';
                    clearButtonClicked = true;

                }


            });
            saveButton.addEventListener('click', function(event) {
                event.preventDefault();

                if (!signaturePad.isEmpty()) {
                    var dataURL = signaturePad.toDataURL();

                    // Update the value of the hidden input field with the signature data URL
                    signatureInputField.value = dataURL;

                    console.log('Signature data URL:', dataURL);
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
        }

        // const dropdownButton = document.getElementById('dropdownDefaultButton');
        // const dropdownMenu = document.getElementById('dropdown');

        // dropdownButton.addEventListener('click', function() {
        // dropdownMenu.classList.toggle('hidden');  // Toggles 'hidden' class on click
        // });

        // function toggleOptions() {
        //     var optionsDiv = document.getElementById("options");
        //     if (optionsDiv.classList.contains("hidden")) {
        //         optionsDiv.classList.remove("hidden");
        //     } else {
        //         optionsDiv.classList.add("hidden");
        //     }
        // }


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