<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'tag',
        'excerpt',
        'body',
        'cover_image',
        'reading_minutes',
        'status',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'reading_minutes' => 'integer',
        ];
    }

    /**
     * Get route key name for Route Model Binding.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Scope for published articles.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * URL pour le partage social.
     */
    public function getShareUrlAttribute(): string
    {
        return route('actualites.show', $this);
    }

    /**
     * URL publique de l'image de couverture.
     */
    public function getCoverImageUrlAttribute(): ?string
    {
        if (!$this->cover_image) {
            return null;
        }

        if (str_starts_with($this->cover_image, 'http://') || str_starts_with($this->cover_image, 'https://')) {
            return $this->cover_image;
        }

        if (str_starts_with($this->cover_image, 'assets/')) {
            return asset($this->cover_image);
        }

        return Storage::disk('public')->url($this->cover_image);
    }

    /**
     * Date formatée en français (ex: 14 Septembre 2026).
     */
    public function getFormattedDateAttribute(): string
    {
        if (!$this->published_at) {
            return '';
        }

        return Carbon::parse($this->published_at)->locale('fr')->translatedFormat('d F Y');
    }
}
