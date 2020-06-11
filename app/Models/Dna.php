<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dna extends Model
{
    public    $timestamps = false;
    protected $casts      = [
        'sequence' => 'array',
    ];
    protected $fillable   = [
        'sequence',
        'is_mutant',
    ];

    public static function stats(): array
    {
        $result = Dna::query()->selectRaw("is_mutant, COUNT(is_mutant) as count")->groupBy('is_mutant')->get();

        $baseStats = $result->mapWithKeys(function (self $dna) {
            $key = $dna->isMutant() ? 'mutants' : 'humans';

            return [$key => $dna->count];
        });

        return [
            'humans'  => $baseStats->get('humans', 0),
            'mutants' => $baseStats->get('mutants', 0),
        ];
    }

    public static function countHumans(): int
    {
        return static::query()->where('is_mutant', false)->count(['id']);
    }

    public static function countMutants(): int
    {
        return static::query()->where('is_mutant', true)->count(['id']);
    }

    public function isMutant(): bool
    {
        return !!($this->attributes['is_mutant'] ?? false);
    }
}

