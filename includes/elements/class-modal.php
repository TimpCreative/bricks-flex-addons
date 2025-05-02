<?php
namespace FlexAddons\Elements;

use Bricks\Element;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Modal extends Element {

    // 1. Meta -----------------
    public $category = 'flex-layout';
    public $name     = 'flex-modal';
    public $label    = 'Modal / Off‑Canvas';
    public $icon     = 'fa-solid fa-window-maximize';  // any Font Awesome class

    // 2. Controls -------------
    public function set_controls() {

        // Trigger text
        $this->controls['trigger_text'] = [
            'tab'   => 'content',
            'label' => 'Trigger Label',
            'type'  => 'text',
            'default' => 'Open Modal',
        ];

        // Content textarea
        $this->controls['modal_content'] = [
            'tab'   => 'content',
            'label' => 'Modal Content',
            'type'  => 'textarea',
            'placeholder' => 'Add your content…',
        ];

        // Position switch (modal vs off‑canvas)
        $this->controls['type'] = [
            'tab'   => 'content',
            'label' => 'Type',
            'type'  => 'select',
            'options' => [
                'modal'      => 'Centered Modal',
                'offcanvas'  => 'Slide‑in',
            ],
            'default' => 'modal',
        ];
    }

    // 3. Render ---------------
    public function render() {
        $id      = 'flex-modal-' . $this->id;
        $type    = $this->settings['type'] ?? 'modal';
        $trigger = esc_html( $this->settings['trigger_text'] ?? 'Open' );
        $content = wp_kses_post( $this->settings['modal_content'] ?? '' );

        ?>
        <button class="flex‑modal‑trigger" data-target="<?php echo esc_attr( $id ); ?>">
            <?php echo $trigger; ?>
        </button>

        <div id="<?php echo esc_attr( $id ); ?>" class="flex‑modal <?php echo esc_attr( $type ); ?>" hidden>
            <div class="flex‑modal__inner">
                <button class="flex‑modal__close" aria-label="Close">&times;</button>
                <?php echo $content; ?>
            </div>
        </div>
        <?php
    }

    // 4. Assets ---------------
    public function enqueue_scripts() {
        wp_enqueue_style(
            'flex-modal',
            plugins_url( '../../assets/css/modal.css', __FILE__ ),
            [],
            '0.1'
        );

        wp_enqueue_script(
            'flex-modal',
            plugins_url( '../../assets/js/modal.js', __FILE__ ),
            [],
            '0.1',
            true
        );
    }
}
