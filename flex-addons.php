<?php
/**
 * Plugin Name: Flex Addons
 * Description: Bricks Flex Addons Premium Elements
 * Version:     0.2.2-alpha
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
                'has_premium_version' => true,
                'has_addons'          => true,
                'has_paid_plans'      => true,
                'trial'               => array(
                    'days'               => 14,
                    'is_require_payment' => true,
                ),
                'menu'                => array(
                    'slug'           => 'flex-addons',
                    'first-path'     => 'admin.php?page=flex-addons',
                    'support'        => false,
                    'account'        => true,
                    'pricing'        => true,
                    'addons'         => true,
                    'contact'        => true,
                    'affiliation'    => false,
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

// Include admin menu and pages
require_once __DIR__ . '/includes/admin/menu-pages.php';

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
    $settings = get_option( 'bfa_settings', array() );
    $dynamic_tags = isset( $settings['dynamic_tags'] ) ? $settings['dynamic_tags'] : array();

    // Only load tags that are enabled in settings
    if ( isset( $dynamic_tags['parent_page_title'] ) && $dynamic_tags['parent_page_title'] ) {
        require_once __DIR__ . '/includes/dynamic-tags/class-parent-page-title.php';
    }
    if ( isset( $dynamic_tags['parent_page_content'] ) && $dynamic_tags['parent_page_content'] ) {
        require_once __DIR__ . '/includes/dynamic-tags/class-parent-page-content.php';
    }
    if ( isset( $dynamic_tags['current_user_first_name'] ) && $dynamic_tags['current_user_first_name'] ) {
        require_once __DIR__ . '/includes/dynamic-tags/class-current-user-first-name.php';
    }
    if ( isset( $dynamic_tags['current_user_role'] ) && $dynamic_tags['current_user_role'] ) {
        require_once __DIR__ . '/includes/dynamic-tags/class-current-user-role.php';
    }
    if ( isset( $dynamic_tags['device_type'] ) && $dynamic_tags['device_type'] ) {
        require_once __DIR__ . '/includes/dynamic-tags/class-device-type.php';
    }
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
        $cats['flex-addons-media'] = array(
            'label' => 'Flex Addons Media & Galleries',
            'icon'  => 'ti-gallery',
        );
        return $cats;
    }, 20, 1 );

    $is_dev = defined( 'WP_FS__DEV_MODE' ) && WP_FS__DEV_MODE;
    $settings = get_option( 'bfa_settings', array() );

    // ─── Layout / Navigation ───
    if ( $is_dev || bfa_plugin()->can_use_premium_code__premium_only() ) {
        if ( isset( $settings['elements']['layout_navigation']['enabled'] ) && $settings['elements']['layout_navigation']['enabled'] ) {
            $files = array();
            
            if ( isset( $settings['elements']['layout_navigation']['modal'] ) && $settings['elements']['layout_navigation']['modal'] ) {
                $files[] = __DIR__ . '/includes/elements/flex-modal/modal.php';
            }
            if ( isset( $settings['elements']['layout_navigation']['flip_box'] ) && $settings['elements']['layout_navigation']['flip_box'] ) {
                $files[] = __DIR__ . '/includes/elements/flex-flip-box/flip-box.php';
            }
            if ( isset( $settings['elements']['layout_navigation']['style_card'] ) && $settings['elements']['layout_navigation']['style_card'] ) {
                $files[] = __DIR__ . '/includes/elements/flex-style-card/style-card.php';
            }
            if ( isset( $settings['elements']['layout_navigation']['back_to_top'] ) && $settings['elements']['layout_navigation']['back_to_top'] ) {
                $files[] = __DIR__ . '/includes/elements/flex-back-to-top/back-to-top.php';
            }

            foreach ( $files as $file ) {
                if ( is_readable( $file ) ) {
                    require_once $file;
                    Bricks\Elements::register_element( $file );
                }
            }
        }
    }

    // ─── Media Galleries ───
    if ( $is_dev || bfa_plugin()->can_use_premium_code__premium_only() ) {
        if ( isset( $settings['elements']['media_galleries']['enabled'] ) && $settings['elements']['media_galleries']['enabled'] ) {
            $files = array();
            
            if ( isset( $settings['elements']['media_galleries']['slider'] ) && $settings['elements']['media_galleries']['slider'] ) {
                $files[] = __DIR__ . '/includes/elements/flex-slider/slider.php';
            }

            foreach ( $files as $file ) {
                if ( is_readable( $file ) ) {
                    require_once $file;
                    Bricks\Elements::register_element( $file );
                }
            }
        }
    }

    // ─── Content / Typography ───
    if ( $is_dev || bfa_plugin()->can_use_premium_code__premium_only() ) {
        if ( isset( $settings['elements']['content_typography']['enabled'] ) && $settings['elements']['content_typography']['enabled'] ) {
            $files = array();
            foreach ( $files as $file ) {
                if ( is_readable( $file ) ) {
                    require_once $file;
                    Bricks\Elements::register_element( $file );
                }
            }
        }
    }

    // ─── Data Displays ───
    if ( $is_dev || bfa_plugin()->can_use_premium_code__premium_only() ) {
        if ( isset( $settings['elements']['data_displays']['enabled'] ) && $settings['elements']['data_displays']['enabled'] ) {
            $files = array();
            foreach ( $files as $file ) {
                if ( is_readable( $file ) ) {
                    require_once $file;
                    Bricks\Elements::register_element( $file );
                }
            }
        }
    }

    // ─── Woo Enhancements ───
    if ( $is_dev || bfa_plugin()->can_use_premium_code__premium_only() ) {
        if ( isset( $settings['elements']['woo_enhancements']['enabled'] ) && $settings['elements']['woo_enhancements']['enabled'] ) {
            $files = array();
            foreach ( $files as $file ) {
                if ( is_readable( $file ) ) {
                    require_once $file;
                    Bricks\Elements::register_element( $file );
                }
            }
        }
    }

    // ─── Utility / Admin ───
    if ( $is_dev || bfa_plugin()->can_use_premium_code__premium_only() ) {
        if ( isset( $settings['elements']['utility_admin']['enabled'] ) && $settings['elements']['utility_admin']['enabled'] ) {
            $files = array();
            foreach ( $files as $file ) {
                if ( is_readable( $file ) ) {
                    require_once $file;
                    Bricks\Elements::register_element( $file );
                }
            }
        }
    }

    // ─── Logic / Conditions ───
    if ( $is_dev || bfa_plugin()->can_use_premium_code__premium_only() ) {
        if ( isset( $settings['elements']['logic_conditions']['enabled'] ) && $settings['elements']['logic_conditions']['enabled'] ) {
            $files = array();
            foreach ( $files as $file ) {
                if ( is_readable( $file ) ) {
                    require_once $file;
                    Bricks\Elements::register_element( $file );
                }
            }
        }
    }

}, 11 );   // init priority after Bricks core elements are registered

?>