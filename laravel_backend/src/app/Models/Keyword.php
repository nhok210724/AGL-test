<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Keyword extends Model
{
    use HasFactory;

    protected $table = 'keywords';

    public $timestamps = false;

    protected $fillable = [
        'keyword',
        'search_id',
    ];

    /**
     * Get the result associated with the keyword.
     */
    public function result(): HasOne
    {
        return $this->hasOne(Result::class, 'keyword_id', 'id');
    }
}
