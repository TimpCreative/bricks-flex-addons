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

// === Flex Addons bootstrap ===
define( 'FLEX_ADDONS_PATH', plugin_dir_path( __FILE__ ) );
require_once FLEX_ADDONS_PATH . 'includes/loader.php';
