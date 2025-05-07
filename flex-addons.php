<?php
/**
 * Plugin Name: Flex Addons
 * Description: Bricks Flex Addons Premium Elements
 * Version:     0.1.0
 * Author:      Your Name
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

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
                'slug'                => 'bricks-flex-addons-pro',
                'type'                => 'plugin',
                'public_key'          => 'pk_8c55d8f649971139698c631e4ed85',
                'is_premium'          => true,
                // If your plugin is a serviceware, set this option to false.
                'has_premium_version' => true,
                'has_addons'          => true,
                'has_paid_plans'      => true,
                'trial'               => array(
                    'days'               => 14,
                    'is_require_payment' => true,
                ),
                'menu'                => array(
                    'slug'     => 'bricks-flex-addons',
                    'first-path'     => 'admin.php?page=bricks-flex-addons',
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
 *  2) Dynamic Tags: load for any paid section or Pro
 * =========================================================
 */
/* <fs_premium_only> */
$is_dev = defined( 'WP_FS__DEV_MODE' ) && WP_FS__DEV_MODE;

$load_tags = $is_dev
    || (
        bfa_plugin()->can_use_premium_code__premium_only()
        && (
            bfa_plugin()->is_plan( 'layout_navigation' )
         || bfa_plugin()->is_plan( 'interactive_animation' )
         || bfa_plugin()->is_plan( 'media_galleries' )
         || bfa_plugin()->is_plan( 'content_typography' )
         || bfa_plugin()->is_plan( 'data_displays' )
         || bfa_plugin()->is_plan( 'woo_enhancements' )
         || bfa_plugin()->is_plan( 'utility_admin' )
         || bfa_plugin()->is_plan( 'logic_conditions' )
         || bfa_plugin()->is_plan( 'dynamic_tags' )
         || bfa_plugin()->is_plan( 'bricks_flex_addons_pro' )
        )
    );

if ( $load_tags ) {
    require_once __DIR__ . '/includes/dynamic-tags/class-parent-page-title.php';
    require_once __DIR__ . '/includes/dynamic-tags/class-parent-page-content.php';
    // ↳ add more tag-class files here as you create them
}
/* </fs_premium_only> */

/* =========================================================
 *  3) Register custom elements on init, per section
 * =========================================================
 */
add_action( 'init', function() {

    // 3-A) Custom element category (always registered)
    add_filter( 'bricks/elements/categories', function( $cats ) {
        $cats['flex-addons'] = array(
            'label' => 'Flex Addons',
            'icon'  => 'flex-modal',
        );
        return $cats;
    }, 10, 1 );

    $is_dev = defined( 'WP_FS__DEV_MODE' ) && WP_FS__DEV_MODE;

    // ─── Layout / Navigation ───
    if ( $is_dev
        || (
            bfa_plugin()->can_use_premium_code__premium_only()
            && (
                bfa_plugin()->is_plan( 'layout_navigation' )
             || bfa_plugin()->is_plan( 'bricks_flex_addons_pro' )
            )
        )
    ) {
        $files = array(
            __DIR__ . '/includes/elements/flex-modal/modal.php',
            // …add layout/navigation elements here
        );
        foreach ( $files as $file ) {
            if ( is_readable( $file ) ) {
                require_once $file;
                Bricks\Elements::register_element( $file );
            }
        }
    }

    // ─── Interactive / Animation ───
    if ( $is_dev
        || (
            bfa_plugin()->can_use_premium_code__premium_only()
            && (
                bfa_plugin()->is_plan( 'interactive_animation' )
             || bfa_plugin()->is_plan( 'bricks_flex_addons_pro' )
            )
        )
    ) {
        $files = array(
            // __DIR__ . '/includes/elements/interactive-animation/your-element.php',
        );
        foreach ( $files as $file ) {
            if ( is_readable( $file ) ) {
                require_once $file;
                Bricks\Elements::register_element( $file );
            }
        }
    }

    // ─── Media Galleries ───
    if ( $is_dev
        || (
            bfa_plugin()->can_use_premium_code__premium_only()
            && (
                bfa_plugin()->is_plan( 'media_galleries' )
             || bfa_plugin()->is_plan( 'bricks_flex_addons_pro' )
            )
        )
    ) {
        $files = array(
            // __DIR__ . '/includes/elements/media-galleries/your-element.php',
        );
        foreach ( $files as $file ) {
            if ( is_readable( $file ) ) {
                require_once $file;
                Bricks\Elements::register_element( $file );
            }
        }
    }

    // ─── Content / Typography ───
    if ( $is_dev
        || (
            bfa_plugin()->can_use_premium_code__premium_only()
            && (
                bfa_plugin()->is_plan( 'content_typography' )
             || bfa_plugin()->is_plan( 'bricks_flex_addons_pro' )
            )
        )
    ) {
        $files = array(
            // __DIR__ . '/includes/elements/content-typography/your-element.php',
        );
        foreach ( $files as $file ) {
            if ( is_readable( $file ) ) {
                require_once $file;
                Bricks\Elements::register_element( $file );
            }
        }
    }

    // ─── Data Displays ───
    if ( $is_dev
        || (
            bfa_plugin()->can_use_premium_code__premium_only()
            && (
                bfa_plugin()->is_plan( 'data_displays' )
             || bfa_plugin()->is_plan( 'bricks_flex_addons_pro' )
            )
        )
    ) {
        $files = array(
            // __DIR__ . '/includes/elements/data-displays/your-element.php',
        );
        foreach ( $files as $file ) {
            if ( is_readable( $file ) ) {
                require_once $file;
                Bricks\Elements::register_element( $file );
            }
        }
    }

    // ─── Woo Enhancements ───
    if ( $is_dev
        || (
            bfa_plugin()->can_use_premium_code__premium_only()
            && (
                bfa_plugin()->is_plan( 'woo_enhancements' )
             || bfa_plugin()->is_plan( 'bricks_flex_addons_pro' )
            )
        )
    ) {
        $files = array(
            // __DIR__ . '/includes/elements/woo-enhancements/your-element.php',
        );
        foreach ( $files as $file ) {
            if ( is_readable( $file ) ) {
                require_once $file;
                Bricks\Elements::register_element( $file );
            }
        }
    }

    // ─── Utility / Admin ───
    if ( $is_dev
        || (
            bfa_plugin()->can_use_premium_code__premium_only()
            && (
                bfa_plugin()->is_plan( 'utility_admin' )
             || bfa_plugin()->is_plan( 'bricks_flex_addons_pro' )
            )
        )
    ) {
        $files = array(
            // __DIR__ . '/includes/elements/utility-admin/your-element.php',
        );
        foreach ( $files as $file ) {
            if ( is_readable( $file ) ) {
                require_once $file;
                Bricks\Elements::register_element( $file );
            }
        }
    }

    // ─── Logic / Conditions ───
    if ( $is_dev
        || (
            bfa_plugin()->can_use_premium_code__premium_only()
            && (
                bfa_plugin()->is_plan( 'logic_conditions' )
             || bfa_plugin()->is_plan( 'bricks_flex_addons_pro' )
            )
        )
    ) {
        $files = array(
            // __DIR__ . '/includes/elements/logic-conditions/your-element.php',
        );
        foreach ( $files as $file ) {
            if ( is_readable( $file ) ) {
                require_once $file;
                Bricks\Elements::register_element( $file );
            }
        }
    }

}, 11 );   // init priority after Bricks core elements are registered

?>