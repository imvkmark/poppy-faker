<?php

declare(strict_types = 1);

namespace Poppy\Faker\JsonSchema;

use Exception;
use FilesystemIterator;
use Iterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;
use RuntimeException;
use SplFileInfo;
use stdClass;

final class FakeJsons
{
    public function __invoke(string $schemaDir, string $distDir, string $schemaUri = null): void
    {
        $faker = new Faker();
        foreach ($this->files($schemaDir) as $fileInfo) {
            /* @var SplFileInfo $fileInfo */
            try {
                $fake           = $faker->generate($fileInfo);
                $schemaFilename = $fileInfo->getFilename();
                if ($fake instanceof stdClass && is_string($schemaUri)) {
                    $fake->{'$schema'} = sprintf('%s/%s', $schemaUri, $schemaFilename);
                }
                $targetPath = $distDir . str_replace($schemaDir, '', $fileInfo->getPath());
                if (!file_exists($targetPath)) {
                    if (!mkdir($targetPath, 0755, true) && !is_dir($targetPath)) {
                        throw new RuntimeException(sprintf('Directory "%s" was not created', $targetPath));
                    }
                }
                $distFile = sprintf('%s/%s', $targetPath, $schemaFilename);
                $fakeJson = json_encode($fake, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL;
                fwrite(STDOUT, sprintf("Generate fake file: %s\n", $distFile));
                file_put_contents($distFile, $fakeJson);
            } catch (Exception $e) {
                fwrite(STDOUT, sprintf("%s: %s %s on line %d\n", $fileInfo->getFilename(), $e->getMessage(), $e->getFile(), $e->getLine()));
                continue;
            }
        }
    }

    private function files(string $dir): Iterator
    {
        return
            new RegexIterator(
                new RecursiveIteratorIterator(
                    new RecursiveDirectoryIterator(
                        $dir,
                        FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_PATHNAME | FilesystemIterator::SKIP_DOTS
                    ),
                    RecursiveIteratorIterator::LEAVES_ONLY
                ),
                "/^.+\\.json/",
                RegexIterator::MATCH
            );
    }
}
