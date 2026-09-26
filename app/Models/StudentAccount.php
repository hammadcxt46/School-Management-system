<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAccount extends Model
{
    /*** the main ledger ***/
    use HasFactory;
    protected $table = 'student_accounts';
    protected $fillable = [
        'student_id',
        'debit',
        'credit',
        'balance',
        'description',
        'created_by',
        'stream_id',
    ];

    public function student(){
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }
    
    public function feepayment(){
     return $this->hasMany(FeePayment::class);   
    }

    public function stream(){
        return $this->belongsTo(Stream::class, 'stream_id', 'id');
    }
}
