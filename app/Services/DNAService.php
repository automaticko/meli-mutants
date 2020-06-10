<?php

namespace App\Services;

class DNAService
{
    private const CONSECUTIVE_BASES = 4;
    private array  $explodedSequence;
    private array  $sequence;
    private int    $size;
    private bool   $isCandidateForMutant = false;

    public function __construct(array $sequence)
    {
        $this->sequence = $sequence;
        $this->size     = count($sequence);
    }

    public function hasMutantGenes(): bool
    {
        if ($this->size < self::CONSECUTIVE_BASES) {
            return false;
        }

        foreach ($this->sequence as $bases) {
            $hasMutantGene = preg_match('/(aaaa|gggg|cccc|tttt)/i', $bases);
            if ($this->isCandidateForMutant && $hasMutantGene) {
                return true;
            }

            $this->isCandidateForMutant = $this->isCandidateForMutant || $hasMutantGene;
        }

        $this->normalizeSequence();

        foreach ($this->explodedSequence as $bases) {
            $hasMutantGene = preg_match('/(aaaa|gggg|cccc|tttt)/i', $bases);
            if ($this->isCandidateForMutant && $hasMutantGene) {
                return true;
            }

            $this->isCandidateForMutant = $this->isCandidateForMutant || $hasMutantGene;
        }

        return false;
    }

    private function normalizeSequence(): void
    {
        $sequence = [];
        for ($row = 0; $row < $this->size; $row += 1) {
            for ($column = 0; $column < $this->size; $column += 1) {
                $verticalIndex = 'v' . $column;
                $diagonalIndex = 'd' . ($row - $column);

                $horizontalBase = $this->sequence[$row][$column];

                $verticalBases = $sequence[$verticalIndex] ?? '';
                $diagonalBases = $sequence[$diagonalIndex] ?? '';

                $sequence[$verticalIndex] = $verticalBases . $horizontalBase;
                $sequence[$diagonalIndex] = $diagonalBases . $horizontalBase;
            }
        }

        $this->explodedSequence = array_filter($sequence, function (string $bases) {
            return self::CONSECUTIVE_BASES <= strlen($bases);
        });
    }
}
