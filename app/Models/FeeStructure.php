<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeStructure extends Model
{
    use HasFactory;
    protected $table = 'fee_structures';

    protected $fillable = [
        'stream_id',
        'term',
        'amount',
        'added_by',
    ];

       protected static function booted(): void
    {
        static::deleting(function (FeeStructure $feeStructure) {
            \Illuminate\Support\Facades\DB::transaction(function () use ($feeStructure) {
                $amountToReverse = (float) $feeStructure->amount;
                $stdAccounts = StudentAccount::where('stream_id', $feeStructure->stream_id)->get();

                foreach ($stdAccounts as $stdAccount) {
                    $stdAccount->balance = $stdAccount->balance + $amountToReverse;
                    $stdAccount->debit = $stdAccount->debit + $amountToReverse;
                    $stdAccount->save();
                }
            });
        });
    }

    public function stream(){
        return $this->belongsTo(Stream::class);
    }

    public function user(){
        return $this->belongsTo(User::class, 'added_by');
    }

}
