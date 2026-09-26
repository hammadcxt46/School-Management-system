<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stream extends Model
{
    use HasFactory;
    protected $table = 'streams';
    protected $fillable = [
        'name',
    ];


    public function student(){
        return $this->hasMany(Student::class);
    }

    public function feestructure(){
        return $this->hasMany(FeesStructure::class);
    }

    public function studentaccount(){
        return $this->hasMany(StudentAccount::class);
    }
}
