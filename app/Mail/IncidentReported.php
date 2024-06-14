<?php

namespace App\Mail;

use App\Models\Incident;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class IncidentReported extends Mailable
{
    use Queueable, SerializesModels;

    public $incident;
    protected $firstImagePath;

    public function __construct(Incident $incident, $firstImagePath = null)
    {
        $this->incident = $incident;
        if($this->incident->incident_image){
            $folderName = $this->incident->incident_image;
    
            // Get all files in the folder
            $files = Storage::disk('public')->files($folderName);
            // Assign the first image and all images to the incident object
            $firstImagePath = count($files) > 0 ? $files[0] : null;
            $this->firstImagePath = $firstImagePath;
        }
        
    }
    

    public function build()
    {
        return $this->view('emails.incidentReported')
                    ->with([
                        'firstImagePath' => $this->firstImagePath
                    ]);
    }
}

