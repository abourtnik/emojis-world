<?php

namespace App\Models;

use App\Casts\StringArray;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Builder;


/**
 * @mixin IdeHelperEmoji
 */
class Emoji extends Model
{
    use HasFactory, Filterable, Searchable;

    protected $guarded = ['id'];

    protected $table = 'emojis';

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'keywords' => StringArray::class,
            'version' => 'decimal:2'
        ];
    }

    /**
     * -------------------- RELATIONS --------------------
     */

    public function category (): BelongsTo {
        return $this->belongsTo(Category::class);
    }

    public function subCategory (): BelongsTo {
        return $this->belongsTo(SubCategory::class);
    }

    public function children () : HasMany  {
        return $this->hasMany(Emoji::class, 'parent_id', 'id');
    }

    public function parent () : HasOne  {
        return $this->hasOne(Emoji::class, 'parent_id', 'id');
    }

    /**
     * -------------------- ATTRIBUTES --------------------
     */

    protected function version(): Attribute
    {
        return Attribute::make(
            get: fn (float $value) => (float) number_format($value, 1),
        );
    }

    /**
     * -------------------- SCOPES --------------------
     */


    protected function scopeWithoutChildren(Builder $query): void
    {
        $query->whereNull('parent_id');
    }


    /**
     * -------------------- LARAVEL SCOUT --------------------
     */

    /**
     * Get the name of the index associated with the model.
     */
    public function searchableAs(): string
    {
        return 'emojis';
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray() : array
    {
        return [
            'id' => (string) $this->id,
            'name' => $this->name,
            'emoji' => $this->emoji,
            'category_id' => $this->category->id,
            'sub_category_id' => $this->subCategory->id,
            'category_name' => $this->category->name,
            'sub_category_name' => $this->subCategory->name,
            'keywords' => $this->keywords,
            'version' => $this->version,
        ];
    }

    /**
     * Modify the query used to retrieve models when making all of the models searchable.
     */
    protected function makeAllSearchableUsing(Builder $query): Builder
    {
        return $query
            ->withoutChildren()
            ->with(['category', 'subCategory']);
    }
}
