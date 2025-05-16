<?php
/**
 * Flex Modal – now with nested Trigger + Inner wrapper + Close
 */
if ( ! defined( 'ABSPATH' ) || ! defined( 'BRICKS_VERSION' ) ) {
	return;
}

use Bricks\Frontend;

class BFA_Flex_Modal extends \Bricks\Element {

	/* ---------- Meta ---------- */
	public $category = 'Flex Addons Layout';
	public $name     = 'flex-modal';
	public $icon     = 'fa-solid fa-window-maximize';
	public $nestable = true;

	public function get_label()    { return 'Modal'; }
	public function get_keywords() { return [ 'modal', 'popup', 'dialog', 'offcanvas' ]; }

	/* ---------- Pre‑insert nested children ---------- */
	public function get_nestable_children() {
	    return [
	        [
	            'name'     => 'block',
	            'label'    => esc_html__( 'Modal Inner', 'flex-addons' ),
	            'settings' => [
	                '_cssClasses' => 'bfa-modal__inner',
	            ],
	            'children' => [
	                [
	                    'name'     => 'button',
	                    'label'    => esc_html__( 'Close Modal', 'flex-addons' ),
	                    'settings' => [
	                        // no text label
	                        'text'          => '',
	                        // default to FontAwesome xmark
	                        'icon'          => [
	                            'library' => 'Font Awesome 6',
	                            'icon'    => 'fa-solid fa-xmark',
	                        ],
	                        'icon_position' => 'only',
	                        // keep your existing class for styling
	                        '_cssClasses'   => 'bfa-modal__close',
	                    ],
	                ],
	            ],
	        ],
	    ];
	}

	/* ---------- Controls ---------- */
	public function set_controls() {
	    // CONTENT tab
	    $this->controls['trigger_text'] = [
	        'tab'     => 'content',
	        'label'   => esc_html__( 'Trigger Label', 'flex-addons' ),
	        'type'    => 'text',
	        'default' => esc_html__( 'Open Modal',     'flex-addons' ),
	    ];
	    $this->controls['type'] = [
	        'tab'     => 'content',
	        'label'   => esc_html__( 'Type', 'flex-addons' ),
	        'type'    => 'select',
	        'options' => [
	            'modal'     => esc_html__( 'Centered Modal', 'flex-addons' ),
	            'offcanvas' => esc_html__( 'Slide‑in',        'flex-addons' ),
	        ],
	        'default' => 'modal',
	    ];
		$this->controls['offcanvas_direction'] = [
		    'tab'      => 'content',
		    'label'    => esc_html__( 'Slide From', 'flex-addons' ),
		    'type'     => 'select',
		    'options'  => [
		        'right'  => esc_html__( 'Right',  'flex-addons' ),
		        'left'   => esc_html__( 'Left',   'flex-addons' ),
		        'top'    => esc_html__( 'Top',    'flex-addons' ),
		        'bottom' => esc_html__( 'Bottom', 'flex-addons' ),
		    ],
		    'default'  => 'right',
		    'required' => [ 'type', '=', 'offcanvas' ],
		];
	    $this->controls['preview_open'] = [
	        'tab'     => 'content',
	        'label'   => esc_html__( 'Keep open while styling', 'flex-addons' ),
	        'type'    => 'checkbox',
	        'default' => '',
	    ];
	}

public function render() {

    $id    = 'flex-modal-' . $this->id;
    $type  = $this->settings['type'] ?? 'modal';
    $open  = ! empty( $this->settings['preview_open'] ) ? ' bfa-modal--open' : '';

    // off‑canvas direction
    $dir_class = '';
    if ( $type === 'offcanvas' ) {
        $dir       = $this->settings['offcanvas_direction'] ?? 'right';
        $dir_class = ' offcanvas-' . esc_attr( $dir );
    }

    // 1) wrapper for inline CSS in Builder
    echo '<div class="bfa-modal-container">';
    if ( bricks_is_builder() && ! empty( $this->settings['preview_open'] ) ) {
        $css = plugin_dir_path( dirname( dirname( dirname( __FILE__ ) ) ) ) . 'assets/css/modal.css';
        if ( file_exists( $css ) ) {
            echo '<style>' . file_get_contents( $css ) . '</style>';
        }
    }

    // 2) static trigger
    echo '<button class="bfa-modal-trigger" data-target="' . esc_attr( $id ) . '">'
       .   esc_html( $this->settings['trigger_text'] )
       . '</button>';

    // 3) modal wrapper with classes
    echo '<div id="' . esc_attr( $id ) . '" class="bfa-modal '
       . esc_attr( $type ) . $dir_class . $open . '">';

        // 4) try rendering any nested children (Builder defaults or user drops)
        $inner = \Bricks\Frontend::render_children( $this );

        if ( trim( $inner ) ) {
            // we have child content — output it
            echo $inner;
        } else {
            // no children saved (front‑end first load) — fallback default:
            echo '<div class="bfa-modal__inner">';
            echo   '<button class="bfa-modal__close" aria-label="Close">'
                 . '<i class="fa-solid fa-xmark"></i>'
                 . '</button>';
            echo '</div>';
        }

    echo '</div>'; // .bfa-modal

    // 5) close wrapper
    echo '</div>'; // .bfa-modal-container
}

	/* ---------- Enqueue JS & CSS ---------- */
	public function enqueue_scripts() {
	    $base = plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) . 'assets/';

	    // 1️⃣ Load Font Awesome from CDN (or self‑hosted if you prefer)
	    wp_enqueue_style(
	        'bfa-fontawesome',
	        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
	        [],
	        '6.4.0'
	    );

	    // 2️⃣ Then your modal CSS/JS as before
	    wp_enqueue_style(
	        'bfa-modal',
	        $base . 'css/modal.css',
	        [ 'bfa-fontawesome' ],  // ensure FontAwesome is loaded first
	        '0.4'
	    );

	    wp_enqueue_script(
	        'bfa-modal',
	        $base . 'js/modal.js',
	        [],
	        '0.4',
	        true
	    );
	}

}
