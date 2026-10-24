<?php

namespace App\Models;

use Database\Factories\LeadFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    /** @use HasFactory<LeadFactory> */
    use HasFactory;

    protected $fillable = ['full_name', 'phone', 'gender', 'inquired_at', 'interested_in', 'source', 'notes', 'follow_up_at', 'status', 'last_contacted_at'];

    protected function casts(): array
    {
        return ['inquired_at' => 'date', 'follow_up_at' => 'date', 'last_contacted_at' => 'date'];
    }
}
