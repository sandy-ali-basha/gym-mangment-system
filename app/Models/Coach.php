<?php

namespace App\Models;

use Database\Factories\CoachFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coach extends Model
{
    /** @use HasFactory<CoachFactory> */
    use HasFactory;

    protected $fillable = ['full_name', 'phone', 'email', 'salary_type', 'base_salary', 'commission_rate', 'is_active'];

    protected function casts(): array
    {
        return ['base_salary' => 'decimal:2', 'commission_rate' => 'decimal:2', 'is_active' => 'boolean'];
    }

    public function memberships(): HasMany
    {
        return $this->hasMany(Membership::class);
    }

    public function classes(): HasMany
    {
        return $this->hasMany(GymClass::class);
    }
}
