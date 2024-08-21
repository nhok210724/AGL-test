<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Result extends Model
{
    use HasFactory;

    protected $table = 'results';

    public $timestamps = false;

    protected $fillable = [
        'keyword_id',
        'google_rank',
        'yahoo_rank',
        'google_total_hits',
        'yahoo_total_hits',
    ];

    /**
     * Get the ranking
     */
    protected function googleRanking(): Attribute
    {
        return Attribute::make(
            get: fn ($value, array $attributes) => $attributes['google_rank'] == 0 ? 'out of rank' : $attributes['google_rank'],
        );
    }

    protected function googleTotalResult(): Attribute
    {
        return Attribute::make(
            get: fn ($value, array $attributes) => number_format($attributes['google_total_hits']),
        );
    }

    protected function yahooRanking(): Attribute
    {
        return Attribute::make(
            get: fn ($value, array $attributes) => $attributes['yahoo_rank'] == 0 ? 'out of rank' : $attributes['yahoo_rank'],
        );
    }

    protected function yahooTotalResult(): Attribute
    {
        return Attribute::make(
            get: fn ($value, array $attributes) => number_format($attributes['yahoo_total_hits']),
        );
    }

    /**
     * Get the user that owns the phone.
    */
    public function keyword(): BelongsTo
    {
        return $this->belongsTo(Keyword::class);
    }
}
