<?php

namespace Tests\Unit\Services;

use App\Services\DNAService;
use Tests\TestCase;

class DNAServiceTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider sequenceProvider
     *
     * @param array $sequence
     * @param bool  $passes
     */
    public function it_has_mutant_genes(array $sequence, bool $passes)
    {
        $service = new DNAService($sequence);

        $this->assertEquals($passes, $service->hasMutantGenes());
    }

    public function sequenceProvider(): array
    {
        return [
            'horizontal'             => [
                [
                    'ATGCGA',
                    'CAGTGC',
                    'TTATGT',
                    'AGAACG',
                    'CCCCTA',
                    'TCACTG',
                ],
                true,
            ],
            'vertical'               => [
                [
                    'ATGCGA',
                    'CAGTGC',
                    'TTATGT',
                    'AGACGG',
                    'CAAATA',
                    'TCACTG',
                ],
                true,
            ],
            'diagonal'               => [
                [
                    'ATGCGA',
                    'CAGTGC',
                    'TTATGT',
                    'AGAACG',
                    'CAAATA',
                    'TCACTG',
                ],
                true,
            ],
            'failing empty sequence' => [[], false],
            'failing small sequence' => [
                [
                    'ACACAC',
                    'AACCAA',
                    'CACACA',
                ],
                false,
            ],

            'failing no genes' => [
                [
                    'ACACAC',
                    'AACCAA',
                    'CACACA',
                    'CCAACC',
                    'AAACCC',
                    'CCCAAA',
                ],
                false,
            ],
        ];
    }
}
