<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\MandorAssignment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AdminController extends Controller
{
    public function getAssignmentList(){
        $assignments = MandorAssignment::all();
        // dd($assignments);
        return view('admin.assignment-list', compact('assignments'));
    }

    public function createQR(){
        $users = User::all();
        $breadcrumb1 = "Manage Users";
        $headings = "Manage Users";
        return view('admin.create-qr', compact('users','breadcrumb1', 'headings'));
    }

    public function getAllUserList(){
        $users = User::all();
        $breadcrumb1 = "Manage Users";
        $headings = "Manage Users";
        return view('admin.users-list', compact('users','breadcrumb1', 'headings'));
    }
    public function returnRegisterNewUserPage(){
        return view('admin.create-newuser');
    }
    public function registerUser(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'worker_id' => 'required|string|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'phone_no' => 'required|string|max:20|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|max:255'
            // Add other validation rules as needed
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'worker_id' => $request->worker_id,
            'phone_no' => $request->phone_no,
            'role' => $request->role,
            'username' => $request->username,  // Fix this line
            'password' => Hash::make($request->password),
        ]);
        $user->save();
        // dd ($user);
        return view('admin.dashboard-admin');

        return redirect()->route('admin.create-newuser')->with('message', 'User registered successfully');
    }

    public function getEditUserAccountForm($id){
        $user = User::find($id);
        return view('admin.edit-user-account', compact('user'));
    }

    public function resetUserPassword($id)  //reset user password
    {
        $user = User::findOrFail($id);

        // Generate a random password
        $newPassword = Str::random(8);

        // Update the user's password
        $user->password = Hash::make($newPassword);
        $user->first_time_status = 1;
        $user->save();

        // Redirect back with success message
        return redirect()->back()->with('message', 'Password reset successfully. New password: ' . $newPassword);
    }

    public function deleteUser($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();

            // Redirect back with a success message
            return redirect()->back()->with('message', 'User deleted successfully.');
        }

        // Redirect back with an error message if the user is not found
        return redirect()->back()->with('error', 'User not found.');
    }
    public function disableUser($id)
    {
        $user = User::find($id);
        $adminUser = Auth::user();

        if ($user && $adminUser != $user) {
            $user->accessToken = ($user->accessToken == 1) ? 0 : 1;
            $user->save();
            $message = ($user->accessToken == 0) ? 'User disabled successfully.' : 'User enabled successfully.';
            return redirect()->back()->with('message', $message);
        } else if ($adminUser == $user) {
            return redirect()->back()->with('error', 'Error! Cannot disable own account!');
        }

        // Redirect back with an error message if the user is not found.
        return redirect()->back()->with('error', 'User not found.');
    }
    public function assignTaskToMandor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'peringkat' => 'required|string',
            'blok' => 'required|string',
            'n_lot' => 'required|string',
            'n_p_tuai' => 'required|string',
            'mandor_id' => 'required|exists:users,id',
            'k_penuai' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            // Dump the failed validation messages (optional for debugging)
            dd($validator->errors()->all()); // Shows all error messages
            
            // Return back with errors if validation fails
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Get the validated data and add the default 'status' value
        $validatedData = $validator->validated();
        $validatedData['status'] = 'Pending'; // Add 'status' with a value of 'pending'

        // // Use the modified data to create the record
        $mandorAssignment = MandorAssignment::create($validatedData);
        // // Generate the URL that includes the id
        // $url = route('another_form', ['id' => $mandorAssignment->id]);

        // // Generate the QR code
        // $qrCode = QrCode::size(200)->generate($url);
        
        return redirect()->route('dashboard');
    }

}
        // Validate and create the assignment
        // dd($request);
        // $data = $request->validate([
        //     'peringkat' => 'required|string',
        //     'blok' => 'required|string',
        //     'n_lot' => 'required|string',
        //     'n_p_tuai' => 'required|string',
        //     'mandor_id' => 'required|exists:users,id',
        //     'k_penuai' => 'required|string',
        //     'status' => 'required|string'
        // ]);
        // dd($data);

        // dd();
