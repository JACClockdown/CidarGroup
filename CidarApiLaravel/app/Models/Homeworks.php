<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homeworks extends Model
{
    use HasFactory;

    protected $table = 'homeworks';

    protected $fillable = [
        'title',
        'description',
        'qualification',
        'student_id'
    ];

    public function student(){
        return $this->belongsTo(Students::class, 'student_id');
    }
    
}
