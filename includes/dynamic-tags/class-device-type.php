<?php

/**
 * Add the tag {bfa_device_type} to the Bricks Builder menu
 */
add_filter( 'bricks/dynamic_tags_list', 'bfa_add_device_type_tag' );
function bfa_add_device_type_tag( $tags ) {
    $tags[] = [
        'name'  => '{bfa_device_type}',
        'label' => 'Device Type',
        'group' => 'Flex Addons',
    ];
    return $tags;
}

/**
 * Hook into the 'render_tag' filter to return the actual value
 */
add_filter( 'bricks/dynamic_data/render_tag', 'bfa_get_device_type', 20, 3 );
function bfa_get_device_type( $tag, $post, $context = 'text' ) {
    if ( $tag !== '{bfa_device_type}' ) {
        return $tag;
    }
    return bfa_run_device_type_logic();
}

/**
 * Hook into 'render_content' to catch the tag in content
 */
add_filter( 'bricks/dynamic_data/render_content', 'bfa_render_device_type_in_content', 20, 3 );
function bfa_render_device_type_in_content( $content, $post, $context = 'text' ) {
    if ( strpos( $content, '{bfa_device_type}' ) === false ) {
        return $content;
    }
    $value = bfa_run_device_type_logic();
    return str_replace( '{bfa_device_type}', $value, $content );
}

/**
 * Hook into frontend render to ensure tag is replaced
 */
add_filter( 'bricks/frontend/render_data', 'bfa_render_device_type_frontend', 20, 2 );
function bfa_render_device_type_frontend( $content, $post ) {
    if ( strpos( $content, '{bfa_device_type}' ) === false ) {
        return $content;
    }
    $value = bfa_run_device_type_logic();
    return str_replace( '{bfa_device_type}', $value, $content );
}

/**
 * Logic to detect device type
 */
function bfa_run_device_type_logic() {
    if ( ! function_exists( 'wp_is_mobile' ) ) {
        return 'unknown';
    }

    if ( wp_is_mobile() ) {
        // Check if it's a tablet
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        if ( preg_match( '/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', $user_agent ) ) {
            return 'tablet';
        }
        return 'mobile';
    }

    return 'desktop';
} 