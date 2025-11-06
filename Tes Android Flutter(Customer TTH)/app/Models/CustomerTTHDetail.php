<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerTTHDetail extends Model
{
    use HasFactory;

    protected $table = 'customertthdetail';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    
    protected $fillable = [
        'TTHNo',
        'TTOTTPNo',
        'Jenis',
        'Qty',
        'Unit'
    ];

    protected $casts = [
        'Qty' => 'integer'
    ];

    /**
     * Get the TTH that owns this detail
     */
    public function tth()
    {
        return $this->belongsTo(CustomerTTH::class, 'TTHNo', 'TTHNo');
    }

    /**
     * Boot method to auto-set Unit based on Jenis
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->setUnitAttribute();
        });

        static::updating(function ($model) {
            if ($model->isDirty('Jenis')) {
                $model->setUnitAttribute();
            }
        });
    }

    /**
     * Set Unit based on Jenis (emas = buah, voucher = lembar)
     */
    public function setUnitAttribute()
    {
        if (stripos($this->Jenis, 'emas') !== false || stripos($this->Jenis, 'Gr') !== false) {
            $this->attributes['Unit'] = 'Buah';
        } elseif (stripos($this->Jenis, 'voucher') !== false || stripos($this->Jenis, 'rb') !== false) {
            $this->attributes['Unit'] = 'Lembar';
        }
    }

    /**
     * Get formatted jenis hadiah badge
     */
    public function getJenisBadgeAttribute()
    {
        if (stripos($this->Jenis, 'Emas') !== false || stripos($this->Jenis, 'Gr') !== false) {
            return '<span class="badge bg-warning text-dark"><i class="fas fa-coins"></i> ' . $this->Jenis . '</span>';
        } elseif (stripos($this->Jenis, 'Voucher') !== false) {
            return '<span class="badge bg-info"><i class="fas fa-ticket-alt"></i> ' . $this->Jenis . '</span>';
        }
        return '<span class="badge bg-secondary">' . $this->Jenis . '</span>';
    }

    /**
     * Get formatted display
     */
    public function getDisplayAttribute()
    {
        return $this->Qty . ' ' . $this->Unit . ' - ' . $this->Jenis;
    }

    /**
     * Scope for specific TTH
     */
    public function scopeForTTH($query, $tthNo)
    {
        return $query->where('TTHNo', $tthNo);
    }
}