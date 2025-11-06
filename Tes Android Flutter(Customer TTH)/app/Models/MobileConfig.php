<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileConfig extends Model
{
    use HasFactory;

    protected $table = 'mobileconfig';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    
    protected $fillable = [
        'BranchCode',
        'Name',
        'Description',
        'Value'
    ];

    /**
     * Get customers for this branch
     */
    public function customers()
    {
        return $this->hasMany(Customer::class, 'BranchCode', 'BranchCode');
    }

    /**
     * Scope for specific branch code
     */
    public function scopeForBranch($query, $branchCode)
    {
        return $query->where('BranchCode', $branchCode);
    }
}