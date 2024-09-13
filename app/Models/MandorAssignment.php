<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MandorAssignment extends Model
{
    protected $table = 'table_mandor_assignment_tbl';
    use HasFactory;

    protected $fillable = [
        'peringkat', 
        'blok', 
        'n_lot', 
        'n_p_tuai', 
        'mandor_id', 
        'k_penuai', 
        'status'
    ];

    // Define the relationship with the User model
    public function mandor()
    {
        return $this->belongsTo(User::class, 'mandor_id');
    }
}
