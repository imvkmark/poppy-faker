<?php

declare(strict_types=1);

namespace Poppy\Faker\Tests\JsonSchema;

use JsonSchema\Validator;
use Poppy\Faker\JsonSchema\FakeJsons;

class FakeJsonsTest extends TestCase
{
    /**
     * @var FakeJsons
     */
    protected FakeJsons $fakeJsons;

    public function testInvoke(): void
    {
        ($this->fakeJsons)(__DIR__ . '/fixture', __DIR__ . '/dist', 'http://example.com/schema');
        $validator = new Validator();
        $data      = json_decode((string) file_get_contents(__DIR__ . '/dist/ref_file_double.json'));
        $validator->validate($data, (object) ['$ref' => 'file://' . __DIR__ . '/fixture/ref_file_double.json']);
        foreach ($validator->getErrors() as $error) {
            fwrite(STDOUT, sprintf("[%s] %s\n", $error['property'], $error['message']));
        }
        $this->assertTrue($validator->isValid());
    }

    protected function setUp(): void
    {
        $this->fakeJsons = new FakeJsons();
    }


}
