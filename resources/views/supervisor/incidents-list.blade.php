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

#carouselWrapper {
    /* ... other styles ... */
    height: 60vh; /* or any other value that suits your needs */
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
      <div class="bg-white border rounded shadow p-4">

        <div class="p-2">
          <!-- Body content goes here -->
          @if(Session::has('message'))
            <div class="bg-green-500 text-white px-4 py-2 rounded">
              <!-- Alert content goes here -->
              {{ Session::get('message') }}
            </div>
          @endif
          <div class="p-2"><a href="{{ route('user-incident-form')}}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Add New Incident</a></div>
          
          <div class="flex flex-col">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8 w-full">
              <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                  <table id="hirarcTable" class="min-w-full text-left text-sm font-light">
                    <thead
                      class="border-b font-medium dark:border-neutral-500">
                      <tr>
                        <th scope="col" class="px-6 py-4">No.</th>
                        <th scope="col" class="px-6 py-4">Title</th>
                        <th scope="col" class="px-6 py-4">Time</th>
                        <th scope="col" class="px-6 py-4">Photo</th>
                        <th scope="col" class="px-6 py-4">Prepared By</th>
                        <th scope="col" class="px-5 py-4">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php($i=0)
                      @foreach($incidents as $incident)
                      <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600"
>
                        <td class="whitespace-nowrap px-6 py-4 font-medium"
                        data-incident='@json($incident)'
                        onclick="showIncidentDetails(this)"
                        >{{ ++$i }}</td>
                        <td class="whitespace-nowrap px-6 py-4"
                        data-incident='@json($incident)'
                        onclick="showIncidentDetails(this)"
                        >{{ $incident->incident_title }}</td>
                        <td class="whitespace-nowrap px-6 py-4"
                        data-incident='@json($incident)'
                        onclick="showIncidentDetails(this)"
                        >{{ $incident->incident_time }}</td>
                        <td class="whitespace-nowrap px-6 py-4"
                        data-incident='@json($incident)'
                        onclick="showIncidentDetails(this)"
                        >
                          @if ($incident->incident_image)
                              <img src="{{ asset('storage/' . $incident->firstImage) }}" alt="Incident Image" class="w-12 h-10">
                          @else
                          {{-- $incident->image ."/". --}}
                              <span></span>
                          @endif
                        </td>
                        <td class="whitespace-nowrap px-6 py-4"
                        data-incident='@json($incident)'
                        onclick="showIncidentDetails(this)"
                        >{{ $incident->user_name }}</td>
                        
                        
                        <td>
                          <form id="deleteForm{{ $incident->reportNo }}" method="post" action="{{ route('user-delete-incident', $incident->reportNo)}}">
                            @csrf
                            @method('DELETE')
                            <a href="{{ route('user-edit-incident', $incident->reportNo) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Update</a>
                            <button type="button" onclick="showDeleteConfirmation(document.getElementById('deleteForm{{ $incident->reportNo }}'))" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Delete</button>
                          </form>
                          

                        </td>
                      </tr>
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
    <div id="indicators-carousel" class="relative w-full" data-carousel="static">
      <!-- Carousel wrapper -->
      <div id="carouselWrapper" class="relative h-56 overflow-hidden rounded-lg md:h-96">
        <!-- Dynamic Images will be inserted here -->
      </div>
      <!-- Slider indicators -->
      <div class="absolute z-30 flex -translate-x-1/2 space-x-3 rtl:space-x-reverse bottom-5 left-1/2">
          <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide 1" data-carousel-slide-to="0"></button>
          <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1"></button>
          <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3" data-carousel-slide-to="2"></button>
          <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 4" data-carousel-slide-to="3"></button>
          <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 5" data-carousel-slide-to="4"></button>
      </div>
      <!-- Slider controls -->
      <button type="button" class="  bg-white bg-opacity-10 absolute top-40 start-0 z-30 flex items-center justify-center h-24 px-4 cursor-pointer focus:outline-none " onclick="previousImage()">
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full group-hover:bg-transparent group-focus:ring-0 group-focus:outline-none">
            <svg class="w-4 h-4 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
            </svg>
            <span class="sr-only">Previous</span>
        </span>
    </button>
    <button type="button" class="bg-opacity-10 absolute top-40 end-0 z-30 flex items-center justify-center h-24 px-4 cursor-pointer focus:outline-none" onclick="nextImage()">
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full group-hover:bg-transparent group-focus:ring-0 group-focus:outline-none">
          <svg class="w-4 h-4 text-black dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
        </svg>
            <span class="sr-only">Next</span>
        </span>
    </button>
    
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
      <button class="bg-green-500 hover:bg-red-600 text-white px-4 py-2 rounded" onclick="confirmDeletion()" >Delete</button>
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
    document.getElementById('preparedBy').innerText = incident.user_name;
    document.getElementById('incidentDesc').innerText = incident.incident_desc;
  
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


  function updateImageDisplay() {
  const carouselWrapper = document.getElementById('carouselWrapper');
  const indicatorsContainer = document.querySelector('.absolute.z-30.flex');
  carouselWrapper.innerHTML = ''; // Clear existing content
  indicatorsContainer.innerHTML = ''; // Clear existing indicators

  incidentImages.forEach((imageSrc, index) => {
    // Create carousel item
    const carouselItem = document.createElement('div');
    carouselItem.className = index === currentImageIndex ? 'block' : 'hidden'; // Show the current image, hide the others
    carouselItem.setAttribute('data-carousel-item', '');

    // Create img tag inside the carousel item
    // Set img tag styles for the carousel item
    const img = document.createElement('img');
    img.src = imageSrc;
    img.alt = 'Incident Image';
    img.style.height = '60vh'; // Set the height of the image
    img.style.width = '100%'; // Set the width to auto to maintain aspect ratio
    img.style.objectFit = 'contain'; // Ensure the image is scaled correctly
    img.src = imageSrc;
    img.alt = 'Incident Image';
    img.className = 'incident-img'; // Use your existing class for the image

    carouselItem.appendChild(img);
    carouselWrapper.appendChild(carouselItem);

    // Create indicator for each image
    const indicator = document.createElement('button');
    indicator.type = 'button';
    indicator.className = 'w-3 h-3 rounded-full';
    indicator.setAttribute('aria-current', index === currentImageIndex ? 'true' : 'false');
    indicator.setAttribute('aria-label', `Slide ${index + 1}`);
    indicator.setAttribute('data-carousel-slide-to', index);
    indicator.onclick = function() { setCurrentImageIndex(index); };
    indicatorsContainer.appendChild(indicator);
  });

  // Function to set the current image index and update display
  function setCurrentImageIndex(index) {
    currentImageIndex = index;
    updateImageDisplay();
  }
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

  </script>

@endsection <!-- End the content section -->

    {{-- <div id="incidentImageContainer"></div>
    <div style="display: flex; justify-content: space-between; outline: 1px solid auto; padding: 10px;">
      <button onclick="previousImage()" id="imagePrev">Previous</button>
      <button onclick="nextImage()" id="imageNext">Next</button>
    </div> --}}

    
{{-- //   function updateImageDisplay(incident) {
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
  //   nextBtn.style.display = currentImageIndex < incidentImages.length - 1 ? 'block' : 'none'; --}}