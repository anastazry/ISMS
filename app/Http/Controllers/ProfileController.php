<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $user = $request->user();

    // Handle profile photo upload
    if ($request->hasFile('profile_photo')) {
        $image = $request->file('profile_photo');
        $filename = 'profile-' . $user->id . '.' . $image->getClientOriginalExtension();
    
        // Store the file and get the path
        $path = $image->storeAs('profile_photos', $filename, 'public');
    
        // Extract only the file name from the path
        $fileNameOnly = pathinfo($path, PATHINFO_BASENAME);
    
        // Save only the file name in the database
        $user->profile_photo = $fileNameOnly;
    }

    if ($request->hasFile('user_signature')) {
        $base64ImageVerified = $request->input('user_signature_64');
        
        // Remove the data URL prefix (e.g., 'data:image/png;base64,')
        $base64ImageVerified = str_replace('data:image/png;base64,', '', $base64ImageVerified);
        
        // Decode the base64-encoded image data
        $imageDataVerified = base64_decode($base64ImageVerified);
        
        // Generate unique file names for the images (e.g., using timestamp)
        $fileNameVerified = 'signature_verifiedby' . $user->id . '.png';
        
        // Specify the storage paths where the images will be saved
        $storagePathVerified = 'public/signatures/usersignature';
        
        // Ensure that the storage directories exist, create them if not
        if (!Storage::exists($storagePathVerified)) {
            Storage::makeDirectory($storagePathVerified);
        }
        

        
        // Store the image files in the specified storage paths
        Storage::put($storagePathVerified . '/' . $fileNameVerified, $imageDataVerified);
        
        // Get the full paths of the saved image files
        $filePathVerified = Storage::url($storagePathVerified . '/' . $fileNameVerified);
        
        // Optionally, return or use the file paths as needed
        // dd('Verified Signature Path:', asset($filePathVerified), 'Approved Signature Path:', asset($filePathApproved));
        
        // Assign the public file path (URL) to $incident->firstImage
        // $titlePage->ver_signature_image = asset($publicFilePath);
        // dd($publicFilePath);
        $user->user_signature = $filePathVerified;
    }
    

    // Fill other fields and save
    $user->fill($request->validated());

    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }
    $user->save();

    return Redirect::route('profile.edit')->with('status', 'profile-updated');
}

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
