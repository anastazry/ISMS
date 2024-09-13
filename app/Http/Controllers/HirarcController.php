<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Risks;
use App\Models\Hazard;
use App\Models\Hirarc;
use App\Models\Control;
use App\Models\TitlePage;
use App\Models\HirarcReport;
use Illuminate\Http\Request;
use App\Events\NewHirarcAdded;
use OwenIt\Auditing\Models\Audit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection; 
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
// use DateTime;

class HirarcController extends Controller
{
    public function getHirarcList(){
        $hirarcReportAll = HirarcReport::all();
        $hirarcItems=[];
        foreach($hirarcReportAll as $hirarcReport){
            $titlePage = TitlePage::find($hirarcReport->tpage_id);
            $hirarc_items = Hirarc::find($hirarcReport->hirarc_id); 
            $hazard_items = Hazard::where('hirarc_id', $hirarcReport->hirarc_id)->get();
            $risk_items = Risks::where('hirarc_id', $hirarcReport->hirarc_id)->get();
            $control_items = Control::where('hirarc_id', $hirarcReport->hirarc_id)->get();

            if ($hirarc_items) {
                // Parse inspection_date as Carbon instance and format to 'Y-m-d'
                $formatted_date = Carbon::parse($hirarc_items->inspection_date)->format('d-m-Y');
                $hirarc_items->inspection_date = $formatted_date;
                // dd($hirarc_items->inspection_date);
            }
            // Create an associative array to hold all items for this hirarcReport
            $hirarcItems[] = [
                'hirarcReport' => $hirarcReport,
                'titlePage' => $titlePage,
                'hirarc' => $hirarc_items,
                'hazard' => $hazard_items,
                'risks' => $risk_items,
                'control' => $control_items,
            ];
        }
        $breadcrumb1 = "HIRARC";
        $headings = "HIRARC List";
        return view('supervisor.hirarc-list', [
            'hirarcItems' => $hirarcItems,
            'breadcrumb1' => $breadcrumb1,
            'headings' => $headings
        ]);
    }

    public function getAssignmentList(){
        $userFullName = auth()->user()->name; // Assuming this correctly retrieves the authenticated user's full name

        $hirarcList = DB::table('hirarc_tbl')
                        ->where('prepared_by', $userFullName)
                        ->whereNull('prepared_by_signature')
                        ->get();
        
        // dd($assignmentList);
        $breadcrumb1 = "HIRARC";
        $headings = "Assignment List";
        return view('supervisor.hirarc-assignment-list', [
            'hirarcList' => $hirarcList,
            'breadcrumb1' => $breadcrumb1,
            'headings' => $headings
        ]);
    }

    public function getHirarcForm(){
        // Generate a random 6-digit number
        $randomNumber = mt_rand(100000, 999999);
        // Convert the number to a string
        $randomString = (string) $randomNumber;
        return view('supervisor.hirarc-form-titlepage', compact('randomString'));
    }
    public function getHirarcFormHazard (){
        return view('supervisor.hirarc-form');
    }

    public function getHirarcFormHIRARC (){
        return view('supervisor.hirarc-form-hirarc');
    }

    public function getHirarcFormRisk (){
        return view('supervisor.hirarc-form-risk');
    }
    
    public function getHirarcFormControl(){
        return view('supervisor.hirarc-form-control');
    }
    
    public function postAddHirarcDetail(){
        $userFullName = auth()->user()->name; // Use correct variable name: $userFullName
        $breadcrumb1 = "HIRARC";
        $breadcrumb2 = "Add HIRARC";
        $headings = "Add HIRARC";
        return view('supervisor.hirarc-form-hirarc', compact('userFullName', 'breadcrumb1', 'breadcrumb2', 'headings')); // Pass $userFullName, not 'userFullName'
    }

    public function assignHirarc() {
        $userNames = DB::select('SELECT name FROM users');
        // dd($userNames);
        return view('assign-hirarc', ['userNames' => $userNames]);
    }

    public function postAssignHirarc(Request $request) {
        // Debugging the request data
        // dd($request->all());
    
        $hirarc = new Hirarc();
        $hirarc->desc_job = $request->input('desc_job');
        $hirarc->location = $request->input('location');
        $hirarc->prepared_by = $request->input('prepared_by');
        $hirarc->inspection_date = $request->input('inspection_date');
    
        // Save the new Hirarc instance to the database
        $hirarc->save();

        $hirarcReport = new HirarcReport();
        $hirarcReport->hirarc_id = $hirarc->hirarc_id;
        $hirarcReport->save();
    
        // Redirect or return response
        return redirect()->route('user.hirarc-list')->with('message', 'Hirarc assigned successfully.');
    }
    

    public function postAddTitleDetails(Request $request){
        $userId = auth()->user()->id;
        $titlePage = new TitlePage();
        $hirarcReport = new HirarcReport();

        $this->validate($request, [
            'insp_date' => 'required|date',
            'verification_date' => 'required|date',
            'verified_by' => 'required|string|max:255',
            'approval_date' => 'required|date',
            'approved_by' => 'required|string|max:255',
        ]);
        // dd($request->input('verified_by_signature'));
        // dd($request->input('approved_by_signature'));

        // Extract the base64-encoded image data from the request
        $base64ImageVerified = $request->input('verified_by_signature');
        $base64ImageApproved = $request->input('approved_by_signature');
        
        // Remove the data URL prefix (e.g., 'data:image/png;base64,')
        $base64ImageVerified = str_replace('data:image/png;base64,', '', $base64ImageVerified);
        $base64ImageApproved = str_replace('data:image/png;base64,', '', $base64ImageApproved);
        
        // Decode the base64-encoded image data
        $imageDataVerified = base64_decode($base64ImageVerified);
        $imageDataApproved = base64_decode($base64ImageApproved);
        
        // Generate unique file names for the images (e.g., using timestamp)
        $fileNameVerified = 'signature_verifiedby' . time() . '.png';
        $fileNameApproved = 'signature_approvedby' . time() . '.png';
        
        // Specify the storage paths where the images will be saved
        $storagePathVerified = 'public/signatures/verifiedby';
        $storagePathApproved = 'public/signatures/approvedby';
        
        // Ensure that the storage directories exist, create them if not
        if (!Storage::exists($storagePathVerified)) {
            Storage::makeDirectory($storagePathVerified);
        }
        
        if (!Storage::exists($storagePathApproved)) {
            Storage::makeDirectory($storagePathApproved);
        }
        
        // Store the image files in the specified storage paths
        Storage::put($storagePathVerified . '/' . $fileNameVerified, $imageDataVerified);
        Storage::put($storagePathApproved . '/' . $fileNameApproved, $imageDataApproved);
        
        // Get the full paths of the saved image files
        $filePathVerified = Storage::url($storagePathVerified . '/' . $fileNameVerified);
        $filePathApproved = Storage::url($storagePathApproved . '/' . $fileNameApproved);
        
        // Optionally, return or use the file paths as needed
        // dd('Verified Signature Path:', asset($filePathVerified), 'Approved Signature Path:', asset($filePathApproved));
        
        // Assign the public file path (URL) to $incident->firstImage
        // $titlePage->ver_signature_image = asset($publicFilePath);
        // dd($publicFilePath);
        $titlePage->ver_signature_image = $filePathVerified;
        $titlePage->appr_signature_img = $filePathApproved;
        $titlePage->insp_date = $request['insp_date'];
        $titlePage->verification_date = $request['verification_date'];
        $titlePage->verified_by = $request['verified_by'];
        $titlePage->approval_date = $request['approval_date'];
        $titlePage->approved_by = $request['approved_by'];
        $titlePage->user_id = $userId;
        $titlePage->save();
        $hirarcReport->tpage_id = $titlePage->tpage_id;
        $hirarcReport->save();
        // Pass the hirarc_id to the view
        $tpage_id = $titlePage->tpage_id; // Assuming hirarc_id is the id of the saved TitlePage
        // dd($tpage_id);
        $breadcrumb1 = "HIRARC";
        $breadcrumb2 = "Add HIRARC";
        $breadcrumb3  = "Add Hazard";
        $headings = "Add Hazard";
        return view('supervisor.hirarc-form-hirarc', compact('tpage_id', 'breadcrumb1' , 'breadcrumb2', 'breadcrumb3', 'headings'));
    }

    public function convertBase64ToImage(String $base64Code){
        // Extract the base64-encoded image data from the request
        $base64ImageVerified = $base64Code;
        
        // Remove the data URL prefix (e.g., 'data:image/png;base64,')
        $base64ImageVerified = str_replace('data:image/png;base64,', '', $base64ImageVerified);
        
        // Decode the base64-encoded image data
        $imageDataVerified = base64_decode($base64ImageVerified);
        
        // Generate unique file names for the images (e.g., using timestamp)
        $fileNameVerified = 'signature_verifiedby' . time() . '.png';
        $fileNameApproved = 'signature_approvedby' . time() . '.png';
        
        // Specify the storage paths where the images will be saved
        $storagePathVerified = 'public/signatures/verifiedby';
        $storagePathApproved = 'public/signatures/approvedby';
        
        // Ensure that the storage directories exist, create them if not
        if (!Storage::exists($storagePathVerified)) {
            Storage::makeDirectory($storagePathVerified);
        }
        
        if (!Storage::exists($storagePathApproved)) {
            Storage::makeDirectory($storagePathApproved);
        }
        
        // Store the image files in the specified storage paths
        Storage::put($storagePathVerified . '/' . $fileNameVerified, $imageDataVerified);
        
        // Get the full paths of the saved image files
        $filePathVerified = Storage::url($storagePathVerified . '/' . $fileNameVerified);
        $filePathApproved = Storage::url($storagePathApproved . '/' . $fileNameApproved);
        
        // Optionally, return or use the file paths as needed
        // dd('Verified Signature Path:', asset($filePathVerified), 'Approved Signature Path:', asset($filePathApproved));
        
        // Assign the public file path (URL) to $incident->firstImage
        // $titlePage->ver_signature_image = asset($publicFilePath);
        // dd($publicFilePath);
    }

    public function postAddHirarcDetails(Request $request){
        // dd($request);
        $userId = auth()->user()->id;
        $hirarc = new Hirarc();
        if (isset($request['prepared_by_signature']) && !empty($request['prepared_by_signature'])){
            // dd('if');

            $base64ImageVerified = $request->input('prepared_by_signature');
        
            // Remove the data URL prefix (e.g., 'data:image/png;base64,')
            $base64ImageVerified = str_replace('data:image/png;base64,', '', $base64ImageVerified);
            
            // Decode the base64-encoded image data
            $imageDataVerified = base64_decode($base64ImageVerified);
            
            // Generate unique file names for the images (e.g., using timestamp)
            $fileNameVerified = 'signature_prepared_by' . time() . '.png';
            
            // Specify the storage paths where the images will be saved
            $storagePathVerified = 'public/signatures/preparedby';
            // Ensure that the storage directories exist, create them if not
            if (!Storage::exists($storagePathVerified)) {
                Storage::makeDirectory($storagePathVerified);
            }
            // Store the image files in the specified storage paths
            Storage::put($storagePathVerified . '/' . $fileNameVerified, $imageDataVerified);
            // Get the full paths of the saved image files
            $filePathVerified = Storage::url($storagePathVerified . '/' . $fileNameVerified);

            $hirarc->prepared_by_signature = $filePathVerified;
        }else{
            $file_path = auth()->user()->user_signature;
            $hirarc->prepared_by_signature = $file_path;
        }
        $hirarc->desc_job = $request['desc_job'];
        $hirarc->location = $request['location'];
        $hirarc->prepared_by = $request['prepared_by'];
        // dd($request['inspection_date']);
        $hirarc->inspection_date = $request['inspection_date'];
        $tpage_id = $request['tpage_id'];
        // $hirarcReport = HirarcReport::where('tpage_id', $tpage_id)->first();
        $hirarcReport = new HirarcReport();
        
        $hirarc->save();

        $hirarc_id = $hirarc->hirarc_id;
        $hirarcReport->hirarc_id = $hirarc_id;
        $hirarcReport->save();
        event(new NewHirarcAdded($hirarc));
        // event(new NewHirarcAdded($hirarc));
        // // Redirect to the next page and pass the hirarc_id as a parameter
        // dd($hirarc_id);
        $breadcrumb1 = "HIRARC";
        $breadcrumb2 = "Add HIRARC";
        $breadcrumb3 = "Add Hazard";
        $headings = "Add Hazard";
        return view('supervisor.hirarc-form', [
            'hirarc_id' => $hirarc_id,
            'breadcrumb1' => $breadcrumb1,
            'breadcrumb2' => $breadcrumb2,
            'breadcrumb3' => $breadcrumb3,
            'headings' => $headings,
        ]);
        
        // return redirect()->route('user.hirarc-form-view')->with('hirarc_id', $hirarc_id);
        // return redirect()->route('user.hirarc-form-view', ['hirarc_id' => $hirarc_id]);
        // return redirect()->route('user.hirarc-form-view', ['hirarc_id' => $hirarc_id]);
    }

    public function postAddHazardDetails(Request $request){
        $hirarc_id = $request->hirarc_id;
    
        // Get all existing hazards related to the current hirarc_id
        $existingHazards = Hazard::where('hirarc_id', $hirarc_id)->get();
    
        // Iterate over submitted hazard data to update or create Hazard models
        if ($request->has('hazard') && is_array($request->hazard['job_sequence'])) {
            foreach ($request->hazard['job_sequence'] as $index => $jobSequence) {
                // Skip processing if job_sequence is empty
                if (empty($jobSequence)) {
                    continue;
                }
    
                // Find existing hazard by index or create a new one
                $hazard = $existingHazards->get($index) ?? new Hazard();
                
                // Update Hazard attributes
                $hazard->job_sequence = $jobSequence;
                $hazard->hazard = $request->hazard['hazard'][$index] ?? null;
                $hazard->can_cause = $request->hazard['can_cause'][$index] ?? null;
                $hazard->hirarc_id = $hirarc_id;
    
                // Save the Hazard model
                $hazard->save();
            }
        }
    
        // Retrieve updated hazard data
        $updatedHazards = Hazard::where('hirarc_id', $hirarc_id)->get();
    
        // Return view with updated hazard data
        $breadcrumb1 = "HIRARC";
        $breadcrumb2 = "Add HIRARC";
        $breadcrumb3 = "Add Hazard";
        $breadcrumbs = ["Add Risks"];
        $headings = "Add Risks";
        return view('supervisor.hirarc-form-risk', [
            'hazard_data' => $updatedHazards,
            'breadcrumb1' => $breadcrumb1,
            'breadcrumb2' => $breadcrumb2,
            'breadcrumb3' => $breadcrumb3,
            'breadcrumbs' => $breadcrumbs,
            'headings' => $headings,
        ]);
    }

    public function postAddRisksDetails(Request $request){
        // $hirarc_id = Session::get('hirarc_id');
        if ($request->has('risk') && is_array($request->risk['risk_desc'])) {
            foreach ($request->risk['risk_desc'] as $index => $riskDesc) {
                if (!empty($riskDesc)) {
                    $risk = new Risks(); // Assuming you have a Hazard model
                    $risk->risk_desc = $riskDesc;
                    $risk->current_control = $request->risk['current_control'][$index] ?? null;
                    $risk->likelihood = $request->risk['likelihood'][$index] ?? null;
                    $risk->severity = $request->risk['severity'][$index] ?? null;
                    $risk->score = $request->risk['score'][$index] ?? null;
                    $risk->index = $request->risk['index'][$index] ?? null;
                    $risk->hazard_id = $request->hazard_id[$index] ?? null;
                    $risk->hirarc_id = $request->hirarc_id[$index] ?? null;
                    $risk->save();
                }
            }
        }
        $data = Hazard::where('hirarc_id', $risk->hirarc_id)->get();
        // dd($data);
        $breadcrumb1 = "HIRARC";
        $breadcrumb2 = "Add HIRARC";
        $breadcrumb3 = "Add Hazard";
        $breadcrumbs = ["Add Risks", "Add Control"];
        $headings = "Add Control";
        return view('supervisor.hirarc-form-control',        
        [
            'hazard_data' => $data,
            'breadcrumb1' => $breadcrumb1,
            'breadcrumb2' => $breadcrumb2,
            'breadcrumb3' => $breadcrumb3,
            'breadcrumbs' => $breadcrumbs,
            'headings' => $headings,
        ]);
    }
            // foreach ($request->control as $index => $control_responsibility) {
            //     // Check if hazard_id is not empty
            //     if (!empty($control_responsibility)) {
            //         $control = new Control(); // Assuming you have a Control model
                    
            //         // Populate Control attributes
            //         $control->opportunity = $request->control['opportunity'][$index] ?? null;
            //         $control->new_control = $request->control['new_control'][$index] ?? null;
            //         $control->responsibility = $request->control['responsibility'][$index] ?? null;
            //         $control->status = $request->control['status'][$index] ?? null;
            //         $control->finish_date = $request->control['finish_date'][$index] ?? null;
            //         $control->hazard_id = $request->hazard_id[$index] ?? null;
            //         $control->hirarc_id = $request->hirarc_id[$index] ?? null;
            //         dd($control->opportunity);
                    
            //         // If hirarc_id is associated with each hazard, you can access it from the request
            //         // $control->hirarc_id = $request->hirarc_id[$index] ?? null;
                    
            //         // Save the Control instance
            //         $control->save();
            //     }
            // }

    public function postAddControlDetails(Request $request)
    {
        if ($request->has('control') && is_array($request->control['responsibility'])) {

            foreach ($request->control['responsibility'] as $index => $responsibility) {
                if (!empty($responsibility)) {
                    $control = new Control();
                    $control->opportunity = $request->control['opportunity'][$index] ?? null;
                    $control->new_control = $request->control['new_control'][$index] ?? null;
                    $control->responsibility = $responsibility;
                    $control->status = $request->control['status'][$index] ?? null;
                    $control->hazard_id = $request->hazard_id[$index] ?? null;
                    $control->hirarc_id = $request->hirarc_id[$index] ?? null;
                    $control->save();
                }
            }
        }
        // Retrieve hazard data based on hirarc_id
        $hazard_data = Hazard::where('hirarc_id', $request->hirarc_id)->get();
        // return view('supervisor.hirarc-list')->with('hazard_data', $hazard_data);
        return redirect()->route('user.hirarc-list')->with('hazard_data', $hazard_data);
    }

    public function getEditHirarcForm(int $hirarc_id)
    {
        // $hirarcReport = HirarcReport::where('hirarc_id', $hirarc_id)->first();
        // $titlePage = TitlePage::find($hirarcReport->tpage_id);
        // $hirarc_items = Hirarc::find($hirarcReport->hirarc_id); 
        // $hazard_items = Hazard::where('hirarc_id', $hirarcReport->hirarc_id)->get();
        // $risk_items = Risks::where('hirarc_id', $hirarcReport->hirarc_id)->get();
        // $control_items = Control::where('hirarc_id', $hirarcReport->hirarc_id)->get();
        $hirarcReport = HirarcReport::where('hirarc_id', $hirarc_id)->first();
        $userName = auth()->user()->role;
        // dd($hirarcReport->tpage_id);
        if(isset($hirarcReport->tpage_id)){
            if($userName == 'Supervisor'){
                Session()->flash('error', 'Sorry only SHO and Project Manager can edit verified form!');
                return redirect()->route('user.hirarc-list');
            }
        }
        if($hirarc_id){
            $hirarc_items = Hirarc::find($hirarc_id); 
            $auditData = $hirarc_items->audits;
            // dd($auditData);

            $hirarcData = [
                'hirarc_items' => $hirarc_items,
                'auditData' => $auditData
            ];
        }
        $hirarcFindAudits = Hirarc::find(89);
        $all = $hirarcFindAudits->audits;
        $counter = 0;
        
        $breadcrumb1 = "HIRARC";
        $breadcrumb2 = "Update HIRARC";
        $headings = "Update HIRARC : " . $hirarc_id;
        
        return view('supervisor.edit-hirarc-hirarc', compact('hirarcData', 'breadcrumb1', 'breadcrumb2', 'headings'));
        
        // Pass data as an associative array to the view
        // return view('supervisor.edit-hirarc-hirarc', [
        //     'hirarcReport' => $hirarcReport,
        //     'titlePage' => $titlePage,
        //     'hirarc_items' => $hirarc_items,
        //     'hazard_items' => $hazard_items,
        //     'risk_items' => $risk_items,
        //     'control_items' => $control_items
        // ]);
    }

    public function putEditTitlePage(Request $request, int $tpage_id) {
        // Eager load injuredPeople and witnessDetails
        $titlePage = TitlePage::findOrFail($tpage_id);
        // Validation rules
        $this->validate($request, [
            // Your validation rules here
        ]);

        // Update other fields
        $titlePage->ver_signature_image = 'default_value';
        $titlePage->appr_signature_img = 'default_value';
        $titlePage->insp_date = $request['insp_date'];
        $titlePage->verification_date = $request['verification_date'];
        $titlePage->verified_by = $request['verified_by'];
        $titlePage->approval_date = $request['approval_date'];
        $titlePage->approved_by = $request['approved_by'];
        $titlePage->save();
        if($titlePage->hirarc_id){
            $hirarc_items = Hirarc::find($titlePage->hirarc_id); 
            $hirarcData = [
                'titlePage' => $titlePage,
                'hirarc_items' => $hirarc_items,
            ];
        }else{
            $hirarcData = [
                'titlePage' => $titlePage,
            ];
        }
        return view('supervisor.edit-hirarc-hirarc', compact('hirarcData'));
    
        // Session()->flash('message', 'Incident successfully updated');
        // return redirect()->route('user-incident-list');
    }
// dd($request['prepared_by_signature']);
// dd($request['prepared_by_signature']);

        // $this->validate($request, [
        //     'desc_job' => 'required|string|max:255',
        //     'location' => 'required|string|max:255',
        //     'prepared_by' => 'required|string|max:255',
        //     'approved_by' => 'required|string|max:255',
        // ]);

    public function putEditHirarcDetails(Request $request,int $hirarc_id){
        $userId = auth()->user()->id;
        $hirarc = Hirarc::findOrFail($hirarc_id);
// dd($request);
    if (isset($request['prepared_by_signature']) && !empty($request['prepared_by_signature'])){
        // dd('if');

        $base64ImageVerified = $request->input('prepared_by_signature');

        // Remove the data URL prefix (e.g., 'data:image/png;base64,')
        $base64ImageVerified = str_replace('data:image/png;base64,', '', $base64ImageVerified);
        
        // Decode the base64-encoded image data
        $imageDataVerified = base64_decode($base64ImageVerified);
        
        // Generate unique file names for the images (e.g., using timestamp)
        $fileNameVerified = 'signature_prepared_by' . time() . '.png';
        
        // Specify the storage paths where the images will be saved
        $storagePathVerified = 'public/signatures/preparedby';
        
        // Ensure that the storage directories exist, create them if not
        if (!Storage::exists($storagePathVerified)) {
            Storage::makeDirectory($storagePathVerified);
        }

        // Store the image files in the specified storage paths
        Storage::put($storagePathVerified . '/' . $fileNameVerified, $imageDataVerified);
        
        // Get the full paths of the saved image files
        $filePathVerified = Storage::url($storagePathVerified . '/' . $fileNameVerified);

        $hirarc->prepared_by_signature = $filePathVerified;
    }

        $hirarc->desc_job = $request['desc_job'];
        $hirarc->location = $request['location'];
        $hirarc->prepared_by = $request['prepared_by'];
        $hirarc->inspection_date = $request['inspection_date'];
        $tpage_id = $request['tpage_id'];
    
        $hirarc->save();

        $hirarc_id = $hirarc->hirarc_id;

        $existingHazards = Hazard::where('hirarc_id', $hirarc_id)->get();
        $auditData = collect(); // Use a Collection to store multiple audit records
        
        $all = Audit::where('auditable_type', 'App\Models\Hazard')->get();
        
        foreach ($all as $auditHazard) {
            if ($auditHazard->event == 'deleted') {
                // Handle deleted audits
                $oldJson = is_array($auditHazard->old_values) ? $auditHazard->old_values : json_decode($auditHazard->old_values, true);
                if ($oldJson['hirarc_id'] == $hirarc_id) {
                    $auditData->push($auditHazard); // Add audit to the collection
                }
            } else {
                // Handle other events (not 'deleted')
                foreach ($existingHazards as $hazard) {
                    if ($hazard->hazard_id == $auditHazard->auditable_id) {
                        $auditData->push($auditHazard); // Add audit to the collection
                        break; // Stop inner loop once audit is found
                    }
                }
            }
        }
        // Pass both $existingHazards and $auditData to the view
        $breadcrumb1 = "HIRARC";
        $breadcrumb2 = "Hazard Identification";
        $headings = "Hazard Identification";
        if ($existingHazards->isNotEmpty()) {
            return view('supervisor.edit-hirarc-hazard')
                ->with('existingHazards', $existingHazards)
                ->with('auditData', $auditData)->with('breadcrumb1', $breadcrumb1)->with('breadcrumb2', $breadcrumb2)->with('headings', $headings);
        } else {
            return view('supervisor.hirarc-form')->with('hirarc_id', $hirarc_id)->with('breadcrumb1', $breadcrumb1)->with('breadcrumb2', $breadcrumb2)->with('headings', $headings);
        }
    }

    public function putEditHazardDetails(Request $request, int $hirarc_id){
        // Retrieve all existing hazard details for the given hirarc_id
        $existingHazards = Hazard::where('hirarc_id', $hirarc_id)->get();
        $newHazardLength = count($request->hazard['job_sequence']);
        $count = 0;

        if ($request->has('hazard') && is_array($request->hazard['job_sequence'])) {
                    // Collect all submitted hazard_id values
            $submittedHazardIds = $request->hazard['hazard_id'];
            $existingHazardsd = Hazard::whereNotIn('hazard_id', $submittedHazardIds)->get();

            // Iterate over existing hazards to delete those not included in the submitted data
            foreach ($existingHazards as $existingHazard) { 
                if (!in_array($existingHazard->hazard_id, $submittedHazardIds)) {

                    // Delete related risks
                    $riskDelete = Risks::where('hazard_id', $existingHazard->hazard_id);

                    // Delete related controls
                    $controlDelete = Control::where('hazard_id', $existingHazard->hazard_id);

                    $riskDelete->delete();
                    $controlDelete->delete();
                    // Finally, delete the hazard itself
                    $existingHazard->delete();
                }
            }
$count = 0;
            foreach ($request->hazard['job_sequence'] as $index => $jobSequence) {
                // $hazard = $existingHazards->firstWhere('hazard_id', $request->hazard['hazard_id'][$index]);
                $hazard = Hazard::find($request->hazard['hazard_id'][$index]);
                $count++;

                if($hazard){
                    $hazard->job_sequence = $request->hazard['job_sequence'][$index] ?? null;
                    $hazard->hazard = $request->hazard['hazard'][$index] ?? null;
                    $hazard->can_cause = $request->hazard['can_cause'][$index] ?? null;
                    $hazard->save();
                }else{
                    // Create new hazard detail
                    // $count++;
                    // dd($count);
                    $newHazard = new Hazard();
                    $newHazard->job_sequence = $request->hazard['job_sequence'][$index] ?? null;
                    $newHazard->hazard = $request->hazard['hazard'][$index] ?? null;
                    $newHazard->can_cause = $request->hazard['can_cause'][$index] ?? null;
                    $newHazard->hirarc_id = $hirarc_id;
                    $newHazard->save();
                }
                // if (!empty($jobSequence)) {
                //     if($index < $oldHazardLength){
                //         $hazard = $existingHazards->firstWhere('hazard_id', $request->hazard['hazard_id'][$index]);
                //         // $hazard = $existingHazards->firstWhere('hazard_id', $request->hazard['hazard_id'][$index]);
                //         // Check if $hazard is not null before updating
                //         if ($hazard !== null) {
                //             $hazard->job_sequence = $request->hazard['job_sequence'][$index] ?? null;
                //             $hazard->hazard = $request->hazard['hazard'][$index] ?? null;
                //             $hazard->can_cause = $request->hazard['can_cause'][$index] ?? null;
                //             $hazard->save();
                //         }

                //     }else {
                //         // Create new hazard detail
                //         $newHazard = new Hazard();
                //         $newHazard->job_sequence = $request->hazard['job_sequence'][$index] ?? null;
                //         $newHazard->hazard = $request->hazard['hazard'][$index] ?? null;
                //         $newHazard->can_cause = $request->hazard['can_cause'][$index] ?? null;
                //         $newHazard->hirarc_id = $hirarc_id;
                //         $newHazard->save();
                //     }
                // }
            }
        }
        // Retrieve all hazard details for the updated hirarc_id
        $updatedHazards = Hazard::where('hirarc_id', $hirarc_id)->get();
        $updatedHazardsRisks = Risks::where('hirarc_id', $hirarc_id)->get();
        $auditData = collect(); // store auditData
        
        $all = Audit::where('auditable_type', 'App\Models\Risks')->get();
        
        foreach ($all as $auditRisk) {
            if ($auditRisk->event == 'deleted') {
                // Handle deleted audits
                $oldJson = is_array($auditRisk->old_values) ? $auditRisk->old_values : json_decode($auditRisk->old_values, true);
                if ($oldJson['hirarc_id'] == $hirarc_id) {
                    $auditData->push($auditRisk); // Add audit to collection
                }
            } else {
                // Handle other events (not 'deleted')
                foreach ($updatedHazardsRisks as $risk) {
                    if ($risk->risk_id == $auditRisk->auditable_id) {
                        $auditData->push($auditRisk); // Add audit to collection
                        break; // Stop inner loop once audit is found
                    }
                }
            }
        }
        $auditData = $auditData->sortBy('created_at');

        // Dd to check sorted data
        // dd($auditData->toArray());
        // Create an associative array to hold both collections
        $breadcrumb1 = "HIRARC";
        $breadcrumb2 = "Hazard Identification";
        $breadcrumb3 = "Risk Assessment";
        $headings = "Risk Assessment";
        $hazardWithRisks = [
            'updatedHazards' => $updatedHazards,
            'updatedHazardsRisks' => $updatedHazardsRisks
        ];
        // dd($hazardWithRisks);
        return view('supervisor.edit-hirarc-risk')
                ->with('hazard_data', $hazardWithRisks)
                ->with('auditData', $auditData)->with('breadcrumb1', $breadcrumb1)->with('breadcrumb2', $breadcrumb2)->with('breadcrumb3', $breadcrumb3)->with('headings', $headings);
    }

    public function destroy($id)
    {
        return $this->deleteHazard($id);
    }

                // Check if a matching risk already exists based on risk_id
                // $matchingRisk = $existingRisks->first(function ($existingRisk) use ($newRiskId) {
                //     return $existingRisk->risk_id == $newRiskId;
                // });
    public function putEditRiskDetails(Request $request, int $hirarc_id){
        // Retrieve all existing hazard details for the given hirarc_id
        $existingRisks = Risks::where('hirarc_id', $hirarc_id)->get();
        // Process submitted hazard data
        // dd($request->hazard['hazard_id'][0]);
        // dd($request->risk); //cun

        // Process submitted risk data from the request
        $newRisks = $request->risk;
        if ($request->has('risk') && is_array($request->risk['risk_desc'])) {
            foreach ($newRisks['risk_desc'] as $index => $newRiskDesc) {
                // Ensure that the required arrays have values at the current index
                if (isset($newRisks['risk_id'][$index])) {
                    $newRiskId = $newRisks['risk_id'][$index];
                    $newCurrControl = $newRisks['curr_control'][$index];
                    $newLikelihood = $newRisks['likelihood'][$index];
                    $newSeverity = $newRisks['severity'][$index];
                    $newScore = $newRisks['score'][$index];
                    $newIndex = $newRisks['index'][$index];
                    $newHazardId = $newRisks['hazard_id'][$index];
    
                    // Check if a matching risk already exists based on risk_id
                    $matchingRisk = Risks::find($newRiskId);
                    if ($matchingRisk) {
                        // Update existing risk with new data
                        $matchingRisk->risk_desc = $newRiskDesc;
                        $matchingRisk->current_control = $newCurrControl;
                        $matchingRisk->likelihood = $newLikelihood;
                        $matchingRisk->severity = $newSeverity;
                        $matchingRisk->score = $newScore;
                        $matchingRisk->index = $newIndex;
                        $matchingRisk->save(); // Save the updated risk
                    } 
                }else{
                    $risk = new Risks(); // Assuming you have a Hazard model
                    $risk->risk_desc = $newRisks['risk_desc'][$index];
                    $risk->current_control = $newRisks['curr_control'][$index] ?? null;
                    $risk->likelihood = $newRisks['likelihood'][$index] ?? null;
                    $risk->severity = $newRisks['severity'][$index] ?? null;
                    $risk->score = $newRisks['score'][$index] ?? null;
                    $risk->index = $newRisks['index'][$index] ?? null;
                    $risk->hazard_id = $newRisks['hazard_id'][$index] ?? null;
                    $risk->hirarc_id = $hirarc_id ?? null;
                    $risk->save(); // Save the updated risk

                }
            }
        }
            // Retrieve all hazard details for the updated hirarc_id
            $updatedHazards = Hazard::where('hirarc_id', $hirarc_id)->get();
            $updatedHazardsControl = Control::where('hirarc_id', $hirarc_id)->get();
            $auditData = collect(); // store auditData
        
            $all = Audit::where('auditable_type', 'App\Models\Control')->get();
            
            foreach ($all as $auditControl) {
                if ($auditControl->event == 'deleted') {
                    // Handle deleted audits
                    $oldJson = is_array($auditControl->old_values) ? $auditControl->old_values : json_decode($auditControl->old_values, true);
                    if ($oldJson['hirarc_id'] == $hirarc_id) {
                        $auditData->push($auditControl); // Add audit to collection
                    }
                } else {
                    // Handle other events (not 'deleted')
                    foreach ($updatedHazardsControl as $control) {
                        if ($control->control_id == $auditControl->auditable_id) {
                            $auditData->push($auditControl); // Add audit to collection
                            break; // Stop inner loop once audit is found
                        }
                    }
                }
            }
            $auditData = $auditData->sortBy('created_at');
            // dd($auditData);
            // Create an associative array to hold both collections
            $hazardWithControls = [
                'updatedHazards' => $updatedHazards,
                'updatedHazardsControl' => $updatedHazardsControl
            ];
            $breadcrumb1 = "HIRARC";
            $breadcrumb2 = "Hazard Identification";
            $breadcrumb3 = "Risk Assessment";
            $headings = "Risk Control";
            $breadcrumbs[] = "Risk Control";
            return view('supervisor.edit-hirarc-control')
            ->with('hazard_data', $hazardWithControls)
            ->with('auditData', $auditData)
            ->with('breadcrumb1', $breadcrumb1)
            ->with('breadcrumb2', $breadcrumb2)
            ->with('breadcrumb3', $breadcrumb3)
            ->with('headings', $headings)
            ->with('breadcrumbs', $breadcrumbs);
}

    public function putEditControlDetails(Request $request, int $hirarc_id){
                // Retrieve all existing hazard details for the given hirarc_id
                $existingControl = Control::where('hirarc_id', $hirarc_id)->get();
                // Process submitted hazard data
                // dd($request->hazard['hazard_id'][0]);
                // dd($request->risk); //cun
        // dd($request->control);
                        // Process submitted risk data from the request
                $newControls = $request->control;
                // dd($newControls);
                if ($request->has('control') && is_array($request->control['responsibility'])) {
                    foreach ($newControls['responsibility'] as $index => $newControlResp) {
                        // Ensure that the required arrays have values at the current index
                        if (isset($newControls['control_id'][$index])) {
                            $newControlId = $newControls['control_id'][$index];
                            $newOpportunity = $newControls['opportunity'][$index];
                            $newControl = $newControls['new_control'][$index];
                            $newResponsibility = $newControls['responsibility'][$index];
                            $newStatus = $newControls['status'][$index];
                            // $newHazardId = $newControls['hirarc_id'][$index];
                            $newHirarcId = $newControls['hirarc_id'][$index];
            
                            // Check if a matching risk already exists based on risk_id
                            $matchingControl = Control::find($newControlId);
                            if ($matchingControl) {
                                // Update existing risk with new data
                                $matchingControl->opportunity = $newOpportunity;
                                $matchingControl->new_control = $newControl;
                                $matchingControl->responsibility = $newResponsibility;
                                $matchingControl->status = $newStatus;
                                $matchingControl->save(); // Save the updated risk
                            } 
                        }else{
                            $control = new Control(); // Assuming you have a Hazard model
                            $control->new_control = $newControls['new_control'][$index];
                            $control->opportunity = $newControls['opportunity'][$index] ?? null;
                            $control->responsibility = $newControls['responsibility'][$index] ?? null;
                            $control->status = $newControls['status'][$index] ?? null;
                            $control->hazard_id = $newControls['hazard_id'][$index] ?? null;
                            $control->hirarc_id = $hirarc_id ?? null;
                            $control->save(); // Save the updated risk
        
                        }
                    }
                }
                $hirarcReportAll = HirarcReport::all();
                $hirarcItems=[];
                foreach($hirarcReportAll as $hirarcReport){
                    $titlePage = TitlePage::find($hirarcReport->tpage_id);
                    $hirarc_items = Hirarc::find($hirarcReport->hirarc_id); 
                    $hazard_items = Hazard::where('hirarc_id', $hirarcReport->hirarc_id)->get();
                    $risk_items = Risks::where('hirarc_id', $hirarcReport->hirarc_id)->get();
                    $control_items = Control::where('hirarc_id', $hirarcReport->hirarc_id)->get();
                    // Create an associative array to hold all items for this hirarcReport
                    $hirarcItems[] = [
                        'hirarcReport' => $hirarcReport,
                        'titlePage' => $titlePage,
                        'hirarc' => $hirarc_items,
                        'hazard' => $hazard_items,
                        'risks' => $risk_items,
                        'control' => $control_items,
                    ];
                }
                // dd($hirarcItems['titlePage']);
                // dd($hirarcItems);

                return view('supervisor.hirarc-list', ['hirarcItems' => $hirarcItems]);
    }



    public function deleteHirarc(string $hirarc_id) {
        $userRole = auth()->user()->role;
        // dd($userRole);
        $hirarcReport = HirarcReport::where('hirarc_id', $hirarc_id)->first();
        if (isset($hirarcReport->tpage_id)) {
            if ($userRole == 'Supervisor') {
                Session()->flash('error', 'Sorry only SHO and Project Manager can delete verified form!');
                return redirect()->route('user.hirarc-list');
            }
        }
        // dd($hirarc);
        if ($hirarcReport) {
            $hirarc = Hirarc::find($hirarc_id);
            if ($hirarc) {
                // Check if prepared_by_signature is not null and delete the file if it does not match the exclusion path
                if (!is_null($hirarc->prepared_by_signature)) {
                    $signaturePath = $hirarc->prepared_by_signature;
                    // Ensure the path is correct
                    // dd($signaturePath);
                    $excludePath = 'public/storage/signatures/usersignature';
                    if (Storage::disk('public')->exists($signaturePath) && $signaturePath !== $excludePath) {
                        Storage::disk('public')->delete($signaturePath);
                    } else {
                        // You can log or handle the case where the path matches the excludePath or does not exist
                        // For example, use: dd('Path does not exist or matches exclude path: ' . $signaturePath);
                    }
                }
    
                Risks::where('hirarc_id', $hirarc->hirarc_id)->delete();
                Control::where('hirarc_id', $hirarc->hirarc_id)->delete();
                Hazard::where('hirarc_id', $hirarc->hirarc_id)->delete();
                Hirarc::where('hirarc_id', $hirarc->hirarc_id)->delete();
                if ($hirarcReport->tpage_id) {
                    $hirarcTitlePage = TitlePage::where('tpage_id', $hirarcReport->tpage_id)->first();
                    $hirarcTitlePage->delete();
                }
                $hirarcReport->delete();
                $hirarc->delete();
            }
    
            Session()->flash('message', 'HIRARC has been deleted!');
            return redirect()->route('user.hirarc-list');
        }
    }
    
    


            // Delete related controls
            // $hirarc->hazards()->delete();
            // $hirarc->titlePage()->delete();
            // $hirarc->risks()->delete();
            // $hirarc->controls()->delete();
            // $hirarc->hazards()->delete();
            // $hirarc->delete();
            // $auditData = collect(); // store auditData
        
            // $all = Audit::where('auditable_type', 'App\Models\Risks')->get();
            
            // foreach ($all as $auditRisk) {
            //     if ($auditRisk->event == 'deleted') {
            //         // Handle deleted audits
            //         $oldJson = is_array($auditRisk->old_values) ? $auditRisk->old_values : json_decode($auditRisk->old_values, true);
            //         if ($oldJson['hirarc_id'] == $hirarc_id) {
            //             $auditData->push($auditRisk); // Add audit to collection
            //         }
            //     } else {
            //         // Handle other events (not 'deleted')
            //         foreach ($updatedHazardsRisks as $risk) {
            //             if ($risk->risk_id == $auditRisk->auditable_id) {
            //                 $auditData->push($auditRisk); // Add audit to collection
            //                 break; // Stop inner loop once audit is found
            //             }
            //         }
            //     }
            // }
            // $auditData = $auditData->sortBy('created_at');
    public function backToTitlePage(string $tpage_id){
        $titlePage = TitlePage::find($tpage_id);
    
        // Pass data as an associative array to the view
        return view('supervisor.edit-hirarc-titlepage', [
            'titlePage' => $titlePage
        ]);
    }
    
    public function backToHazardFromRisk($hirarc_id)
    {
        $existingHazards = Hazard::where('hirarc_id', $hirarc_id)->get();
        $auditData = collect(); // Use a Collection to store multiple audit records
        
        $all = Audit::where('auditable_type', 'App\Models\Hazard')->get();
        
        foreach ($all as $auditHazard) {
            if ($auditHazard->event == 'deleted') {
                // Handle deleted audits
                $oldJson = is_array($auditHazard->old_values) ? $auditHazard->old_values : json_decode($auditHazard->old_values, true);
                if ($oldJson['hirarc_id'] == $hirarc_id) {
                    $auditData->push($auditHazard); // Add audit to the collection
                }
            } else {
                // Handle other events (not 'deleted')
                foreach ($existingHazards as $hazard) {
                    if ($hazard->hazard_id == $auditHazard->auditable_id) {
                        $auditData->push($auditHazard); // Add audit to the collection
                        break; // Stop inner loop once audit is found
                    }
                }
            }
        }
        // Pass both $existingHazards and $auditData to the view
        if ($existingHazards->isNotEmpty()) {
            return view('supervisor.edit-hirarc-hazard')
                ->with('existingHazards', $existingHazards)
                ->with('auditData', $auditData);
        } else {
            return view('supervisor.hirarc-form')->with('hirarc_id', $hirarc_id);
        }
    }
    

    public function backToRiskFromControl($hirarc_id){
        // Retrieve all hazard details for the updated hirarc_id
        $updatedHazards = Hazard::where('hirarc_id', $hirarc_id)->get();
        $updatedHazardsRisks = Risks::where('hirarc_id', $hirarc_id)->get();
        // Create an associative array to hold both collections
        $auditData = collect(); // store auditData
        
        $all = Audit::where('auditable_type', 'App\Models\Risks')->get();
        
        foreach ($all as $auditRisk) {
            if ($auditRisk->event == 'deleted') {
                // Handle deleted audits
                $oldJson = is_array($auditRisk->old_values) ? $auditRisk->old_values : json_decode($auditRisk->old_values, true);
                if ($oldJson['hirarc_id'] == $hirarc_id) {
                    $auditData->push($auditRisk); // Add audit to collection
                }
            } else {
                // Handle other events (not 'deleted')
                foreach ($updatedHazardsRisks as $risk) {
                    if ($risk->risk_id == $auditRisk->auditable_id) {
                        $auditData->push($auditRisk); // Add audit to collection
                        break; // Stop inner loop once audit is found
                    }
                }
            }
        }
        $auditData = $auditData->sortBy('created_at');
        $hazardWithRisks = [
            'updatedHazards' => $updatedHazards,
            'updatedHazardsRisks' => $updatedHazardsRisks
        ];
        // dd($hazardWithRisks);
        return view('supervisor.edit-hirarc-risk')
                ->with('hazard_data', $hazardWithRisks)
                ->with('auditData', $auditData);
    }
    private function chunkDataWithDetails($data, $titlePage, $hirarc, $chunkSize)
    {
        $chunkedData = $data->chunk($chunkSize);

        // Iterate over each chunk and assign additional details
        $chunkedData = $chunkedData->map(function ($chunk) use ($titlePage, $hirarc) {
            return $chunk->map(function ($item) use ($titlePage, $hirarc) {
                // Assign titlePage and hirarc details to each item in the chunk
                $item->titlePage = $titlePage;
                $item->hirarc = $hirarc;
                return $item;
            });
        });

        return $chunkedData;
    }
    public function generatePDF($hirarc_id)
    {
        $hirarcReport = HirarcReport::where('hirarc_id', $hirarc_id)->first();
    
        if ($hirarcReport) {
            $titlePage = TitlePage::find($hirarcReport->tpage_id);
            if(!isset($titlePage)){
                return redirect()->back()->with('error', 'Data Not Complete!');
            }elseif(isset($titlePage)){
                if(!isset($titlePage->verified_by)){
                    return redirect()->back()->with('error', 'Need to verify!');
                }else if(!isset($titlePage->approved_by)){
                    return redirect()->back()->with('error', 'Need approval!');
                }
            }
            $hirarc = Hirarc::find($hirarc_id);
            $hazards = Hazard::where('hirarc_id', $hirarc_id)->get(); // Use get() to retrieve all hazards
            $data = [];
            $risks = Risks::where('hirarc_id', $hirarc_id)->get();
            $controls = Control::where('hirarc_id', $hirarc_id)->get();
            // Loop through each hazard to generate corresponding risks and controls
            // Combine hazards, risks, and controls into a single array of data
            $combinedData = [];
            $counter = 0;

    foreach ($hazards as $hazard) {
        // Ensure index is within bounds of risks and controls arrays
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

    // Split the combined data into chunks of at most 3 items each
    $data = array_chunk($combinedData, 3);
    // dd($dataChunks);
    // Pass the data chunks to the view
        // Pass the data chunks to the view
        // return view('supervisor.hirarc-report')->with('data', $data);

        $view = view('supervisor.hirarc-report', compact('data'));

        // Generate PDF using DomPDF
        $pdf = PDF::loadHTML($view);
        $pdf->setPaper('a4', 'landscape');
        // Stream the PDF content to the browser for download
        return $pdf->download('hirarcreport_' . $hirarc_id . '.pdf');
            // Generate PDF using DomPDF

        } else {
            // Handle case where HirarcReport is not found
            // Redirect or return response as needed
            return redirect()->back()->with('error', 'Hirarc Report not found.');
        }
    }

}