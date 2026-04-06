<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'tanggal_penawaran',
        'nomor_penawaran',
        'nilai_penawaran',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_penawaran' => 'date',
        'nilai_penawaran' => 'decimal:2',
    ];

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }
}