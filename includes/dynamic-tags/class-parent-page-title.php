<?php

/**
 * 1) Add the tag {parent_page_title} to the Bricks Builder menu
 */
add_filter( 'bricks/dynamic_tags_list', 'my_prefix_add_parent_page_tag_to_builder' );
function my_prefix_add_parent_page_tag_to_builder( $tags ) {
    // EXACTLY as in the docs: 'name' includes curly braces
    $tags[] = [
        'name'  => '{parent_page_title}',
        'label' => 'Parent Page Title',
        'group' => 'Custom', // Optional grouping in the builder
    ];
    return $tags;
}

/**
 * 2) Hook into the 'render_tag' filter to return the actual value
 *    whenever Bricks encounters {parent_page_title}.
 */
add_filter( 'bricks/dynamic_data/render_tag', 'my_prefix_get_parent_page_title', 20, 3 );
function my_prefix_get_parent_page_title( $tag, $post, $context = 'text' ) {
    // Only handle {parent_page_title}
    if ( $tag !== '{parent_page_title}' ) {
        return $tag; // not our tag, just return as-is
    }
    // Return the parent page's title (or empty if none)
    return my_prefix_run_parent_page_logic();
}

/**
 * 3) Also hook into 'render_content' to catch {parent_page_title}
 *    if it appears among other dynamic tags or HTML in content.
 */
add_filter( 'bricks/dynamic_data/render_content', 'my_prefix_render_parent_page_tag_in_content', 20, 3 );
function my_prefix_render_parent_page_tag_in_content( $content, $post, $context = 'text' ) {
    // If the placeholder isn't in the content, do nothing
    if ( strpos( $content, '{parent_page_title}' ) === false ) {
        return $content;
    }
    // Replace with the parent's title
    $my_value = my_prefix_run_parent_page_logic();
    return str_replace( '{parent_page_title}', $my_value, $content );
}

/**
 * 4) And hook 'frontend/render_data' to ensure the tag is replaced
 *    in final frontend output.
 */
add_filter( 'bricks/frontend/render_data', 'my_prefix_render_parent_page_tag_frontend', 20, 2 );
function my_prefix_render_parent_page_tag_frontend( $content, $post ) {
    // If the placeholder isn't in the content, do nothing
    if ( strpos( $content, '{parent_page_title}' ) === false ) {
        return $content;
    }
    $my_value = my_prefix_run_parent_page_logic();
    return str_replace( '{parent_page_title}', $my_value, $content );
}

/**
 * 5) The actual logic to fetch the parent page's title.
 *    If there's no parent, returns '' (empty string).
 */
function my_prefix_run_parent_page_logic() {
    global $post;
    if ( $post && $post->post_parent ) {
        return get_the_title( $post->post_parent );
    }
    // No parent found
    return '';
}
