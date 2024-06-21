<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Hirarc;
use App\Models\Incident;
use App\Models\HirarcReport;
use Illuminate\Http\Request;
use App\Events\MessageCreated;
use App\Events\NewHirarcAdded;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\IncidentInvestigation;

class UserController extends Controller
{
    public function getUsersLists(){
        $users = User::all();
        $breadcrumb1 = "Manage Users";
        $headings = "Manage Users";
        return view('admin.users-list', compact('users','breadcrumb1', 'headings'));
    }

    public function getUsersRegistrationForm(){
        $breadcrumb1 = "Manage User";
        $breadcrumb2 = "Register New User";
        $headings = "Register New User";
        return view('admin.users-registration-form', compact('breadcrumb1', 'breadcrumb2', 'headings'));
    }

    public function checkFirstTimeStatus()
    {
        // MessageCreated::dispatch('camammzzzzzz');
        // $hirarc = Hirarc::find(83); // Assuming you have a Hirarc instance to pass to the event
        // event(new NewHirarcAdded($hirarc));
        $user = Auth::user();

        if ($user->first_time_status == 1) {
            return redirect('/update-to-new-password');
        }

        if($user->role == "Admin"){
            $hirarc = Hirarc::all();
            $hirarcCount = $hirarc->count();
            $hirarcReports = HirarcReport::all();
            $hirarcReportCount = 0;
            foreach($hirarcReports as $hirarcReport) {
                if ($hirarcReport->tpage_id !== null) {
                    $hirarcReportCount++;
                }
            }
            $incidents = Incident::all();
            $incidentCount = $incidents->count();
            $incidentInvestigation = IncidentInvestigation::all();
            $incidentInvestigationCount = $incidentInvestigation->count();

            $users = User::where('role', '!=', 'Admin')->get();
            $userCount = $users->count();
            $svCount = 0;
            $pmCount = 0;
            $shoCount = 0;

            foreach($users as $user){
                if($user->role == 'Supervisor'){
                    $svCount++;
                }elseif($user->role == "Project Manager"){
                    $pmCount++;
                }elseif($user->role == "SHO"){
                    $shoCount++;
                }
            }
            $headings = "Admin Dashboard";
            return view('admin.dashboard-admin', compact('hirarcCount', 'hirarcReportCount' , 'incidentCount' , 'incidentInvestigationCount', 'userCount',
                            'svCount', 'pmCount', 'shoCount' , 'headings'));
        }else{
            $hirarc = Hirarc::whereYear('inspection_date', 2023)->get();
            $hirarcCount = $hirarc->count();
    
            $incidents = Incident::whereYear('incident_date', 2023)->get();
            $incidentsCount = $incidents->count();

            // dd($hirarcCount);
            $hirarcCountsByMonth = Hirarc::whereYear('inspection_date', 2024)
                                 ->selectRaw('MONTH(inspection_date) as month, COUNT(*) as count')
                                 ->groupBy('month')
                                 ->orderBy('month')
                                 ->get();
    
            $incidentsCountsByMonth = Incident::whereYear('incident_date', 2023)
            ->selectRaw('MONTH(incident_date) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    
            $hirarcCounts = []; // Initialize an empty array to hold counts for each month
            $incidentCounts = []; // Initialize an empty array to hold counts for each month
    
            // Initialize counts for each month with 0
            for ($i = 0; $i < 12; $i++) {
                $hirarcCounts[$i] = 0; // Initialize count for each month number (1 to 12) with 0
            }
    
            // Initialize counts for each month with 0
            for ($i = 0; $i < 12; $i++) {
                $incidentCounts[$i] = 0; // Initialize count for each month number (1 to 12) with 0
            }
            
            // Populate hirarcCounts array with counts from database query
            foreach ($hirarcCountsByMonth as $item) {
                $monthNumber = $item->month -1; // Get the month number from the query result
                $hirarcCounts[$monthNumber] = $item->count; // Set the count for the corresponding month number
            }
    
            // Populate hirarcCounts array with counts from database query
            foreach ($incidentsCountsByMonth as $itemz) {
                $monthNumberz = $itemz->month -1; // Get the month number from the query result
                $incidentCounts[$monthNumberz] = $itemz->count; // Set the count for the corresponding month number
            }
            
            // dd($incidentCounts);
            // Output the populated hirarcCounts array
            // dd($hirarcCounts);
    
            // Create an array containing counts
            $counts = [
                'hirarcCount' => $hirarcCount,
                'incidentsCount' => $incidentsCount,
                'hirarcCountsByMonth' => $hirarcCounts,
                'incidentsCountsByMonth' => $incidentCounts
            ];
            // dd($counts);
    
            $breadcrumb1 = "Dashboard";
            $headings = "Dashboard";
            // $breadcrumb2 = "Dashboard";
            // $breadcrumb1 = "Dashboard";
            return view('dashboard', compact('counts', 'breadcrumb1', 'headings'));
        }


    }

    public function dashboardWithYear(Request $request){
        $user = Auth::user();

        if ($user->first_time_status == 1) {
            return redirect('/update-to-new-password');
        }

        $year = $request->input('selectedYear');
        $hirarc = Hirarc::whereYear('inspection_date', $year)->get();
        $hirarcCount = $hirarc->count();

        $incidents = Incident::whereYear('incident_date', $year)->get();
        $incidentsCount = $incidents->count();

        $hirarcCountsByMonth = Hirarc::whereYear('inspection_date', $year)
                             ->selectRaw('MONTH(inspection_date) as month, COUNT(*) as count')
                             ->groupBy('month')
                             ->orderBy('month')
                             ->get();

        $incidentsCountsByMonth = Incident::whereYear('incident_date', $year)
        ->selectRaw('MONTH(incident_date) as month, COUNT(*) as count')
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        $hirarcCounts = []; // Initialize an empty array to hold counts for each month
        $incidentCounts = []; // Initialize an empty array to hold counts for each month

        // Initialize counts for each month with 0
        for ($i = 0; $i < 12; $i++) {
            $hirarcCounts[$i] = 0; // Initialize count for each month number (1 to 12) with 0
        }

        // Initialize counts for each month with 0
        for ($i = 0; $i < 12; $i++) {
            $incidentCounts[$i] = 0; // Initialize count for each month number (1 to 12) with 0
        }
        
        // Populate hirarcCounts array with counts from database query
        foreach ($hirarcCountsByMonth as $item) {
            $monthNumber = $item->month -1; // Get the month number from the query result
            $hirarcCounts[$monthNumber] = $item->count; // Set the count for the corresponding month number
        }

        // Populate hirarcCounts array with counts from database query
        foreach ($incidentsCountsByMonth as $itemz) {
            $monthNumberz = $itemz->month -1; // Get the month number from the query result
            $incidentCounts[$monthNumberz] = $itemz->count; // Set the count for the corresponding month number
        }
        
        // dd($incidentCounts);
        // Output the populated hirarcCounts array
        // dd($hirarcCounts);

        // Create an array containing counts
        $counts = [
            'hirarcCount' => $hirarcCount,
            'incidentsCount' => $incidentsCount,
            'hirarcCountsByMonth' => $hirarcCounts,
            'incidentsCountsByMonth' => $incidentCounts,
            'year' => $year
        ];
        // dd($counts);
        $breadcrumb1 = "Dashboard";
        $headings = "Dashboard";

        return view('dashboard', compact('counts', 'breadcrumb1', 'headings'));
    }

    public function updateFirstTimePassword (){
        return view('first-time-user');
    }
    public function resetFirstTimePassword(Request $request)
    {
        // Validate the input
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Get the authenticated user
        $userId = Auth::id(); // Get the authenticated user's ID
         $user = User::find($userId); // Retrieve the user model instance

        if ($user) {
            $user->password = Hash::make($request->password);
            $user->first_time_status = 0;
            $user->save();

            // Redirect or return response
        }

        // Redirect the user or show a success message
        return redirect()->route('dashboard')->with('success', 'Password updated successfully.');
    }



}
