<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Season;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Episode extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['number'];
    protected $casts = [
        'watched' => 'boolean'
    ];

    public function seasons()
    {
        return $this->belongsTo(Season::class);
    }

    // protected function watched(): Attribute
    // {
    //     // return Attribute::make();
    //     return new Attribute(
    //         fn($watched) => (bool) $watched,
    //         fn($watched) => (bool) $watched
    //     );
    // }

    // Escopo local
    // public function scopeWatched (Builder $query)
    // {
    //     $query->where('watched', true);
    // }
}
