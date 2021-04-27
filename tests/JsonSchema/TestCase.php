<?php

declare(strict_types = 1);

namespace Poppy\Faker\Tests\JsonSchema;

use ReflectionMethod;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function getFixture($name)
    {
        return json_decode((string) file_get_contents(__DIR__ . "/fixture/{$name}.json"));
    }

    protected function getFile($name)
    {
        return __DIR__ . "/fixture/{$name}.json";
    }

    protected function callInternalMethod($instance, $method, array $args = [])
    {
        $ref = new ReflectionMethod(get_class($instance), $method);
        $ref->setAccessible(true);

        return $ref->invokeArgs($instance, $args);
    }
}
