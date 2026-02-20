<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $guarded = [];

    public function clinics()
    {
        return $this->hasMany(Clinic::class);
    }

    public function mainBranch()
    {
        return $this->hasOne(Clinic::class)->where('is_main_branch', true);
    }

    // Automatically delete associated clinics to trigger their delete events
    protected static function booted()
    {
        static::deleting(function ($org) {
            $org->clinics->each->delete();
        });
    }
}