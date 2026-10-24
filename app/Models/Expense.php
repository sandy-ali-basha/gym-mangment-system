<?php

namespace App\Models;

use Database\Factories\ExpenseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    /** @use HasFactory<ExpenseFactory> */
    use HasFactory;

    protected $fillable = ['category', 'description', 'amount', 'incurred_at', 'payment_method', 'vendor', 'receipt_path', 'recorded_by'];

    protected function casts(): array
    {
        return ['amount' => 'decimal:2', 'incurred_at' => 'date'];
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
