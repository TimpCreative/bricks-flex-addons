<?php
// Abort if Bricks Builder isn’t active
if ( ! defined( 'BRICKS_VERSION' ) ) {
    return;
}

/**
 * PSR‑4‑ish autoloader for our classes.
 * Classes live under namespace FlexAddons\*
 */
spl_autoload_register(
    function ( $class ) {
        $prefix = 'FlexAddons\\';
        if ( strpos( $class, $prefix ) !== 0 ) {
            return;
        }
        $path = __DIR__ . '/' . str_replace(
            '\\',
            '/',
            substr( $class, strlen( $prefix ) )
        ) . '.php';

        if ( file_exists( $path ) ) {
            require_once $path;
        }
    }
);

/**
 * Register all custom Bricks elements.
 */
add_action(
    'init',
    function () {
        // Elements
        \Bricks\Elements::register_element( new FlexAddons\Elements\Modal() );
    },
    11    // after Bricks has registered its core elements
);

/**
 * Register dynamic‑data tags
 */
add_filter(
    'bricks/dynamic_data_tags',
    function ( $tags ) {
        $tags['parent_page_title']   = new FlexAddons\DynamicTags\ParentPageTitle();
        $tags['parent_page_content'] = new FlexAddons\DynamicTags\ParentPageContent();
        return $tags;
    }
);
