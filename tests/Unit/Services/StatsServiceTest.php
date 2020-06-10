<?php

namespace Tests\Unit\Services;

use App\Services\StatsService;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class StatsServiceTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider humansProvider
     *
     * @param int $humans
     */
    public function it_stores_humans(int $humans)
    {
        Cache::put('humans', $humans);

        $statsService = new StatsService();

        $this->assertEquals($humans, $statsService->humans());
    }

    public function humansProvider(): array
    {
        return [
            'zero humans' => [0],
            'one human'   => [1],
        ];
    }

    /**
     * @test
     *
     * @dataProvider mutantsProvider
     *
     * @param int $mutants
     */
    public function it_stores_mutants(int $mutants)
    {
        Cache::put('mutants', $mutants);

        $statsService = new StatsService();

        $this->assertEquals($mutants, $statsService->mutants());
    }

    public function mutantsProvider(): array
    {
        return [
            'zero mutants' => [0],
            'one mutant'   => [1],
        ];
    }

    /**
     * @test
     *
     * @dataProvider ratioProvider
     *
     * @param int   $mutants
     * @param int   $humans
     * @param float $ratio
     */
    public function it_returns_ratio(int $mutants, int $humans, float $ratio)
    {
        Cache::put('humans', $humans);
        Cache::put('mutants', $mutants);

        $statsService = new StatsService();

        $this->assertEquals($ratio, $statsService->ratio());
    }

    public function ratioProvider(): array
    {
        return [
            'zero mutants, zero humans, 0 ratio' => [0, 0, 0],
            '1 mutant, zero humans, 0 ratio'     => [1, 0, 0],
            '0 mutants, 1 human, 0 ratio'        => [0, 1, 0],
            '1 mutants, 1 human, 1 ratio'        => [1, 1, 1],
            '40 mutants, 100 human, 0.4 ratio'   => [40, 100, 0.4],
        ];
    }
}
