<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Device extends Model
{
    protected $fillable = [
        'nom',
        'marque',
        'numero_serie',
        'etat',
        'date_achat',
        'description',
        'room_id',
    ];

    // relation 1 equipement 1 salle
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    // relation 1 equipement plusieurs interventions
    public function interventions(): HasMany
    {
        return $this->hasMany(Intervention::class);
    }

    // relation 1 equipement plusieurs categories
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    // Couleur du badge selon l'état (bonus)
    public function getBadgeColorAttribute(): string
    {
        return match ($this->etat) {
            'neuf' => 'success',
            'bon' => 'primary',
            'en panne' => 'danger',
            default => 'secondary',
        };
    }
}