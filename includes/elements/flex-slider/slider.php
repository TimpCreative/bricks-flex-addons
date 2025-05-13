<?php
/**
 * Flex Slider Element
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Flex_Slider extends \Bricks\Element {
    public $category = 'Flex Addons Media & Galleries';
    public $name = 'flex-slider';
    public $icon = 'ti-layout-slider';
    public $css_selector = '.flex-slider';

    public function get_label() {
        return esc_html__( 'Before/After Slider', 'bricks' );
    }

    public function enqueue_scripts() {
        // Enqueue JS
        wp_enqueue_script(
            'bfa-slider-js',
            plugins_url('/assets/js/slider.js', dirname(__DIR__, 2)),
            [],
            '1.0.0',
            true
        );
        // Enqueue CSS
        wp_enqueue_style(
            'bfa-slider-css',
            plugins_url('/assets/css/slider.css', dirname(__DIR__, 2)),
            [],
            '1.0.0'
        );
    }

    public function set_controls() {
        // Images group
        $this->controls['beforeImage'] = [
            'tab' => 'content',
            'group' => 'images',
            'label' => esc_html__( 'Before Image', 'bricks' ),
            'type' => 'image',
            'description' => esc_html__( 'Select the "before" image', 'bricks' ),
        ];
        $this->controls['afterImage'] = [
            'tab' => 'content',
            'group' => 'images',
            'label' => esc_html__( 'After Image', 'bricks' ),
            'type' => 'image',
            'description' => esc_html__( 'Select the "after" image', 'bricks' ),
        ];

        // Slider Settings group
        $this->controls['defaultPosition'] = [
            'tab' => 'content',
            'group' => 'slider_settings',
            'label' => esc_html__( 'Default Position', 'bricks' ),
            'type' => 'number',
            'min' => 0,
            'max' => 100,
            'step' => 1,
            'default' => 50,
            'description' => esc_html__( 'Default slider position in percentage', 'bricks' ),
        ];
        $this->controls['direction'] = [
            'tab' => 'content',
            'group' => 'slider_settings',
            'label' => esc_html__( 'Direction', 'bricks' ),
            'type' => 'select',
            'options' => [
                'horizontal' => esc_html__( 'Horizontal', 'bricks' ),
                'vertical' => esc_html__( 'Vertical', 'bricks' ),
            ],
            'default' => 'horizontal',
        ];
        $this->controls['animationSpeed'] = [
            'tab' => 'content',
            'group' => 'slider_settings',
            'label' => esc_html__( 'Animation Speed', 'bricks' ),
            'type' => 'number',
            'min' => 0,
            'max' => 1000,
            'step' => 50,
            'default' => 300,
            'unit' => 'ms',
        ];
        $this->controls['aspectRatio'] = [
            'tab' => 'content',
            'group' => 'slider_settings',
            'label' => esc_html__( 'Aspect Ratio', 'bricks' ),
            'type' => 'text',
            'placeholder' => '16/9',
            'default' => '16/9',
            'description' => esc_html__( 'Set the aspect ratio (e.g. 16/9, 4/3, 1/1)', 'bricks' ),
        ];
        $this->controls['sliderWidth'] = [
            'tab' => 'content',
            'group' => 'slider_settings',
            'label' => esc_html__( 'Width', 'bricks' ),
            'type' => 'text',
            'placeholder' => '100%',
            'description' => esc_html__( 'Set the width of the slider (e.g. 100%, 600px)', 'bricks' ),
        ];
        $this->controls['sliderHeight'] = [
            'tab' => 'content',
            'group' => 'slider_settings',
            'label' => esc_html__( 'Max Height', 'bricks' ),
            'type' => 'text',
            'placeholder' => '',
            'description' => esc_html__( 'Set the max height of the slider (e.g. 400px, 60vh)', 'bricks' ),
        ];

        // Handle Styling group
        $this->controls['handleStyle'] = [
            'tab' => 'content',
            'group' => 'handle_styling',
            'label' => esc_html__( 'Handle Style', 'bricks' ),
            'type' => 'select',
            'options' => [
                'circle' => esc_html__( 'Circle', 'bricks' ),
                'arrow' => esc_html__( 'Arrow', 'bricks' ),
                'custom' => esc_html__( 'Custom', 'bricks' ),
            ],
            'default' => 'circle',
        ];
        $this->controls['handleColor'] = [
            'tab' => 'content',
            'group' => 'handle_styling',
            'label' => esc_html__( 'Handle Color', 'bricks' ),
            'type' => 'color',
            'default' => '#ffffff',
        ];
        $this->controls['handleSize'] = [
            'tab' => 'content',
            'group' => 'handle_styling',
            'label' => esc_html__( 'Handle Size', 'bricks' ),
            'type' => 'number',
            'min' => 20,
            'max' => 100,
            'default' => 40,
            'unit' => 'px',
        ];
        $this->controls['handleIcon'] = [
            'tab' => 'content',
            'group' => 'handle_styling',
            'label' => esc_html__( 'Handle Icon', 'bricks' ),
            'type' => 'icon',
            'condition' => ['handleStyle' => 'custom'],
        ];

        // Line Styling group
        $this->controls['lineColor'] = [
            'tab' => 'content',
            'group' => 'line_styling',
            'label' => esc_html__( 'Line Color', 'bricks' ),
            'type' => 'color',
            'default' => '#ffffff',
        ];
        $this->controls['lineWidth'] = [
            'tab' => 'content',
            'group' => 'line_styling',
            'label' => esc_html__( 'Line Width', 'bricks' ),
            'type' => 'number',
            'min' => 1,
            'max' => 10,
            'default' => 2,
            'unit' => 'px',
        ];
    }

    public function set_control_groups() {
        $this->control_groups['images'] = [
            'title' => esc_html__('Images', 'bricks'),
            'tab'   => 'content',
        ];
        $this->control_groups['slider_settings'] = [
            'title' => esc_html__('Slider Settings', 'bricks'),
            'tab'   => 'content',
        ];
        $this->control_groups['handle_styling'] = [
            'title' => esc_html__('Handle Styling', 'bricks'),
            'tab'   => 'content',
        ];
        $this->control_groups['line_styling'] = [
            'title' => esc_html__('Line Styling', 'bricks'),
            'tab'   => 'content',
        ];
    }

    // Helper function to robustly extract a color string from Bricks color controls
    private function bfa_get_color_string($color, $default = '#fff') {
        if (is_array($color)) {
            if (isset($color['hex'])) {
                $color = $color['hex'];
            } elseif (isset($color['color'])) {
                $color = $color['color'];
            } else {
                $color = $default;
            }
        }
        if (empty($color) || $color === 'transparent') {
            $color = $default;
        }
        return (string)$color;
    }

    public function render() {
        $settings = $this->settings;
        $root_classes = ['flex-slider'];

        // Add direction class
        if ( ! empty( $settings['direction'] ) ) {
            $root_classes[] = "flex-slider-{$settings['direction']}";
        }

        // Build inline style for width, height, aspect ratio
        $inline_style = '';
        if ( ! empty( $settings['sliderWidth'] ) ) {
            $inline_style .= 'width:' . esc_attr( $settings['sliderWidth'] ) . ';';
        } else {
            $inline_style .= 'width:100%;';
        }
        if ( ! empty( $settings['sliderHeight'] ) ) {
            $inline_style .= 'max-height:' . esc_attr( $settings['sliderHeight'] ) . ';';
        }
        if ( ! empty( $settings['aspectRatio'] ) ) {
            $inline_style .= 'aspect-ratio:' . esc_attr( $settings['aspectRatio'] ) . ';';
        } else {
            $inline_style .= 'aspect-ratio:16/9;';
        }

        $element_id = uniqid('flex-slider-');
        $root_classes[] = $element_id;

        // Get handle and line styling
        $handle_color = $this->bfa_get_color_string($settings['handleColor'] ?? null, '#fff');
        $line_color = $this->bfa_get_color_string($settings['lineColor'] ?? null, '#fff');
        $handle_size = !empty($settings['handleSize']) ? $settings['handleSize'] : 40;
        $line_width = !empty($settings['lineWidth']) ? $settings['lineWidth'] : 2;

        // Add CSS variables to inline style
        $inline_style .= sprintf(
            '--slider-handle-color: %s; --slider-handle-size: %spx; --slider-line-color: %s; --slider-line-width: %spx;',
            $handle_color,
            $handle_size,
            $line_color,
            $line_width
        );

        $this->set_attribute('_root', 'style', $inline_style);
        $this->set_attribute('_root', 'class', $root_classes);

        // Get images
        $before_image = ! empty( $settings['beforeImage'] ) ? $settings['beforeImage'] : '';
        $after_image = ! empty( $settings['afterImage'] ) ? $settings['afterImage'] : '';

        if ( ! $before_image || ! $after_image ) {
            return $this->render_element_placeholder(
                [
                    'title' => esc_html__( 'Please select both before and after images.', 'bricks' ),
                ]
            );
        }

        // Get default position
        $default_position = ! empty( $settings['defaultPosition'] ) ? $settings['defaultPosition'] : 50;

        // Output
        echo "<div {$this->render_attributes( '_root' )}>";
        echo '<div class="flex-slider-container">';
        echo '<div class="flex-slider-before">';
        echo wp_get_attachment_image( $before_image['id'], 'full' );
        echo '</div>';
        echo '<div class="flex-slider-after">';
        echo wp_get_attachment_image( $after_image['id'], 'full' );
        echo '</div>';
        $handle_style = ! empty( $settings['handleStyle'] ) ? $settings['handleStyle'] : 'circle';
        echo '<div class="flex-slider-handle ' . esc_attr( $handle_style ) . '"';
        echo ' style="left: ' . esc_attr( $default_position ) . '%"';
        echo '>';
        if ($handle_style === 'custom' && !empty($settings['handleIcon'])) {
            // Output icon markup (FontAwesome, etc.)
            $icon = $settings['handleIcon'];
            if (is_array($icon) && !empty($icon['library']) && !empty($icon['icon'])) {
                if ($icon['library'] === 'Fontawesome - Solid') {
                    echo '<i class="fa-solid ' . esc_attr($icon['icon']) . '"></i>';
                } elseif ($icon['library'] === 'ionicons') {
                    echo '<i class="' . esc_attr($icon['icon']) . '"></i>';
                } elseif ($icon['library'] === 'themify') {
                    echo '<i class="' . esc_attr($icon['icon']) . '"></i>';
                }
            }
        }
        echo '</div>';
        echo '</div>';
        echo '</div>';

        $this->set_attribute('_root', 'data-default-position', $default_position);
    }
} 