<?php
namespace FlexAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Modal extends \Bricks\Element {

  /* ---------- Meta ---------- */
  public $category = 'flex-layout';       // shows as new category
  public $name     = 'flex-modal';        // must be unique, lowercase
  public $icon     = 'fas fa-window-maximize';
  public $css_selector = '.flex‑modal__inner';    // default CSS target

  /* ---------- REQUIRED builder labels ---------- */
  public function get_label()   { return esc_html__( 'Modal / Off‑Canvas', 'flex-addons' ); }
  public function get_keywords(){ return [ 'modal', 'popup', 'offcanvas', 'flex' ]; }

  /* ---------- Controls (simplified for now) --- */
  public function set_controls() {
    $this->controls['trigger_text'] = [
      'tab'     => 'content',
      'label'   => esc_html__( 'Trigger Label', 'flex-addons' ),
      'type'    => 'text',
      'default' => 'Open Modal',
    ];
    $this->controls['modal_content'] = [
      'tab'   => 'content',
      'label' => esc_html__( 'Modal Content', 'flex-addons' ),
      'type'  => 'textarea',
    ];
    $this->controls['type'] = [
      'tab'     => 'content',
      'label'   => esc_html__( 'Type', 'flex-addons' ),
      'type'    => 'select',
      'options' => [ 'modal' => 'Centered Modal', 'offcanvas' => 'Slide‑in' ],
      'default' => 'modal',
    ];
  }

  /* ---------- Render ---------- */
  public function render() {
    $id   = 'flex-modal-' . $this->id;
    $type = $this->settings['type'] ?? 'modal';
    ?>
    <button class="flex‑modal‑trigger" data-target="<?php echo esc_attr( $id ); ?>">
      <?php echo esc_html( $this->settings['trigger_text'] ?? 'Open' ); ?>
    </button>
    <div id="<?php echo esc_attr( $id ); ?>" class="flex‑modal <?php echo esc_attr( $type ); ?>" hidden>
      <div class="flex‑modal__inner">
        <button class="flex‑modal__close" aria-label="Close">&times;</button>
        <?php echo wp_kses_post( $this->settings['modal_content'] ?? '' ); ?>
      </div>
    </div>
    <?php
  }
}
