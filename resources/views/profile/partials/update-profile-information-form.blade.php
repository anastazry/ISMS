<section>
    <style>

    
        /* Hover effect for the button */
        #saveSignatureBtn{
            background-color: green;
        }
        #saveSignatureBtn:hover {
            background-color: #45a049; /* Darker green on hover */
        }
    </style>
    
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')
        
        <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="user_avatar">Upload file</label>
                <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" 
                id="profile_photo" type="file" name="profile_photo" accept="image/*">
                <div class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="user_avatar_help">A profile picture is useful to confirm your are logged into your account</div>
              {{-- </form>
            <label for="profile_photo">Profile Image</label>
            <input type="file" id="profile_photo" name="profile_photo" accept="image/*"> --}}
        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>
        {{-- user edit phone number --}}
        <div>
            <x-input-label for="phone_no" :value="__('Phone Number')" />
            <x-text-input id="phone_no" name="phone_no" type="text" class="mt-1 block w-full" :value="old('phone_no', $user->phone_no)" required autofocus autocomplete="phone_no" />
            <x-input-error class="mt-2" :messages="$errors->get('phone_no')" />
        </div>
        {{-- user insert signature --}}
        <div>
            <x-input-label for="Signature" :value="__('Signature')" />
            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" 
            id="user_signature" type="file" name="user_signature" accept="image/*">
            <div style="margin-top: 10px">
            <x-input-label for="Signature" :value="__('Current Signature')" />

                <div id="signature-pad" class="signature-pad">
                    <div class="signature-pad-footer" style="text-align: right">
                        <button type="button" id="clear-signature" class="btn btn-danger">Clear</button>
                    </div>
                </div> 
                <div class="canvas-container">
                    @if(isset($user->user_signature))
                        <img src="{{ asset($user->user_signature) }}" alt="User Signature">
                    @endif
                
                
                    <canvas id="signatureCanvas" class="border border-black" width=400 height=200></canvas>
                </div>

                <input type="text" name="user_signature_64" id="user_signature_64" value="" style="display: none">

                {{-- <div class="button-container"> --}}
                    <div style="display: flex; justify-content:center; margin-right: 200px">
                        <button id="saveSignatureBtn" class="btn btn-primary" style="width: 40px; height: 40px; padding: 0;">
                            <img src="{{ asset('images/icons/saveButton.png') }}" style="width: 100%; height: 100%; object-fit: contain; margin-right: 10px;">
                        </button>
                    </div>

                {{-- </div> --}}
            </div>
            <div class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="user_avatar_help">A signature picture is useful</div>

    </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var canvas = document.getElementById('signatureCanvas');
    var signaturePad = new SignaturePad(canvas);
    var saveButton = document.getElementById('saveSignatureBtn');
    var cancelButton = document.getElementById('clear-signature');
    var signatureInputField = document.getElementById('user_signature');
    var signatureInputFieldHidden = document.getElementById('user_signature_64');


    saveButton.addEventListener('click', function(event) {
        event.preventDefault();

        if (!signaturePad.isEmpty()) {
            // Get base64 data URL of the signature image
            var dataURL = signaturePad.toDataURL('image/png');
            var dataURLHidden = signaturePad.toDataURL();

            // Convert base64 to Blob
            var blob = base64ToBlob(dataURL);

            // Create a File object from the Blob
            var file = new File([blob], 'signature.png', { type: 'image/png' });

            // Create a FileList containing the File object
            var fileList = new DataTransfer();
            fileList.items.add(file);

            // Assign the FileList to the files property of the file input
            signatureInputField.files = fileList.files;
            signatureInputFieldHidden.value = dataURLHidden;


            console.log('Signature data URL:', dataURLHidden);
            alert('Signature saved successfully!');
        } else {
            alert('Please provide a signature before saving.');
        }
    });

    cancelButton.addEventListener('click', function(event) {
        signaturePad.clear();
        // Clear the value of the file input when cancelling
        signatureInputField.value = '';
    });

    function base64ToBlob(base64Data) {
        var parts = base64Data.split(';base64,');
        var contentType = parts[0].split(':')[1];
        var raw = window.atob(parts[1]);
        var rawLength = raw.length;
        var uInt8Array = new Uint8Array(rawLength);

        for (var i = 0; i < rawLength; ++i) {
            uInt8Array[i] = raw.charCodeAt(i);
        }

        return new Blob([uInt8Array], { type: contentType });
    }
});

</script>
