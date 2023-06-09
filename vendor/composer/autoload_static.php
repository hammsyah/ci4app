<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3854d8a4ade47d2404d72066899f216a
{
    public static $files = array (
        '3917c79c5052b270641b5a200963dbc2' => __DIR__ . '/..' . '/kint-php/kint/init.php',
    );

    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Psr\\Log\\' => 8,
        ),
        'L' => 
        array (
            'Laminas\\Escaper\\' => 16,
        ),
        'K' => 
        array (
            'Kint\\' => 5,
        ),
        'C' => 
        array (
            'Config\\' => 7,
            'CodeIgniter\\' => 12,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'Laminas\\Escaper\\' => 
        array (
            0 => __DIR__ . '/..' . '/laminas/laminas-escaper/src',
        ),
        'Kint\\' => 
        array (
            0 => __DIR__ . '/..' . '/kint-php/kint/src',
        ),
        'Config\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/Config',
        ),
        'CodeIgniter\\' => 
        array (
            0 => __DIR__ . '/..' . '/codeigniter4/framework/system',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3854d8a4ade47d2404d72066899f216a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3854d8a4ade47d2404d72066899f216a::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit3854d8a4ade47d2404d72066899f216a::$classMap;

        }, null, ClassLoader::class);
    }
}
