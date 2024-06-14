<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
class Hirarc extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    protected $table = 'hirarc_tbl';
    protected $primaryKey = 'hirarc_id';
    protected $auditInclude = [
        'hirarc_id',
        'desc_job',
        'location',
        'prepared_by',
        'created_at',
        'updated_at',
        'inspection_date',
        'prepared_by_signature',
    ];



}
