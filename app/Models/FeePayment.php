<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeePayment extends Model
{
    /*** ledger entries of payments ***/
    use HasFactory;
    protected $table = 'fee_payments';
    protected $fillable =
    [
        'student_id',
        'guardian_name',
        'payment_date',
        'amount',
        'feestypes_id',
        'paymentmode_id',
        'added_by',
        'is_correction',
    ];

    public function student(){
        return $this->belongsTo(Student::class);
    }

    public function studentaccount(){
     return $this->belongsTo(StudentAccount::class);
    }

    public function feestypes(){
        return $this->belongsTo(Feestype::class);
    }

    public function paymentmode( ){
        return $this-> belongsTo(PaymentMode::class);
    }

    public function users(){
        return $this->belongsTo(User::class, 'added_by', 'id');
    }

    public function receipt(){
        return $this->hasOne(Receipt::class, 'feepayment_id');
    }

    protected static function booted()
    {
        static::deleting(function ($payment) {
            // delete related receipt first to avoid FK constraint errors
            if ($payment->receipt) {
                $payment->receipt->delete();
            }
        });
    }
}
