<?php
/**
 * Flex Flip Box – with nested Front + Back elements
 */
if ( ! defined( 'ABSPATH' ) || ! defined( 'BRICKS_VERSION' ) ) {
    return;
}

use Bricks\Frontend;

class BFA_Flip_Box extends \Bricks\Element {

    /* ---------- Meta ---------- */
    public $category = 'Flex Addons Layout';
    public $name     = 'flip-box';
    public $icon     = 'fa-solid fa-rotate';
    public $nestable = true;

    public function get_label()    { return 'Flex Flip Box'; }
    public function get_keywords() { return [ 'flip', 'box', 'card', 'hover', 'animation' ]; }

    /* ---------- Pre‑insert nested children ---------- */
    public function get_nestable_children() {
        return [
            [
                'name'     => 'block',
                'label'    => esc_html__( 'Flip Front', 'flex-addons' ),
                'settings' => [
                    '_cssClasses' => 'bfa-flip-box__front',
                ],
            ],
            [
                'name'     => 'block',
                'label'    => esc_html__( 'Flip Back', 'flex-addons' ),
                'settings' => [
                    '_cssClasses' => 'bfa-flip-box__back',
                ],
            ],
        ];
    }

    /* ---------- Controls ---------- */
    public function set_controls() {
        // CONTENT tab
        $this->controls['trigger_type'] = [
            'tab'     => 'content',
            'label'   => esc_html__( 'Trigger Type', 'flex-addons' ),
            'type'    => 'select',
            'options' => [
                'hover' => esc_html__( 'Hover', 'flex-addons' ),
                'click' => esc_html__( 'Click', 'flex-addons' ),
            ],
            'default' => 'hover',
        ];

        $this->controls['flip_direction'] = [
            'tab'     => 'content',
            'label'   => esc_html__( 'Flip Direction', 'flex-addons' ),
            'type'    => 'select',
            'options' => [
                'horizontal' => esc_html__( 'Horizontal', 'flex-addons' ),
                'vertical'   => esc_html__( 'Vertical', 'flex-addons' ),
            ],
            'default' => 'horizontal',
        ];

        $this->controls['flip_duration'] = [
            'tab'     => 'content',
            'label'   => esc_html__( 'Flip Duration', 'flex-addons' ),
            'type'    => 'number',
            'min'     => 0.1,
            'max'     => 5,
            'step'    => 0.1,
            'default' => 0.6,
            'unit'    => 's',
        ];
    }

    public function render() {
        $id = 'flex-flip-box-' . $this->id;
        
        // Get settings
        $trigger_type = $this->settings['trigger_type'] ?? 'hover';
        $direction = $this->settings['flip_direction'] ?? 'horizontal';
        $duration = $this->settings['flip_duration'] ?? 0.6;

        // Build classes
        $classes = ['bfa-flip-box'];
        $classes[] = 'bfa-flip-box--' . $trigger_type;
        $classes[] = 'bfa-flip-box--' . $direction;

        // 1) Flip box container
        echo '<div id="' . esc_attr( $id ) . '" class="' . esc_attr( implode( ' ', $classes ) ) . '" style="--flip-duration: ' . esc_attr( $duration ) . 's">';

        // 2) Try rendering any nested children (Builder defaults or user drops)
        $inner = \Bricks\Frontend::render_children( $this );

        if ( trim( $inner ) ) {
            // We have child content — output it
            echo $inner;
        } else {
            // No children saved (front‑end first load) — fallback default:
            echo '<div class="bfa-flip-box__front">';
            echo   '<div class="bfa-flip-box__content">';
            echo     esc_html__( 'Front Content', 'flex-addons' );
            echo   '</div>';
            echo '</div>';
            echo '<div class="bfa-flip-box__back">';
            echo   '<div class="bfa-flip-box__content">';
            echo     esc_html__( 'Back Content', 'flex-addons' );
            echo   '</div>';
            echo '</div>';
        }

        echo '</div>'; // .bfa-flip-box
    }

    /* ---------- Enqueue JS & CSS ---------- */
    public function enqueue_scripts() {
        $base = plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) . 'assets/';

        wp_enqueue_style(
            'bfa-flip-box',
            $base . 'css/flip-box.css',
            [],
            '0.1'
        );

        wp_enqueue_script(
            'bfa-flip-box',
            $base . 'js/flip-box.js',
            [],
            '0.1',
            true
        );
    }
}
