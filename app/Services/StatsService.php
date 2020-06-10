<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class StatsService
{
    private const HUMANS_COUNT  = 'humans';
    private const MUTANTS_COUNT = 'mutants';

    public function addHuman(): void
    {
        Cache::put(self::HUMANS_COUNT, Cache::get(self::HUMANS_COUNT, 0) + 1);
    }

    public function addMutant(): void
    {
        Cache::put(self::MUTANTS_COUNT, Cache::get(self::MUTANTS_COUNT, 0) + 1);
    }

    public function ratio(): float
    {
        $humansCount  = Cache::get(self::HUMANS_COUNT, 0);
        $mutantsCount = Cache::get(self::MUTANTS_COUNT, 0);

        return $humansCount ? $mutantsCount / $humansCount : 0;
    }

    public function humans(): int
    {
        return Cache::get(self::HUMANS_COUNT, 0);
    }

    public function mutants(): int
    {
        return Cache::get(self::MUTANTS_COUNT, 0);
    }

    public function flush(): void
    {
        Cache::forget(self::HUMANS_COUNT);
        Cache::forget(self::MUTANTS_COUNT);
    }
}
