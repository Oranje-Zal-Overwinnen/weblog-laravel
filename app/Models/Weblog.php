<?php

namespace App\Models;

use Database\Factories\WeblogFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['user_id', 'title', 'text', 'is_premium', 'published_at'])]
class Weblog extends Model
{
    /** @use HasFactory<WeblogFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_premium' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    /**
     * Get the user that wrote the article.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the categories of the article.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Get the comments on the article.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the images of the article.
     */
    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    /**
     * Determine if the article may be viewed by the given user.
     */
    public function isVisibleTo(?User $user): bool
    {
        return ! $this->is_premium
            || (bool) $user?->is_subscriber
            || $user?->id === $this->user_id;
    }

    /**
     * Limit the query to the articles the given user may view.
     */
    public function scopeVisibleTo(Builder $query, ?User $user): Builder
    {
        if ($user?->is_subscriber) {
            return $query;
        }

        return $query->where(function (Builder $query) use ($user) {
            $query->where('is_premium', false);

            if ($user !== null) {
                $query->orWhere('user_id', $user->id);
            }
        });
    }
}
