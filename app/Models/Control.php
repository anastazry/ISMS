<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Control extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $table = 'control_tbl';
    protected $primaryKey = 'control_id';
    public function hazard()
    {
        return $this->belongsTo(Hazard::class, 'hazard_id');
    }
    protected $auditInclude = [
        'hazard_id',
        'opportunity',
        'new_control',
        'responsibility',
        'status',
        'hirarc_id',
    ];
}
