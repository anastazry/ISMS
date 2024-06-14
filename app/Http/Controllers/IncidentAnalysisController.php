<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Incident;
use Illuminate\Http\Request;
use App\Models\InjuredPerson;

class IncidentAnalysisController extends Controller
{
    public function getIncidentAnalysis(){
        return view('supervisor.incident-analysis.incident-analysis-overall');
    }

    public function getIncidentAnalysisMonthly(){
        $breadcrumb1 = "Safety Analysis Report";
        $headings = "Monthly Safety Analysis";
        return view('supervisor.incident-analysis.incident-analysis-monthly', compact('breadcrumb1', 'headings'));
    }

    // public function monthlySafetyAnalysisFor(Request $request){
    //     $month = $request->input('month');
    //     $totalManHoursWorked = 120000;  //dummy
    //     $averageWorkersPerDay = 350;    //dummy
    //     // Validate and sanitize the input month to ensure it's in a valid format (e.g., 'YYYY-MM')
    //     // For example, you can use Carbon to parse and validate the month format:
    //     try {
    //         $parsedMonth = \Carbon\Carbon::parse($month);
    //     } catch (\Exception $e) {
    //         // Handle invalid month format
    //         return response()->json(['error' => 'Invalid month format'], 400);
    //     }
    
    //     // Fetch incidents for the specified month
    //     $incidentsInTheMonth = Incident::whereYear('incident_date', $parsedMonth->year)
    //         ->whereMonth('incident_date', $parsedMonth->month)
    //         ->get();
        
    //     // dd($incidentsInTheMonth);
    //     $injuredPeople = [];
    //     $nonLostTime = [];
    //     $lostTimeCases = [];
    //     $fatalityCases = [];
    //     $nearMissCases = [];

    //     foreach ($incidentsInTheMonth as $incident) {
    //         $injuredPersons = InjuredPerson::where('incident_id', $incident->reportNo)->get();
        
    //         foreach ($injuredPersons as $injured) {
    //             // Check if the injured person has lost days greater than 0
    //             if ($injured->total_lost_days > 0) {
    //                 // Append the valid injured person to the $injuredPeople array
    //                 $injuredPeople[] = $injured;
    //                 $lostTimeCases[] = $injured;
    //             }else if($injured->total_lost_days == 0){
    //                 $nonLostTime[] = $injured;
    //             }
    //             if($injured->incident_type == "Fatality"){
    //                 $fatalityCases[] = $injured;
    //             }else if($injured->incident_type == "Near Miss"){
    //                 $nearMissCases[] = $injured;
    //             }
    //         }
    //     }
    //     //count Fatality Cases
    //     $numOfFatalityCasesCurrMonth = count($fatalityCases);
    //     //count of Lost Time Cases
    //     $numOfLostTimeCasesCurrMonth = count($lostTimeCases);
    //     //count of nonLostTime
    //     $numOfNonLostTimeCasesCurrMonth = count($nonLostTime);
    //     //total number of days lost in currMonth
    //     $totalDaysLost = 0;
    //     foreach($injuredPeople as $injuredPerson){
    //         $totalDaysLost = $totalDaysLost + $injuredPerson->total_lost_days;
    //     }
    //     // dd($totalDaysLost);
    //     //frequency rate
    //     $frequencyRateCurrMonth = ($numOfLostTimeCasesCurrMonth*100000)/$totalManHoursWorked;
    //     //severity rate
    //     $severityRate = ($totalDaysLost*100000)/$totalManHoursWorked;
    //     //count near miss
    //     $numOfNearMissCasesCurrMonth = count($nearMissCases); 
                

    // }



    public function monthlySafetyAnalysisFor(Request $request)
{
    $month = $request->input('month');
    $totalManHoursWorked = 120000;  // Dummy values (replace with actual data)
    $averageWorkersPerDay = 350;    // Dummy values (replace with actual data)

    // Validate and parse the input month to ensure it's in a valid format (e.g., 'YYYY-MM')
    try {
        $parsedMonth = Carbon::parse($month);
    } catch (\Exception $e) {
        // Handle invalid month format
        return response()->json(['error' => 'Invalid month format'], 400);
    }

    $currentYear = $parsedMonth->year;
    $currentMonth = $parsedMonth->month;

    // Initialize arrays to store aggregated safety analysis data
    $monthlySafetyAnalysis = [];

    // Loop through each month from January of the current year up to the selected month
    for ($m = 1; $m <= $currentMonth; $m++) {
        // Create a Carbon instance for the current looped month and year
        $currentDate = Carbon::create($currentYear, $m, 1);

        // Fetch incidents for the specified month
        $incidentsInTheMonth = Incident::whereYear('incident_date', $currentDate->year)
            ->whereMonth('incident_date', $currentDate->month)
            ->get();

        $injuredPeople = [];
        $nonLostTime = [];
        $lostTimeCases = [];
        $fatalityCases = [];
        $nearMissCases = [];
        $totalDaysLost = 0;
        $recordedBy = [];

        foreach ($incidentsInTheMonth as $incident) {
            $injuredPersons = InjuredPerson::where('incident_id', $incident->reportNo)->get();

            foreach ($injuredPersons as $injured) {
                $user = User::where('id', $injured->user_id)->first();
                $userName = $user->name;
                // dd($userName);
                if ($injured->total_lost_days > 0) {
                    $injuredPeople[] = $injured;
                    $lostTimeCases[] = $injured;
                    $recordedBy[] = $userName;


                } else {
                    $nonLostTime[] = $injured;
                    $recordedBy[] = $userName;

                    // $recordedBy[] = $userName;
                }
                if ($injured->incident_type == "Fatality") {
                    $fatalityCases[] = $injured;
                    $recordedBy[] = $userName;
                } elseif ($injured->incident_type == "Near Miss") {
                    $nearMissCases[] = $injured;
                    $recordedBy[] = $userName;

                }
            }

        }


        // Calculate total days lost for the current month
        foreach ($injuredPeople as $injuredPerson) {
            $totalDaysLost += $injuredPerson->total_lost_days;
        }
        // dd(count($recordedBy));
        // Calculate safety metrics for the current month
        // dd($fatalityCases);

        $numOfFatalityCasesCurrMonth = count($fatalityCases);

        $numOfLostTimeCasesCurrMonth = count($lostTimeCases);
        $numOfNonLostTimeCasesCurrMonth = count($nonLostTime);
        $frequencyRateCurrMonth = ($numOfLostTimeCasesCurrMonth * 100000) / $totalManHoursWorked;
        $severityRateCurrMonth = ($totalDaysLost * 100000) / $totalManHoursWorked;
        $numOfNearMissCasesCurrMonth = count($nearMissCases);
        $frequencyRateCurrMonth = number_format($frequencyRateCurrMonth, 2);

        // Format severity rate to 2 decimal places
        $severityRateCurrMonth = number_format($severityRateCurrMonth, 2);

        // Store safety analysis data for the current month in the result array
        $monthlySafetyAnalysis[] = [
            'month' => $currentDate->format('Y-m'),
            'numOfFatalityCases' => $numOfFatalityCasesCurrMonth,
            'numOfLostTimeCases' => $numOfLostTimeCasesCurrMonth,
            'numOfNonLostTimeCases' => $numOfNonLostTimeCasesCurrMonth,
            'totalDaysLost' => $totalDaysLost,
            'frequencyRate' => $frequencyRateCurrMonth,
            'severityRate' => $severityRateCurrMonth,
            'numOfNearMissCases' => $numOfNearMissCasesCurrMonth,
            'totalManHoursWorked' => $totalManHoursWorked,
            'averageWorkersPerDay' => $averageWorkersPerDay,
        ];
    }
    // dd($recordedBy);

    for($i = 0 ; $i < (count($monthlySafetyAnalysis)) ; $i++){
        $monthlySafetyAnalysis[0]['numOfFatalityCases'] = $monthlySafetyAnalysis[0]['numOfFatalityCases'] + $monthlySafetyAnalysis[$i]['numOfFatalityCases'];
        $monthlySafetyAnalysis[0]['numOfLostTimeCases'] = $monthlySafetyAnalysis[0]['numOfLostTimeCases'] + $monthlySafetyAnalysis[$i]['numOfLostTimeCases'];
        $monthlySafetyAnalysis[0]['numOfNonLostTimeCases'] = $monthlySafetyAnalysis[0]['numOfNonLostTimeCases'] + $monthlySafetyAnalysis[$i]['numOfNonLostTimeCases'];
        $monthlySafetyAnalysis[0]['numOfNearMissCases'] = $monthlySafetyAnalysis[0]['numOfNearMissCases'] + $monthlySafetyAnalysis[$i]['numOfNearMissCases'];
        $monthlySafetyAnalysis[0]['totalDaysLost'] = $monthlySafetyAnalysis[0]['totalDaysLost'] + $monthlySafetyAnalysis[$i]['totalDaysLost'];
    }

    $monthlySafetyAnalysis[0]['frequencyRate'] = ($monthlySafetyAnalysis[0]['numOfLostTimeCases'] *100000) / $totalManHoursWorked;
    $monthlySafetyAnalysis[0]['severityRate'] = ($monthlySafetyAnalysis[0]['totalDaysLost'] *100000) / $totalManHoursWorked;
    $monthlySafetyAnalysis[0]['frequencyRate'] = number_format($monthlySafetyAnalysis[0]['frequencyRate'], 2);

    // Format severity rate to 2 decimal places
    $monthlySafetyAnalysis[0]['severityRate'] = number_format($monthlySafetyAnalysis[0]['severityRate'], 2);
    $monthlySafetyAnalysis[1] = $monthlySafetyAnalysis[count($monthlySafetyAnalysis) - 2];
    $monthlySafetyAnalysis[2] = $monthlySafetyAnalysis[count($monthlySafetyAnalysis) - 1];
    $monthlySafetyAnalysis = array_slice($monthlySafetyAnalysis, 0, 3);
    // dd($monthlySafetyAnalysis);

    // dd($recordedCounts);
    // Pass the truncated array to the view
    $recordedCounts = array_count_values($recordedBy);

    $breadcrumb1 = "Monthly Analysis";
    $headings = "Monthly Safety Analysis";
    return view('supervisor.incident-analysis.incident-analysis-monthly')
    ->with('monthlySafetyAnalysis', $monthlySafetyAnalysis)
    ->with('recordedCounts', $recordedCounts)
    ->with('breadcrumb1', $breadcrumb1)
    ->with('headings', $headings);




    // Return the aggregated safety analysis data for the selected months
    return response()->json(['monthlySafetyAnalysis' => $monthlySafetyAnalysis]);
}

}
