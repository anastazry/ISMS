<?php

namespace App\Http\Controllers;

use App\Models\Risks;
use App\Models\Hazard;
use App\Models\Hirarc;
use App\Models\Control;
use App\Models\TitlePage;
use App\Models\HirarcReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UpperManagementController extends Controller
{
    public function getManagementApprovalList(){
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
        $breadcrumb1 ="HIRARC Approval";
        $headings = "HIRARC Approval";
        return view('supervisor.form-approval.form-approval', [
            'hirarcItems' => $hirarcItems,
            'breadcrumb1' => $breadcrumb1,
            'headings' => $headings,
        ]);
        // return view('supervisor.hirarc-list');
    }

    public function approveHirarcForm($hirarc_id){
        $breadcrumb1 ="HIRARC Approval/Verification";
        $breadcrumb2 ="HIRARC Approval";
        $headings = "HIRARC Approval";
        $hirarcReport = $hirarcReport = HirarcReport::where('hirarc_id', $hirarc_id)->first();
        if($hirarcReport){
            $titlePage = TitlePage::where('tpage_id', $hirarcReport->tpage_id)->first();
            return view('supervisor.form-approval.approve-hirarc-form', compact('titlePage', 'hirarc_id', 'breadcrumb1', 'breadcrumb2','headings'));
        }else{
            return view('supervisor.form-approval.approve-hirarc-form', compact('hirarc_id','breadcrumb1', 'breadcrumb2','headings'));

        }
    }

    public function verifyHirarcForm($hirarc_id){
        $hirarcReport = $hirarcReport = HirarcReport::where('hirarc_id', $hirarc_id)->first();
        if($hirarcReport){
            $titlePage = TitlePage::where('tpage_id', $hirarcReport->tpage_id)->first();
            return view('supervisor.form-approval.verify-hirarc-form', compact('titlePage', 'hirarc_id'));
        }else{
            return view('supervisor.form-approval.verify-hirarc-form', compact('hirarc_id'));

        }
    }

    public function postAddApprovalDetails(Request $request){
        $userId = auth()->user()->id;

        // dd($request);
        $base64ImageApproved = $request->input('approved_by_signature');
        $expectedPrefix = 'data:image/png;base64,';

        if (strpos($base64ImageApproved, $expectedPrefix) === 0) {
            // Remove the data URL prefix (e.g., 'data:image/png;base64,')
            $base64ImageApproved = str_replace('data:image/png;base64,', '', $base64ImageApproved);
            
            // Decode the base64-encoded image data
            $imageDataApproved = base64_decode($base64ImageApproved);
            
            // Generate unique file names for the images (e.g., using timestamp)
            $fileNameApproved = 'signature_approvedby' . time() . '.png';
            
            // Specify the storage paths where the images will be saved
            $storagePathApproved = 'public/signatures/approvedby';
            
            // Ensure that the storage directories exist, create them if not
            
            if (!Storage::exists($storagePathApproved)) {
                Storage::makeDirectory($storagePathApproved);
            }
            
            // Store the image files in the specified storage paths
            Storage::put($storagePathApproved . '/' . $fileNameApproved, $imageDataApproved);
            
            // Get the full paths of the saved image files
            $filePathApproved = Storage::url($storagePathApproved . '/' . $fileNameApproved);
        } else {
            $filePathApproved = $request->input('approved_by_signature');
        }
        
        $hirarc_id = $request['hirarc_id'];
        $hirarcReport = HirarcReport::where('hirarc_id', $hirarc_id)->first();

        if($hirarcReport){
            // dd('camam');
            $titlePage = TitlePage::where('tpage_id', $hirarcReport->tpage_id)->first();
            if($titlePage){
                $titlePage->appr_signature_img = $filePathApproved;
                $titlePage->approval_date = $request['approval_date'];
                $titlePage->approved_by = $request['approved_by'];
                $titlePage->user_id = $userId;
                $titlePage->save();
                $hirarcReport->tpage_id = $titlePage->tpage_id;
                $hirarcReport->save();


            }else{
                $titlePage = new TitlePage();
                if($request->input('approved_by_signature')){

                }
                $titlePage->appr_signature_img = $filePathApproved;
                $titlePage->approval_date = $request['approval_date'];
                $titlePage->approved_by = $request['approved_by'];
                $titlePage->user_id = $userId;
                $titlePage->save();
                $hirarcReport->tpage_id = $titlePage->tpage_id;
                $hirarcReport->save();

            }
        }else{
            // dd('takda');
            $hirarcReport = new HirarcReport();
            $titlePage = new TitlePage();
            $titlePage->appr_signature_img = $filePathApproved;
            $titlePage->approval_date = $request['approval_date'];
            $titlePage->approved_by = $request['approved_by'];
            $titlePage->user_id = $userId;
            $titlePage->save();
            $hirarcReport->tpage_id = $titlePage->tpage_id;
            $hirarcReport->save();

        }
        return redirect()->route('user.management-approval-list');
    }

    public function postAddVerificationDetails(Request $request){
        $userId = auth()->user()->id;

        // dd($request);
        $base64ImageApproved = $request->input('ver_signature_image');
        $expectedPrefix = 'data:image/png;base64,';

        if (strpos($base64ImageApproved, $expectedPrefix) === 0) {
            // Remove the data URL prefix (e.g., 'data:image/png;base64,')
            $base64ImageApproved = str_replace('data:image/png;base64,', '', $base64ImageApproved);
            
            // Decode the base64-encoded image data
            $imageDataApproved = base64_decode($base64ImageApproved);
            
            // Generate unique file names for the images (e.g., using timestamp)
            $fileNameApproved = 'signature_verifiedby' . time() . '.png';
            
            // Specify the storage paths where the images will be saved
            $storagePathApproved = 'public/signatures/verifiedby';
            
            // Ensure that the storage directories exist, create them if not
            
            if (!Storage::exists($storagePathApproved)) {
                Storage::makeDirectory($storagePathApproved);
            }
            
            // Store the image files in the specified storage paths
            Storage::put($storagePathApproved . '/' . $fileNameApproved, $imageDataApproved);
            
            // Get the full paths of the saved image files
            $filePathApproved = Storage::url($storagePathApproved . '/' . $fileNameApproved);
        } else {
            $filePathApproved = $request->input('ver_signature_image');
        }
        
        $hirarc_id = $request['hirarc_id'];
        $hirarcReport = HirarcReport::where('hirarc_id', $hirarc_id)->first();

        if($hirarcReport){
            // dd('camam');
            $titlePage = TitlePage::where('tpage_id', $hirarcReport->tpage_id)->first();
            if($titlePage){
                $titlePage->ver_signature_image = $filePathApproved;
                $titlePage->verification_date = $request['verification_date'];
                $titlePage->verified_by = $request['verified_by'];
                $titlePage->user_id = $userId;
                $titlePage->save();
                $hirarcReport->tpage_id = $titlePage->tpage_id;
                $hirarcReport->save();


            }else{
                $titlePage = new TitlePage();
                $titlePage->ver_signature_image = $filePathApproved;
                $titlePage->verification_date = $request['verification_date'];
                $titlePage->verified_by = $request['verified_by'];
                $titlePage->user_id = $userId;
                $titlePage->save();
                $hirarcReport->tpage_id = $titlePage->tpage_id;
                $hirarcReport->save();

            }
        }else{
            // dd('takda');
            $hirarcReport = new HirarcReport();
            $titlePage = new TitlePage();
            $titlePage->ver_signature_image = $filePathApproved;
            $titlePage->verification_date = $request['verification_date'];
            $titlePage->verified_by = $request['verified_by'];
            $titlePage->user_id = $userId;
            $titlePage->save();
            $hirarcReport->tpage_id = $titlePage->tpage_id;
            $hirarcReport->save();

        }
        return redirect()->route('user.management-approval-list');
    }
}
