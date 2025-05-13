<?php

/**
 * Add the tag {bfa_current_user_role} to the Bricks Builder menu
 */
add_filter( 'bricks/dynamic_tags_list', 'bfa_add_current_user_role_tag' );
function bfa_add_current_user_role_tag( $tags ) {
    $tags[] = [
        'name'  => '{bfa_current_user_role}',
        'label' => 'Current User Role',
        'group' => 'Flex Addons',
    ];
    return $tags;
}

/**
 * Hook into the 'render_tag' filter to return the actual value
 */
add_filter( 'bricks/dynamic_data/render_tag', 'bfa_get_current_user_role', 20, 3 );
function bfa_get_current_user_role( $tag, $post, $context = 'text' ) {
    if ( $tag !== '{bfa_current_user_role}' ) {
        return $tag;
    }
    return bfa_run_current_user_role_logic();
}

/**
 * Hook into 'render_content' to catch the tag in content
 */
add_filter( 'bricks/dynamic_data/render_content', 'bfa_render_current_user_role_in_content', 20, 3 );
function bfa_render_current_user_role_in_content( $content, $post, $context = 'text' ) {
    if ( strpos( $content, '{bfa_current_user_role}' ) === false ) {
        return $content;
    }
    $value = bfa_run_current_user_role_logic();
    return str_replace( '{bfa_current_user_role}', $value, $content );
}

/**
 * Hook into frontend render to ensure tag is replaced
 */
add_filter( 'bricks/frontend/render_data', 'bfa_render_current_user_role_frontend', 20, 2 );
function bfa_render_current_user_role_frontend( $content, $post ) {
    if ( strpos( $content, '{bfa_current_user_role}' ) === false ) {
        return $content;
    }
    $value = bfa_run_current_user_role_logic();
    return str_replace( '{bfa_current_user_role}', $value, $content );
}

/**
 * Logic to get current user's role
 */
function bfa_run_current_user_role_logic() {
    $current_user = wp_get_current_user();
    if ( $current_user && $current_user->exists() ) {
        $roles = $current_user->roles;
        if ( ! empty( $roles ) ) {
            // Get the first role and make it more readable
            $role = reset( $roles );
            return ucfirst( str_replace( '_', ' ', $role ) );
        }
    }
    return '';
} 