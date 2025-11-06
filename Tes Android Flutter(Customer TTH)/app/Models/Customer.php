<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customer';
    protected $primaryKey = 'CustID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    
    protected $fillable = [
        'CustID',
        'Name',
        'Address',
        'BranchCode',
        'PhoneNo'
    ];

    /**
     * Get all TTH for this customer
     */
    public function tths()
    {
        return $this->hasMany(CustomerTTH::class, 'CustID', 'CustID');
    }

    /**
     * Get the branch configuration
     */
    public function branch()
    {
        return $this->belongsTo(MobileConfig::class, 'BranchCode', 'BranchCode');
    }

    /**
     * Get active TTH count
     */
    public function getActiveTthCountAttribute()
    {
        return $this->tths()->where('Received', 1)->count();
    }
}