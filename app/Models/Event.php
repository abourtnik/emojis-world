<?php

namespace App\Models;

use App\Events\EventResolver;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin IdeHelperEvent
 */
class Event extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'events';

    public $timestamps = false;

    /**
     * -------------------- RELATIONS --------------------
     */

    public function emojis (): BelongsToMany {
        return $this->belongsToMany(Emoji::class, 'event_has_emojis');
    }

    /**
     * -------------------- ATTRIBUTES --------------------
     */

    protected function route(): Attribute
    {
        return Attribute::make(
            get: fn () => route('pages.event', $this->slug)
        );
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => asset('events/' . $this->image)
        );
    }

    /**
     * -------------------- METHODS --------------------
     */

    public function getEmojis(): Collection
    {
        return (new EventResolver($this))->resolve();
    }
}
