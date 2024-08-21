<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Search extends Model
{
    use HasFactory;

    protected $table = 'searches';

    protected $fillable = [
        'url',
    ];

    public $timestamps = false;

    /**
     * Get the keyword for the url.
     */
    public function keywords(): HasMany
    {
        return $this->hasMany(Keyword::class, 'search_id', 'id');
    }
}
