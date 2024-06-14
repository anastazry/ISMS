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
                <form method="post" action="{{ route('user-edit-hazard-details', $existingHazards[0]->hirarc_id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="flex justify-center items-center gap-2">
                        <div class="relative flex items-center border-t-6 border-b-6 border-r-6 border-black">
                            <div class=" text-black p-2 border-black rounded-l-lg">
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
                            @foreach($existingHazards as $hazard)
                            <tr class="hazard">
                                <td>
                                    <input type="text" name="hazard[job_sequence][]" value="{{ old('hazard[job_sequence][]', $hazard->job_sequence) }}" class="p-2 border rounded-md w-full" required>
                                    @error('hazard[job_sequence][]')
                                    <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td>
                                    <input type="text" name="hazard[hazard][]" value="{{ old('hazard[hazard][]', $hazard->hazard) }}" class="p-2 border rounded-md w-full" required>
                                    @error('hazard[hazard][]')
                                    <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td>
                                    <input type="text" name="hazard[can_cause][]" value="{{ old('hazard[can_cause][]', $hazard->can_cause) }}" class="p-2 border rounded-md w-full" required>
                                    @error('hazard[can_cause][]')
                                    <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                    <input type="hidden" name="hazard[hazard_id][]" value="{{ $hazard->hazard_id ?? 'dummy_value' }}" class="p-2 border rounded-md w-full" required>

                                </td>
                                <td class="center text-center align-middle">
                                    <button type="button" onclick="deleteRow(this)">
                                        <img src="{{ asset('images/icons/removeIcon.png') }}" width = "30px" height="30px">
                                    </button>
                                </td>

                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                    <input type="hidden" name="hirarc_id" value="{{ $existingHazards[0]->hirarc_id }}" class="p-2 border rounded-md w-full">
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
                                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
                                    Next
                                </button>
                                
                                {{-- <button onclick="event.preventDefault(); location.href='{{ route('user-incident-list') }}';
                        " class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
                                    Cancel
                                </button> --}}
                            </td>
                        </tr>
                    </form>
                    <div style="display: flex; justify-content: flex-end; margin-top: -40px">
                        <form id="editHirarcForm" action="{{ route('user-edit-hirarc', ['hirarc_id' => $existingHazards[0]->hirarc_id]) }}" method="GET">
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
            @if (isset($auditData))
                @foreach ($auditData as $audit)
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
                                // ddd($oldData);
                                $newData = is_array($audit->new_values) ? $audit->new_values : json_decode($audit->new_values, true);
                            ?>
                            @if (isset($audit->updated_at))
                                <div class="text-sm font-normal text-gray-500 dark:text-gray-300" style="margin-left: 15px"><span style="font-weight: bold">Time Updated:</span> {{ date('H:i:s', strtotime($audit->updated_at)) }}</div>
                            @endif
                            @if($audit->event == 'deleted')
                                @if (isset($oldData['job_sequence']))
                                <div class="text-sm font-normal text-gray-500 dark:text-gray-300" style="margin-left: 15px">
                                    <span style="font-weight: bold">Job Sequence:</span>
                                    {{ $oldData['job_sequence'] }} 
                                </div>
                                @if (isset($oldData['hazard']))
                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-300" style="margin-left: 15px">
                                        <span style="font-weight: bold">Hazard:</span>
                                        {{ $oldData['hazard'] }}
                                    </div>
                                @endif
                                @if (isset($oldData['can_cause']))
                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-300" style="margin-left: 15px">
                                        <span style="font-weight: bold">Can Cause:</span>
                                        {{ $oldData['can_cause'] }}
                                    </div>
                                @endif  
                            @endif
                            @elseif($audit->event == 'created')
                                @if (isset($newData['job_sequence']))
                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-300" style="margin-left: 15px">
                                        <span style="font-weight: bold">Job Sequence:</span>
                                        {{ $newData['job_sequence'] }}
                                    </div>
                                @endif
                                @if (isset($newData['hazard']))
                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-300" style="margin-left: 15px">
                                        <span style="font-weight: bold">Hazard:</span>
                                        {{ $newData['hazard'] }}
                                    </div>
                                @endif
                                @if (isset($newData['can_cause']))
                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-300" style="margin-left: 15px">
                                        <span style="font-weight: bold">Can Cause:</span>
                                        {{ $newData['can_cause'] }}
                                    </div>
                                @endif
                            @else
                                @if (isset($newData['job_sequence']) && isset($oldData['job_sequence']))
                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-300" style="margin-left: 15px">
                                        <span style="font-weight: bold">Job Sequence:</span>
                                        {{ $oldData['job_sequence'] }} to {{ $newData['job_sequence'] }}
                                    </div>
                                @endif

                                @if (isset($newData['hazard']) && isset($oldData['hazard']))
                                <div class="text-sm font-normal text-gray-500 dark:text-gray-300" style="margin-left: 15px">
                                    <span style="font-weight: bold">Hazard:</span>
                                    {{ $oldData['hazard'] }} to {{ $newData['hazard'] }}
                                </div>
                                @endif
                        
                                @if (isset($newData['can_cause']) && isset($oldData['can_cause']))
                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-300" style="margin-left: 15px">
                                        <span style="font-weight: bold">Can Cause:</span>
                                        {{ $oldData['can_cause'] }} to {{ $newData['can_cause'] }}
                                    </div>
                                @endif  
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
 
</div>
    <script>
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

