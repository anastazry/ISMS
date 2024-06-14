<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Hazard extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    use HasFactory;
    protected $table = 'hazard_identify_tbl';
    protected $primaryKey = 'hazard_id';
    // Define relationship with Risk model with cascading delete
    public function risks()
    {
        return $this->hasMany(Risks::class, 'hazard_id');
    }

    public function controls()
    {
        return $this->hasMany(Control::class, 'hazard_id');
    }
    protected $auditInclude = [
        'hirarc_id',
        'hazard_id',
        'job_sequence',
        'hazard',
        'can_cause',
    ];

}
