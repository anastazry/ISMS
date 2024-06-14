@extends('layouts.app')

@section('content')
<style>
    .bg-gray-200 {
        background-color: #d1d5db; /* Change to your desired grey color */
    }
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
                <form method="post" action="{{ route('user-edit-control-details', $hazard_data['updatedHazards'][0]->hirarc_id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                <div class="flex justify-center items-center gap-2">
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
                    <div class=" relative flex items-center border-t-6 border-b-6 border-r-6 border-black">
                        <div class=" text-black p-2 border-black">
                            Risk Assessment
                        </div>
                        <div class="absolute -right-2  h-full w-4 flex items-center justify-center">
                            <div class="border-t-6 border-b-6 border-transparent border-r-6 border-black"></div>
                        </div>
                    </div>
                    <div class=" bg-green-500 text-black p-2 rounded-r-lg">
                        Control
                    </div>
                </div>
                
                <div id="witnesses">
                    <h5>Particulars of Controls</h5>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th>Hazard</th>
                                <th>Opportunity</th>
                                <th>New Control</th>
                                <th>Responsibility</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @if($hazard_data->isNotEmpty()) --}}
                            @if(!empty($hazard_data) && !empty($hazard_data['updatedHazards']) && !empty($hazard_data['updatedHazardsControl']))
                                @foreach($hazard_data['updatedHazards'] as $index => $hazard)
                                    <tr class="witness">
                                        
                                        <td><input type="text" name="hazard_name[]" value="{{ $hazard->hazard }}" class="p-2 border rounded-md w-full h-20"></td>
                                        
                                        @if(isset($hazard_data['updatedHazardsControl'][$index]))
                                            <td><textarea name="control[opportunity][]" class="p-2 border rounded-md w-full h-20"  style="margin-top: 7px;">{{ old('control[opportunity][]', isset($hazard_data['updatedHazardsControl'][$index]) ? $hazard_data['updatedHazardsControl'][$index]->opportunity : '') }}</textarea ></textarea></td>
                                            <td><textarea name="control[new_control][]" class="p-2 border rounded-md w-full h-20"  style="margin-top: 7px;">{{ old('control[new_control][]', isset($hazard_data['updatedHazardsControl'][$index]) ? $hazard_data['updatedHazardsControl'][$index]->new_control : '') }}</textarea ></td>
                                            <td><input type="text" name="control[responsibility][]" class="border rounded-md w-full h-20 "  value="{{ old('control[responsibility][]', $hazard_data['updatedHazardsControl'][$index]->responsibility) }}" required></td>
                                            <td>
                                                <select name="control[status][]" class="p-2 border rounded-md w-full">
                                                    <option value="Reviewing" {{ old('control[status][]', isset($hazard_data['updatedHazardsControl'][$index]) && $hazard_data['updatedHazardsControl'][$index]->status == 'Reviewing' ? 'selected' : '') }}>Reviewing</option>
                                                    <option value="Ongoing" {{ old('control[status][]', isset($hazard_data['updatedHazardsControl'][$index]) && $hazard_data['updatedHazardsControl'][$index]->status == 'Ongoing' ? 'selected' : '') }}>Ongoing</option>
                                                    <option value="Finished" {{ old('control[status][]', isset($hazard_data['updatedHazardsControl'][$index]) && $hazard_data['updatedHazardsControl'][$index]->status == 'Finished' ? 'selected' : '') }}>Finished</option>
                                                </select>
                                            </td>
                                            <input type="hidden" name="control[hazard_id][]" value="{{ old('control[hazard_id][]', $hazard_data['updatedHazards'][$index]->hazard_id) }}">
                                            <input type="hidden" name="control[hirarc_id][]" value="{{ old('control[hirarc_id][]', $hazard_data['updatedHazards'][$index]->hirarc_id) }}">
                                            <input type="hidden" name="control[control_id][]" value="{{ old('control[control_id][]', $hazard_data['updatedHazardsControl'][$index]->control_id) }}">
                                            
                                        @else
                                            <td><textarea name="control[opportunity][]" class="p-2 border rounded-md w-full h-20"  style="margin-top: 7px;"></textarea ></td>
                                            <td><textarea name="control[new_control][]" class="p-2 border rounded-md w-full h-20"  style="margin-top: 7px;"></textarea ></td>
                                            <td><input type="text" name="control[responsibility][]" class="border rounded-md w-full h-20 " required></td>
                                            <td>
                                                <select name="control[status][]" class="p-2 border rounded-md w-full">
                                                    <option value="Reviewing">Reviewing</option>
                                                    <option value="Ongoing">Ongoing</option>
                                                    <option value="Finished">Finished</option>
                                                </select>
                                            </td>
                                            <input type="hidden" name="control[hazard_id][]" value="{{ old('control[hazard_id][]', $hazard_data['updatedHazards'][$index]->hazard_id) }}">
                                            <input type="hidden" name="control[hirarc_id][]" value="{{ old('control[hirarc_id][]', $hazard_data['updatedHazards'][$index]->hirarc_id) }}">
                                        @endif
                                    </tr>
                                

                            @endforeach
                            @else
                            <tr class="witness">
                                <td><input type="text" name="hazard_name[]" value="" class="p-2 border rounded-md w-full h-20"></td>
                                <td><textarea name="control[opportunity][]" class="p-2 border rounded-md w-full h-20"></textarea></td>
                                <td><textarea name="risk[new_control][]" class="p-2 border rounded-md w-full h-20"></textarea></td>
                                <td><input type="text" name="risk[responsibility][]" class="border rounded-md w-full h-20 "></td>
                            </tr>
                            @endif
                            

                        </tbody>
                    </table>
                    {{-- <div class="flex justify-center mt-4" id="buttonGroup">
                        <input type="button" class="px-4 py-2 bg-white text-black rounded-md mr-2 border border-blue-500 cursor-pointer" value="Reviewing">
                        <input type="button" class="px-4 py-2 bg-white text-black rounded-md mr-2 border border-blue-500 cursor-pointer" value="Ongoing">
                        <input type="button" class="px-4 py-2 bg-white text-black rounded-md mr-2 border border-blue-500 cursor-pointer" value="Finished">
                    </div> --}}
                    
                    
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
                                
                                {{-- <button onclick="event.preventDefault(); location.href='{{ route('user.hirarc-list') }}';
                        " class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
                                    Cancel
                                </button> --}}
                                
                            </td>
                        </tr>

                    </form>
                    <div style="display: flex; justify-content: flex-end; margin-top: -40px">
                        <form id="editHirarcForm" action="{{ route('user-backto-risk-details', ['hirarc_id' => $hazard_data['updatedHazards'][0]->hirarc_id]) }}" method="POST">
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
                            <div class="text-sm font-normal text-gray-500 dark:text-gray-300"><span style="color: blue">{{ $userName }}</span> has <span style="color: #39393A">{{ $audit->event }}</span> the Risk data!</div>
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
                                @if (isset($oldData['risk_desc']))
                                <div class="text-sm font-normal text-gray-500 dark:text-gray-300" style="margin-left: 15px">
                                    <span style="font-weight: bold">Risk:</span>
                                    {{ $oldData['risk_desc'] }} 
                                </div>
                                @if (isset($oldData['current_control']))
                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-300" style="margin-left: 15px">
                                        <span style="font-weight: bold">Current Control:</span>
                                        {{ $oldData['current_control'] }}
                                    </div>
                                @endif
                                @if (isset($oldData['likelihood']))
                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-300" style="margin-left: 15px">
                                        <span style="font-weight: bold">Likelihood:</span>
                                        {{ $oldData['likelihood'] }}
                                    </div>
                                @endif  

                                @if (isset($oldData['severity']))
                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-300" style="margin-left: 15px">
                                        <span style="font-weight: bold">Severity:</span>
                                        {{ $oldData['severity'] }}
                                    </div>
                                @endif  

                                @if (isset($oldData['score']))
                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-300" style="margin-left: 15px">
                                        <span style="font-weight: bold">Score:</span>
                                        {{ $oldData['score'] }}
                                    </div>
                                @endif  

                                @if (isset($oldData['index']))
                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-300" style="margin-left: 15px">
                                        <span style="font-weight: bold">Index:</span>
                                        {{ $oldData['index'] }}
                                    </div>
                                @endif  
                            @endif
                            @elseif($audit->event == 'created')
                                @if (isset($newData['new_control']))
                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-300" style="margin-left: 15px">
                                        <span style="font-weight: bold">New Control:</span>
                                        {{ $newData['new_control'] }}
                                    </div>
                                @endif

                                @if (isset($newData['opportunity']))
                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-300" style="margin-left: 15px">
                                        <span style="font-weight: bold">Opportunity:</span>
                                        {{ $newData['opportunity'] }}
                                    </div>
                                @endif

                                @if (isset($newData['responsibility']))
                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-300" style="margin-left: 15px">
                                        <span style="font-weight: bold">Responsibility:</span>
                                        {{ $newData['responsibility'] }}
                                    </div>
                                @endif

                                @if (isset($newData['status']))
                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-300" style="margin-left: 15px">
                                        <span style="font-weight: bold">Status:</span>
                                        {{ $newData['status'] }}
                                    </div>
                                @endif

                            @else
                                @if (isset($newData['opportunity']))
                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-300" style="margin-left: 15px">
                                        <span style="font-weight: bold">Opportunity: </span>
                                        @if(isset($oldData['opportunity']))
                                            {{ $oldData['opportunity'] }} to {{ $newData['opportunity'] }}
                                        @else
                                            {{ $newData['opportunity'] }}
                                        @endif
                                    </div>
                                @endif

                                @if (isset($newData['new_control']))
                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-300" style="margin-left: 15px">
                                        <span style="font-weight: bold">New Control:</span>
                                        @if(isset($oldData['new_control']))
                                            {{ $oldData['new_control'] }} to {{ $newData['new_control'] }}
                                        @else
                                            {{ $newData['new_control'] }}
                                        @endif
                                    </div>
                                @endif

                                @if (isset($newData['responsibility']))
                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-300" style="margin-left: 15px">
                                        <span style="font-weight: bold">Responsibility: </span>
                                        @if(isset($oldData['responsibility']))
                                            {{ $oldData['responsibility'] }} to {{ $newData['responsibility'] }}
                                        @else
                                            {{ $newData['responsibility'] }}
                                        @endif
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

    <script>
    // Get all buttons within the button group
    const buttons = document.querySelectorAll('#buttonGroup input[type="button"]');

    // Add click event listener to each button
    buttons.forEach(button => {
        button.addEventListener('click', () => {
            // Remove 'bg-gray-200' class from all buttons
            buttons.forEach(btn => btn.classList.remove('bg-gray-200'));
            
            // Add 'bg-gray-200' class to the clicked button
            button.classList.add('bg-gray-200');
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