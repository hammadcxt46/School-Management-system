<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    //the receipt serves as the official ledger for school payments
    use HasFactory;
    protected $table='receipts';
    protected $fillable=[
        'feepayment_id',    //identify the payment that the receipt belongs to
        'student_id',       //identify the student who made the payment
        'existing_balance', //the balance before the payment
        'amount_paid',      //the amount paid
        'new_balance',      //the balance after the payment
    ];

    public function feepayment(){
        return $this->belongsTo(FeePayment::class, 'feepayment_id');
    }

    public function student(){
        return $this->belongsTo(Student::class);   
    }
}
