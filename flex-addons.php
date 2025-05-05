<?php
/*
Plugin Name: Bricks Flex Addons
Description: Modular add-ons for Bricks Builder.
Version: 0.1.0
Author: TimpCreative
License: GPL-2.0+
*/

if ( ! function_exists( 'bfa_plugin' ) ) {
    // Create a helper function for easy SDK access.
    function bfa_plugin() {
        global $bfa_plugin;

        if ( ! isset( $bfa_plugin ) ) {
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/vendor/freemius/start.php';
            $bfa_plugin = fs_dynamic_init( array(
                'id'                  => '18913',
                'slug'                => 'bricks-flex-addons',
                'type'                => 'plugin',
                'public_key'          => 'pk_8c55d8f649971139698c631e4ed85',
                'is_premium'          => false,
                'has_addons'          => false,
                'has_paid_plans'      => false,
                'menu'                => array(
                    'account'        => false,
                    'support'        => false,
                ),
            ) );
        }

        return $bfa_plugin;
    }

    // Init Freemius.
    bfa_plugin();
    // Signal that SDK was initiated.
    do_action( 'bfa_plugin_loaded' );
}

/* =========================================================
 *  FLEX ADDONS BOOTSTRAP
 * =========================================================
 */

/* ---------- 1.  Load Dynamic‑Tag classes immediately ---------- */
/*     (filters must exist before Bricks parses page content)    */
require_once __DIR__ . '/includes/dynamic-tags/class-parent-page-title.php';
require_once __DIR__ . '/includes/dynamic-tags/class-parent-page-content.php';
// ↳ add more tag-class files here as you create them


/* ---------- 2.  Register custom elements on init ------------- */
add_action( 'init', function () {

    /* 2‑A  Element category */
    add_filter( 'bricks/elements/categories', function ( $cats ) {
        $cats['flex-addons'] = 'Flex Addons';
        return $cats;
    } );

    /* 2‑B  Element files */
    $element_files = [
        __DIR__ . '/includes/elements/flex-modal/modal.php',
        // add more element paths here…
    ];

    foreach ( $element_files as $file ) {
        if ( is_readable( $file ) ) {
            require_once $file;
            Bricks\Elements::register_element( $file );
        }
    }

}, 11 );   // after Bricks core elements are registered
