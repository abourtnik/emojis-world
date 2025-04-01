<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperSubCategory
 */
class SubCategory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public $timestamps = false;

    public function category (): BelongsTo {
        return $this->belongsTo(Category::class);
    }
}
