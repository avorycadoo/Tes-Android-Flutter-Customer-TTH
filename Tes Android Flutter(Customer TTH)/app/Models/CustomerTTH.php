<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerTTH extends Model
{
    use HasFactory;

    protected $table = 'customertth';
    protected $primaryKey = 'TTHNo';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    
    protected $fillable = [
        'TTHNo',
        'SalesID',
        'TTOTTPNo',
        'CustID',
        'DocDate',
        'Received',
        'ReceivedDate',
        'FailedReason'
    ];

    protected $casts = [
        'DocDate' => 'datetime',
        'ReceivedDate' => 'datetime',
        'Received' => 'integer'
    ];

    /**
     * Get the customer that owns the TTH
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'CustID', 'CustID');
    }

    /**
     * Get all details for this TTH
     */
    public function details()
    {
        return $this->hasMany(CustomerTTHDetail::class, 'TTHNo', 'TTHNo');
    }

    /**
     * Get formatted status
     */
    public function getStatusBadgeAttribute()
    {
        if ($this->Received == 1) {
            return '<span class="badge bg-success"><i class="fas fa-check-circle"></i> Diterima</span>';
        } else {
            return '<span class="badge bg-warning"><i class="fas fa-clock"></i> Belum Diterima</span>';
        }
    }

    /**
     * Get formatted date
     */
    public function getFormattedDocDateAttribute()
    {
        return $this->DocDate ? $this->DocDate->format('d M Y') : '-';
    }

    /**
     * Get formatted received date
     */
    public function getFormattedReceivedDateAttribute()
    {
        return $this->ReceivedDate && $this->ReceivedDate->format('Y') != '0000' 
            ? $this->ReceivedDate->format('d M Y H:i') 
            : '-';
    }
}