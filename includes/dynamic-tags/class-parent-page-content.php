<?php
namespace FlexAddons\DynamicTags;

class ParentPageContent {

    public $label = 'Parent Page Content';

    public function get_value() {
        $post = get_queried_object();
        if ( $post && $post->post_parent ) {
            $parent = get_post( $post->post_parent );
            return apply_filters( 'the_content', $parent->post_content );
        }
        return '';
    }
}
