<?php
namespace FlexAddons\DynamicTags;

class ParentPageTitle {

    public $label = 'Parent Page Title';

    public function get_value() {
        $post = get_queried_object();
        if ( $post && $post->post_parent ) {
            return get_the_title( $post->post_parent );
        }
        return '';
    }
}
