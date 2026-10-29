<?php

namespace App\Models;

use App\Casts\StringArray;
use App\Enums\Direction;
use App\Enums\Gender;
use App\Enums\SkinTone;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;


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
            'version' => 'decimal:2',
            'skin_tone' => SkinTone::class,
            'skin_tone_2' => SkinTone::class,
            'gender' => Gender::class,
            'direction' => Direction::class,
        ];
    }

    /**
     * -------------------- RELATIONS --------------------
     */

    public function category (): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory (): BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function children (): HasMany
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function parent (): HasOne
    {
        return $this->hasOne(self::class, 'id', 'parent_id');
    }

    public function group(): HasMany
    {
        return $this->hasMany(self::class, 'group_id', 'group_id');
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

    protected function description(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->attributes['description'] ?: $this->parent?->description,
        );
    }

    protected function route(): Attribute
    {
        return Attribute::make(
            get: fn () => route('pages.emoji', ['emoji' => $this->slug]),
        );
    }

    protected function keywordsAsString(): Attribute
    {
        return Attribute::make(
            get: fn () => implode(', ' , $this->keywords)
        );
    }

    protected function codepoint(): Attribute
    {
        return Attribute::make(
            get: fn () => Str::of($this->unicode)->explode(' ')->map(fn($code) => 'U+' . $code)->join(' ')
        );
    }

    protected function descriptionHtml(): Attribute
    {
        return Attribute::get(function () {
            $html = collect(preg_split('/\n{2,}/', $this->description))
                ->map(fn (string $p) => trim($p))
                ->filter()
                ->map(fn (string $p) => '<p>' . e($p) . '</p>')
                ->implode("\n");

            return new HtmlString($html);
        });
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
            'description' => $this->description,
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
        return $query->scopes('withoutChildren')->with(['category', 'subCategory']);
    }

    /**
     * -------------------- METHODS --------------------
     */

    public function genderSlug(Gender $gender): string
    {
        return Str::replaceFirst(
            Str::lower($this->gender->pluralLabel()),
            Str::lower($gender->pluralLabel()),
            $this->slug
        );
    }

    public function genderSlugMultiple(Gender $gender): string
    {
        return Str::replaceFirst(
            Str::lower($this->gender->coupleLabel()),
            Str::lower($gender->coupleLabel()),
            $this->slug
        );
    }

    public function directionSlug(Direction $direction): string
    {
        if ($direction === Direction::Default) {
            return Str::replaceFirst('-facing-right', '', $this->slug);
        }

        return preg_replace(
            '/(?=-(?:medium-light|medium-dark|light|medium|dark)-skin-tone)|$/',
            '-facing-right',
            $this->slug,
            1
        );
    }
}
