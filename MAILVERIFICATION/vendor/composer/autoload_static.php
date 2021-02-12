<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitcd4fc1053dd89231e4acc3b02b8b8bb9
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitcd4fc1053dd89231e4acc3b02b8b8bb9::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitcd4fc1053dd89231e4acc3b02b8b8bb9::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
