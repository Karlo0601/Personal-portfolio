<?php
/**
 * Class loader using SPL autoloader.
 */
class blackhat_Autoloader {
    /**
     * Registers Twig_Autoloader as an SPL autoloader.
     *
     * @param bool $prepend Whether to prepend the autoloader or not.
     */
    public static function register( $prepend = false ) {
        if ( PHP_VERSION_ID < 50300 ) {
            spl_autoload_register( array( __CLASS__, 'autoload' ) );
        } else {
            spl_autoload_register( array( __CLASS__, 'autoload' ), true, $prepend );
        }
    }
    /**
     * Handles autoloading of classes.
     *
     * @param string $class A class name.
     */
    public static function autoload( $class ) {
        if ( 0 !== strpos( $class, 'blackhat_Flexible_Layout' ) ) {
            return;
        }

        $filename = str_replace( 'blackhat_Flexible_Layout_Render_', '', $class );

        if ( is_file( $file = dirname(__FILE__) . '/' . $filename . '.php' ) ) {
            require $file;
        }
    }
}