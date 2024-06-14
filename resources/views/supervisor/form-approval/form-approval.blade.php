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



</style>
<div class="py-12">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      {{-- <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white text-gray-900">
              {{ __("You're logged in!") }}
          </div>
      </div> --}}
      <div class="bg-white border rounded shadow p-4" style="width: 100%">
        <div class="border-b p-2">
          <!-- Header content goes here -->
          HIRARC List
        </div>
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
                        {{-- <th scope="col" class="px-6 py-4">Date</th> --}}
                        <th scope="col" class="px-5 py-4">Prepared By</th>
                        <th scope="col" class="px-5 py-4">Verified</th>
                        <th scope="col" class="px-5 py-4">Approved</th>
                        <th scope="col" class="px-5 py-4">Action</th>
                        <th scope="col" class="px-5 py-4">Download</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                      $i = 0; // Declare and initialize the variable $i
                      @endphp
                      @foreach ($hirarcItems as $hirarcItem)
                      @if(isset($hirarcItem['hirarc']->hirarc_id))
                      <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600">
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                          {{ $i+1 }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                          @isset($hirarcItem['hirarc']->desc_job)
                              {{ $hirarcItem['hirarc']->desc_job }}
                          @endisset
                      </td>
                      <td class="whitespace-nowrap px-6 py-4 font-medium">
                        @isset($hirarcItem['hirarc']->inspection_date)
                            {{ \Carbon\Carbon::parse($hirarcItem['hirarc']->inspection_date)->format('d-m-Y') }}
                        @endisset
                    </td>
                    
                      {{-- <td class="whitespace-nowrap px-6 py-4 font-medium">
                        @isset($hirarcItem['hirarc']->location)
                            {{ $hirarcItem['hirarc']->location }}
                        @endisset
                      </td> --}}

                      <td class="whitespace-nowrap px-6 py-4 font-medium">
                        @isset($hirarcItem['hirarc']->prepared_by)
                            {{ $hirarcItem['hirarc']->prepared_by }}
                        @endisset
                      </td>
                      <td class="whitespace-nowrap px-6 py-4 font-medium">
                        @if(isset($hirarcItem['hirarcReport']->tpage_id))
                        @if(isset($hirarcItem['titlePage']->ver_signature_image))
                        <img src="{{ asset('images/icons/right_green.png') }}" width = "30px" height="30px">
                        @else
                        <img src="{{ asset('images/icons/wrong_red.png') }}" width = "30px" height="30px">
                        @endif
                        @else
                        <img src="{{ asset('images/icons/wrong_red.png') }}" width = "30px" height="30px">
                        @endif
                      </td>
                      <td class="whitespace-nowrap px-6 py-4 font-medium">
                        @if(isset($hirarcItem['hirarcReport']->tpage_id))
                        @if(isset($hirarcItem['titlePage']->appr_signature_img))
                        <img src="{{ asset('images/icons/right_green.png') }}" width = "30px" height="30px">
                        @else
                        <img src="{{ asset('images/icons/wrong_red.png') }}" width = "30px" height="30px">
                        @endif
                        @else
                        <img src="{{ asset('images/icons/wrong_red.png') }}" width = "30px" height="30px">
                        @endif
                      </td>
                        {{-- <td class="whitespace-nowrap px-6 py-4 font-medium">
                          {{$hirarcItem['hirarc']->}}
                        </td> --}}
                        {{-- <td class="whitespace-nowrap px-6 py-4 font-medium">
                          {{$hirarcItem['titlePage']->insp_date}}
                        </td> --}}
                        {{-- <td class="whitespace-nowrap px-6 py-4 font-medium">
                          {{$hirarcItem['hirarc']->prepared_by}}
                        </td> --}}
                        <td>
                        @php($user = Auth::user())
                          <form id="" method="post" action="">
                            @csrf
                            @if($user->role == 'Project Manager')
                            <button type="button" onclick="redirectToManagerApprove('{{ $hirarcItem['hirarc']->hirarc_id }}')" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-2xl">Approve</button>

                            @elseif($user->role == 'SHO')
                            <button type="button" onclick="redirectToManagerVerify('{{ $hirarcItem['hirarc']->hirarc_id }}')" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-2xl">Verify</button>
                            @endif
                          </form>
                          

                        </td>
                        <td>
                          <form id="" method="post" action="">
                            @csrf
                            <button type="button" onclick="redirectToReportGeneration('{{ $hirarcItem['hirarc']->hirarc_id }}')" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-2xl">Download</button>

                          </form>
                        </td>
                        @endif
                        @endforeach
                      </tr>
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
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
        $(document).ready(function() {
          $('#hirarcTable').DataTable({
              // "order": [[ 3, "asc" ]] // Sort by the fourth column (date) in ascending order initially
          });
      });
  function redirectToManagerApprove(hirarcId) {
      // Construct the URL with the hirarc_id parameter using Laravel's route() function
      var url = "{{ route('manager-approve-form', ['hirarc_id' => ':hirarcId']) }}";
      
      // Replace ':hirarcId' placeholder with the actual hirarcId value
      url = url.replace(':hirarcId', hirarcId);

      // Redirect to the constructed URL
      window.location.href = url;
  }
  function redirectToManagerVerify(hirarcId) {
    // Construct the URL with the hirarc_id parameter using Laravel's route() function
    var url = "{{ route('manager-verify-form', ['hirarc_id' => ':hirarcId']) }}";
    
    // Replace ':hirarcId' placeholder with the actual hirarcId value
    url = url.replace(':hirarcId', hirarcId);

    // Redirect to the constructed URL
    window.location.href = url;
}
  function redirectToReportGeneration(hirarcId){
        // Construct the URL with the hirarc_id parameter using Laravel's route() function
    var url = "{{ route('pdf-generate', ['hirarc_id' => ':hirarcId']) }}";
    
    // Replace ':hirarcId' placeholder with the actual hirarcId value
    url = url.replace(':hirarcId', hirarcId);

    // Redirect to the constructed URL
    window.location.href = url;
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