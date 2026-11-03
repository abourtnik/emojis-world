<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperLog
 */
class Log extends Model
{
    protected $guarded = ['id'];

    public $timestamps = false;

    protected $casts = [
        'date' => 'datetime',
    ];
}
