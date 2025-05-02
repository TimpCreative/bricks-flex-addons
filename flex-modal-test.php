<?php
/**
 * Name: Flex Modal TEST
 * Description: Stand‑alone test element bypassing the autoloader.
 */

if ( ! defined( 'ABSPATH' ) || ! defined( 'BRICKS_VERSION' ) ) {
    return;
}

class Flex_Addons_Test_Modal extends \Bricks\Element {

    public $category = 'layout';

    public function get_name()  { return 'flex-modal-test'; }
    public function get_label() { return 'Flex Modal Test'; }

    public function set_controls() {}

    public function render() {
        echo '<div style="padding:1rem;border:2px dashed red">Flex Modal TEST renders</div>';
    }
}

add_action( 'init', function () {
    // register by class string ONLY
    \Bricks\Elements::register_element( 'Flex_Addons_Test_Modal' );
}, 11 );
