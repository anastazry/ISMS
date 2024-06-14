@extends('layouts.app')

@section('content')
<style>
    .status-box {
    display: inline-block;
    width: 100px;
    height: 50px;
    border: 1px solid #ccc;
    background-color: #fff;
    vertical-align: center;
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
.status-box:hover{
    opacity: 0.3;
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
        .opaque-bg {
            opacity: 0.1;
        }
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
{{-- <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="p-4 md:p-5 text-center">
                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Some of the fields are empty. Are you sure you want to continue?</h3>
                <button id="continue-button" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                    Continue
                </button>
                <button data-modal-hide="popup-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                    Ok
                </button>
            </div>
        </div>
    </div>
</div> --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white border rounded shadow p-4">
                <div class="border-b p-2">
                    <!-- Header content goes here -->
                    Incident Investigation (Part A)
                </div>
                <div class="p-2">
                    <!-- Body content goes here -->
                    @if(Session::has('message'))
                        <div id="alert-border-3" class="flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800" role="alert">
                            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                            </svg>
                            <div class="ms-3 text-sm font-medium">
                                {{ Session::get('message') }}
                            </div>
                            <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"  data-dismiss-target="#alert-border-3" aria-label="Close">
                            <span class="sr-only">Dismiss</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            </button>
                        </div>
                        {{-- <div class="bg-green-500 text-white px-4 py-2 rounded">
                            <!-- Alert content goes here -->
                            {{ Session::get('message') }}
                        </div> --}}
                    @elseif(Session::has('error'))
                        <div id="alert-border-2" class="flex items-center p-4 mb-4 text-red-800 border-t-4 border-red-300 bg-red-50 dark:text-red-400 dark:bg-gray-800 dark:border-red-800" role="alert">
                            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                            </svg>
                            <div class="ms-3 text-sm font-medium">
                                {{ Session::get('error') }}
                            </div>
                            <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700"  data-dismiss-target="#alert-border-2" aria-label="Close">
                            <span class="sr-only">Dismiss</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            </button>
                        </div>
                        {{-- <div class="bg-red-500 text-white px-4 py-2 rounded">
                            <!-- Alert content goes here -->
                            {{ Session::get('error') }}
                        </div> --}}
                    @endif
                    @if(isset($crudOperation))
                    <form id="investigation-form" method="post" action="{{ route('update-investigation-form-a', ['reportNo' => $reportNo]) }}" enctype="multipart/form-data">
                    @else
                    <form  id="investigation-form" method="post" action="{{ route('submit-investigation-form-a', ['reportNo' => $reportNo]) }}" enctype="multipart/form-data">
                    @endif
                        @csrf
                        <table class="min-w-full divide-y divide-gray-200">
                            <tbody class="bg-white divide-y divide-gray-200">
                                <!-- ... existing rows ... -->
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">Report No</td>
                                    <td class="px-6 py-4">
                                        <input type="text" name="reportNo" value="{{ $reportNo }}" class="p-2 border rounded-md w-full" readonly>
                                        @error('reportNo')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap" style="vertical-align: top">Investigation Team</td>
                                    <td class="px-6 py-4">
                                        <div id="investigationTeamContainer">
                                            @if(isset($investigation->investigation_team))
                                                @foreach($investigation->investigation_team as $team)
                                                    <div class="flex items-center mb-2" style="position: relative;">
                                                    <input type="text" name="investigation_team[]" value="{{ $team }}" class="p-2 border rounded-md w-full mr-2 search-user" placeholder="Enter Group Leader's Name" autocomplete="off">
                                                    <button type="button" onclick="removeInvestigationTeam(this)">
                                                        <img src="{{ asset('images/icons/removeIcon.png') }}" width="30px" height="30px">
                                                    </button>
                                                    <div class="results"></div>
                                            </div>
                                                @endforeach
                                            @else
                                            <div class="flex items-center mb-2" style="position: relative;">
                                                <input type="text" name="investigation_team[]" value="{{ old('investigation_team.0') }}" class="p-2 border rounded-md w-full mr-2 search-user" placeholder="Enter Group Leader's Name" autocomplete="off">
                                                <button type="button" onclick="removeInvestigationTeam(this)">
                                                    <img src="{{ asset('images/icons/removeIcon.png') }}" width="30px" height="30px">
                                                </button>
                                                <div class="results"></div>
                                            </div>
                                            @endif
                                        </div>
                                        <div id="investigation-team-error">
                                            @error('investigation_team')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="flex justify-center mt-4">
                                            <button type="button" onclick="addInvestigationTeam()">
                                                <img src="{{ asset('images/icons/addNewIcon.png') }}" width="30px" height="30px">
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">Terms of Reference</td>
                                    <td class="px-6 py-4">
                                        @if(isset($investigation->project_site))
                                            <label for="">Site Of Incident</label>
                                            <!-- Display images for reference or preview -->
                                            <div class="mt-2 flex flex-row">
                                                @foreach($investigation->project_site as $index => $image)
                                                    <div class="image-container">
                                                        <img src="{{ asset('storage/' . $image) }}" alt="Image" class="mr-2" style="max-width: 100px; max-height: 100px;">
                                                        <span class="delete-btn" onclick="deleteImage('{{ $image }}')" >X</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <input type="file" name="project_site[]" multiple accept="image/*" class="p-2 border rounded-md w-full">
                                            @error('project_site')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        @else
                                            <label for="">Site Of Incident</label>
                                            <input type="file" name="project_site[]" multiple accept="image/*" class="p-2 border rounded-md w-full">
                                            @error('project_site')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        @endif

                                        @if(isset($investigation->hirarc_id))
                                            <label for="hirarc_copy">Copy Of Hirarc</label>
                                            <div style="position: relative;">
                                                <input type="text" id="search" name="hirarc_copy" placeholder="Search HIRARC..." style="width: 100%" value="{{$investigation->copyOfHirarc}}" autocomplete="off">
                                                <input type="hidden" name="hirarc_id" id="hirarc_id" value="{{$investigation->hirarc_id}}">
                                            </div>
                                            <div id="results"></div>
                                            {{-- <input type="file" name="hirarc_copy" accept="application/pdf" class="p-2 border rounded-md w-full"> --}}
                                            @error('hirarc_copy')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        @else
                                            <div style="position: relative; margin-top: 10px">
                                            <label for="hirarc_copy">Copy Of Hirarc</label>

                                                <input type="text" id="search" name="hirarc_copy" placeholder="Search HIRARC..." style="width: 100%" autocomplete="off">
                                                <input type="hidden" name="hirarc_id" id="hirarc_id">
                                            </div>
                                            <div id="results"></div>
                                            {{-- <input type="file" name="hirarc_copy" accept="application/pdf" class="p-2 border rounded-md w-full"> --}}
                                            @error('hirarc_copy')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        @endif

                                        @if(isset($investigation->interview_victims_or_witness))
                                        <label for="interview_victims_or_witness" class="flex items-center justify-between" style=" margin-top: 10px">
                                            Interview Victims or Witness
                                            <input type="checkbox" name="interview_victims_or_witness" id="interview_victims_or_witness" class="ml-2" @if(isset($investigation->interview_victims_or_witness) && $investigation->interview_victims_or_witness == 1) checked @endif>
                                        </label>                                        
                                        @else
                                        <label for="interview_victims_or_witness" class="flex items-center justify-between" style=" margin-top: 10px">
                                            Interview Victims or Witness
                                            <input type="checkbox" name="interview_victims_or_witness" id="interview_victims_or_witness" class="ml-2">
                                        </label>
                                        @endif
                                        
                                        
                                        @error('interview_victims_or_witness')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror


                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">Category Of Incident</td>
                                    <td class="px-6 py-4">
                                        @if(isset($investigation->incident_category))
                                            <select name="incident_category" class="p-2 border rounded-md w-full">
                                                <option value="">-- Select Category --</option>
                                                <option value="Serious Bodily Harm" {{ (isset($investigation->incident_category) && $investigation->incident_category == 'Serious Bodily Harm') ? 'selected' : '' }}>Serious Bodily Harm</option>
                                                <option value="Poisoning" {{ (isset($investigation->incident_category) && $investigation->incident_category == 'Poisoning') ? 'selected' : '' }}>Poisoning</option>
                                                <option value="Fatal" {{ (isset($investigation->incident_category) && $investigation->incident_category == 'Fatal') ? 'selected' : '' }}>Fatal</option>
                                                <option value="Dangerous Occurence" {{ (isset($investigation->incident_category) && $investigation->incident_category == 'Dangerous Occurence') ? 'selected' : '' }}>Dangerous Occurence</option>
                                            </select>
                                        @else
                                            <select name="incident_category" class="p-2 border rounded-md w-full">
                                                <option value="">-- Select Category --</option>
                                                <option value="Serious Bodily Harm" {{ old('incident_category') == 'Serious Bodily Harm' ? 'selected' : '' }}>Serious Bodily Harm</option>
                                                <option value="Poisoning" {{ old('incident_category') == 'Poisoning' ? 'selected' : '' }}>Poisoning</option>
                                                <option value="Fatal" {{ old('incident_category') == 'Fatal' ? 'selected' : '' }}>Fatal</option>
                                                <option value="Dangerous Occurence" {{ old('incident_category') == 'Dangerous Occurence' ? 'selected' : '' }}>Dangerous Occurence</option>
                                            </select>
                                        @endif
                                        @error('incident_category')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">When and Where did the incident occur?</td>
                                    <td class="px-6 py-4">
                                        <input type="text" name="incidentWhenAndWhere" value="{{ old('incidentWhenAndWhere', $incidentWhenAndWhere ?? '') }}" class="p-2 border rounded-md w-full">
                                        @error('incidentWhenAndWhere')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">Incident Description</td>
                                    <td class="px-6 py-4">
                                    @if(isset($investigation->incident_desc))
                                        <input type="text" name="incident_desc" value="{{$investigation->incident_desc }}" class="p-2 border rounded-md w-full">
                                        @error('incident_time')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    @else
                                        <input type="text" name="incident_desc" value="{{ old('incident_desc', $incident->incident_desc ?? '') }}" class="p-2 border rounded-md w-full">
                                        @error('incident_time')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">Description Property Damage</td>
                                    <td class="px-6 py-4">
                                        @if(isset($investigation->property_damage))
                                            <input type="text" name="property_damage" value="{{ old('property_damage', $investigation->property_damage) }}" class="p-2 border rounded-md w-full">
                                            @error('property_damage')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        @else
                                            <input type="text" name="property_damage" value="{{ old('property_damage') }}" class="p-2 border rounded-md w-full">
                                            @error('property_damage')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        @endif
                                    </td>
                                </tr>
                                <!-- ... similar for other rows ... -->
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">How and Why incident occur?</td>
                                    <td class="px-6 py-4">
                                        <label for="">Drawing (if applicable)</label>
                                        @if(isset($investigation->incident_drawing))
                                            <div class="mt-2 flex flex-row">
                                                @foreach($investigation->incident_drawing as $index => $image)
                                                    <div class="image-container">
                                                        <img src="{{ asset('storage/' . $image) }}" alt="Image" class="mr-2" style="max-width: 100px; max-height: 100px;">
                                                        <span class="delete-btn" onclick="deleteImage('{{ $image }}')" >X</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <input type="file" name="incident_drawing[]" multiple accept="image/*" class="p-2 border rounded-md w-full">
                                            @error('incident_drawing')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        @else
                                            <input type="file" name="incident_drawing[]" multiple accept="image/*" class="p-2 border rounded-md w-full">
                                            @error('incident_drawing')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        @endif
                                        <label for="">Explanation</label>
                                        @if(isset($investigation->incident_explanation))
                                            <textarea name="incident_explanation" rows="4" class="p-2 border rounded-md w-full">{{ $investigation->incident_explanation }}</textarea>
                                            @error('incident_explanation')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        @else
                                            <textarea name="incident_explanation" rows="4" class="p-2 border rounded-md w-full">{{ old('incident_explanation') }}</textarea>
                                            @error('incident_explanation')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        @endif
                                    </td>
                                </tr>                    
        
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">Findings</td>
                                    <td class="px-6 py-4">
                                        @if(isset($investigation->investigation_findings))
                                        <textarea name="investigation_findings" rows="4" class="p-2 border rounded-md w-full">{{ $investigation->investigation_findings }}</textarea>
                                        @error('investigation_findings')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                        @else
                                            <textarea name="investigation_findings" rows="4" class="p-2 border rounded-md w-full">{{ old('investigation_findings') }}</textarea>
                                            @error('investigation_findings')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        @endif
                                    </td>
                                </tr> 
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">Status</td>
                                    <td id="status-cell" class="center-content" style="text-align: center">
                                        @if(isset($investigation->status))
                                        <label class="status-box" id="ongoingLabel" style="background-color: {{ $investigation->status == 'Ongoing' ? 'green' : 'transparent' }}" >
                                            <input type="radio" name="status" value="Ongoing" {{ $investigation->status == 'Ongoing' ? 'checked' : '' }} onchange="updateLabelBackground(this)">
                                            Ongoing
                                        </label>
                                        <label class="status-box" id="finishedLabel" style="background-color: {{ $investigation->status == 'Finished' ? 'green' : 'transparent' }}">
                                            <input type="radio" name="status" value="Finished" {{ $investigation->status == 'Finished' ? 'checked' : '' }} onchange="updateLabelBackground(this)">
                                            Finished
                                        </label>
                                        @error('status')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                        @else
                                            <label class="status-box" >
                                                <input type="radio" name="status" value="Ongoing" {{ old('status') == 'Ongoing' ? 'checked' : '' }} onchange="updateLabelBackground(this)">
                                                Ongoing
                                            </label>
                                            <label class="status-box">
                                                <input type="radio" name="status" value="Finished" {{ old('status') == 'Finished' ? 'checked' : '' }} onchange="updateLabelBackground(this)">
                                                Finished
                                            </label>
                                            @error('status')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        @endif
                                </tr>
                                @auth
                                @if(isset($investigation->investigation_team) && Auth::user()->name == $investigation->investigation_team[0])
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">Team Leader Signature:</td>
                                            <td>
                                                @if(isset($investigation->submitted_by))
                                                    <div id="signatureImage" class="flex flex-col items-center justify-center">
                                                        <h6 id="newSignatureTrigger" class="self-end cursor-pointer text-right" style="color: red">Remove Signature?</h6>
                                                        <img src="{{$investigation->submitted_by}}" alt="" class="max-w-full h-auto" style="outline: auto">
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
                                                    
                                                @else
                                                    <div>
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
                                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50" onclick="return checkIfInputIsEmpty()">
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
    <div id="popup-modal" tabindex="-1" class="hidden fixed inset-0 z-50 flex justify-center items-center bg-black bg-opacity-50">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Some of the fields are empty. Are you sure you want to continue?</h3>
                    <button id="continue-button" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Continue
                    </button>
                    <button data-modal-hide="popup-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        Nevermind
                    </button>
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
        const maximumInvestigationTeam = 5;
        function addInvestigationTeam() {
            var investigationInputs = document.querySelectorAll('input[name="investigation_team[]"]');
            var errorContainer = document.getElementById('investigation-team-error');

            if (investigationInputs.length == 5) {
                // Clear any existing error message
                errorContainer.innerHTML = '<span class="text-red-500">You cannot add more than 5 team members.</span>';
                return;
            }

            // Clear any existing error message if the condition is not met
            errorContainer.innerHTML = '';
            const container = document.getElementById('investigationTeamContainer');
            const newInput = document.createElement('div');
            newInput.classList.add('flex', 'items-center', 'mb-2');
            newInput.innerHTML = `
                <input type="text" name="investigation_team[]" class="p-2 border rounded-md w-full mr-2" placeholder="">
                <button type="button" onclick="removeInvestigationTeam(this)">
                    <img src="{{ asset('images/icons/removeIcon.png') }}" width="30px" height="30px">
                </button>
                <div class="results"></div>

            `;
            container.appendChild(newInput);
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

    function checkIfInputIsEmpty() {
    var investigation_teamInput = document.querySelector('input[name="investigation_team[]"]');
    var hirarc_copyInput = document.querySelector('input[name="hirarc_copy"]');
    var incident_categoryInput = document.querySelector('input[name="incident_category"]');
    var incidentWhenAndWhereInput = document.querySelector('input[name="incidentWhenAndWhere"]');
    var incident_descInput = document.querySelector('input[name="incident_desc"]');
    var property_damageInput = document.querySelector('input[name="property_damage"]');
    var incident_explanationInput = document.querySelector('input[name="incident_explanation"]');
    var investigation_findingsInput = document.querySelector('input[name="investigation_findings"]');

    var inputs = [
        investigation_teamInput,
        hirarc_copyInput,
        incident_categoryInput,
        incidentWhenAndWhereInput,
        incident_descInput,
        property_damageInput,
        incident_explanationInput,
        investigation_findingsInput
    ];

    var isEmpty = inputs.some(function(input) {
        return !input.value.trim();
    });

    if (isEmpty) {
        document.getElementById('popup-modal').classList.remove('hidden');
        document.querySelector('.py-12').classList.add('opaque-bg');
        return false;  // Prevent form submission
    }

    return true;  // Allow form submission
}

    // Attach event listener to the buttons to close the modal
    document.querySelectorAll('[data-modal-hide="popup-modal"]').forEach(function(button) {
        button.addEventListener('click', function() {
            document.getElementById('popup-modal').classList.add('hidden');
            document.querySelector('.py-12').classList.remove('opaque-bg');
        });
    });

    // Attach event listener to the continue button to submit the form
    document.getElementById('continue-button').addEventListener('click', function() {
        document.getElementById('investigation-form').submit();
    });


        function removeInvestigationTeam(button) {
            var investigationInputs = document.querySelectorAll('input[name="investigation_team[]"]');
            var errorContainer = document.getElementById('investigation-team-error');
            // Clear any existing error message 
            errorContainer.innerHTML = '';
            if(investigationInputs.length == 1){
                return;
            }
            const container = document.getElementById('investigationTeamContainer');
            container.removeChild(button.parentNode);
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