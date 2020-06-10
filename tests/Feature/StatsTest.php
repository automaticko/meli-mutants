<?php

namespace Tests\Feature;

use App\Services\StatsService;
use Mockery;
use Tests\TestCase;

class StatsTest extends TestCase
{
    /** @test */
    public function has_stats()
    {
        $this->app->bind(StatsService::class, function () {
            $mock = Mockery::mock(StatsService::class);
            $mock->shouldReceive('humans')->withNoArgs()->andReturn(100);
            $mock->shouldReceive('mutants')->withNoArgs()->andReturn(40);
            $mock->shouldReceive('ratio')->withNoArgs()->andReturn(1.4);

            return $mock;
        });

        $response = $this->get('/stats');

        $response->assertJson([
            'count_human_dna'  => 100,
            'count_mutant_dna' => 40,
            'ratio'            => 1.4,
        ]);
    }
}
