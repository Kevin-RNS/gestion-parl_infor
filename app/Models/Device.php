<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Device extends Model
{
    use HasFactory;

    /**
     * États possibles d'un équipement.
     *
     * @var array<string, string>
     */
    public const ETATS = [
        'neuf' => 'Neuf',
        'bon' => 'Bon état',
        'en panne' => 'En panne',
    ];

    /**
     * Correspondance état => couleur de badge (Bootstrap).
     *
     * @var array<string, string>
     */
    public const ETAT_COLORS = [
        'neuf' => 'success',
        'bon' => 'primary',
        'en panne' => 'danger',
    ];

    protected $fillable = [
        'nom',
        'marque',
        'numero_serie',
        'etat',
        'date_achat',
        'description',
        'room_id',
    ];

    protected function casts(): array
    {
        return [
            'date_achat' => 'date',
        ];
    }

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
        return self::ETAT_COLORS[$this->etat] ?? 'secondary';
    }

    /**
     * Libellé lisible de l'état (accentué, sans la valeur brute).
     */
    public function getEtatLabelAttribute(): string
    {
        return self::ETATS[$this->etat] ?? (string) $this->etat;
    }

    /**
     * Icône bootstrap associée à l'état.
     */
    public function getEtatIconAttribute(): string
    {
        return match ($this->etat) {
            'neuf' => 'bi-stars',
            'bon' => 'bi-check-circle',
            'en panne' => 'bi-exclamation-octagon',
            default => 'bi-question-circle',
        };
    }
}
