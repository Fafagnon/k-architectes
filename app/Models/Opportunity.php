<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Opportunity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'contract_type',
        'location',
        'excerpt',
        'body',
        'application_deadline',
        'status',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'application_deadline' => 'date',
            'published_at' => 'datetime',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Scope for published opportunities (published or closed).
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->whereIn('status', ['published', 'closed']);
    }

    /**
     * Scope for open opportunities accepting applications.
     */
    public function scopeOpen(Builder $query): Builder
    {
        return $query->where('status', 'published')
            ->where(function (Builder $q) {
                $q->whereNull('application_deadline')
                    ->orWhere('application_deadline', '>=', now()->toDateString());
            });
    }

    /**
     * Indicates whether the opportunity is currently accepting applications.
     */
    public function getIsOpenAttribute(): bool
    {
        if ($this->status !== 'published') {
            return false;
        }

        if ($this->application_deadline && $this->application_deadline->isPast()) {
            return false;
        }

        return true;
    }

    public function getShareUrlAttribute(): string
    {
        return route('opportunites.show', $this);
    }

    public function getFormattedDeadlineAttribute(): ?string
    {
        if (!$this->application_deadline) {
            return null;
        }

        return Carbon::parse($this->application_deadline)->locale('fr')->translatedFormat('d F Y');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }
}
