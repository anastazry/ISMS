@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white border rounded shadow p-4">
                <div class="border-b p-2">
                    <!-- Header content goes here -->
                    Add HIRARC
                </div>
                <form method="post" action="{{ route('user-edit-titlepage-details', ['tpage_id' => $titlePage->tpage_id]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
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
                                <!-- Display form input using old() helper -->
                                <input type="date" name="insp_date" value="{{ old('insp_date', $titlePage->insp_date) }}" class="p-2 border rounded-md w-full"/>
                                @error('insp_date')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                                </td>
                                {{-- 'hirarcItems.' .  --}}
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
                                        <input type="date" name="verification_date" value="{{ old('verification_date', $titlePage->verification_date) }}" class="p-2 border rounded-md w-full">
                                        @error('verification_date')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                        <h3 style="text-align:left">Name and Signature</h3>
                                        <input type="text" name="verified_by" value="{{ old('verified_by', $titlePage->verified_by) }}" class="p-2 border rounded-md w-full">
                                        @error('verified_by')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                        <img src="{{$titlePage->ver_signature_image}}" alt="">
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
                                        <input type="date" name="approval_date" value="{{ old('approval_date', $titlePage->approval_date) }}" class="p-2 border rounded-md w-full">
                                        @error('approval_date')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                        <h3 style="text-align:left">Name and Signature</h3>
                                        <input type="text" name="approved_by" value="{{ old('approved_by', $titlePage->approved_by) }}" class="p-2 border rounded-md w-full">
                                        @error('approved_by')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                        <img src="{{$titlePage->appr_signature_img}}" alt="">
                                        {{-- @if($hirarcReport->hirarc_id)
                                        <input type="hidden" name="hirarc_id" value="{{$hirarcReport->hirarc_id}}">
                                        @endif --}}
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