<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    protected $primaryKey = 'reportNo';

    // If 'reportNo' is not an auto-incrementing integer, set this to false
    public $incrementing = false;
    protected $dates = ['incident_date'];
    // If 'reportNo' is not an integer, you should also specify the key type
    protected $keyType = 'string';

    public function injuredPeople()
    {
        return $this->hasMany(InjuredPerson::class, 'incident_id', 'reportNo');
    }
    public function witnessDetails()
    {
        return $this->hasMany(WitnessDetails::class, 'incident_id', 'reportNo');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    use HasFactory;
}
