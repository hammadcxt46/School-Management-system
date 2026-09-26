<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $table='students';

    protected $fillable=[
        'name',
        'gender',
        'admission_number',
        'guardian_phone',
        'guardian_name',
        'stream_id',
        'added_by',
    ];

    public function stream() 
    {
        return $this->belongsTo(Stream::class);
    }

    public function user(){
        return $this->belongsTo(User::class, 'added_by');
    }

    public function feepayment(){
     return $this->hasMany(FeePayment::class);   
    }

    public function receipt(){
        return $this->hasMany(Receipt::class);   
    }
    
    public function studentaccount(){
     return $this->hasOne(StudentAccount::class);   
    }

    protected static function booted()
    {
        static::deleting(function ($student) {
            // delete receipts for this student
            $student->receipt()->get()->each->delete();

            // delete fee payments (they will delete their receipts in their own deleting handler)
            $student->feepayment()->get()->each->delete();

            // delete student account if exists
            if ($student->studentaccount) {
                $student->studentaccount->delete();
            }
        });
    }
}
