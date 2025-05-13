<?php

/**
 * Add the tag {bfa_current_user_first_name} to the Bricks Builder menu
 */
add_filter( 'bricks/dynamic_tags_list', 'bfa_add_current_user_first_name_tag' );
function bfa_add_current_user_first_name_tag( $tags ) {
    $tags[] = [
        'name'  => '{bfa_current_user_first_name}',
        'label' => 'Current User First Name',
        'group' => 'Flex Addons',
    ];
    return $tags;
}

/**
 * Hook into the 'render_tag' filter to return the actual value
 */
add_filter( 'bricks/dynamic_data/render_tag', 'bfa_get_current_user_first_name', 20, 3 );
function bfa_get_current_user_first_name( $tag, $post, $context = 'text' ) {
    if ( $tag !== '{bfa_current_user_first_name}' ) {
        return $tag;
    }
    return bfa_run_current_user_first_name_logic();
}

/**
 * Hook into 'render_content' to catch the tag in content
 */
add_filter( 'bricks/dynamic_data/render_content', 'bfa_render_current_user_first_name_in_content', 20, 3 );
function bfa_render_current_user_first_name_in_content( $content, $post, $context = 'text' ) {
    if ( strpos( $content, '{bfa_current_user_first_name}' ) === false ) {
        return $content;
    }
    $value = bfa_run_current_user_first_name_logic();
    return str_replace( '{bfa_current_user_first_name}', $value, $content );
}

/**
 * Hook into frontend render to ensure tag is replaced
 */
add_filter( 'bricks/frontend/render_data', 'bfa_render_current_user_first_name_frontend', 20, 2 );
function bfa_render_current_user_first_name_frontend( $content, $post ) {
    if ( strpos( $content, '{bfa_current_user_first_name}' ) === false ) {
        return $content;
    }
    $value = bfa_run_current_user_first_name_logic();
    return str_replace( '{bfa_current_user_first_name}', $value, $content );
}

/**
 * Logic to get current user's first name
 */
function bfa_run_current_user_first_name_logic() {
    $current_user = wp_get_current_user();
    if ( $current_user && $current_user->exists() ) {
        return $current_user->first_name;
    }
    return '';
} 