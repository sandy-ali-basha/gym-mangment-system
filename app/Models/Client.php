<?php

namespace App\Models;

use Database\Factories\ClientFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    /** @use HasFactory<ClientFactory> */
    use HasFactory;

    protected $fillable = ['full_name', 'phone', 'email', 'registered_at', 'gender', 'profile_photo_path', 'status', 'notes', 'emergency_contact_name', 'emergency_contact_phone'];

    protected function casts(): array
    {
        return ['registered_at' => 'date'];
    }

    public function memberships(): HasMany
    {
        return $this->hasMany(Membership::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
