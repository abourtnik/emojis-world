<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class History extends Model
{
    protected $guarded = ['id'];

    protected $table = 'history';

    public $timestamps = false;

    protected $casts = [
        'date' => 'datetime',
    ];

    public function emoji (): BelongsTo {
        return $this->belongsTo(Emoji::class);
    }
}
