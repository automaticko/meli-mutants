<?php

namespace Tests\Feature;

use App\Services\DNAService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Mockery;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class MutantsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     *
     * @dataProvider mutantProvider
     *
     * @param          $isMutant
     * @param null|int $expectedHTTPStatusCode
     */
    public function is_mutant(bool $isMutant, ?int $expectedHTTPStatusCode)
    {
        $this->app->bind(DNAService::class, function () use ($isMutant) {
            $mock = Mockery::mock(DNAService::class);
            $mock->shouldReceive('hasMutantGenes')->withNoArgs()->andReturn($isMutant);

            return $mock;
        });

        $response = $this->post('/mutant', ['dna' => []]);

        $response->assertStatus($expectedHTTPStatusCode);
    }

    public function mutantProvider(): array
    {
        return [
            'is mutant'     => [true, Response::HTTP_OK,],
            'is not mutant' => [false, Response::HTTP_FORBIDDEN],
        ];
    }
}
