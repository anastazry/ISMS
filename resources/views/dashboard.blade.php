@extends('layouts.app')
<style>
    .uniform-card {
    height: auto; /* Adjust the height as needed */
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    overflow-y: auto;
}
@media (max-width: 768px) {
    .uniform-card {
        height: auto; /* Adjust for smaller screens */
    }
}

</style>
@section('content')
<div class="py-12">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <div class="max-w-8xl mx-auto sm:px-6 lg:px-8" style="margin-top: -5%; padding-left: 5%" >
        <div style="text-align: right; margin-top: 5%">
            <form method="get" action="{{ route('dashboard-year') }}" id="yearForm">
                <!-- Use a <select> element for dropdown -->
                <label for="selectedYear">Year</label>
                <select name="selectedYear" id="selectedYearDropdown">
                    <!-- Define dropdown options using <option> elements -->
                    <option value="2024"></option>
                    <option value="2024">2024</option>
                    <option value="2023">2023</option>
                    <option value="2022">2022</option>
                    <!-- Add more <option> elements as needed -->
                </select>
                <!-- Add a submit button within the form -->
                {{-- <button type="submit">Submit</button> --}}
            </form>
        </div>
        
        <div class="grid grid-cols-2 gap-8">
            <a href="#" class="uniform-card block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                @if(isset($counts['year']))
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Incidents ({{$counts['year']}})</h5>
                @else
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Incidents (2024)</h5>
                @endif
            
                <p class="font-normal text-gray-700 dark:text-gray-400">{{ $counts['incidentsCount'] }}</p>
                <p class="font-normal text-gray-700 dark:text-gray-400"></p>
            </a>
            <a href="#" class="uniform-card block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                @if(isset($counts['year']))
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Incidents ({{$counts['year']}})</h5>
                @else
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Incidents 2024</h5>
                @endif
                <canvas id="myChart"></canvas>
            </a>
            <a href="#" class="uniform-card block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Inspections Performed</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">{{ $counts['hirarcCount'] }}</p>
            </a>
            <a href="#" class="uniform-card block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Inspection (2024)</h5>
                <canvas id="myChart2"></canvas>
            </a>
        </div>
    </div>
    <script>
        
// Retrieve hirarcCountsByMonth data from Blade template
        const incidentsCountsByMonth = @json($counts['incidentsCountsByMonth']);

        // Extract month names and counts from hirarcCountsByMonth
        const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        // Map hirarcCountsByMonth data to match the format expected by Chart.js
        const chartData = months.map((month, index) => {
            const count = incidentsCountsByMonth[index] ?? 0; // Use count from hirarcCountsByMonth or default to 0 if undefined
            return { month: month, count: count };
        });

        // Get the canvas context
        const ctx = document.getElementById('myChart').getContext('2d');

        // Create the Chart.js chart using the dynamically generated data
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData.map(data => data.month), // Extract month names from chartData
                datasets: [{
                    label: 'Incidents Counts by Month',
                    data: chartData.map(data => data.count), // Extract counts from chartData
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
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

        const hirarcCountsByMonth = @json($counts['hirarcCountsByMonth']);
                // Map hirarcCountsByMonth data to match the format expected by Chart.js
        const chartData2 = months.map((month, index) => {
            const count = hirarcCountsByMonth[index] ?? 0; // Use count from hirarcCountsByMonth or default to 0 if undefined
            return { month: month, count: count };
        });

        const ctx2 = document.getElementById('myChart2').getContext('2d');
        const myChart2 = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: chartData2.map(data => data.month), // Extract month names from chartData
                datasets: [{
                    label: 'Hirarc Counts by Month',
                    data: chartData2.map(data => data.count), // Extract counts from chartData
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
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
            // Wait for the document to be fully loaded
    $(document).ready(function() {
        // Attach change event listener to the dropdown
        $('#selectedYearDropdown').change(function() {
            // Submit the form when an option is selected
            $('#yearForm').submit();
        });
    });
    </script>
    
</div>

@endsection
