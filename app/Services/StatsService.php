<?php

namespace App\Services;

use App\Models\Dna;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class StatsService
{
    use DatabaseMigrations;

    public function ratio(): float
    {
        $baseStats = Dna::stats();

        $humansCount  = $baseStats['humans'] ?? 0;
        $mutantsCount = $baseStats['mutants'] ?? 0;

        return $humansCount ? $mutantsCount / $humansCount : 0;
    }

    public function humans(): int
    {
        return Dna::countHumans();
    }

    public function mutants(): int
    {
        return Dna::countMutants();
    }

    public function flush(): void
    {
        Dna::delete();
    }
}
