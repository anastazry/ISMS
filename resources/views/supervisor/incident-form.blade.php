@extends('layouts.app')

@section('content')
<style>
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

                <div class="p-2">
                    <!-- Body content goes here -->
                    @if(Session::has('message'))
                        <div class="bg-green-500 text-white px-4 py-2 rounded">
                            <!-- Alert content goes here -->
                            {{ Session::get('message') }}
                        </div>
                    @endif
                    <form method="post" action="{{ route('user-add-incident') }}" enctype="multipart/form-data">
                        @csrf
                        <table class="min-w-full divide-y divide-gray-200">
                            <tbody class="bg-white divide-y divide-gray-200">
                                <!-- ... existing rows ... -->
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">Report No</td>
                                    <td class="px-6 py-4">
                                        <input type="text" name="reportNo" value="{{ $randomString }}" class="p-2 border rounded-md w-full" readonly>
                                        @error('reportNo')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">Department Name</td>
                                    <td class="px-6 py-4">
                                        <input type="text" name="dept_name" value="{{ old('dept_name') }}" class="p-2 border rounded-md w-full">
                                        @error('dept_name')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">Project Site</td>
                                    <td class="px-6 py-4">
                                        <input type="text" name="project_site" value="{{ old('project_site') }}" class="p-2 border rounded-md w-full">
                                        @error('project_site')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">Title</td>
                                    <td class="px-6 py-4">
                                        <input type="text" name="incident_title" value="{{ old('incident_title') }}" class="p-2 border rounded-md w-full">
                                        @error('incident_title')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">Date of Incident</td>
                                    <td class="px-6 py-4">
                                        <input type="date" name="incident_date" value="{{ old('incident_date') }}" class="p-2 border rounded-md w-full">
                                        @error('incident_date')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">Time of Incident</td>
                                    <td class="px-6 py-4">
                                        <input type="time" name="incident_time" value="{{ old('incident_time') }}" class="p-2 border rounded-md w-full">
                                        @error('incident_time')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">Location of Incident</td>
                                    <td class="px-6 py-4">
                                        <input type="text" name="incident_location" value="{{ old('incident_location') }}" class="p-2 border rounded-md w-full">
                                        @error('incident_location')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </td>
                                </tr>
                                <!-- ... similar for other rows ... -->
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">Description</td>
                                    <td class="px-6 py-4">
                                        <textarea name="incident_desc" rows="4" class="p-2 border rounded-md w-full">{{ old('incident_desc') }}</textarea>
                                        @error('incident_desc')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </td>
                                </tr>                    
        
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">Photo (if necessary)</td>
                                    <td class="px-6 py-4">
                                        {{-- <input type="file" name="incident_photos[]" class="p-2 border rounded-md w-full" multiple> --}}

                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="user_avatar">Upload file</label>
                                        <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" 
                                        id="profile_photo" type="file" name="incident_photos[]" accept="image/*" multiple>

                                        {{-- <div class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="user_avatar_help">A profile picture is useful to confirm your are logged into your account</div> --}}
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
                                    <tr class="injuredPerson">
                                        <td><input type="text" name="injured_persons[injured_name][]" class="p-2 border rounded-md w-full"></td>
                                        <td><input type="text" name="injured_persons[injured_ic][]" class="p-2 border rounded-md w-full"></td>
                                        <td><input type="text" name="injured_persons[nationality][]" class="p-2 border rounded-md w-full"></td>
                                        <td><input type="text" name="injured_persons[company][]" class="p-2 border rounded-md w-full"></td>
                                        <td><input type="text" name="injured_persons[trades][]" class="p-2 border rounded-md w-full"></td>
                                        <td><input type="text" name="injured_persons[total_lost_days][]" class="p-2 border rounded-md w-full"></td>
                                        <td>
                                            <select name="injured_persons[incident_type][]" class="p-2 border rounded-md w-full">
                                                <option value=""></option>
                                                <option value="Fatality">Fatality</option>
                                                <option value="Lost Time">Lost Time</option>
                                                <option value="Non-Lost Time">Non-Lost Time</option>
                                                <option value="Near Miss">Near Miss</option>
                                                <option value="Injury">Injury</option>
                                                <option value="Poisoning/Disease">Poisoning/Disease</option>
                                                <!-- Add more options as needed -->
                                            </select>
                                        </td>
                                        <td class="center text-center align-middle">
                                            <button type="button" onclick="deleteRow(this)">
                                                <img src="{{ asset('images/icons/removeIcon.png') }}" width = "30px" height="30px">
                                            </button>
                                        </td>
                                    </tr>
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
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
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
                                <textarea name="notes" rows="4" class="p-2 border rounded-md w-full">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr> 
                        <tr>
                            <td class="px-6 py-4"></td>
                            <td class="px-6 py-4">
                                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
                                    Submit
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

    <script>

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