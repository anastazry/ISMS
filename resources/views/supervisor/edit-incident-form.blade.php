@extends('layouts.app')

@section('content')
<style>
    .image-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
    gap: 10px;
}

.image-container {
    position: relative;
}

.delete-btn {
    position: absolute;
    top: 0;
    right: 0;
    display: none;
    padding-left: 5px;
    padding-right: 5px;
    border-radius: 20px;
}

.image-container:hover .delete-btn {
    display: block;
}
.modal {
  display: none;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0,0,0,0.4);
}

.modal-content {
  background-color: #fefefe;
  margin: 15% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}

.incident-img {
  width: 100%;
  height: auto;
  display: block;
  margin-bottom: 10px;
}

#incidentModal .modal-content button {
  padding: 5px 10px;
  margin-right: 5px;
}
</style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border rounded shadow p-4">
                <div class="border-b p-2">
                    <!-- Header content goes here -->
                    <h4 style="font-weight: bold">Update Incident Details</h4>
                </div>
                <div class="p-2">
                    <!-- Body content goes here -->
                    @if(Session::has('message'))
                        <div class="bg-green-500 text-white px-4 py-2 rounded">
                            <!-- Alert content goes here -->
                            {{ Session::get('message') }}
                        </div>
                    @endif
                    <form method="post" action="{{ route('user-update-incident', $incident->reportNo) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <table class="min-w-full divide-y divide-gray-200">
                            <tbody class="bg-white divide-y divide-gray-200">
                                <!-- ... existing rows ... -->
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">Report No</td>
                                    <td class="px-6 py-4">
                                        <input type="text" name="reportNo" value="{{ old('reportNo', $incident->reportNo) }}"  class="p-2 border rounded-md w-full" readonly>
                                        @error('reportNo')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">Department Name</td>
                                    <td class="px-6 py-4">
                                        <input type="text" name="dept_name" value="{{ old('dept_name', $incident->dept_name) }}" class="p-2 border rounded-md w-full">
                                        @error('dept_name')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">Project Site</td>
                                    <td class="px-6 py-4">
                                        <input type="text" name="project_site" value="{{ old('project_site', $incident->project_site) }}" class="p-2 border rounded-md w-full">
                                        @error('project_site')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">Title</td>
                                    <td class="px-6 py-4">
                                        <input type="text" name="incident_title" value="{{ old('incident_title', $incident->incident_title) }}" class="p-2 border rounded-md w-full">
                                        @error('incident_title')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">Date of Incident</td>
                                    <td class="px-6 py-4">
                                        <input type="date" name="incident_date" value="{{ old('incident_date', $incident->incident_date) }}" class="p-2 border rounded-md w-full">
                                        @error('incident_date')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">Time of Incident</td>
                                    <td class="px-6 py-4">
                                        <input type="time" name="incident_time" value="{{ old('incident_time', $incident->incident_time) }}" class="p-2 border rounded-md w-full" >
                                        @error('incident_time')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">Location of Incident</td>
                                    <td class="px-6 py-4">
                                        <input type="text" name="incident_location" value="{{ old('incident_location', $incident->incident_location) }}" class="p-2 border rounded-md w-full">
                                        @error('incident_location')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </td>
                                </tr>
                                <!-- ... similar for other rows ... -->
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">Description</td>
                                    <td class="px-6 py-4">
                                        <textarea name="incident_desc" rows="4" class="p-2 border rounded-md w-full">{{ old('incident_desc', $incident->incident_desc) }}</textarea>
                                        @error('incident_desc')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </td>
                                </tr>                    
        
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">Photo (if necessary)</td>
                                    <td class="px-6 py-4">
                                        @if ($incident->images)
                                        <div class="image-grid">
                                            @foreach ($incident->images as $image)
                                                <div class="image-container">
                                                    <img src="{{ asset('storage/' . $image) }}" alt="Incident Image">
                                                    <button class="delete-btn" onclick="deleteImage('{{ $image }}')" style=" background-color:azure">X</button>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                    <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" 
                                    id="profile_photo" type="file" name="incident_photos[]" accept="image/*" multiple>
                                        @error('incident_photo')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Dynamic fields for injured persons -->
                        <div id="injuredPersons">
                            <h5>Particulars of Injured Person</h5>
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>IC</th>
                                        <th>Nationality</th>
                                        <th>Company</th>
                                        <th>Trades</th>
                                        <th>Total Lost Days</th>
                                        <th>Incident Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($incident->injuredPeople as $injuredPerson)
                                    <tr class="injuredPerson">
                                        <td><input type="text" name="injured_persons[injured_name][]" class="p-2 border rounded-md w-full" value="{{$injuredPerson->injured_name}}"></td>
                                        <td><input type="text" name="injured_persons[injured_ic][]" class="p-2 border rounded-md w-full" value="{{$injuredPerson->injured_ic}}"></td>
                                        <td><input type="text" name="injured_persons[nationality][]" class="p-2 border rounded-md w-full" value="{{$injuredPerson->injured_nationality}}"></td>
                                        <td><input type="text" name="injured_persons[company][]" class="p-2 border rounded-md w-full" value="{{$injuredPerson->injured_company}}"></td>
                                        <td><input type="text" name="injured_persons[trades][]" class="p-2 border rounded-md w-full" value="{{$injuredPerson->injured_trades}}"></td>
                                        <td><input type="text" name="injured_persons[total_lost_days][]" class="p-2 border rounded-md w-full" value="{{$injuredPerson->total_lost_days}}"></td>
                                        <td><input type="text" name="injured_persons[incident_type][]" class="p-2 border rounded-md w-full" value="{{$injuredPerson->incident_type}}"></td>
                                        <td class="center text-center align-middle">
                                            <button type="button" onclick="deleteRow(this)">
                                                <img src="{{ asset('images/icons/removeIcon.png') }}" width = "30px" height="30px">
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr class="injuredPerson">
                                        <td><input type="text" name="injured_persons[injured_name][]" class="p-2 border rounded-md w-full"></td>
                                        <td><input type="text" name="injured_persons[injured_ic][]" class="p-2 border rounded-md w-full"></td>
                                        <td><input type="text" name="injured_persons[nationality][]" class="p-2 border rounded-md w-full"></td>
                                        <td><input type="text" name="injured_persons[company][]" class="p-2 border rounded-md w-full"></td>
                                        <td><input type="text" name="injured_persons[trades][]" class="p-2 border rounded-md w-full"></td>
                                        <td><input type="text" name="injured_persons[total_lost_days][]" class="p-2 border rounded-md w-full"></td>
                                        <td><input type="text" name="injured_persons[incident_type][]" class="p-2 border rounded-md w-full"></td>
                                        <td class="center text-center align-middle">
                                            <button type="button" onclick="deleteRow(this)">
                                                <img src="{{ asset('images/icons/removeIcon.png') }}" width = "30px" height="30px">
                                            </button>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="flex justify-center mt-4">
                                <button type="button" onclick="addInjuredPerson()">
                                    <img src="{{ asset('images/icons/addNewIcon.png') }}" width="30px" height="30px">
                                </button>
                            </div>
                        </div>

                        <!-- Dynamic fields for witnesses -->
                        <div id="witnesses">
                            <h5>Particulars of Witness</h5>
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Company</th>
                                        <th>Remark</th>
                                        <th class="px-0 py-0 w-0">Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($incident->witnessDetails as $witnessDetail)
                                        <tr class="witness">
                                            <td><input type="text" name="witnesses[witness_name][]" class="p-2 border rounded-md w-full" value="{{$witnessDetail->witness_name}}"></td>
                                            <td><input type="text" name="witnesses[witness_company][]" class="p-2 border rounded-md w-full" value="{{$witnessDetail->witness_company}}"></td>
                                            <td><input type="text" name="witnesses[remarks][]" class="p-2 border rounded-md w-full" value="{{$witnessDetail->remarks}}"></td>
                                            <td class="center text-center align-middle">
                                                <button type="button" onclick="deleteWitnessRow(this)" class="p-2 m-0">
                                                    <img src="{{ asset('images/icons/removeIcon.png') }}" width = "30px" height="30px">
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="witness">
                                            <td><input type="text" name="witnesses[witness_name][]" class="p-2 border rounded-md w-full"></td>
                                            <td><input type="text" name="witnesses[witness_company][]" class="p-2 border rounded-md w-full"></td>
                                            <td><input type="text" name="witnesses[remarks][]" class="p-2 border rounded-md w-full"></td>
                                            <td class="center text-center align-middle">
                                                <button type="button" onclick="deleteWitnessRow(this)" class="p-2 m-0">
                                                    <img src="{{ asset('images/icons/removeIcon.png') }}" width = "30px" height="30px">
                                                </button>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                
                            </table>
                            <div class="flex justify-center mt-4">
                                <button type="button" onclick="addWitness()">
                                    <img src="{{ asset('images/icons/addNewIcon.png') }}" width="30px" height="30px">
                                </button>
                            </div>
                        </div>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">Notes</td>
                            <td class="px-6 py-4">
                                <textarea name="notes" rows="4" class="p-2 border rounded-md w-full">{{ old('notes', $incident->notes) }}</textarea>
                                @error('notes')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr> 
                        <tr>
                            <td class="px-6 py-4"></td>
                            <td class="px-6 py-4">
                                <button type="button" onclick="showSubmitConfirmation(this.form)" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
                                    Submit
                                </button>
                                
                                
                                
                                <button onclick="event.preventDefault(); location.href='{{ route('user-incident-list') }}';
" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
                                    Cancel
                                </button>
                                {{-- <button type="button" onclick="showDeleteConfirmation(document.getElementById('deleteForm{{ $incident->reportNo }}'))" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Delete</button> --}}
                                
                            </td>
                        </tr>

                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- Submit Confirmation Modal -->
<div id="submitConfirmationModal" class="modal w-9">
    <div class="modal-content " style="width: 25%;">
        <span class="close" onclick="closeSubmitModal()">&times;</span>
        <h4 style="text-align: center">Are you sure you want to submit these details?</h4>
        <div style="display: flex; justify-content:center; gap:40px; margin-top:10px">
            <button onclick="confirmSubmission()" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Yes, Submit</button>
            <button onclick="closeSubmitModal()" class="bg-red-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Cancel</button>
        </div>
    </div>
</div>
{{-- <!-- Cancel Confirmation Modal -->
<div id="cancelConfirmationModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeSubmitModal()">&times;</span>
        <h4>Are you sure you want to submit these details?</h4>
        <div style="display: flex; justify-content:center; gap:5px;">
            <button onclick="confirmSubmission()" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Yes, Submit</button>
            <button onclick="closeSubmitModal()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Cancel</button>
        </div>
    </div>
</div> --}}
    <script>
        let submitForm;

        function showSubmitConfirmation(form) {
            submitForm = form; // Store the form reference
            document.getElementById('submitConfirmationModal').style.display = 'block';
        }

        function closeSubmitModal() {
            document.getElementById('submitConfirmationModal').style.display = 'none';
        }

        function confirmSubmission() {
            submitForm.submit(); // Submit the stored form
        }


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

            function deleteImage(imagePath) {
            if(confirm('You will never recover this even if you cancel! Are you sure you want to delete this image?')) {
                fetch('{{ route('user-delete-image1') }}', {
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
    </script>
@endsection

