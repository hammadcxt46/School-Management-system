<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolExpense extends Model
{
    use HasFactory;
    protected $table = 'school_expenses';

    protected $fillable = [
        'description',
        'amount',
        'added_by',
    ];

    public function user()
    {
       return $this->belongsTo(User::class, 'added_by'); 
    }
}
