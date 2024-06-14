<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function registerUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'worker_id' => 'required|string|max:255|unique:users',
            'phone_no' => 'required|string|max:20|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|max:255'
            // Add other validation rules as needed
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'worker_id' =>$request->worker_id,
            'phone_no' => $request->phone_no,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            // Add other fields as needed
        ]);

        return redirect()->route('admin.users-list')->with('message', 'User registered successfully');
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

}
