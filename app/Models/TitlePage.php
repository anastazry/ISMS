<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TitlePage extends Model
{
    use HasFactory;
    protected $table = 'titlepage_tbl';
    protected $primaryKey = 'tpage_id';

    public function user(){
        return $this->belongsTo(User::class);
    }
}
