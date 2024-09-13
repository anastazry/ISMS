@extends('layouts.app')
<style>
    .uniform-card {
        height: auto; /* Adjust the height as needed */
        display: flex;
        flex-direction: column;
        justify-content: center; /* Center vertically */
        align-items: center; /* Center horizontally */
        overflow-y: auto;
        text-align: center; /* Center text inside elements */
    }
    @media (max-width: 768px) {
        .uniform-card {
            height: auto; /* Adjust for smaller screens */
        }
    }

    .card-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .card-container1 {
        display: grid;
        grid-template-columns: repeat(2, 2fr);
        gap: 20px;
    }

    @media (max-width: 768px) {
        .card-container {
            grid-template-columns: 1fr;
        }
    }

    /* Ensure <p> tags are centered within the card */
    .uniform-card p {
        margin: 0; /* Reset margin for paragraphs */
    }
</style>

@section('content')
<div class="py-12">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <div class="max-w-8xl mx-auto sm:px-6 lg:px-8" style="padding-left: 5%">
        <div class="card-container">
            <a href="#" class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 uniform-card">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Number of Users</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">{{$userCount}}</p>
            </a>
            <a href="#" class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 uniform-card">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Number of IO</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">{{$svCount}}</p>
            </a>
            <a href="#" class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 uniform-card">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Number of Super</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">{{$pmCount}}</p>
            </a>
            <a href="#" class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 uniform-card">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Number of Admin</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">{{$shoCount}}</p>
            </a>
        </div>
    </div>
    <div class="max-w-8xl mx-auto sm:px-6 lg:px-8" style="padding-left: 5%">
        
        <div class="card-container1" style="margin-top: 3%">
            <a href="#" class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 uniform-card">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Cases</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">{{$hirarcCount}}</p>
            </a>
            <a href="#" class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 uniform-card">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Cases Completed</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">{{$hirarcReportCount}}</p>
            </a>
            <a href="#" class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 uniform-card">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Ongoing cases</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">{{$incidentCount}}</p>
            </a>
            <a href="#" class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 uniform-card">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Incidents Investigated</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">{{$incidentInvestigationCount}}</p>
            </a>
        </div>
    </div>
</div>

@endsection
