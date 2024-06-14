<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Risks extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $table = 'risk_assesment_tbl';
    protected $primaryKey = 'risk_id';
    public function hazard()
    {
        return $this->belongsTo(Hazard::class, 'hazard_id');
    }
    protected $auditInclude = [
        'hirarc_id',
        'risk_desc',
        'current_control',
        'likelihood',
        'severity',
        'score',
        'index',
        'hazard_id',
    ];
}
