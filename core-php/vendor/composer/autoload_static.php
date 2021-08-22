<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitab22bfc0478d1bde12ab036b29f83cb9
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitab22bfc0478d1bde12ab036b29f83cb9::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitab22bfc0478d1bde12ab036b29f83cb9::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitab22bfc0478d1bde12ab036b29f83cb9::$classMap;

        }, null, ClassLoader::class);
    }
}