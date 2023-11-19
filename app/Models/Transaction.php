<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'amount',
        'payer_id',
        'due_on',
        'vat_amount',
        'is_vat_inclusive',
        'status',
        'total_paid_amount'
    ];

    protected $casts = [
        'is_vat_inclusive' => 'boolean',
        'amount' => 'decimal:2',
        'vat_amount' => 'decimal:2',
        'total_paid_amount' => 'decimal:2'
    ];

    /**
     * @return BelongsTo<User>
     */
    public function payer(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany<Payment>
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function getAmountWithVatAttribute()
    {
        return $this->amount + $this->vat_amount;
    }

}
