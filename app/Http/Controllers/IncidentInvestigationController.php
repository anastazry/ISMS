<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Risks;
use App\Models\Hazard;

use App\Models\Hirarc;
use App\Models\Control;
use App\Models\Incident;
use App\Models\TitlePage;
use iio\libmergepdf\Pages;
use iio\libmergepdf\Merger;
use Illuminate\Support\Str;
use App\Models\HirarcReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\IncidentInvestigation;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use App\Models\IncidentInvestigationPartB;

class IncidentInvestigationController extends Controller
{
    public function getIncidentList(){
        $incidents = Incident::all();
        $users = User::all();
        $investigations = IncidentInvestigation::all();
        foreach ($incidents as $incident) {
            $folderName = $incident->incident_image;
    
            // Get all files in the folder
            $files = Storage::disk('public')->files($folderName);
    
            // Initialize an array to store image URLs
            $incidentImages = [];

            // Loop through files and add to the array
            foreach ($files as $file) {
                // Prepend 'storage/' to the file path to make it accessible from the web
                array_push($incidentImages, asset('storage/' . $file));
            }
            // Assign the first image and all images to the incident object
            $incident->firstImage = count($files) > 0 ? $files[0] : null;
            $incident->incidentImages = $incidentImages;
            $user = User::find($incident->user_id);
            if($user){
                $incident->user_name = $user->name;  
            }
            // Check if the incident's reportNo exists in investigations
            // Check if the incident's reportNo exists in investigations
            $investigation = $investigations->where('reportNo', $incident->reportNo)->first();


            if ($investigation) {
                $incident->investigationstatus = "set";
                
                // Check if $investigationB is not null before accessing its properties
                $investigationB = IncidentInvestigationPartB::where('investigation_a_id', $investigation->id)->first();

                if($investigationB){
                    $incident->investigationBiD = $investigationB->id;
                }
            } else {
                // Handle the case where $investigation is null
}



        }
        $breadcrumb1 = "Incident";
        $breadcrumb2 = "Incident Investigation";
        $headings = "Incident Investigation";
        return view('investigation.incident-investigation', compact('incidents', 'breadcrumb1', 'breadcrumb2', 'headings'));
    }

    public function getIncidentInvestigationReport(string $reportNo)
    {
        $incident = Incident::find($reportNo);
        $incidentWhenAndWhere = null;  // Initialize to null in case the incident is not found
    
        if ($incident) {
            $incidentDateFormatted = Carbon::parse($incident->incident_date)->format('d-m-Y');
            $incidentWhenAndWhere = "The incident occurred on {$incidentDateFormatted} at {$incident->incident_time}. It occurred at {$incident->incident_location}.";
        }
    
        $breadcrumb1 = "Incident";
        $breadcrumb2 = "Incident Investigation";
        $headings = "Incident Investigation (Part A)";
        return view('investigation.investigation-form', compact('incident', 'incidentWhenAndWhere', 'reportNo', 'breadcrumb1', 'breadcrumb2', 'headings'));
    }
    
    public function submitIncidentPartA(string $reportNo, Request $request){
        // dd($request);
        $reportNo = $request->reportNo;
        $investigationTeam = json_encode($request->investigation_team);
        $projectSiteFolderName = '';
        $incidentDrawingFolderName = '';
    
        $errors = [];
    
        // Check if team leader exists in system
        $userName = $request->investigation_team[0];
        $user = User::firstWhere('name', $userName);
        if (!$user) {
            $errors['investigation_team'] = 'Team Leader must be ISMS user!';
        }
    
        // Check if HIRARC exists in system
        if($request->hirarc_id){
            $submittedHirarc = $request->hirarc_id;
            $hirarc = Hirarc::find($submittedHirarc);
            if (!$hirarc) {
                $errors['hirarc_copy'] = 'HIRARC does not exist';
            }
        } else {
            $errors['hirarc_copy'] = 'HIRARC does not exist';
        }

        if(!$request->incident_category){
            $errors['incident_category'] = 'Incident Category cannot be empty!';
        }

        if(!$request->property_damage){
            $errors['property_damage'] = 'IProperty damage cannot be empty!';
        }

        if(!$request->investigation_findings){
            $errors['investigation_findings'] = 'Incident findings cannot be empty!';
        }

        if(!$request->status){
            $errors['status'] = 'Status cannot be empty!';
        }

    
        // If there are any errors, redirect back with errors
        if (!empty($errors)) {
            return redirect()
                ->route('incident-investigation-form', ['reportNo' => $reportNo])
                ->with('error', 'There are validation errors')
                ->withErrors($errors);
        }
    
        // Handle file uploads
        if ($request->hasFile('project_site')) {
            $folderName = 'incident-investigation/project_site/project_site_' . $reportNo . '_';
            $projectSiteFolderName = $folderName;
    
            foreach ($request->file('project_site') as $file) {
                $filename = $request->reportNo . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs($folderName, $filename, 'public');
            }
        }
    
        if ($request->hasFile('incident_drawing')) {
            $folderNameDrawing = 'incident-investigation/incident_drawing/incident_drawing' . $reportNo . '_';
            $incidentDrawingFolderName = $folderNameDrawing;
    
            foreach ($request->file('incident_drawing') as $file) {
                $filenameDrawing = $request->reportNo . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs($folderNameDrawing, $filenameDrawing, 'public');
            }
        }
    
        try {
            $investigation = new IncidentInvestigation();
            $investigation->hirarc_id = $request->hirarc_id;
            $investigation->reportNo = $request->reportNo;
            $investigation->investigation_team = json_encode($request->investigation_team);
            $investigation->incident_category = $request->incident_category;
            $investigation->incidentWhenAndWhere = $request->incidentWhenAndWhere;
            $investigation->incident_desc = $request->incident_desc;
            $investigation->property_damage = $request->property_damage;
            $investigation->investigation_findings = $request->investigation_findings;
            $investigation->status = $request->status;
            $investigation->incident_explanation = $request->incident_explanation;
            $investigation->project_site = $projectSiteFolderName;
            $investigation->incident_drawing = $incidentDrawingFolderName;
            if($request->interview_victims_or_witness){
                $investigation->interview_victims_or_witness = ($request->interview_victims_or_witness === "on") ? 1 : $request->interview_victims_or_witness;
            }
            $investigation->save();
    
            return redirect()->route('incident-investigation-list')->with('success', 'Incident investigation data saved successfully!');
        } catch (Exception $e) {
            return redirect()
                ->route('incident-investigation-form', ['reportNo' => $reportNo])
                ->with('error', 'Failed to save incident investigation data: ' . $e->getMessage())
                ->withErrors(['database' => 'An error occurred while saving the data.']);
        }
    }

    public function arrayCleaner(array $array){
        $cleanedArray = [];
        foreach(array_filter($array) as $item){
            $cleanedArray[] = $item;
        }
        return $cleanedArray;
    }
    
    public function submitIncidentPartB(string $reportNo, Request $request){
        // dd($request);
        $ncrCleaned = json_encode($this->arrayCleaner($request->ncr));
        $mitigative_actionsCleaned = json_encode($this->arrayCleaner($request->mitigative_actions));
        $cont_improveCleaned = json_encode($this->arrayCleaner($request->cont_improve));
        $penaltyCleaned = json_encode($this->arrayCleaner($request->penalty));
        // dd($cont_improveCleaned);

        $investigationB  = new IncidentInvestigationPartB();
        if($request->safety_comittee_know){
            $investigationB->safety_comittee_know = ($request->safety_comittee_know === "on") ? 1 : $request->safety_comittee_know;
        }
        if($request->pm_know){
            $investigationB->pm_know = ($request->pm_know === "on") ? 1 : $request->pm_know;
        }
        if($request->staff_know){
            $investigationB->staff_know = ($request->staff_know === "on") ? 1 : $request->staff_know;
        }
        if($request->others_know){
            $investigationB->others_know = ($request->others_know === "on") ? 1 : $request->others_know;
        }

        if ($request->approved_by_signature) {
            // Get the directory path
            $storagePathApproved = 'incident-investigation/partb/shosignature/signed_by' . $reportNo . '_';
        
            // Check if the directory exists
            if (Storage::disk('public')->exists($storagePathApproved)) {
                // Delete all files in the directory
                Storage::disk('public')->deleteDirectory($storagePathApproved);
            }
        
            // Decode the base64-encoded image data
            $base64ImageApproved = $request->approved_by_signature;
            $expectedPrefix = 'data:image/png;base64,';
            
            if (strpos($base64ImageApproved, $expectedPrefix) === 0) {
                // Remove the data URL prefix (e.g., 'data:image/png;base64,')
                $base64ImageApproved = str_replace($expectedPrefix, '', $base64ImageApproved);
                
                // Decode the base64-encoded image data
                $imageDataApproved = base64_decode($base64ImageApproved);
                
                // Generate unique file names for the images (e.g., using timestamp)
                $fileNameApproved = 'signed_by_' . time() . '.png';
                
                // Ensure that the storage directories exist, create them if not
                if (!Storage::disk('public')->exists($storagePathApproved)) {
                    Storage::disk('public')->makeDirectory($storagePathApproved);
                }
                
                // Store the image files in the specified storage paths
                Storage::disk('public')->put($storagePathApproved . '/' . $fileNameApproved, $imageDataApproved);
                
                // Get the full paths of the saved image files
                $filePathApproved = Storage::url($storagePathApproved . '/' . $fileNameApproved);
        
                $investigationB->sho_signature = $filePathApproved;
            }
        }

        $investigationB->ncr = $ncrCleaned;
        $investigationB->mitigative_actions = $mitigative_actionsCleaned;
        $investigationB->cont_improve = $cont_improveCleaned;
        $investigationB->penalty = $penaltyCleaned;
        $currUserID = Auth::id();
        $currUser = User::find($currUserID);
        if($currUser->role == "SHO"){
            $investigationB->sho_id = $currUser->id;
        }
        $investigationA = IncidentInvestigation::where('reportNo', $reportNo)->first();
        $investigationB->investigation_a_id = $investigationA->id;
        $investigationB->sho_signature_date = $request->sho_signature_date;

        $investigationB->save();

        return redirect()->route('incident-investigation-list')->with('success', "Incident investigation {$request->reportNo} data saved successfully!");


    }



    public function putEditIncidentInvestigationReport($reportNo){
        $crudOperation = 'update';
        $investigation = IncidentInvestigation::where('reportNo', $reportNo)->first();
        $investigation->investigation_team = json_decode($investigation->investigation_team);
        $incidentWhenAndWhere = $investigation->incidentWhenAndWhere;

        $projectSiteFolderName = $investigation->project_site;
        $projectSiteFolderContents = Storage::disk('public')->files($projectSiteFolderName);
        $investigation->project_site = $projectSiteFolderContents;

        $drawingFolderName = $investigation->incident_drawing;
        $drawingFolderContents = Storage::disk('public')->files($drawingFolderName);
        $investigation->incident_drawing = $drawingFolderContents;

        $hirarc = Hirarc::find($investigation->hirarc_id);
        if($hirarc){
            $investigation->copyOfHirarc = "{$hirarc->hirarc_id} {$hirarc->desc_job}";
        }
        // dd($investigation);

        // dd($investigation);
        $breadcrumb1 = "Incident";
        $breadcrumb2 = "Incident Investigation";
        $breadcrumb3 = "Incident Investigation (Part A)";
        $headings = "Incident Investigation (Part A)";
        return view('investigation.investigation-form', compact('investigation', 'incidentWhenAndWhere', 'reportNo', 'crudOperation', 'breadcrumb1', 'breadcrumb2', 'breadcrumb3', 'headings'));
    }

    public function putEditIncidentInvestigationReportB($id){
        if (!Auth::check() || Auth::user()->role !== 'SHO') {
            // If not, return with an error message or redirect
            return redirect()->back()->with('error', 'Only SHO can fill form B!.');
        }
        $crudOperation = 'update';
        // $investigation = IncidentInvestigationPartB::where('investigation_a_id', $id)->first();
        $investigation = IncidentInvestigationPartB::find($id);
        // dd();
        // $investigation->investigation_team = json_decode($investigation->investigation_team);
        // dd($investigation->investigation_team);
        $investigationA = IncidentInvestigation::find($investigation->investigation_a_id);
        $reportNo = $investigationA->reportNo;

        $incidentWhenAndWhere = $investigation->incidentWhenAndWhere;

        $projectSiteFolderName = $investigation->project_site;
        $projectSiteFolderContents = Storage::disk('public')->files($projectSiteFolderName);
        $investigation->project_site = $projectSiteFolderContents;

        $drawingFolderName = $investigation->incident_drawing;
        $drawingFolderContents = Storage::disk('public')->files($drawingFolderName);
        $investigation->incident_drawing = $drawingFolderContents;

        $hirarc = Hirarc::find($investigation->hirarc_id);
        if($hirarc){
            $investigation->copyOfHirarc = "{$hirarc->hirarc_id} {$hirarc->desc_job}";
        }
        // dd($investigation);
        $investigation->ncr = json_decode($investigation->ncr);
        $investigation->mitigative_actions = json_decode($investigation->mitigative_actions);
        $investigation->cont_improve = json_decode($investigation->cont_improve);
        $investigation->penalty = json_decode($investigation->penalty);
        $sho = User::find($investigation->sho_id);
        $sho_name = $sho->name;

        $breadcrumb1 = "Incident";
        $breadcrumb2 = "Incident Investigation";
        // $breadcrumb3 = "Incident Investigation (Part B)";
        $headings = "Incident Investigation (Part B)";

        // dd($investigation);
        return view('investigation.investigation-form-b', compact('investigation', 'incidentWhenAndWhere', 'reportNo', 'crudOperation', 'sho_name'
                    , 'breadcrumb1', 'breadcrumb2', 'headings'));
    }

    public function updateIncidentPartA($reportNo, Request $request){
        // dd($request);
        $investigation = IncidentInvestigation::where('reportNo', $reportNo)->first();
        $investigation->investigation_team = json_encode($request->investigation_team);
        $investigation->hirarc_id = $request->hirarc_id;
        $investigation->incident_category = $request->incident_category;
        $investigation->incidentWhenAndWhere = $request->incidentWhenAndWhere;
        $investigation->incident_desc = $request->incident_desc;
        $investigation->property_damage = $request->property_damage;
        $investigation->incident_explanation = $request->incident_explanation;
        $investigation->investigation_findings = $request->investigation_findings;
        $investigation->status = $request->status;

        if($request->interview_victims_or_witness){
            $investigation->interview_victims_or_witness = ($request->interview_victims_or_witness === "on") ? 1 : $request->interview_victims_or_witness;
        }

        if ($request->hasFile('project_site')) {                                //untuk project site images
            // Create a unique folder name for the incident
            $folderName = 'incident-investigation/project_site/project_site_' . $reportNo . '_';
            $projectSiteFolderName = $folderName;

            foreach ($request->file('project_site') as $file) {
                // Generate a unique file name
                //stop sini
                $filename = $request->reportNo . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
    
                // Store the file in the unique folder within the 'public' disk
                $path = $file->storeAs($folderName, $filename, 'public');
    
                // Save file reference in the database or associate with the incident
                // For example: $incident->photos()->create(['filename' => $path]);
            }
            $investigation->project_site = $projectSiteFolderName;

        }

        if ($request->hasFile('incident_drawing')) {                                //untuk incidentdrawings images
            // Create a unique folder name for the incident
            $folderNameDrawing = 'incident-investigation/incident_drawing/incident_drawing' . $reportNo . '_';
            $incidentDrawingFolderName = $folderNameDrawing;

            foreach ($request->file('incident_drawing') as $file) {
                // Generate a unique file name
                //stop sini
                $filenameDrawing = $request->reportNo . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
    
                // Store the file in the unique folder within the 'public' disk
                $path = $file->storeAs($folderNameDrawing, $filenameDrawing, 'public');
            }
            $investigation->incident_drawing = $incidentDrawingFolderName;

        }
        if ($request->approved_by_signature) {
            // Get the directory path
            $storagePathApproved = 'incident-investigation/submitted_by/submitted_by_' . $reportNo . '_';
        
            // Check if the directory exists
            if (Storage::disk('public')->exists($storagePathApproved)) {
                // Delete all files in the directory
                Storage::disk('public')->deleteDirectory($storagePathApproved);
            }
        
            // Decode the base64-encoded image data
            $base64ImageApproved = $request->approved_by_signature;
            $expectedPrefix = 'data:image/png;base64,';
            
            if (strpos($base64ImageApproved, $expectedPrefix) === 0) {
                // Remove the data URL prefix (e.g., 'data:image/png;base64,')
                $base64ImageApproved = str_replace($expectedPrefix, '', $base64ImageApproved);
                
                // Decode the base64-encoded image data
                $imageDataApproved = base64_decode($base64ImageApproved);
                
                // Generate unique file names for the images (e.g., using timestamp)
                $fileNameApproved = 'submitted_by_' . time() . '.png';
                
                // Ensure that the storage directories exist, create them if not
                if (!Storage::disk('public')->exists($storagePathApproved)) {
                    Storage::disk('public')->makeDirectory($storagePathApproved);
                }
                
                // Store the image files in the specified storage paths
                Storage::disk('public')->put($storagePathApproved . '/' . $fileNameApproved, $imageDataApproved);
                
                // Get the full paths of the saved image files
                $filePathApproved = Storage::url($storagePathApproved . '/' . $fileNameApproved);
        
                $investigation->submitted_by = $filePathApproved;
            }
        }
        



        $investigation->save();
        return redirect()->route('incident-investigation-list')->with('success', 'Incident investigation updated successfully!');

    }

    public function updateIncidentPartB($id, Request $request){
        if (!Auth::check() || Auth::user()->role !== 'SHO') {
            // If not, return with an error message or redirect
            return redirect()->back()->with('error', 'Only SHO can fill form B!.');
        }
        $ncrCleaned = json_encode($this->arrayCleaner($request->ncr));
        $mitigative_actionsCleaned = json_encode($this->arrayCleaner($request->mitigative_actions));
        $cont_improveCleaned = json_encode($this->arrayCleaner($request->cont_improve));
        $penaltyCleaned = json_encode($this->arrayCleaner($request->penalty));

        $investigationB  = IncidentInvestigationPartB::find($id);

        if($request->safety_comittee_know){
            $investigationB->safety_comittee_know = ($request->safety_comittee_know === "on") ? 1 : $request->safety_comittee_know;
        }else{
            $investigationB->safety_comittee_know = 0;
        }
        if($request->pm_know){
            $investigationB->pm_know = ($request->pm_know === "on") ? 1 : $request->pm_know;
        }else{
            $investigationB->pm_know = 0;
        }
        if($request->staff_know){
            $investigationB->staff_know = ($request->staff_know === "on") ? 1 : $request->staff_know;
        }else{
            $investigationB->staff_know = 0;
        }
        if($request->others_know){
            $investigationB->others_know = ($request->others_know === "on") ? 1 : $request->others_know;
        }else{
            $investigationB->others_know = 0;
        }

        if ($request->approved_by_signature) {
            // Get the directory path
            $storagePathApproved = 'incident-investigation/partb/shosignature/signed_by' . $request->reportNo . '_';
        
            // Check if the directory exists
            if (Storage::disk('public')->exists($storagePathApproved)) {
                // Delete all files in the directory
                Storage::disk('public')->deleteDirectory($storagePathApproved);
            }
        
            // Decode the base64-encoded image data
            $base64ImageApproved = $request->approved_by_signature;
            $expectedPrefix = 'data:image/png;base64,';
            
            if (strpos($base64ImageApproved, $expectedPrefix) === 0) {
                // Remove the data URL prefix (e.g., 'data:image/png;base64,')
                $base64ImageApproved = str_replace($expectedPrefix, '', $base64ImageApproved);
                
                // Decode the base64-encoded image data
                $imageDataApproved = base64_decode($base64ImageApproved);
                
                // Generate unique file names for the images (e.g., using timestamp)
                $fileNameApproved = 'signed_by_' . time() . '.png';
                
                // Ensure that the storage directories exist, create them if not
                if (!Storage::disk('public')->exists($storagePathApproved)) {
                    Storage::disk('public')->makeDirectory($storagePathApproved);
                }
                
                // Store the image files in the specified storage paths
                Storage::disk('public')->put($storagePathApproved . '/' . $fileNameApproved, $imageDataApproved);
                
                // Get the full paths of the saved image files
                $filePathApproved = Storage::url($storagePathApproved . '/' . $fileNameApproved);
        
                $investigationB->sho_signature = $filePathApproved;
            }
        }

        $investigationB->ncr = $ncrCleaned;
        $investigationB->mitigative_actions = $mitigative_actionsCleaned;
        $investigationB->cont_improve = $cont_improveCleaned;
        $investigationB->penalty = $penaltyCleaned;
        $investigationB->sho_id = Auth::id();
        $investigationB->sho_signature_date = Carbon::now()->toDateString();
        $currUserRole = User::find($investigationB->sho_id);

        if($currUserRole->role != "SHO"){
            $investigationB->sho_id = null;
        }

        $investigationB->save();

        return redirect()->route('incident-investigation-list')->with('success', "Incident investigation {$request->reportNo} data updated successfully!");


    }

    public function searchHirarc(Request $request)
    {
        $query = $request->input('query');
        $results = Hirarc::where('desc_job', 'LIKE', "%{$query}%")->get(); // Adjust 'name' to your searchable field
        return response()->json($results);
    }

    public function searchUser(Request $request)
    {
        $query = $request->input('query');
        $results = User::where('name', 'LIKE', "%{$query}%")
        ->where('role', '!=', 'admin')
        ->get();
        return response()->json($results);
    }

    public function deleteImage(Request $request)
    {
        $imagePath = $request->input('imagePath');

        // Validate the input
        if (!$imagePath || !Storage::disk('public')->exists($imagePath)) {
            return response()->json(['message' => 'File not found.'], 404);
        }

        // Delete the image
        Storage::disk('public')->delete($imagePath);

        // Respond with success message
        return response()->json(['message' => 'Image deleted successfully.']);
    }

    public function getIncidentInvestigationReportB($id){

        // $incident = Incident::find($reportNo);
        // $incidentWhenAndWhere = null;  // Initialize to null in case the incident is not found
    
        // if ($incident) {
        //     $incidentDateFormatted = Carbon::parse($incident->incident_date)->format('d-m-Y');
        //     $incidentWhenAndWhere = "The incident occurred on {$incidentDateFormatted} at {$incident->incident_time}. It occurred at {$incident->incident_location}.";
        // }
        if (!Auth::check() || Auth::user()->role !== 'SHO') {
            // If not, return with an error message or redirect
            return redirect()->back()->with('error', 'Only SHO can fill form B!.');
        }
        $crudOperation = 'update';
        $investigation = IncidentInvestigationPartB::find($id);
        if($investigation){
            $investigationA = IncidentInvestigation::find($investigation->investigation_a_id);
            $reportNo = $investigationA->reportNo;
            $investigation->mitigative_actions = json_decode($investigation->mitigative_actions);
            $investigation->cont_improve  = json_decode($investigation->cont_improve );
            $investigation->penalty  = json_decode($investigation->penalty );
            $investigation->ncr = json_decode($investigation->ncr);
            if($investigation->sho_id){
                $shoName = (User::find($investigation->sho_id))->name;
                $investigation->sho_name = $shoName;
            }

            return view('investigation.investigation-form-b', compact('investigation', 'crudOperation', 'reportNo'));
        }
        else{
            return view('investigation.investigation-form-b');

        }



    }
    public function getIncidentInvestigationReportBForm($reportNo){
            // Check if the authenticated user has the role "SHO"
    if (!Auth::check() || Auth::user()->role !== 'SHO') {
        // If not, return with an error message or redirect
        return redirect()->back()->with('error', 'Only SHO can fill form B!.');
    }
        $incident = Incident::find($reportNo);
        $incidentWhenAndWhere = null;  // Initialize to null in case the incident is not found
    
        if ($incident) {
            $incidentDateFormatted = Carbon::parse($incident->incident_date)->format('d-m-Y');
            $incidentWhenAndWhere = "The incident occurred on {$incidentDateFormatted} at {$incident->incident_time}. It occurred at {$incident->incident_location}.";
        }
        return view('investigation.investigation-form-b', compact('reportNo'));

    }

    public function printFullReport($reportNo)
    {
        $investigationA = IncidentInvestigation::where('reportNo', $reportNo)->first();
    
        if (!$investigationA) {
            return redirect()->back()->with('error', 'Please start filling the investigation form first!');
        }

        // dd(empty($investigationA->submitted_by));
        if (empty($investigationA->submitted_by)) {
            return redirect()->back()->with('error', 'Team Leader need to sign Form A!');
        }
    
        $hirarc_id = $investigationA->hirarc_id;
        $hirarcReport = HirarcReport::where('hirarc_id', $hirarc_id)->first();
    
        if (!$hirarcReport) {
            return redirect()->back()->with('error', 'Data Not Complete!');
        }
    
        $titlePage = TitlePage::find($hirarcReport->tpage_id);
    
        if (!isset($titlePage)) {
            return redirect()->back()->with('error', 'Data Not Complete!');
        }
    
        if (!isset($titlePage->verified_by)) {
            return redirect()->back()->with('error', 'Contact SHO to verify form!');
        }
    
        if (!isset($titlePage->approved_by)) {
            return redirect()->back()->with('error', 'Contact Project Manager to approve HIRARC form!');
        }
    
        $investigationB = IncidentInvestigationPartB::where('investigation_a_id',$investigationA->id)->first();
    
        if (!$investigationB) {
            return redirect()->back()->with('error', 'Please complete investigation form B!');
        }

        if(!$investigationB->sho_id || !$investigationB->sho_signature || !$investigationB->sho_signature_date){
            return redirect()->back()->with('error', 'SHO needs to approve Form B!');
        }

        $userRole = (User::find($investigationB->sho_id))->role;
        if($userRole != 'SHO'){
            return redirect()->back()->with('error', 'Only SHO can sign Form B!');
        }

    
        $hirarc = Hirarc::find($hirarc_id);
        $hazards = Hazard::where('hirarc_id', $hirarc_id)->get();
        $risks = Risks::where('hirarc_id', $hirarc_id)->get();
        $controls = Control::where('hirarc_id', $hirarc_id)->get();
    
        $combinedData = [];
        $counter = 0;
    
        foreach ($hazards as $hazard) {
            if ($counter < count($risks) && $counter < count($controls)) {
                $combinedData[] = [
                    'titlePage' => $titlePage,
                    'hirarc' => $hirarc,
                    'hazard' => $hazard,
                    'risk' => $risks[$counter],
                    'control' => $controls[$counter]
                ];
                $counter++;
            }
        }


        $data = array_chunk($combinedData, 3);

        $investigationA->investigation_team = json_decode($investigationA->investigation_team);
            // Generate a unique reference number
        $investigationA->referenceSiteOfIncident = 'REF-' . Carbon::now()->format('Ymd') . '-' . Str::upper(Str::random(6));
        $investigationA->referenceHIRARC = 'REF-' . Carbon::now()->format('Ymd') . '-' . Str::upper(Str::random(6));
        $investigationA->referenceHowIncidentHappen = 'REF-' . Carbon::now()->format('Ymd') . '-' . Str::upper(Str::random(6));

        $investigationB->ncr = json_decode($investigationB->ncr);
        $investigationB->mitigative_actions = json_decode($investigationB->mitigative_actions);
        $investigationB->cont_improve = json_decode($investigationB->cont_improve);
        $investigationB->penalty = json_decode($investigationB->penalty);
        $investigationB->shoName = (User::find($investigationB->sho_id))->name;
        $projectSiteFolderName = $investigationA->project_site;
        $projectSiteFolderContents = Storage::disk('public')->files($projectSiteFolderName);
        $investigationA->project_site = $projectSiteFolderContents;
        // if(!$investigationA->project_site){
        //     // return
        // }
        $projectDrawingsFolderName = $investigationA->incident_drawing;
        $projectIncidentDrawingContents = Storage::disk('public')->files($projectDrawingsFolderName);
        $investigationA->incident_drawing = $projectIncidentDrawingContents;
        // dd($investigationA->incident_drawing);

        // return view('investigation.investigation-report', compact('data', 'investigationA', 'investigationB'));

        // Render the first PDF
        $viewInvestigationA = view('investigation.investigation-report', compact('data', 'investigationA', 'investigationB'));
        $pdfInvA = PDF::loadHTML($viewInvestigationA);
        $pdfInvA->render();

        // Render the second PDF
        $referenceHIRARC = $investigationA->referenceHIRARC;
        $viewHIRARC = view('supervisor.hirarc-report', compact('data', 'referenceHIRARC'));
        $pdfHIRARC = PDF::loadHTML($viewHIRARC);
        $pdfHIRARC->setPaper('a4', 'landscape');
        $pdfHIRARC->render();

        // Merge the PDFs using libmergepdf
        $merger = new Merger;
        $merger->addRaw($pdfInvA->output());
        $merger->addRaw($pdfHIRARC->output());

        // Get the merged PDF content
        $mergedPdf = $merger->merge();

        // Return the merged PDF as a download response
        return response()->streamDownload(
            fn() => print($mergedPdf),
            'investigationreport_' . $reportNo . '.pdf',
            ['Content-Type' => 'application/pdf']
        );
        

        // return view('investigation.investigation-report', compact('data'));

        // $viewHIRARC = view('supervisor.hirarc-report', compact('data'));
    
        $pdf = PDF::loadHTML($viewHIRARC);
        $pdf->setPaper('a4', 'landscape');
        return $pdf->download('hirarcreport_' . $hirarc_id . '.pdf');

        // return view('')
    
        // return $pdf->download('hirarcreport_' . $hirarc_id . '.pdf');
    }
    

}


        // $hirarcReport = HirarcReport::where('hirarc_id', $hirarc_id)->first();
    
        // if ($hirarcReport) {
        //     $titlePage = TitlePage::find($hirarcReport->tpage_id);
        //     if(!isset($titlePage)){
        //         return redirect()->back()->with('error', 'Data Not Complete!');
        //     }elseif(isset($titlePage)){
        //         if(!isset($titlePage->verified_by)){
        //             return redirect()->back()->with('error', 'Need to verify!');
        //         }else if(!isset($titlePage->approved_by)){
        //             return redirect()->back()->with('error', 'Need approval!');
        //         }
        //     }
    //         $hirarc = Hirarc::find($hirarc_id);
    //         $hazards = Hazard::where('hirarc_id', $hirarc_id)->get(); // Use get() to retrieve all hazards
    //         $data = [];
    //         $risks = Risks::where('hirarc_id', $hirarc_id)->get();
    //         $controls = Control::where('hirarc_id', $hirarc_id)->get();
    //         // Loop through each hazard to generate corresponding risks and controls
    //         // Combine hazards, risks, and controls into a single array of data
    //         $combinedData = [];
    //         $counter = 0;

    // foreach ($hazards as $hazard) {
    //     // Ensure index is within bounds of risks and controls arrays
    //     if ($counter < count($risks) && $counter < count($controls)) {
    //         $combinedData[] = [
    //             'titlePage' => $titlePage,
    //             'hirarc' => $hirarc,
    //             'hazard' => $hazard,
    //             'risk' => $risks[$counter],
    //             'control' => $controls[$counter]
    //         ];
    //         $counter++;
    //     }
    // }

    // // Split the combined data into chunks of at most 3 items each
    // $data = array_chunk($combinedData, 3);
    // // dd($dataChunks);
    // // Pass the data chunks to the view
    //     // Pass the data chunks to the view
    //     // return view('supervisor.hirarc-report')->with('data', $data);

    //     $view = view('supervisor.hirarc-report', compact('data'));

    //     // Generate PDF using DomPDF
    //     $pdf = PDF::loadHTML($view);
    //     $pdf->setPaper('a4', 'landscape');
    //     // Stream the PDF content to the browser for download
    //     return $pdf->download('hirarcreport_' . $hirarc_id . '.pdf');
    //         // Generate PDF using DomPDF

    //     } else {
    //         // Handle case where HirarcReport is not found
    //         // Redirect or return response as needed
    //         return redirect()->back()->with('error', 'Hirarc Report not found.');
        // }
        // }