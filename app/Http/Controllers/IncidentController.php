<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Incident;
use App\Models\WitnessDetails;
use App\Models\InjuredPerson;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Mail\IncidentReported;
use App\Models\IncidentInvestigation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class IncidentController extends Controller
{
    public function getIncidentList(){
        $incidents = Incident::all();
        $users = User::all();
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
        }
        $breadcrumb1 = "Incident";
        $headings = "Incidents List";
        return view('supervisor.incidents-list', compact('incidents', 'breadcrumb1', 'headings'));
    }
    

    public function getIncidentForm(){
        // Generate a random 6-digit number
        $randomNumber = mt_rand(100000, 999999);
        // Convert the number to a string
        $randomString = (string) $randomNumber;
        $breadcrumb1 = "Incident";
        $breadcrumb2 = "Add New Incident";
        $headings = "Add New Incident";
        return view('supervisor.incident-form', compact('randomString', 'breadcrumb1', 'breadcrumb2', 'headings'));
    }

    public function postAddIncident(Request $request) {
        // Assuming you have an Incident model
        $userId = auth()->user()->id;
        $incident = new Incident();
        // Validation rules
        $this->validate($request, [
            'reportNo' => 'required|string|max:255',
            'incident_location' => 'required|string|max:255',
            'incident_title' => 'required|string|max:255',
            // 'incident_photos.*' => 'image|mimes:jpeg,jpg,png|max:10000',
            'incident_date' => 'required|date',
            'incident_time' => 'required|date_format:H:i',
            'incident_desc' => 'required|string|max:255',
            'notes' => 'required|string|max:255',
            // 'injured_persons.*.total_lost_days' => 'required|numeric',
            // Add similar rules for other attributes in injured_persons
        ]);

        
        if ($request->hasFile('incident_photos')) {
            // Create a unique folder name for the incident
            $folderName = 'incident-image/incident_' . $request->reportNo . '_';
            
            foreach ($request->file('incident_photos') as $file) {
                // Generate a unique file name
                //stop sini
                $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();
    
                // Store the file in the unique folder within the 'public' disk
                $path = $file->storeAs($folderName, $filename, 'public');
    
                // Save file reference in the database or associate with the incident
                // For example: $incident->photos()->create(['filename' => $path]);
            }
            $incident->incident_image = $folderName;
        }
    
        // Set other incident fields
        $incident->reportNo = $request['reportNo'];
        $incident->dept_name = $request['dept_name'];
        $incident->project_site = $request['project_site'];
        $incident->incident_location = $request['incident_location'];
        $incident->incident_title = $request['incident_title'];
        $incident->incident_time = $request['incident_time'];
        $incident->incident_desc = $request['incident_desc'];
        $incident->notes = $request['notes'];
        $incident->incident_date = $request['incident_date'];
        $incident->user_id = $userId;
        $incident->save();
    
        // Handle injured persons
        if ($request->has('injured_persons') && is_array($request->injured_persons['injured_name'])) {
            foreach ($request->injured_persons['injured_name'] as $index => $name) {
                if (!empty($name)) {
                $injuredPerson = new InjuredPerson(); // Assuming you have an InjuredPerson model
                $injuredPerson->incident_id = $incident->reportNo;
                $injuredPerson->user_id = $userId;
                $injuredPerson->injured_name = $name;
                $injuredPerson->injured_ic = $request->injured_persons['injured_ic'][$index] ?? null;
                $injuredPerson->injured_nationality = $request->injured_persons['nationality'][$index] ?? null;
                $injuredPerson->injured_company = $request->injured_persons['company'][$index] ?? null;
                $injuredPerson->injured_trades = $request->injured_persons['trades'][$index] ?? null;
                $injuredPerson->total_lost_days = $request->injured_persons['total_lost_days'][$index] ?? 0;
                $injuredPerson->incident_type = $request->injured_persons['incident_type'][$index] ?? null;
                $injuredPerson->save();
                }
            }
        }
            // Handle witnesses
            if ($request->has('witnesses') && is_array($request->witnesses['witness_name'])) {
                foreach($request->witnesses['witness_name'] as $index => $name){
                    if (!empty($name)) {
                    $witnessDetail = new WitnessDetails(); // Assuming you have a WitnessDetails model
                    $witnessDetail->incident_id = $incident->reportNo; // Assuming a relationship between Incident and WitnessDetails
                    $witnessDetail->user_id = $userId;
                    // Correctly access the witness details
                    $witnessDetail->witness_name = $name;
                    $witnessDetail->witness_company = $request->witnesses['witness_company'][$index] ?? null;
                    $witnessDetail->remarks = $request->witnesses['remarks'][$index] ?? null;
                    $witnessDetail->save();
                    }
                }
            }

            // Fetch users who are not 'Admin' and send them an email
        $users = User::where('role', '!=', 'Admin')->get();
        $files = Storage::disk('public')->files($incident->incident_image);
        $firstImage = count($files) > 0 ? $files[0] : null;

        foreach ($users as $user) {
            Mail::to($user->email)->send(new IncidentReported($incident, $firstImage));
        }
        
        Session()->flash('message', 'Incident successfully added');
        
        return redirect()->route('user-incident-list'); // Adjust the route as per your application
    }

    public function getEditIncidentForm(string $reportNo){
        // $incident = Incident::find($reportNo);
        $incident = Incident::with(['injuredPeople', 'witnessDetails'])->find($reportNo);
        $folderName = $incident->incident_image;
        $files = Storage::disk('public')->files($folderName);
        $incident->images = $files;
        $breadcrumb1 = "Incident";
        $breadcrumb2  = "Update Incident";
        $headings = "Update Incident";
        return view('supervisor.edit-incident-form', compact('incident', 'breadcrumb1', 'breadcrumb2', 'headings'));
    }

    public function putEditIncident(Request $request, $reportNo) {
        // Eager load injuredPeople and witnessDetails
        $incident = Incident::with(['injuredPeople', 'witnessDetails'])->findOrFail($reportNo);
        // Validation rules
        $this->validate($request, [
            // Your validation rules here
        ]);
    
        if ($request->hasFile('incident_photos')) {
            // Create a unique folder name for the incident
            $folderName = 'incident-image/incident_' . $request->reportNo . '_';
            
            foreach ($request->file('incident_photos') as $file) {
                // Generate a unique file name
                //stop sini
                $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();
    
                // Store the file in the unique folder within the 'public' disk
                $path = $file->storeAs($folderName, $filename, 'public');
    
                // Save file reference in the database or associate with the incident
                // For example: $incident->photos()->create(['filename' => $path]);
            }
            $incident->incident_image = $folderName;
        }
    
        // Update other fields
        $incident->dept_name = $request['dept_name'];
        $incident->project_site = $request['project_site'];
        $incident->incident_location = $request['incident_location'];
        $incident->incident_title = $request['incident_title'];
        $incident->incident_time = $request['incident_time'];
        $incident->incident_desc = $request['incident_desc'];
        $incident->notes = $request['notes'];
        $incident->incident_date = $request['incident_date'];
        $incident->user_id = auth()->user()->id;
        $incident->save();
    
        // Handle injured persons
        // Handle injured persons
        $submittedInjuredIds = is_array($request->injured_persons) && isset($request->injured_persons['id'])
            ? collect($request->injured_persons['id'])->filter()
            : collect([]);

        // Delete injured persons not in the submitted IDs
        InjuredPerson::where('incident_id', $incident->reportNo)
                    ->whereNotIn('id', $submittedInjuredIds)
                    ->delete();

        // Check if 'injured_persons' is an array and 'injured_name' key exists in it
        if (is_array($request->injured_persons) && isset($request->injured_persons['injured_name'])) {
            foreach ($request->injured_persons['injured_name'] as $index => $name) {
                if (!empty($name)) {
                $injuredPersonId = isset($request->injured_persons['id'][$index]) ? $request->injured_persons['id'][$index] : null;

                $injuredPerson = InjuredPerson::findOrNew($injuredPersonId);

                $injuredPerson->injured_name = $name;
                $injuredPerson->incident_id = $incident->reportNo;
                $injuredPerson->injured_ic = $request->injured_persons['injured_ic'][$index] ?? null;
                $injuredPerson->injured_nationality = $request->injured_persons['nationality'][$index] ?? null;
                $injuredPerson->injured_company = $request->injured_persons['company'][$index] ?? null;
                $injuredPerson->injured_trades = $request->injured_persons['trades'][$index] ?? null;
                $injuredPerson->total_lost_days = $request->injured_persons['total_lost_days'][$index] ?? 0;
                $injuredPerson->incident_type = $request->injured_persons['incident_type'][$index] ?? null;
                $injuredPerson->user_id = auth()->user()->id;
                $injuredPerson->save();
                }
            }
        }
    
        // Check if 'witnesses' is an array and 'id' key exists in it
        $submittedWitnessIds = is_array($request->witnesses) && isset($request->witnesses['id'])
            ? collect($request->witnesses['id'])->filter()
            : collect([]);

        // Delete witness details not in the submitted IDs
        WitnessDetails::where('incident_id', $incident->reportNo)
                    ->whereNotIn('id', $submittedWitnessIds)
                    ->delete();

        // Check if 'witnesses' is an array and 'witness_name' key exists in it
        if (is_array($request->witnesses) && isset($request->witnesses['witness_name'])) {
            foreach ($request->witnesses['witness_name'] as $index => $name) {
                if (!empty($name)) {
                $witnessDetailId = $request->witnesses['id'][$index] ?? null;
                $witnessDetail = WitnessDetails::findOrNew($witnessDetailId);
                $witnessDetail->user_id = auth()->user()->id;
                $witnessDetail->incident_id = $incident->reportNo;
                $witnessDetail->witness_name = $name;
                $witnessDetail->witness_company = $request->witnesses['witness_company'][$index] ?? null;
                $witnessDetail->remarks = $request->witnesses['remarks'][$index] ?? null;
                $witnessDetail->save();
                }
            }
        }
        Session()->flash('message', 'Incident successfully updated');
        return redirect()->route('user-incident-list');
    }
    
    public function deleteIncident(string $id){
        $incident = Incident::find($id);
        $reportNo = $incident->reportNo;
    
        // Check if the report number exists in the IncidentInvestigation table
        $exists = IncidentInvestigation::where('reportNo', $reportNo)->exists();
        if ($exists) {
            return redirect()->back()->with('error', 'Incident has been investigated!');
        } else {
            // The report number does not exist in the IncidentInvestigation table
            // Perform your logic here
        }
        $incident->injuredPeople()->delete();
        $incident->witnessDetails()->delete();
        if($incident->incident_image){
            if (Storage::disk('public')->exists($incident->incident_image)) {
                Storage::disk('public')->deleteDirectory($incident->incident_image);
            }
        }
        
        $incident->delete();
        Session()->flash('message', 'Incident has been deleted!');
        return redirect()->route('user-incident-list');
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
}
