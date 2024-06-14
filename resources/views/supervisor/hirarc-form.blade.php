@extends('layouts.app')

@section('content')
<style>
            /* Basic styling for demonstration */
            .dropdown {
            position: relative;
            display: inline-block;
            width: 100%;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            width: 100%;
            background-color: #f9f9f9;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            z-index: 1;
            min-width: 160px;
        }
        .dropdown-content a {
            padding: 10px;
            display: block;
            cursor: pointer;
        }
        .dropdown-content a:hover {
            background-color: #ddd;
        }
</style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white border rounded shadow p-4">
                <div class="border-b p-2">
                    <!-- Header content goes here -->
                    Add HIRARC
                </div>
                <form id="outerForm" method="post" action="{{ route('user-add-hazards') }}" enctype="multipart/form-data">
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
                            <div class=" text-black p-2 border-black">
                                HIRARC
                            </div>
                            <div class="absolute -right-2  h-full w-4 flex items-center justify-center">
                                <div class="border-t-6 border-b-6 border-transparent border-r-6 border-black"></div>
                            </div>
                        </div>
                        <div class="relative flex items-center border-t-6 border-b-6 border-r-6 border-black">
                            <div class="bg-green-500 text-white p-2 border-black">
                                Hazard Identification
                            </div>
                            <div class="absolute -right-2  h-full w-4 flex items-center justify-center">
                                <div class="border-t-6 border-b-6 border-transparent border-r-6 border-black"></div>
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
                
                        <div id="hazards">
                            <h5>Particulars of Hazards</h5>
                            <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th>Job Sequence</th>
                                <th>Hazard</th>
                                <th>Can cause</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="hazard">
                                <td>
                                    <input type="text" name="hazard[job_sequence][]" class="p-2 border rounded-md w-full" required autocomplete="off">
                                    @error('hazard[job_sequence][]')
                                    <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <input type="text" name="hazard[hazard][]" class="p-2 border rounded-md w-full" required 
                                               oninput="showDropdown(this)" autocomplete="off">
                                        @error('hazard[hazard][]')
                                        <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                        <div id="hazardDropdown" class="dropdown-content">
                                            <a href="#" data-value="Falling">Falling</a>
                                            <a href="#" data-value="Slipping and Tripping">Slipping and Tripping</a>
                                            <a href="#" data-value="Airborne">Airborne</a>
                                            <a href="#" data-value="Struck By">Struck By</a>
                                            <a href="#" data-value="Excessive Noise">Excessive Noise</a>
                                            <a href="#" data-value="Obstruct Material">Obstruct Material</a>
                                            <a href="#" data-value="Falling Material">Falling Material</a>
                                            <a href="#" data-value="Pinch Point">Pinch Point</a>
                                            <a href="#" data-value="Electrical">Electrical</a>
                                            <a href="#" data-value="Burns">Burns</a>
                                            <a href="#" data-value="Material Handling">Material Handling</a>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <input type="text" name="hazard[can_cause][]" class="p-2 border rounded-md w-full" required autocomplete="off">
                                    @error('hazard[can_cause][]')
                                    <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td class="center text-center align-middle">
                                    <button type="button" onclick="deleteRow(this)">
                                        <img src="{{ asset('images/icons/removeIcon.png') }}" width = "30px" height="30px">
                                    </button>
                                </td>

                            </tr>
                        </tbody>
                        </table>
                        <input type="hidden" name="hirarc_id" value="{{ $hirarc_id }}" class="p-2 border rounded-md w-full">
                        <div class="flex justify-center mt-4">
                            <button type="button" onclick="addWitness()">
                                <img src="{{ asset('images/icons/addNewIcon.png') }}" width="30px" height="30px">
                            </button>
                            </div>
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
                                <button id="outerFormSubmitBtn" type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
                                    Next
                                </button>

                                {{-- <button onclick="event.preventDefault(); location.href='{{ route('user-incident-list') }}';
                                " class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
                                    Cancel
                                </button> --}}
                                
                            </td>
                        </tr>

                    </form>

                </div>
                <div style="display: flex; justify-content: flex-end; margin-top: -40px">
                    <form id="editHirarcForm" action="{{ route('user-edit-hirarc', ['hirarc_id' => $hirarc_id]) }}" method="GET">
                    @csrf
                    @method('GET')
                    <!-- Add any other form fields if needed -->
                    <button type="submit" id="editHirarcSubmitBtn" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-50">
                        Back
                    </button>
                </form>
                </div>

            </div>
        </div>
    </div>

    <script>

function showDropdown(inputField) {
        var inputValue = inputField.value.trim().toLowerCase();
        var dropdownContent = document.getElementById("hazardDropdown");
        var dropdownItems = dropdownContent.getElementsByTagName("a");

        // Display all dropdown items if input field is empty
        if (inputValue === "") {
            for (var i = 0; i < dropdownItems.length; i++) {
                dropdownItems[i].style.display = "block";
            }
            dropdownContent.style.display = "block";
            return;
        }

        var hasMatchingItems = false;

        for (var i = 0; i < dropdownItems.length; i++) {
            var itemText = dropdownItems[i].innerText.toLowerCase();
            if (itemText.startsWith(inputValue)) {
                dropdownItems[i].style.display = "block";
                hasMatchingItems = true;
            } else {
                dropdownItems[i].style.display = "none";
            }
        }

        dropdownContent.style.display = hasMatchingItems ? "block" : "none";
    }
    function selectHazard(hazard) {
        var inputField = document.querySelector('input[name="hazard[hazard][]"]');
        inputField.value = hazard;
        document.getElementById("hazardDropdown").style.display = "none";
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
        if (!event.target.matches('.p-2.border.rounded-md.w-full')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.style.display === "block") {
                    openDropdown.style.display = "none";
                }
            }
        }
    }

    document.addEventListener('input', function(event) {
        var dropdownContent = document.getElementById('hazardDropdown');
        var inputField = document.querySelector('input[name="hazard[hazard][]"]');
        
        if (!event.target.closest('.dropdown')) {
            dropdownContent.style.display = 'none';
        }

        if (event.target.tagName === 'A' && event.target.parentElement === dropdownContent) {
            var selectedValue = event.target.innerText;
            inputField.value = selectedValue;
            dropdownContent.style.display = 'none';
        }
    });

    function enterCustomHazard() {
        var customHazard = prompt("Enter your custom hazard:");
        if (customHazard !== null) { // If user entered something
            document.querySelector('input[name="hazard[hazard][]"]').value = customHazard;
            document.getElementById("hazardDropdown").style.display = "none";
        }
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
        if (!event.target.matches('.p-2.border.rounded-md.w-full')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.style.display === "block") {
                    openDropdown.style.display = "none";
                }
            }
        }
    }

    function filterDropdown(inputField) {
        var inputValue = inputField.value.trim().toLowerCase();
        var dropdownItems = document.querySelectorAll('#hazardDropdown a');

        dropdownItems.forEach(function(item) {
            var itemValue = item.getAttribute('data-value').toLowerCase();
            if (itemValue.startsWith(inputValue)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });

        var dropdownContent = document.getElementById('hazardDropdown');
        dropdownContent.style.display = 'block';
    }

    document.addEventListener('click', function(event) {
        var dropdownContent = document.getElementById('hazardDropdown');
        var inputField = document.querySelector('input[name="hazard[hazard][]"]');
        
        if (!event.target.closest('.dropdown')) {
            dropdownContent.style.display = 'none';
        }

        if (event.target.tagName === 'A' && event.target.parentElement === dropdownContent) {
            var selectedValue = event.target.getAttribute('data-value');
            inputField.value = selectedValue;
            dropdownContent.style.display = 'none';
        }
    });

        function deleteRow(btn) {
            var injuredPeopleRows = document.querySelectorAll('#hazards .hazard');
            if (injuredPeopleRows.length > 1) {
                var row = btn.parentNode.parentNode;
                row.parentNode.removeChild(row);
                updateIndices();
            }
        }
    
        function updateIndices() {
            var injuredPeopleRows = document.querySelectorAll('#hazards .hazard');
            injuredPeopleRows.forEach((row, index) => {
                row.querySelectorAll('input').forEach(input => {
                    var name = input.name;
                    var newName = name.replace(/\[\d+\]/, '[' + index + ']'); // Update the index
                    input.name = newName;
                });
            });
        }
    
        function deleteWitnessRow(btn) {
        var witnessRows = document.querySelectorAll('#hazards .hazard');
        if (witnessRows.length > 1) {
            var row = btn.parentNode.parentNode;
            row.parentNode.removeChild(row);
            updateWitnessIndices();
        }
    }
    
        function updateWitnessIndices(tbody) {
            var witnessRows = tbody.querySelectorAll('.hazard');
            witnessRows.forEach((row, index) => {
                row.querySelectorAll('input').forEach(input => {
                    var name = input.name;
                    var newName = name.replace(/\[\d+\]/, '[' + index + ']'); // Update the index
                    input.name = newName;
                });
            });
        }
    
        function addInjuredPerson() {
            var tbody = document.querySelector('#hazards tbody');
            if (tbody) {
                var newRow = tbody.querySelector('.injuredPerson').cloneNode(true);
                newRow.querySelectorAll('input').forEach(input => input.value = '');
                tbody.appendChild(newRow);
            }
        }
    
        function addWitness() {
            var tbody = document.querySelector('#hazards tbody');
            if (tbody) {
                var newRow = tbody.querySelector('.hazard').cloneNode(true);
                newRow.querySelectorAll('input').forEach(input => input.value = '');
                tbody.appendChild(newRow);
            }
        }
    </script>
    
    
    
@endsection
