<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitf55ebbe2a1ed89043a1a822d5405fc02
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInitf55ebbe2a1ed89043a1a822d5405fc02', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitf55ebbe2a1ed89043a1a822d5405fc02', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitf55ebbe2a1ed89043a1a822d5405fc02::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}