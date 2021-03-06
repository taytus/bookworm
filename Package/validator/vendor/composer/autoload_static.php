<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1f559b470c394c5bde2b8df3f088c3ae
{
    public static $prefixLengthsPsr4 = array (
        'R' => 
        array (
            'ROBOAMP\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'ROBOAMP\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1f559b470c394c5bde2b8df3f088c3ae::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit1f559b470c394c5bde2b8df3f088c3ae::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
