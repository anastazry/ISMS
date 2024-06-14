<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class HirarcReport extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $table = 'hirarc_report_tbl';
    public function hazards()
    {
        return $this->hasMany(Hazard::class, 'hirarc_id');
    }

    public function titlePage()
    {
        return $this->hasMany(TitlePage::class, 'hirarc_id');
    }

    public function risks()
    {
        return $this->hasMany(Risks::class, 'hirarc_id');
    }
    
    public function controls()
    {
        return $this->hasMany(Control::class, 'hirarc_id');
    }

    protected $auditInclude = [
        'tpage_id',
        'hirarc_id',
    ];
}
