<?php
namespace FlexAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Modal extends \Bricks\Element {

  /* ---------- Meta ---------- */
  public $category = 'flex-layout';
  public function get_name()   { return 'flex-modal'; }
  public function get_label()  { return esc_html__( 'Flex Modal', 'flex-addons' ); }

  /* ---------- Controls ---------- */
  public function set_controls() {
    // A single “Content” textarea – enough for the Builder to render
    $this->controls['content'] = [
      'tab'   => 'content',
      'label' => esc_html__( 'Content', 'flex-addons' ),
      'type'  => 'textarea',
    ];
  }

  /* ---------- Render ---------- */
  public function render() {
    echo '<div class="flex-modal-dummy">';
    echo wp_kses_post( $this->settings['content'] ?? 'Hello from Flex Modal!' );
    echo '</div>';
  }
}
