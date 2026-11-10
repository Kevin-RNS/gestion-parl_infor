<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Intervention extends Model
{
    use HasFactory;

    /**
     * Types d'intervention possibles.
     *
     * @var array<string, string>
     */
    public const TYPES = [
        'maintenance' => 'Maintenance',
        'panne' => 'Panne',
        'reparation' => 'Réparation',
    ];

    protected $fillable = ['date', 'type', 'commentaire', 'device_id'];

    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }

    /**
     * Libellé lisible du type d'intervention.
     */
    public function getTypeLabelAttribute(): string
    {
        return self::TYPES[$this->type] ?? ucfirst((string) $this->type);
    }

    /**
     * Couleur (Bootstrap) associée au type d'intervention.
     */
    public function getTypeColorAttribute(): string
    {
        return match ($this->type) {
            'maintenance' => 'info',
            'panne' => 'danger',
            'reparation' => 'warning',
            default => 'secondary',
        };
    }

    /**
     * Icône bootstrap associée au type d'intervention.
     */
    public function getTypeIconAttribute(): string
    {
        return match ($this->type) {
            'maintenance' => 'bi-tools',
            'panne' => 'bi-exclamation-triangle',
            'reparation' => 'bi-wrench-adjustable',
            default => 'bi-clock-history',
        };
    }

    // 1 intervention appartient à 1 équipement
    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }
}
