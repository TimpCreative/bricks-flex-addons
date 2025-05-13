<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class BFA_Back_To_Top extends \Bricks\Element {
    public $category = 'Flex Addons Layout';
    public $name = 'bfa-back-to-top';
    public $icon = 'fa-solid fa-arrow-up';
    public $css_selector = '.bfa-back-to-top';
    public $nestable = false;
    public $scripts = ['bfaBackToTop'];

    public function get_label() {
        return esc_html__( 'Back to Top', 'bricks' );
    }

    public function get_keywords() {
        return ['back', 'top', 'scroll', 'button', 'arrow'];
    }

    public function set_control_groups() {
        $this->control_groups['button'] = [
            'title' => esc_html__( 'Button', 'bricks' ),
            'tab'   => 'content',
        ];
        $this->control_groups['icon'] = [
            'title' => esc_html__( 'Icon', 'bricks' ),
            'tab'   => 'content',
        ];
        $this->control_groups['position'] = [
            'title' => esc_html__( 'Position', 'bricks' ),
            'tab'   => 'content',
        ];
        $this->control_groups['style'] = [
            'title' => esc_html__( 'Style', 'bricks' ),
            'tab'   => 'content',
        ];
        $this->control_groups['border'] = [
            'title' => esc_html__( 'Border', 'bricks' ),
            'tab'   => 'content',
        ];
    }

    public function set_controls() {
        // Button shape
        $this->controls['shape'] = [
            'tab' => 'content',
            'group' => 'button',
            'label' => esc_html__( 'Shape', 'bricks' ),
            'type' => 'select',
            'options' => [
                'circle' => esc_html__( 'Circle', 'bricks' ),
                'square' => esc_html__( 'Square', 'bricks' ),
                'rounded' => esc_html__( 'Rounded', 'bricks' ),
            ],
            'default' => 'circle',
        ];
        // Size
        $this->controls['size'] = [
            'tab' => 'content',
            'group' => 'button',
            'label' => esc_html__( 'Size (px)', 'bricks' ),
            'type' => 'number',
            'default' => 48,
            'min' => 24,
            'max' => 128,
            'step' => 1,
        ];
        // Tooltip
        $this->controls['tooltip'] = [
            'tab' => 'content',
            'group' => 'button',
            'label' => esc_html__( 'Tooltip', 'bricks' ),
            'type' => 'text',
            'default' => esc_html__( 'Back to Top', 'bricks' ),
        ];
        // Show/hide on devices
        $this->controls['show_on'] = [
            'tab' => 'content',
            'group' => 'button',
            'label' => esc_html__( 'Show On', 'bricks' ),
            'type' => 'checkbox',
            'options' => [
                'desktop' => esc_html__( 'Desktop', 'bricks' ),
                'tablet' => esc_html__( 'Tablet', 'bricks' ),
                'mobile' => esc_html__( 'Mobile', 'bricks' ),
            ],
            'default' => ['desktop', 'tablet', 'mobile'],
        ];
        // Scroll offset
        $this->controls['scroll_offset'] = [
            'tab' => 'content',
            'group' => 'button',
            'label' => esc_html__( 'Show After Scroll (px)', 'bricks' ),
            'type' => 'number',
            'default' => 0,
            'min' => 0,
            'max' => 2000,
            'step' => 10,
        ];
        // Icon
        $this->controls['icon'] = [
            'tab' => 'content',
            'group' => 'icon',
            'label' => esc_html__( 'Icon', 'bricks' ),
            'type' => 'icon',
            'default' => [
                'library' => 'Fontawesome - Solid',
                'icon' => 'fa-arrow-up',
            ],
        ];
        // Icon color
        $this->controls['icon_color'] = [
            'tab' => 'content',
            'group' => 'icon',
            'label' => esc_html__( 'Icon Color', 'bricks' ),
            'type' => 'color',
            'default' => '#000000',
        ];
        // Position
        $this->controls['position'] = [
            'tab' => 'content',
            'group' => 'position',
            'label' => esc_html__( 'Position', 'bricks' ),
            'type' => 'select',
            'options' => [
                'bottom-right' => esc_html__( 'Bottom Right', 'bricks' ),
                'bottom-left' => esc_html__( 'Bottom Left', 'bricks' ),
                'top-right' => esc_html__( 'Top Right', 'bricks' ),
                'top-left' => esc_html__( 'Top Left', 'bricks' ),
                'custom' => esc_html__( 'Custom', 'bricks' ),
            ],
            'default' => 'bottom-right',
        ];
        $this->controls['offset_x'] = [
            'tab' => 'content',
            'group' => 'position',
            'label' => esc_html__( 'Horizontal Offset (px)', 'bricks' ),
            'type' => 'number',
            'default' => 32,
            'min' => 0,
            'max' => 200,
            'step' => 1,
            'condition' => ['position' => 'custom'],
        ];
        $this->controls['offset_y'] = [
            'tab' => 'content',
            'group' => 'position',
            'label' => esc_html__( 'Vertical Offset (px)', 'bricks' ),
            'type' => 'number',
            'default' => 32,
            'min' => 0,
            'max' => 200,
            'step' => 1,
            'condition' => ['position' => 'custom'],
        ];
        // Border controls (now in their own group under Content)
        $this->controls['border_width'] = [
            'tab' => 'content',
            'group' => 'border',
            'label' => esc_html__( 'Border Width (px)', 'bricks' ),
            'type' => 'number',
            'default' => 6,
            'min' => 1,
            'max' => 32,
            'step' => 1,
        ];
        $this->controls['border_color'] = [
            'tab' => 'content',
            'group' => 'border',
            'label' => esc_html__( 'Border Color', 'bricks' ),
            'type' => 'color',
            'default' => '#ff9800',
        ];
        // Background
        $this->controls['background'] = [
            'tab' => 'content',
            'group' => 'style',
            'label' => esc_html__( 'Background Color', 'bricks' ),
            'type' => 'color',
            'default' => '#fff',
        ];
        // Box shadow
        $this->controls['box_shadow'] = [
            'tab' => 'content',
            'group' => 'style',
            'label' => esc_html__( 'Box Shadow', 'bricks' ),
            'type' => 'box-shadow',
        ];
    }

    public function enqueue_scripts() {
        // Enqueue icon library if needed
        $icon = $this->settings['icon'] ?? [ 'library' => 'Fontawesome - Solid', 'icon' => 'fa-arrow-up' ];
        if (!empty($icon['library'])) {
            if ($icon['library'] === 'Fontawesome - Solid') {
                wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css');
            } elseif ($icon['library'] === 'ionicons') {
                wp_enqueue_style('ionicons', 'https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css');
            } elseif ($icon['library'] === 'themify') {
                wp_enqueue_style('themify-icons', 'https://cdnjs.cloudflare.com/ajax/libs/themify-icons/1.0.1/css/themify-icons.min.css');
            }
        }
        wp_enqueue_script(
            'bfa-back-to-top',
            plugins_url( 'assets/js/back-to-top.js', dirname( __DIR__, 3 ) . '/flex-addons.php' ),
            ['jquery'],
            '0.2.2-alpha',
            true
        );
        wp_enqueue_style(
            'bfa-back-to-top',
            plugins_url( 'assets/css/back-to-top.css', dirname( __DIR__, 3 ) . '/flex-addons.php' ),
            [],
            '0.2.2-alpha'
        );
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
        $shape = $settings['shape'] ?? 'circle';
        $size = intval($settings['size'] ?? 48);
        $icon = $settings['icon'] ?? [ 'library' => 'Fontawesome - Solid', 'icon' => 'fa-arrow-up' ];
        $position = $settings['position'] ?? 'bottom-right';
        $offset_x = intval($settings['offset_x'] ?? 32);
        $offset_y = intval($settings['offset_y'] ?? 32);
        $border_width = intval($settings['border_width'] ?? 6);
        $border_color = $this->bfa_get_color_string($settings['border_color'] ?? null, '#ff9800');
        $background = $this->bfa_get_color_string($settings['background'] ?? null, '#fff');
        $icon_color = $this->bfa_get_color_string($settings['icon_color'] ?? null, '#000000');
        $box_shadow = $settings['box_shadow'] ?? '';
        $tooltip = $settings['tooltip'] ?? esc_html__( 'Back to Top', 'bricks' );
        $show_on = $settings['show_on'] ?? ['desktop', 'tablet', 'mobile'];
        $scroll_offset = intval($settings['scroll_offset'] ?? 200);

        $classes = ['bfa-back-to-top', 'bfa-shape-' . $shape, 'bfa-pos-' . $position];
        if (!in_array('desktop', $show_on)) $classes[] = 'bfa-hide-desktop';
        if (!in_array('tablet', $show_on)) $classes[] = 'bfa-hide-tablet';
        if (!in_array('mobile', $show_on)) $classes[] = 'bfa-hide-mobile';

        // Determine display property: always show in builder
        $display = 'none';
        if ( ( defined('BRICKS_ENV') && BRICKS_ENV === 'builder' ) || ( function_exists('bricks_is_builder_main') && bricks_is_builder_main() ) ) {
            $display = 'block';
        }
        $style = "width:{$size}px;height:{$size}px;background:{$background};border-radius:";
        $style .= ($shape === 'circle') ? '50%' : (($shape === 'rounded') ? '12px' : '0');
        $style .= ";box-shadow:{$box_shadow};";
        $style .= "position:fixed;z-index:9999;display:block;cursor:pointer;";
        switch($position) {
            case 'bottom-right':
                $style .= "right:{$offset_x}px;bottom:{$offset_y}px;"; break;
            case 'bottom-left':
                $style .= "left:{$offset_x}px;bottom:{$offset_y}px;"; break;
            case 'top-right':
                $style .= "right:{$offset_x}px;top:{$offset_y}px;"; break;
            case 'top-left':
                $style .= "left:{$offset_x}px;top:{$offset_y}px;"; break;
            case 'custom':
                $style .= "left:{$offset_x}px;top:{$offset_y}px;"; break;
        }
        $this->set_attribute('_root', 'class', implode(' ', $classes));
        $this->set_attribute('_root', 'style', $style);
        $this->set_attribute('_root', 'title', esc_attr($tooltip));
        echo '<div ' . $this->render_attributes('_root') . ' data-scroll-offset="' . esc_attr($scroll_offset) . '">';
        echo '<div style="position:relative;width:100%;height:100%;display:flex;align-items:center;justify-content:center;">';
        // Render icon (always on top)
        if ( isset($icon['icon']) ) {
            $icon_class = '';
            if (!empty($icon['library']) && !empty($icon['icon'])) {
                if ($icon['library'] === 'Fontawesome - Solid') {
                    $icon_class = 'fa-solid ' . $icon['icon'];
                } elseif ($icon['library'] === 'ionicons') {
                    $icon_class = $icon['icon'];
                } elseif ($icon['library'] === 'themify') {
                    $icon_class = $icon['icon'];
                }
                echo '<i class="' . esc_attr($icon_class) . '" aria-hidden="true" style="font-size:2em;z-index:2;position:relative;color:' . esc_attr($icon_color) . ';"></i>';
            }
        }
        // SVG border (always behind icon)
        $svg_size = $size;
        $stroke_width = max(1, intval($settings['border_width'] ?? 6));
        $svg_outer = $size + 2 * $stroke_width;
        $svg = '';
        // Detect builder context for SVG border progress
        $in_builder = ( defined('BRICKS_ENV') && BRICKS_ENV === 'builder' ) || ( function_exists('bricks_is_builder_main') && bricks_is_builder_main() );
        if ($shape === 'circle') {
            $radius = ($size / 2) + ($stroke_width / 2);
            $circumference = 2 * pi() * $radius;
            $dashoffset = $in_builder ? 0 : $circumference;
            $svg = '<svg class="bfa-back-to-top-svg" width="' . esc_attr($svg_outer) . '" height="' . esc_attr($svg_outer) . '" style="position:absolute;top:-' . $stroke_width . 'px;left:-' . $stroke_width . 'px;pointer-events:none;z-index:1;" viewBox="0 0 ' . esc_attr($svg_outer) . ' ' . esc_attr($svg_outer) . '"><circle class="bfa-back-to-top-border" cx="' . ($svg_outer/2) . '" cy="' . ($svg_outer/2) . '" r="' . $radius . '" stroke="' . esc_attr($border_color) . '" stroke-width="' . $stroke_width . '" fill="none" stroke-dasharray="' . $circumference . '" stroke-dashoffset="' . $dashoffset . '" transform="rotate(-90 ' . ($svg_outer/2) . ' ' . ($svg_outer/2) . ')"/></svg>';
        } else {
            $rect_radius = ($shape === 'rounded') ? 12 : 0;
            $rect_size = $size;
            $perimeter = 2 * ($rect_size + $rect_size);
            if ($shape === 'rounded') {
                $linejoin = 'round';
                $linecap = 'round';
                $dasharray = $perimeter - 0.5;
                $dashoffset = $in_builder ? 0 : $perimeter;
            } else {
                $linejoin = 'miter';
                $linecap = 'square';
                $dasharray = $perimeter + $stroke_width;
                $dashoffset = $in_builder ? 0 : $perimeter;
            }
            $svg = '<svg class="bfa-back-to-top-svg" width="' . esc_attr($svg_outer) . '" height="' . esc_attr($svg_outer) . '" style="position:absolute;top:-' . $stroke_width . 'px;left:-' . $stroke_width . 'px;pointer-events:none;z-index:1;" viewBox="0 0 ' . esc_attr($svg_outer) . ' ' . esc_attr($svg_outer) . '"><rect class="bfa-back-to-top-border" x="' . $stroke_width . '" y="' . $stroke_width . '" width="' . $rect_size . '" height="' . $rect_size . '" rx="' . $rect_radius . '" ry="' . $rect_radius . '" stroke="' . esc_attr($border_color) . '" stroke-width="' . $stroke_width . '" fill="none" stroke-dasharray="' . $dasharray . '" stroke-dashoffset="' . $dashoffset . '" stroke-linejoin="' . $linejoin . '" stroke-linecap="' . $linecap . '"/></svg>';
        }
        echo $svg;
        echo '</div>';
        echo '</div>';
    }
} 