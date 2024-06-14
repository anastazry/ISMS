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
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      {{-- <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white text-gray-900">
              {{ __("You're logged in!") }}
          </div>
      </div> --}}
      <div class="bg-white border rounded shadow p-4">
        <div class="border-b p-2">
          <!-- Header content goes here -->
        Safety Analysis
        </div>
        <div class="p-2">
          <!-- Body content goes here -->
          @if(Session::has('message'))
            <div class="bg-green-500 text-white px-4 py-2 rounded">
              <!-- Alert content goes here -->
              {{ Session::get('message') }}
            </div>
          @endif
          <div class="space-y-4">
            <div>
                <label for="from-date" class="block text-sm font-medium text-gray-700">From</label>
                <input type="date" id="from-date" name="incident_date_from" value="{{ old('incident_date_from') }}" class="p-2 border rounded-md w-full">
                @error('incident_date_from')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
        
            <div>
                <label for="to-date" class="block text-sm font-medium text-gray-700">To</label>
                <input type="date" id="to-date" name="incident_date_to" value="{{ old('incident_date_to') }}" class="p-2 border rounded-md w-full">
                @error('incident_date_to')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
        
            <div class="text-center">
                <a href="{{ route('user.hirarc-form')}}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
                    View
                </a>
            </div>
        </div>
        
          
          <div class="flex flex-col">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8 w-full">
              <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                  <table class="min-w-full text-left text-sm font-light">
                    <thead
                      class="border-b font-medium dark:border-neutral-500">
                      <tr>
                        <th scope="col" class="px-6 py-4">Description</th>
                        <th scope="col" class="px-6 py-4">Amount</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600">
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                            Fatality
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                            2
                        </td>
                      </tr>
                      <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600">
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                            Lost Time Accident
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                            2
                        </td>
                      </tr>
                      <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600">
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                            Non-Lost Time Accident
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                            3
                        </td>
                      </tr>
                      <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600">
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                            Total Days Lost
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                            20
                        </td>
                      </tr>
                      <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600">
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                            Total Man Hours Worked
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                            25
                        </td>
                      </tr>
                      <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600">
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                            Average Workers Per Day
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                            20
                        </td>
                      </tr>
                      <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600">
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                            Frequency Rate
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                            25
                        </td>
                      </tr>
                      <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600">
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                            Severity Rate
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                            25
                        </td>
                      </tr>
                      <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600">
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                            Near Miss
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                            25
                        </td>
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