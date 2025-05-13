<?php

/**
 * 1) Add the tag {bfa_parent_page_title} to the Bricks Builder menu
 */
add_filter( 'bricks/dynamic_tags_list', 'bfa_add_parent_page_tag_to_builder' );
function bfa_add_parent_page_tag_to_builder( $tags ) {
    // EXACTLY as in the docs: 'name' includes curly braces
    $tags[] = [
        'name'  => '{bfa_parent_page_title}',
        'label' => 'Parent Page Title',
        'group' => 'Flex Addons', // Optional grouping in the builder
    ];
    return $tags;
}

/**
 * 2) Hook into the 'render_tag' filter to return the actual value
 *    whenever Bricks encounters {bfa_parent_page_title}.
 */
add_filter( 'bricks/dynamic_data/render_tag', 'bfa_get_parent_page_title', 20, 3 );
function bfa_get_parent_page_title( $tag, $post, $context = 'text' ) {
    // Only handle {bfa_parent_page_title}
    if ( $tag !== '{bfa_parent_page_title}' ) {
        return $tag; // not our tag, just return as-is
    }
    // Return the parent page's title (or empty if none)
    return bfa_run_parent_page_logic();
}

/**
 * 3) Also hook into 'render_content' to catch {bfa_parent_page_title}
 *    if it appears among other dynamic tags or HTML in content.
 */
add_filter( 'bricks/dynamic_data/render_content', 'bfa_render_parent_page_tag_in_content', 20, 3 );
function bfa_render_parent_page_tag_in_content( $content, $post, $context = 'text' ) {
    // If the placeholder isn't in the content, do nothing
    if ( strpos( $content, '{bfa_parent_page_title}' ) === false ) {
        return $content;
    }
    // Replace with the parent's title
    $my_value = bfa_run_parent_page_logic();
    return str_replace( '{bfa_parent_page_title}', $my_value, $content );
}

/**
 * 4) And hook 'frontend/render_data' to ensure the tag is replaced
 *    in final frontend output.
 */
add_filter( 'bricks/frontend/render_data', 'bfa_render_parent_page_tag_frontend', 20, 2 );
function bfa_render_parent_page_tag_frontend( $content, $post ) {
    // If the placeholder isn't in the content, do nothing
    if ( strpos( $content, '{bfa_parent_page_title}' ) === false ) {
        return $content;
    }
    $my_value = bfa_run_parent_page_logic();
    return str_replace( '{bfa_parent_page_title}', $my_value, $content );
}

/**
 * 5) The actual logic to fetch the parent page's title.
 *    If there's no parent, returns '' (empty string).
 */
function bfa_run_parent_page_logic() {
    global $post;
    if ( $post && $post->post_parent ) {
        return get_the_title( $post->post_parent );
    }
    // No parent found
    return '';
}
