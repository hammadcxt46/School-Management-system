<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolAccount extends Model
{
    use HasFactory;
    protected $table = 'school_accounts';
    protected $fillable = [
        'name',
        'income',
        'expenses',
        'balance',
    ];
}
