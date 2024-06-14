<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InjuredPerson extends Model
{
    protected $fillable = [
        'incident_id', 
        'injured_name', 
        'injured_ic', 
        'injured_nationality', 
        'injured_company', 
        'injured_trades', 
        'total_lost_days', 
        'incident_type'
    ];
    
    use HasFactory;
}
