<?php

/**
 * 1) Add the tag {parent_page_content} to the Bricks Builder menu.
 *    This makes it selectable under the "Custom" group in the builder.
 */
add_filter( 'bricks/dynamic_tags_list', 'my_prefix_add_parent_content_tag' );
function my_prefix_add_parent_content_tag( $tags ) {
    $tags[] = [
        'name'  => '{parent_page_content}',
        'label' => 'Parent Page Content (Text)',
        'group' => 'Custom', // Optional grouping in the builder
    ];
    return $tags;
}

/**
 * 2) Hook into 'bricks/dynamic_data/render_tag' to replace {parent_page_content}
 *    with the parent's content (or empty if none).
 */
add_filter( 'bricks/dynamic_data/render_tag', 'my_prefix_render_parent_content_tag', 20, 3 );
function my_prefix_render_parent_content_tag( $tag, $post, $context = 'text' ) {
    // Only handle our custom tag
    if ( $tag !== '{parent_page_content}' ) {
        return $tag; // It's not our tag, so just return it unchanged
    }
    // Return the parent's content
    return my_prefix_run_parent_page_content_logic();
}

/**
 * 3) Also hook into 'bricks/dynamic_data/render_content' to catch {parent_page_content}
 *    if it appears within other content strings or dynamic tags.
 */
add_filter( 'bricks/dynamic_data/render_content', 'my_prefix_render_parent_content_in_text', 20, 3 );
function my_prefix_render_parent_content_in_text( $content, $post, $context = 'text' ) {
    if ( strpos( $content, '{parent_page_content}' ) === false ) {
        return $content;
    }
    // Replace with the parent's content
    $parent_content = my_prefix_run_parent_page_content_logic();
    return str_replace( '{parent_page_content}', $parent_content, $content );
}

/**
 * 4) Hook into 'bricks/frontend/render_data' to ensure {parent_page_content}
 *    is replaced in the final frontend output.
 */
add_filter( 'bricks/frontend/render_data', 'my_prefix_render_parent_content_frontend', 20, 2 );
function my_prefix_render_parent_content_frontend( $content, $post ) {
    if ( strpos( $content, '{parent_page_content}' ) === false ) {
        return $content;
    }
    $parent_content = my_prefix_run_parent_page_content_logic();
    return str_replace( '{parent_page_content}', $parent_content, $content );
}

/**
 * 5) The logic that fetches the parent page's content.
 *    If there's no parent, we return an empty string.
 *    Optionally, strip shortcodes or HTML if you want plain text only.
 */
function my_prefix_run_parent_page_content_logic() {
    global $post;
    if ( $post && $post->post_parent ) {
        // Fetch the raw parent page content
        $parent_content = get_post_field( 'post_content', $post->post_parent );

        // For "plain text" only (optional):
        $parent_content = strip_shortcodes( $parent_content );
        $parent_content = wp_strip_all_tags( $parent_content );

        return $parent_content;
    }
    return ''; // No parent or no $post
}
