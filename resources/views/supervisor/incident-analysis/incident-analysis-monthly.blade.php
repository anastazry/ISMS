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

  .flex {
    display: flex;
  }

  #secondDiv {
    margin-left: 20px; /* Adjust the margin as needed */
  }
  @media screen and (min-width: 600px) and (max-width: 1200px) {

#contents {
    width: 87%; /* Adjust width for smaller screens */
    margin-left: 13%; /* Reset margin-left for smaller screens */
    /* padding-left: 30%; Consider adjusting padding for smaller screens if needed */
    /* background-color: #000; */
}
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

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

        <div class="space-y-4">
          <form action="{{ route('user-incident-analysis-for-') }}" method="GET">
            @csrf 
            <div>
              <label for="from-date" class="block text-sm font-medium text-gray-700">Month</label>
              <input type="month" id="from-date" name="month" value="{{ old('month') }}" class="p-2 border rounded-md w-full" required>
              @error('incident_date_from')
                <span class="text-red-500 text-xs">{{ $message }}</span>
              @enderror
              <div class="text-center">
                <input type="submit" name="" id="" class="text-center bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md" style="margin-top: 1rem">
              </div>
            </div>
          </form>
        </div>

        <div class="flex">
          <div id="firstDiv" class="flex flex-col">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8 w-full">
              <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                  <!-- Content of the first div -->
                  <table class="min-w-full text-left text-sm font-light">
                    <thead class="border-b font-medium dark:border-neutral-500">
                      <tr>
                        <th scope="col" class="px-6 py-4">Description</th>
                        <th scope="col" class="px-6 py-4">Current Month</th>
                        <th scope="col" class="px-6 py-4">Previous Month</th>
                        <th scope="col" class="px-6 py-4">Year to Date</th>
                      </tr>
                    </thead>
                      <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600">
                        <td class="whitespace-nowrap px-6 py-4 font-medium">Fatality</td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                          @if(isset($monthlySafetyAnalysis[2]["numOfFatalityCases"]))
                            {{$monthlySafetyAnalysis[2]["numOfFatalityCases"]}}
                          @else
                            NIL
                          @endif
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                          @if(isset($monthlySafetyAnalysis[1]["numOfFatalityCases"]))
                            {{$monthlySafetyAnalysis[1]["numOfFatalityCases"]}}
                          @else
                            NIL
                          @endif
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                          @if(isset($monthlySafetyAnalysis[0]["numOfFatalityCases"]))
                            {{$monthlySafetyAnalysis[0]["numOfFatalityCases"]}}
                          @else
                            NIL
                          @endif
                        </td>
                      </tr>
                      <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600">
                        <td class="whitespace-nowrap px-6 py-4 font-medium">Lost Time Accident</td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                          @if(isset($monthlySafetyAnalysis[2]["numOfLostTimeCases"]))
                            {{$monthlySafetyAnalysis[2]["numOfLostTimeCases"]}}
                          @else
                            NIL
                          @endif
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                          @if(isset($monthlySafetyAnalysis[1]["numOfLostTimeCases"]))
                            {{$monthlySafetyAnalysis[1]["numOfLostTimeCases"]}}
                          @else
                            NIL
                          @endif
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                          @if(isset($monthlySafetyAnalysis[0]["numOfLostTimeCases"]))
                            {{$monthlySafetyAnalysis[0]["numOfLostTimeCases"]}}
                          @else
                            NIL
                          @endif
                        </td>
                      </tr>
                      <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600">
                        <td class="whitespace-nowrap px-6 py-4 font-medium">Non-Lost Time Accident</td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                          @if(isset($monthlySafetyAnalysis[2]["numOfNonLostTimeCases"]))
                            {{$monthlySafetyAnalysis[2]["numOfNonLostTimeCases"]}}
                          @else
                            NIL
                          @endif
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                          @if(isset($monthlySafetyAnalysis[1]["numOfNonLostTimeCases"]))
                            {{$monthlySafetyAnalysis[1]["numOfNonLostTimeCases"]}}
                          @else
                            NIL
                          @endif
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                          @if(isset($monthlySafetyAnalysis[0]["numOfNonLostTimeCases"]))
                            {{$monthlySafetyAnalysis[0]["numOfNonLostTimeCases"]}}
                          @else
                            NIL
                          @endif
                        </td>
                      </tr>
                      <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600">
                        <td class="whitespace-nowrap px-6 py-4 font-medium">Total Days Lost</td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                          @if(isset($monthlySafetyAnalysis[2]["totalDaysLost"]))
                            {{$monthlySafetyAnalysis[2]["totalDaysLost"]}}
                          @else
                            NIL
                          @endif
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                          @if(isset($monthlySafetyAnalysis[1]["totalDaysLost"]))
                            {{$monthlySafetyAnalysis[1]["totalDaysLost"]}}
                          @else
                            NIL
                          @endif
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                          @if(isset($monthlySafetyAnalysis[0]["totalDaysLost"]))
                            {{$monthlySafetyAnalysis[0]["totalDaysLost"]}}
                          @else
                            NIL
                          @endif
                        </td>
                      </tr>
                      <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600">
                        <td class="whitespace-nowrap px-6 py-4 font-medium">Frequency Rate</td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                          @if(isset($monthlySafetyAnalysis[2]["frequencyRate"]))
                            {{$monthlySafetyAnalysis[2]["frequencyRate"]}}
                          @else
                            NIL
                          @endif
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                          @if(isset($monthlySafetyAnalysis[1]["frequencyRate"]))
                            {{$monthlySafetyAnalysis[1]["frequencyRate"]}}
                          @else
                            NIL
                          @endif
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                          @if(isset($monthlySafetyAnalysis[0]["frequencyRate"]))
                            {{$monthlySafetyAnalysis[0]["frequencyRate"]}}
                          @else
                            NIL
                          @endif
                        </td>
                      </tr>
                      <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600">
                        <td class="whitespace-nowrap px-6 py-4 font-medium">Severity Rate</td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                          @if(isset($monthlySafetyAnalysis[2]["severityRate"]))
                            {{$monthlySafetyAnalysis[2]["severityRate"]}}
                          @else
                            NIL
                          @endif
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                          @if(isset($monthlySafetyAnalysis[1]["severityRate"]))
                            {{$monthlySafetyAnalysis[1]["severityRate"]}}
                          @else
                            NIL
                          @endif
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                          @if(isset($monthlySafetyAnalysis[0]["severityRate"]))
                            {{$monthlySafetyAnalysis[0]["severityRate"]}}
                          @else
                            NIL
                          @endif
                        </td>
                      </tr>
                      <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600">
                        <td class="whitespace-nowrap px-6 py-4 font-medium">Total Man Hours Worked</td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                          @if(isset($monthlySafetyAnalysis[2]["totalManHoursWorked"]))
                            {{$monthlySafetyAnalysis[2]["totalManHoursWorked"]}}
                          @else
                            NIL
                          @endif
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                          @if(isset($monthlySafetyAnalysis[1]["totalManHoursWorked"]))
                            {{$monthlySafetyAnalysis[1]["totalManHoursWorked"]}}
                          @else
                            NIL
                          @endif
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                          @if(isset($monthlySafetyAnalysis[0]["totalManHoursWorked"]))
                            {{$monthlySafetyAnalysis[0]["totalManHoursWorked"]}}
                          @else
                            NIL
                          @endif
                        </td>
                      </tr>
                      <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600">
                        <td class="whitespace-nowrap px-6 py-4 font-medium">Average Workers Per Day</td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                          @if(isset($monthlySafetyAnalysis[2]["averageWorkersPerDay"]))
                            {{$monthlySafetyAnalysis[2]["averageWorkersPerDay"]}}
                          @else
                            NIL
                          @endif
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                          @if(isset($monthlySafetyAnalysis[1]["averageWorkersPerDay"]))
                            {{$monthlySafetyAnalysis[1]["averageWorkersPerDay"]}}
                          @else
                            NIL
                          @endif
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                          @if(isset($monthlySafetyAnalysis[0]["averageWorkersPerDay"]))
                            {{$monthlySafetyAnalysis[0]["averageWorkersPerDay"]}}
                          @else
                            NIL
                          @endif
                        </td>
                      </tr>
                      <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600">
                        <td class="whitespace-nowrap px-6 py-4 font-medium">Near Miss</td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                          @if(isset($monthlySafetyAnalysis[2]["numOfNearMissCases"]))
                            {{$monthlySafetyAnalysis[2]["numOfNearMissCases"]}}
                          @else
                            NIL
                          @endif
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                          @if(isset($monthlySafetyAnalysis[1]["numOfNearMissCases"]))
                            {{$monthlySafetyAnalysis[1]["numOfNearMissCases"]}}
                          @else
                            NIL
                          @endif
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                          @if(isset($monthlySafetyAnalysis[0]["numOfNearMissCases"]))
                            {{$monthlySafetyAnalysis[0]["numOfNearMissCases"]}}
                          @else
                            NIL
                          @endif
                        </td>
                      </tr>
                    {{-- <tbody>
                      @foreach (['Fatality', 'Lost Time Accident', 'Non-Lost Time Accident', 'Total Days Lost', 'Total Man Hours Worked', 'Average Workers Per Day', 'Frequency Rate', 'Severity Rate', 'Near Miss'] as $index => $type)
                        <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600">
                          <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $type }}</td>
                          <td class="whitespace-nowrap px-6 py-4 font-medium">
                            @if(isset($monthlySafetyAnalysis[2]["numOf{$type}Cases"]))
                              {{$monthlySafetyAnalysis[2]["numOf{$type}Cases"]}}
                            @else
                              NIL
                            @endif
                          </td>
                          <td class="whitespace-nowrap px-6 py-4 font-medium">
                            @if(isset($monthlySafetyAnalysis[1]["numOf{$type}Cases"]))
                              {{$monthlySafetyAnalysis[1]["numOf{$type}Cases"]}}
                            @else
                              NIL
                            @endif
                          </td>
                          <td class="whitespace-nowrap px-6 py-4 font-medium">
                            @if(isset($monthlySafetyAnalysis[0]["numOf{$type}Cases"]))
                              {{$monthlySafetyAnalysis[0]["numOf{$type}Cases"]}}
                            @else
                              NIL
                            @endif
                          </td>
                        </tr>
                      @endforeach
                    </tbody> --}}
                  </table>
                </div>
              </div>
            </div>
          </div>

          @if(isset($monthlySafetyAnalysis[2]["month"]))
          <div id="secondDiv" style="width: 50%">
            <div class="grid grid-cols-1 gap-8" style="width: 120%">
              <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
                <div style="text-align: right;">
                  <!-- Use a <select> element for dropdown -->
                  <label for="selectedIncident">Type</label>
                  <select name="selectedIncident" id="selectedIncidentDropdown">
                    <!-- Define dropdown options using <option> elements -->
                    <option value=""></option>
                    <option value="Fatality">Fatality</option>
                    <option value="Lost Time">Lost Time</option>
                    <option value="Non Lost Time">Non Lost Time</option>
                    <option value="Near Miss">Near Miss</option>
                    <!-- Add more <option> elements as needed -->
                  </select>
                </div>

                <a href="#" class="uniform-card block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700" style="width: 100%">
                  <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Incidents 2024</h5>
                  <canvas id="myChart"></canvas>
                </a>

                {{-- <div style="text-align: right;">
                  <form method="get" action="{{ route('dashboard-year') }}" id="yearForm">
                    <!-- Use a <select> element for dropdown -->
                    <label for="selectedYear">Select</label>
                    <select name="selectedYear" id="selectedYearDropdown">
                      <!-- Define dropdown options using <option> elements -->
                      <option value=""></option>
                      <option value="Current Month">Current Month</option>
                      <option value="Previous Month">Previous Month</option>
                      <option value="Year to Date">Year to Date</option>
                      <!-- Add more <option> elements as needed -->
                    </select>
                  </form>
                </div> --}}

                <a href="#" class="uniform-card block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                  <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Amount Registered By</h5>
                  <canvas id="myPieChart"></canvas>
                </a>
              </div>
            </div>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

<div id="myModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Modal Header</h2>
    <p>Some text in the Modal..</p>
    <button>OK</button>
    <button>Cancel</button>
  </div>
</div>

<script>
  const modal = document.getElementById("myModal");
  const btn = document.getElementById("myBtn");
  const span = document.getElementsByClassName("close")[0];

  // btn.onclick = function() {
  //   modal.style.display = "block";
  // }

  // span.onclick = function() {
  //   modal.style.display = "none";
  // }

  // window.onclick = function(event) {
  //   if (event.target === modal) {
  //     modal.style.display = "none";
  //   }
  // }

        @isset($monthlySafetyAnalysis)
            const monthlySafetyAnalysis = @json($monthlySafetyAnalysis);
        @else
            const monthlySafetyAnalysis = null;
        @endisset

        @isset($recordedCounts)
            const recordedCounts = @json($recordedCounts);
        @else
            const recordedCounts = null;
        @endisset

        // Now you can safely use monthlySafetyAnalysis and recordedCounts
        if (monthlySafetyAnalysis) {
            console.log(monthlySafetyAnalysis);
        } else {
            console.log("monthlySafetyAnalysis is not set");
        }

        if (recordedCounts) {
            console.log(recordedCounts);
        } else {
            console.log("recordedCounts is not set");
        }
  // Initialize the chart
  const ctx = document.getElementById('myChart').getContext('2d');
  const myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Current Month', 'Previous Month', 'Year to Date'],
      datasets: [{
        label: 'Number of Cases',
        data: [], // This will be updated based on the selection
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });

  // Update the chart data based on the selected incident type
  document.getElementById('selectedIncidentDropdown').addEventListener('change', function() {
    const selectedIncident = this.value;

    let dataKey;
    switch (selectedIncident) {
      case 'Fatality':
        dataKey = 'numOfFatalityCases';
        break;
      case 'Lost Time':
        dataKey = 'numOfLostTimeCases';
        break;
      case 'Non Lost Time':
        dataKey = 'numOfNonLostTimeCases';
        break;
      case 'Near Miss':
        dataKey = 'numOfNearMissCases';
        break;
      default:
        dataKey = null;
    }

    if (dataKey) {
      const data = [
        monthlySafetyAnalysis[2][dataKey] ?? 0, // Current Month
        monthlySafetyAnalysis[1][dataKey] ?? 0, // Previous Month
        monthlySafetyAnalysis[0][dataKey] ?? 0  // Year to Date
      ];

      myChart.data.datasets[0].data = data;
      myChart.update();
    }
  });

  // Initialize the pie chart
  const pieCtx = document.getElementById('myPieChart').getContext('2d');
  const pieLabels = Object.keys(recordedCounts);
  const pieData = Object.values(recordedCounts);
  const myPieChart = new Chart(pieCtx, {
    type: 'pie',
    data: {
      labels: pieLabels,
      datasets: [{
        data: pieData,
        backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)', 'rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)'],
        borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)'],
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
    }
  });
</script>

@endsection
