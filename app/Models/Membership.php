<?php

namespace App\Models;

use Database\Factories\MembershipFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Membership extends Model
{
    /** @use HasFactory<MembershipFactory> */
    use HasFactory;

    protected $fillable = ['client_id', 'membership_plan_id', 'coach_id', 'start_date', 'end_date', 'plan_price', 'discount_amount', 'final_price', 'paid_amount', 'remaining_amount', 'payment_status', 'status'];

    protected function casts(): array
    {
        return ['start_date' => 'date', 'end_date' => 'date', 'plan_price' => 'decimal:2', 'discount_amount' => 'decimal:2', 'final_price' => 'decimal:2', 'paid_amount' => 'decimal:2', 'remaining_amount' => 'decimal:2'];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(MembershipPlan::class, 'membership_plan_id');
    }

    public function coach(): BelongsTo
    {
        return $this->belongsTo(Coach::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
