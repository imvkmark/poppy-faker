<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd03dd259f6b062eead856d23533cd0f3
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Poppy\\Faker\\' => 12,
        ),
        'F' => 
        array (
            'Faker\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Poppy\\Faker\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Faker\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/Faker',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd03dd259f6b062eead856d23533cd0f3::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd03dd259f6b062eead856d23533cd0f3::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitd03dd259f6b062eead856d23533cd0f3::$classMap;

        }, null, ClassLoader::class);
    }
}
