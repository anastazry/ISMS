<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FruitsModel extends Model
{
    protected $table = 'fruits_detaile_tbl';
    use HasFactory;

    protected $fillable = [
        'dituai', 
        'muda', 
        'busuk', 
        'kosong', 
        'panjang', 
        's_lama', 
        's_baru', 
        'images-path', 
        'location', 
        'tarikh', 
        'masa', 
        'mandor_id', 
        'assignment_id', 
    ];

    // Define the relationship with the User model
    public function users()
    {
        return $this->belongsTo(User::class, 'mandor_id');
    }
}
