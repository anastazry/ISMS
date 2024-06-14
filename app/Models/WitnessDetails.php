<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WitnessDetails extends Model
{
    protected $fillable = [
        'incident_id',
        'witness_name',
        'witness_company',
        'remarks'
    ];

    // If you have relationships, define them here
    // For example, if a witness detail belongs to an incident:
    public function incident()
    {
        return $this->belongsTo(Incident::class);
    }
    use HasFactory;
}
