<?php

namespace Tests\Unit\FormValidationRules;

use App\Rules\ValidDNA;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;

class ValidDNATest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider sequenceTypeProvider
     *
     * @param      $sequence
     * @param bool $passes
     *
     * @throws ReflectionException
     */
    public function sequence_type_is_array($sequence, bool $passes)
    {
        $reflection = new ReflectionClass(ValidDNA::class);
        $method     = $reflection->getMethod('isValidSequence');
        $method->setAccessible(true);

        $this->assertEquals($passes, $method->invokeArgs(new ValidDNA(), [$sequence]));
    }

    public function sequenceTypeProvider(): array
    {
        return [
            'not array' => [true, false],
            'array'     => [[], true],
        ];
    }

    /**
     * @test
     *
     * @dataProvider sequenceRowProvider
     *
     * @param      $row
     * @param bool $passes
     *
     * @throws ReflectionException
     */
    public function is_valid_sequence_row($row, bool $passes)
    {
        $reflection = new ReflectionClass(ValidDNA::class);
        $method     = $reflection->getMethod('isValidRow');
        $method->setAccessible(true);

        $this->assertEquals($passes, $method->invokeArgs(new ValidDNA(), [$row]));
    }

    public function sequenceRowProvider(): array
    {
        return [
            'null string'            => [null, false],
            'empty string'           => ['', true],
            'bool false'             => [false, false],
            'bool true'              => [true, false],
            'integer zero string'    => [0, false],
            'integer natural string' => [123, false],
            'invalid string'         => ['invalid string', false],
            'valid single base'      => ['aaaaaaa', true],
            'valid multiple base'    => ['acgtcatcgatc', true],
        ];
    }

    /**
     * @test
     *
     * @dataProvider sequenceRowsProvider
     *
     * @param array $rows
     * @param bool  $passes
     *
     * @throws ReflectionException
     */
    public function have_valid_sequence_rows(array $rows, bool $passes)
    {
        $reflection = new ReflectionClass(ValidDNA::class);
        $method     = $reflection->getMethod('haveValidRows');
        $method->setAccessible(true);

        $this->assertEquals($passes, $method->invokeArgs(new ValidDNA(), [$rows]));
    }

    public function sequenceRowsProvider(): array
    {
        return [
            'empty array'                        => [[], true],
            'row length longer than rows number' => [['ag'], false],
            'valid rows'                         => [['ag', 'ct'], true],
        ];
    }
}
