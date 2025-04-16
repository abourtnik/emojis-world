<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperCategory
 */
class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public $timestamps = false;

    public function subCategories() : HasMany {
        return $this->hasMany(SubCategory::class);
    }

    public function emojis() : HasMany {
        return $this->hasMany(Emoji::class);
    }
}
