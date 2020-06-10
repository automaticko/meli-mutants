<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidDNA implements Rule
{
    public function passes($attribute, $sequence): bool
    {
        if (!$this->isValidSequence($sequence)) {
            return false;
        }

        return $this->haveValidRows($sequence);
    }

    private function isValidSequence($sequence): bool
    {
        return is_array($sequence);
    }

    private function haveValidRows(array $rows): bool
    {
        $size = count($rows);
        foreach ($rows as $row) {
            if (!$this->isValidRow($row)) {
                return false;
            }

            if (strlen($row) !== $size) {
                return false;
            }
        }

        return true;
    }

    private function isValidRow($row): bool
    {
        if (!is_string($row)) {
            return false;
        }

        return preg_match('/^[AGCT]*$/i', $row);
    }

    public function message(): string
    {
        return 'Malformed DNA.';
    }
}
