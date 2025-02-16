<?php

declare(strict_types = 1);

namespace Poppy\Faker\Tests\JsonSchema;

use JsonException;
use ReflectionException;
use ReflectionMethod;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @throws JsonException
     */
    protected function getFixture($name)
    {
        return json_decode((string) file_get_contents(__DIR__ . "/fixture/{$name}.json"), false, 512, JSON_THROW_ON_ERROR);
    }

    protected function getFile($name): string
    {
        return __DIR__ . "/fixture/{$name}.json";
    }

    /**
     * @throws ReflectionException
     */
    protected function callInternalMethod($instance, $method, array $args = [])
    {
        return (new ReflectionMethod(get_class($instance), $method))->invokeArgs($instance, $args);
    }
}
