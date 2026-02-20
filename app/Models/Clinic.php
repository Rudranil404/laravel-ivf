<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    use HasFactory;

    protected $guarded = []; // Allows all fields to be mass-assigned securely

    /**
     * Get the organization (group) that owns this clinic/branch.
     */
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Get the users associated with this specific clinic/branch.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the secondary branches associated with this clinic.
     */
    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    /**
     * Get all of the clinic's contacts using polymorphic relationships.
     */
    public function contacts()
    {
        return $this->morphMany(Contact::class, 'contactable');
    }

    /**
     * Automatically delete associated Users when a Clinic/Branch is deleted
     */
    protected static function booted()
    {
        static::deleting(function ($clinic) {
            // Delete associated user login accounts
            $clinic->users()->delete();
            
            // Delete associated polymorphic contacts
            $clinic->contacts()->delete(); 
        });
    }
}