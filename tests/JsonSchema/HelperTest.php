<?php

declare(strict_types = 1);

namespace Poppy\Faker\Tests\JsonSchema;

use Exception;
use JsonSchema\Validator;
use Poppy\Faker\JsonSchema\Faker;
use Poppy\Faker\Provider\Internet;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class HelperTest extends TestCase
{
    public function testGetMaximumMustReturnMaximumMinusOneIfExclusiveMaximumTrue()
    {
        $maximum = 300;
        $schema  = (object) ['exclusiveMaximum' => true, 'maximum' => $maximum];

        $actual = (new Faker)->getMaximum($schema);

        // -1 mean exclusive
        $this->assertSame($actual, $maximum - 1);
    }

    public function testGetMaximumMustReturnMaximumIfExclusiveMaximumFalse()
    {
        $maximum = 300;
        $schema  = (object) ['exclusiveMaximum' => false, 'maximum' => $maximum];

        $actual = (new Faker)->getMaximum($schema);

        $this->assertSame($actual, $maximum);
    }

    public function testGetMaximumMustReturnMaximumIfExclusiveMaximumAbsent()
    {
        $maximum = 300;
        $schema  = (object) ['maximum' => $maximum];

        $actual = (new Faker)->getMaximum($schema);

        $this->assertSame($actual, $maximum);
    }

    public function testGetMinimumMustReturnMinimumMinusOneIfExclusiveMinimumTrue()
    {
        $minimum = 300;
        $schema  = (object) ['exclusiveMinimum' => true, 'minimum' => $minimum];

        $actual = (new Faker)->getMinimum($schema);

        // +1 mean exclusive
        $this->assertSame($actual, $minimum + 1);
    }

    public function testGetMinimumMustReturnMinimumIfExclusiveMinimumFalse()
    {
        $minimum = 300;
        $schema  = (object) ['exclusiveMinimum' => false, 'minimum' => $minimum];

        $actual = (new Faker)->getMinimum($schema);

        $this->assertSame($actual, $minimum);
    }

    public function testGetMinimumMustReturnMinimumIfExclusiveMinimumAbsent()
    {
        $minimum = 300;
        $schema  = (object) ['minimum' => $minimum];

        $actual = (new Faker)->getMinimum($schema);

        $this->assertSame($actual, $minimum);
    }

    public function testGetMultipleOfMustReturnValueIfPresent()
    {
        $expected = 7;
        $schema   = (object) ['multipleOf' => $expected];

        $actual = (new Faker)->getMultipleOf($schema);

        $this->assertSame($actual, $expected);
    }

    public function testGetMultipleOfMustReturnOneIfAbsent()
    {
        $expected = 1;
        $schema   = (object) [];

        $actual = (new Faker)->getMultipleOf($schema);

        $this->assertSame($actual, $expected);
    }

    public function testGetInternetFakerInstanceMustReturnInstance()
    {
        $actual = (new Faker)->getInternetFakerInstance();

        $this->assertTrue($actual instanceof Internet);
    }

    /**
     * @dataProvider getFormats
     */
    public function testGetFormattedValueMustReturnValidValue($format)
    {
        $schema    = (object) ['type' => 'string', 'format' => $format];
        $validator = new Validator();

        $actual = (new Faker)->getFormattedValue($schema);
        $validator->check($actual, $schema);

        $this->assertTrue($validator->isValid());
    }

    public function testGetFormattedValueMustThrowExceptionIfInvalidFormat()
    {
        $this->expectException(Exception::class);

        (new Faker)->getFormattedValue((object) ['format' => 'xxxxx']);
    }

    /**
     * @see testGetFormattedValueMustReturnValidValue
     * @SuppressWarnings(PHPMD.UnusedPrivateMethod)
     */
    public function getFormats(): array
    {
        return [
            ['date-time'],
            ['email'],
            ['hostname'],
            ['ipv4'],
            ['ipv6'],
            ['uri'],
        ];
    }
}
