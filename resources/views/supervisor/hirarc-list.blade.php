@extends('layouts.app') <!-- Extend the app.blade.php file -->
@section('content') <!-- Start the content section -->
<style>
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
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4); /* Dimmed background */
}

.modal-content {
    background-color: #f8f9fa; /* Light grey background */
    margin: 10% auto; /* Adjusted for centering */
    padding: 20px;
    border: 1px solid #dee2e6; /* Light border */
    border-radius: 8px; /* Rounded corners */
    width: 50%; /* Adjust width as needed */
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); /* Box shadow for depth */
}

.close {
    color: #6c757d; /* Dark grey color */
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

.modal h2, .modal p {
    color: #495057; /* Dark grey text */
}

#incidentImageContainer {
    margin-top: 15px;
    margin-bottom: 15px;
    text-align: center; /* Center align images */
}

.incident-img {
    max-width: 100%;
    height: auto;
    border-radius: 5px; /* Rounded corners for images */
}

.modal button {
    padding: 10px 20px;
    margin: 5px;
    border: none;
    border-radius: 5px;
    background-color: #007bff; /* Bootstrap primary color */
    color: white;
    cursor: pointer;
}

.modal button:hover {
    background-color: #0056b3; /* Darker on hover */
}
select[name="hirarcTable_length"] {
  width: 25%;
}

#hirarcTable_length{
  width: 20%;
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
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
{{-- <div style="margin-left: 14%; background-color: white" class="bg-white border rounded shadow p-4">
  <nav class="flex mb-4" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3 rtl:space-x-reverse">
      <li class="inline-flex items-center">
        <a href="#" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
          <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
          </svg>
          Dashboard
        </a>
      </li>
      <li>
        <div class="flex items-center">
          <svg class="w-3 h-3 text-gray-400 mx-1 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
          </svg>
          <a href="#" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Hirarc List</a>
        </div>
      </li> --}}
      {{-- <li aria-current="page">
        <div class="flex items-center">
          <svg class="w-3 h-3 text-gray-400 mx-1 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
          </svg>
          <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Flowbite</span>
        </div>
      </li> --}}
    {{-- </ol>
  </nav>
  <h3 class="mb-4 text-3xl font-extrabold leading-none tracking-tight text-gray-900 md:text-4xl dark:text-white">Hirarc List</h3>
</div> --}}
<div class="flex-container">
  <div class="py-12" style="padding-top: 10px" id="firstDiv">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      {{-- <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white text-gray-900">
              {{ __("You're logged in!") }}
          </div>
      </div> --}}
      <div class="bg-white border rounded shadow p-4">
        {{-- <div class="border-b p-2">
          <!-- Header content goes here -->
          HIRARC List
        </div> --}}
        <div class="p-2">
          <!-- Body content goes here -->
          @if(Session::has('message'))
            <div class="bg-green-500 text-white px-4 py-2 rounded">
              <!-- Alert content goes here -->
              {{ Session::get('message') }}
            </div>
          @elseif(Session::has('error'))
            <div class="bg-red-500 text-white px-4 py-2 rounded">
              <!-- Alert content goes here -->
              {{ Session::get('error') }}
            </div>
          @endif
          <div class="p-2"><a href="{{ route('user-add-hirarc-details')}}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Add New Report</a></div>
          
          <div class="flex flex-col">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8 w-full">
              <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                  <table id="hirarcTable" class="min-w-full text-left text-sm font-light">
                    <thead
                      class="border-b font-medium dark:border-neutral-500">
                      <tr>
                        <th scope="col" class="px-6 py-4">No.</th>
                        <th scope="col" class="px-6 py-4">Description</th>
                        <th scope="col" class="px-6 py-4">Location</th>
                        <th scope="col" class="px-6 py-4">Date</th>
                        <th scope="col" class="px-5 py-4">Prepared By</th>
                        <th scope="col" class="px-5 py-4">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                      $i = 1; // Declare and initialize the variable $i
                      @endphp
                      @foreach ($hirarcItems as $hirarcItem)
                      @if(isset($hirarcItem['hirarc']->hirarc_id))
                      <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600">
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                          {{ $i++ }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                          @isset($hirarcItem['hirarc']->desc_job)
                              {{ $hirarcItem['hirarc']->desc_job }}
                          @endisset
                      </td>
                      <td class="whitespace-nowrap px-6 py-4 font-medium">
                        @isset($hirarcItem['hirarc']->location)
                            {{ $hirarcItem['hirarc']->location }}
                        @endisset
                      </td>
                      <td class="whitespace-nowrap px-6 py-4 font-medium">
                        @isset($hirarcItem['hirarc']->inspection_date)
                            {{ $hirarcItem['hirarc']->inspection_date }}
                        @endisset
                      </td>
                      <td class="whitespace-nowrap px-6 py-4 font-medium">
                        @isset($hirarcItem['hirarc']->prepared_by)
                            {{ $hirarcItem['hirarc']->prepared_by }}
                        @endisset
                      </td>
                        <td>
                          <form id="" method="post" action="{{ route('user-delete-hirarc', $hirarcItem['hirarc']->hirarc_id)}}">
                            @csrf 
                            @method('DELETE')
                            <a href="{{ route('user-edit-hirarc', ['hirarc_id' => $hirarcItem['hirarc']->hirarc_id]) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Edit</a>
                            {{-- <button type="button" onclick="confirmDelete()" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Delete</button> --}}
                            <button type="submit" onclick="return confirmDelete()" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Delete</button>
                        </form>  
                        
                          

                        </td>
                      </tr>
                      @endif
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>

</div>
<div class="py-12" style="padding-top: 10px" id="secondDiv">
  <div style="margin-right: 15px" class="">

      <div class="bg-white border rounded shadow p-4">
          <div class="border-b p-2">
              <!-- Header content goes here -->
              <span style="font-weight: bold">Audit Trail</span>
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
<!-- Incident Modal -->
<div id="incidentModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <h2 style="font-weight: bold; font-size: 24px;">Report No: <span id="incidentID"></span></h2>
    <p>Incident Title : <span id="incidentTitle"></span></p>
    <p>Project Site: <span id="projectSite"></span></p>
    <p>Incident Location: <span id="incidentLocation"></span></p>
    <p>Date: <span id="incidentDate"></span></p>
    <p>Incident Time: <span id="incidentTime"></span></p>
    <p>Description: <span id="incidentDesc"></span></p>
    <div id="incidentImageContainer"></div>
    <div style="display: flex; justify-content: space-between; outline: 1px solid auto; padding: 10px;">
      <button onclick="previousImage()" id="imagePrev">Previous</button>
      <button onclick="nextImage()" id="imageNext">Next</button>
    </div>
    
    <p>Prepared By : <span id="preparedBy"></span></p>
    <!-- Add more elements for other incident details -->
  </div>
</div>
<!-- Delete Confirmation Modal -->
<div id="deleteConfirmationModal" class="modal w-9">
  <div class="modal-content">
    <span class="close" onclick="closeDeleteModal()">&times;</span>
    <h4 style="text-align: center">Are you sure you want to delete this incident?</h4>
    
    <div style="display: flex; justify-content:center; gap:5px;">
      <button onclick="confirmDeletion()" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Yes, Delete</button>
      <button onclick="closeDeleteModal()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Cancel</button>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
      $(document).ready(function() {
          $('#hirarcTable').DataTable({
              // "order": [[ 3, "asc" ]] // Sort by the fourth column (date) in ascending order initially
          });
      });
    function confirmDelete() {
        return confirm('Are you sure you want to delete this HIRARC?'); // Display confirmation dialog
    }
</script>
{{-- <script>
let deleteForm;

function showDeleteConfirmation(form) {
  deleteForm = form; // Store the form reference
  document.getElementById('deleteConfirmationModal').style.display = 'block';
}

function closeDeleteModal() {
  document.getElementById('deleteConfirmationModal').style.display = 'none';
}

function confirmDeletion() {
  deleteForm.submit(); // Submit the stored form
}

  let currentImageIndex = 0;
let incidentImages = [];
  function showIncidentDetails(row) {
    // Set the content of the modal
    const incident = JSON.parse(row.getAttribute('data-incident'));
    document.getElementById('incidentID').innerText = incident.reportNo;
    document.getElementById('incidentTitle').innerText = incident.incident_title;
    document.getElementById('projectSite').innerText = incident.project_site;
    document.getElementById('incidentLocation').innerText = incident.incident_location;
    document.getElementById('incidentDate').innerText = incident.incident_date;
    document.getElementById('incidentTime').innerText = incident.incident_time;
    document.getElementById('incidentDesc').innerText = incident.incident_desc;
    document.getElementById('preparedBy').innerText = incident.user_name;

  
    currentImageIndex = 0;
    incidentImages = incident.incidentImages || [];
    updateImageDisplay(row);

    // Display the modal
    document.getElementById('incidentModal').style.display = 'block';
  }
  
  function closeModal() {
    document.getElementById('incidentModal').style.display = 'none';
  }
  
  window.onclick = function(event) {
    let modal = document.getElementById('incidentModal');
    if (event.target == modal) {
      closeModal();
    }
  }

//   function updateImageDisplay(incident) {
//   const imageContainer = document.getElementById('incidentImageContainer');
//   const prevBtn = document.getElementById('imagePrev');
//   const nextBtn = document.getElementById('imageNext');
//   if (incidentImages.length > 0 && currentImageIndex < incidentImages.length && incident.incident_image) {
//     imageContainer.innerHTML = `<img src="${incidentImages[currentImageIndex]}" alt="Incident Image" class="incident-img">`;
//   } else  {
//     imageContainer.innerHTML = '<span>No Image Available</span>';
//     // Remove the prevBtn and nextBtn elements
//     if (prevBtn) {
//       prevBtn.remove();
//     }

//     if (nextBtn) {
//       nextBtn.remove();
//     }
//   }
//   // Manage the visibility of previous and next buttons
//   prevBtn.style.display = currentImageIndex > 0 ? 'block' : 'none';
//   nextBtn.style.display = currentImageIndex < incidentImages.length - 1 ? 'block' : 'none';
// }
function updateImageDisplay() {
    const imageContainer = document.getElementById('incidentImageContainer');
    const prevBtn = document.getElementById('imagePrev');
    const nextBtn = document.getElementById('imageNext');

    if (incidentImages.length > 0 && currentImageIndex < incidentImages.length) {
        imageContainer.innerHTML = `<img src="${incidentImages[currentImageIndex]}" alt="Incident Image" class="incident-img">`;
    } else {
        imageContainer.innerHTML = '<span>No Image Available</span>';
        // Hide buttons if there are no images
        if (prevBtn) prevBtn.style.display = 'none';
        if (nextBtn) nextBtn.style.display = 'none';
    }

    // Update button visibility based on the current index and image array length
    if (prevBtn && incidentImages.length > 0) prevBtn.style.display = currentImageIndex > 0 ? 'block' : 'none';
    if (nextBtn && incidentImages.length > 0) nextBtn.style.display = currentImageIndex < incidentImages.length - 1 ? 'block' : 'none';
}


function nextImage() {
  if (currentImageIndex < incidentImages.length - 1) {
    currentImageIndex++;
    updateImageDisplay();
  }
}

function previousImage() {
  if (currentImageIndex > 0) {
    currentImageIndex--;
    updateImageDisplay();
  }
}
  </script> --}}

@endsection <!-- End the content section -->