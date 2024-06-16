<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

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
        
        // Generate a random file name for the image
        $fileName = Str::random(40) . '.' . $image->getClientOriginalExtension();
        $folderName = 'profile_photos/' . $user->id;
        
        // Specify the storage path where the image will be saved
        $storagePath = 'public/' . $folderName;
        $fullPath = $storagePath . '/' . $fileName;

        // Ensure that the storage directories exist, create them if not
        if (!Storage::exists($storagePath)) {
            Storage::makeDirectory($storagePath);
        }
        
        // Delete any existing files in the storage path
        $files = Storage::allFiles($storagePath);
        Storage::delete($files);
        
        // Store the new image file in the specified storage path
        $path = $image->storeAs($folderName, $fileName, 'public');
        
        // Extract only the file name from the path
        $fileNameOnly = pathinfo($path, PATHINFO_BASENAME);
        $storagePathUrlVerified = Storage::url($fullPath);
        
        // Save only the file name in the database
        $user->profile_photo = $storagePathUrlVerified;
    }

    if ($request->has('user_signature_64')) {
        $base64ImageVerified = $request->input('user_signature_64');
        
        // Remove the data URL prefix (e.g., 'data:image/png;base64,')
        $base64ImageVerified = str_replace('data:image/png;base64,', '', $base64ImageVerified);
        
        // Decode the base64-encoded image data
        $imageDataVerified = base64_decode($base64ImageVerified);
        
        // Generate a random file name for the image
        $fileNameVerified = Str::random(40) . '.png';
        $folderName = 'signature_verifiedby' . $user->id;
        
        // Specify the storage paths where the images will be saved
        $storagePathVerified = 'public/signatures/usersignature/' . $folderName;
        $fullPathVerified = $storagePathVerified . '/' . $fileNameVerified;
        
        // Ensure that the storage directories exist, create them if not
        if (!Storage::exists($storagePathVerified)) {
            Storage::makeDirectory($storagePathVerified);
        }
        
        // Delete any existing files in the storage path
        $files = Storage::allFiles($storagePathVerified);
        Storage::delete($files);
        
        // Store the new image file in the specified storage path
        Storage::put($fullPathVerified, $imageDataVerified);
        
        // Get the URL of the saved image file
        $fileUrlVerified = Storage::url($fullPathVerified);
        
        // Update the user's signature path in the database
        $user->user_signature = $fileUrlVerified;
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
