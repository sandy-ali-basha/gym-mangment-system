<?php

namespace App\Models;

use Database\Factories\ClassScheduleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassSchedule extends Model
{
    /** @use HasFactory<ClassScheduleFactory> */
    use HasFactory;

    protected $fillable = ['gym_class_id', 'coach_id', 'day_of_week', 'days_of_week', 'starts_at', 'ends_at', 'location'];

    protected function casts(): array
    {
        return ['days_of_week' => 'array', 'starts_at' => 'datetime:H:i', 'ends_at' => 'datetime:H:i'];
    }

    public function gymClass(): BelongsTo
    {
        return $this->belongsTo(GymClass::class);
    }

    public function coach(): BelongsTo
    {
        return $this->belongsTo(Coach::class);
    }
}
