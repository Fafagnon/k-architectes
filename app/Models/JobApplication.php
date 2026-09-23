<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'poste_vise',
        'opportunity_id',
        'message',
        'cv_path',
        'status',
        'ip_address',
    ];

    public function getNomCompletAttribute(): string
    {
        return trim("{$this->prenom} {$this->nom}");
    }

    public function opportunity(): BelongsTo
    {
        return $this->belongsTo(Opportunity::class);
    }

    public function getCvUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->cv_path);
    }

    public function isUnread(): bool
    {
        return $this->status === 'unread';
    }
}
