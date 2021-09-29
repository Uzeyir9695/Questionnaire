<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function addresses() 
    {
        return $this->hasMany(Address::class);
    }

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function education() 
    {
        return $this->hasMany(Education::class);
    }

    public function jobs() 
    {
        return $this->hasMany(Job::class);
    }
}
