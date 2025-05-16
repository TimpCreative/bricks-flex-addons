<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Flex_Content_Switcher extends \Bricks\Element {
    public $category = 'Flex Addons Interactive';
    public $name = 'flex-content-switcher';
    public $icon = 'ti-layout-accordion-merged';
    public $css = ['assets/css/content-toggle'];
    public $scripts = ['assets/js/content-toggle'];
    public $nestable = true;
    public $nestable_children = true;

    public function get_label() {
        return esc_html__('Content Switcher', 'bricks');
    }

    public function get_nestable_children() {
        return [
            [
                'name' => 'div',
                'label' => esc_html__('Content Section (Copy me!)', 'bricks'),
            ],
        ];
    }

    public function set_control_groups() {
        $this->control_groups['toggle'] = [
            'title' => esc_html__('Toggle', 'bricks'),
            'tab' => 'content',
        ];
        $this->control_groups['style'] = [
            'title' => esc_html__('Style', 'bricks'),
            'tab' => 'content',
        ];
    }

    public function set_controls() {
        // Toggle Type Control
        $this->controls['toggleType'] = [
            'tab' => 'content',
            'group' => 'toggle',
            'label' => esc_html__('Toggle Type', 'bricks'),
            'type' => 'select',
            'options' => [
                'auto' => esc_html__('Auto (Based on content)', 'bricks'),
                'buttons' => esc_html__('Buttons', 'bricks'),
                'switch' => esc_html__('Switch', 'bricks'),
            ],
            'default' => 'auto',
            'description' => esc_html__('Auto will use buttons for 3+ items, switch for 2 items', 'bricks'),
        ];

        // Button Style Controls
        $this->controls['buttonStyle'] = [
            'tab' => 'content',
            'group' => 'style',
            'label' => esc_html__('Button Style', 'bricks'),
            'type' => 'select',
            'options' => [
                'pill' => esc_html__('Pill', 'bricks'),
                'rounded' => esc_html__('Rounded', 'bricks'),
                'square' => esc_html__('Square', 'bricks'),
            ],
            'default' => 'pill',
            'required' => ['toggleType', '!=', 'switch'],
        ];

        // Button Typography
        $this->controls['buttonTypography'] = [
            'tab' => 'content',
            'group' => 'style',
            'label' => esc_html__('Button Typography', 'bricks'),
            'type' => 'typography',
            'css' => [
                [
                    'property' => 'typography',
                    'selector' => '.bfa-toggle-button',
                ],
            ],
            'required' => ['toggleType', '!=', 'switch'],
        ];
        // Active Button Typography
        $this->controls['buttonActiveTypography'] = [
            'tab' => 'content',
            'group' => 'style',
            'label' => esc_html__('Active Button Typography', 'bricks'),
            'type' => 'typography',
            'css' => [
                [
                    'property' => 'typography',
                    'selector' => '.bfa-toggle-button.active',
                ],
            ],
            'required' => ['toggleType', '!=', 'switch'],
        ];

        // Button Padding
        $this->controls['buttonPadding'] = [
            'tab' => 'content',
            'group' => 'style',
            'label' => esc_html__('Button Padding', 'bricks'),
            'type' => 'dimensions',
            'css' => [
                [
                    'property' => 'padding',
                    'selector' => '.bfa-toggle-button',
                ],
            ],
            'required' => ['toggleType', '!=', 'switch'],
        ];

        // Button Alignment
        $this->controls['buttonAlignment'] = [
            'tab' => 'content',
            'group' => 'style',
            'label' => esc_html__('Button Alignment', 'bricks'),
            'type' => 'select',
            'options' => [
                'flex-start' => esc_html__('Left', 'bricks'),
                'center' => esc_html__('Center', 'bricks'),
                'flex-end' => esc_html__('Right', 'bricks'),
            ],
            'default' => 'flex-start',
            'css' => [
                [
                    'property' => '--toggle-justify',
                    'selector' => '.brxe-flex-content-switcher',
                ],
            ],
            'required' => ['toggleType', '!=', 'switch'],
        ];

        // Button Colors
        $this->controls['buttonActiveBg'] = [
            'tab' => 'content',
            'group' => 'style',
            'label' => esc_html__('Active Button Background', 'bricks'),
            'type' => 'color',
            'css' => [
                [
                    'property' => '--toggle-accent',
                    'selector' => '.brxe-flex-content-switcher',
                ],
            ],
        ];
        $this->controls['buttonActiveBorder'] = [
            'tab' => 'content',
            'group' => 'style',
            'label' => esc_html__('Active Button Border', 'bricks'),
            'type' => 'color',
            'css' => [
                [
                    'property' => '--toggle-accent-dark',
                    'selector' => '.brxe-flex-content-switcher',
                ],
            ],
        ];
        $this->controls['buttonInactiveBg'] = [
            'tab' => 'content',
            'group' => 'style',
            'label' => esc_html__('Inactive Button Background', 'bricks'),
            'type' => 'color',
            'css' => [
                [
                    'property' => '--toggle-bg',
                    'selector' => '.brxe-flex-content-switcher',
                ],
            ],
        ];
        $this->controls['buttonInactiveBorder'] = [
            'tab' => 'content',
            'group' => 'style',
            'label' => esc_html__('Inactive Button Border', 'bricks'),
            'type' => 'color',
            'css' => [
                [
                    'property' => '--toggle-inactive-border',
                    'selector' => '.brxe-flex-content-switcher',
                ],
            ],
        ];

        // Button Border Width
        $this->controls['buttonBorderWidth'] = [
            'tab' => 'content',
            'group' => 'style',
            'label' => esc_html__('Button Border Width (px)', 'bricks'),
            'type' => 'number',
            'default' => 1.5,
            'min' => 0,
            'max' => 10,
            'step' => 0.5,
            'css' => [], // handled inline
        ];

        // Animation
        $this->controls['transitionDuration'] = [
            'tab' => 'content',
            'group' => 'style',
            'label' => esc_html__('Transition Duration', 'bricks'),
            'type' => 'number',
            'units' => ['ms', 's'],
            'unit' => 'ms',
            'default' => '300ms',
            'css' => [
                [
                    'property' => 'transition-duration',
                    'selector' => '.bfa-toggle-buttons button, .bfa-toggle-switch, .bfa-content-item',
                ],
            ],
        ];
    }

    /**
     * Render the Content Switcher element
     */
    public function render() {
        $settings = $this->settings;
        $toggle_type = isset($settings['toggleType']) ? $settings['toggleType'] : 'auto';

        // Extract color and border settings for data attributes
        $active_bg = $this->bfa_get_color_string($settings['buttonActiveBg'] ?? '#ffc940');
        $active_border = $this->bfa_get_color_string($settings['buttonActiveBorder'] ?? '#e6a800');
        $inactive_bg = $this->bfa_get_color_string($settings['buttonInactiveBg'] ?? '#fff');
        $inactive_border = $this->bfa_get_color_string($settings['buttonInactiveBorder'] ?? '#ffc940');
        $border_width = isset($settings['buttonBorderWidth']) ? $settings['buttonBorderWidth'] : '1.5';
        // Strip 'px' if present and ensure it's a valid number
        $border_width = str_replace('px', '', $border_width);
        $border_width = is_numeric($border_width) ? floatval($border_width) : 1.5;
        $transition_duration = (isset($settings['transitionDuration']) && $settings['transitionDuration'] !== '') ? $settings['transitionDuration'] : '300ms';

        $data_attrs = sprintf(
            ' data-buttonactivebg="%s" data-buttonactiveborder="%s" data-buttoninactivebg="%s" data-buttoninactiveborder="%s" data-buttonborderwidth="%s" data-buttonalignment="%s" data-transitionduration="%s"',
            esc_attr($active_bg),
            esc_attr($active_border),
            esc_attr($inactive_bg),
            esc_attr($inactive_border),
            esc_attr($border_width),
            esc_attr($settings['buttonAlignment'] ?? 'flex-start'),
            esc_attr($transition_duration)
        );

        $output = '<div ' . $this->render_attributes('_root') . $data_attrs . '>';
        $children = isset($this->element['children']) ? $this->element['children'] : [];
        $childCount = count($children);

        if ($childCount > 0) {
            // Determine toggle type if set to auto
            if ($toggle_type === 'auto') {
                $toggle_type = $childCount > 2 ? 'buttons' : 'switch';
            }

            // Render toggle
            $output .= $this->render_toggle_buttons($childCount, $toggle_type);

            // Render content items
            $output .= '<div class="bfa-content-wrapper">';
            $output .= \Bricks\Frontend::render_children($this);
            $output .= '</div>';
        } else {
            // Fallback if no children
            $output .= '<div class="bfa-content-wrapper">';
            $output .= '<div class="bfa-content-item active">';
            $output .= esc_html__('Add content items to switch between.', 'bricks');
            $output .= '</div>';
            $output .= '</div>';
        }

        $output .= '</div>';
        echo $output;
    }

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

    private function render_toggle_buttons($count, $type) {
        $output = '';
        $settings = $this->settings;
        $buttonStyle = isset($settings['buttonStyle']) ? $settings['buttonStyle'] : 'pill';
        $active_bg = $this->bfa_get_color_string($settings['buttonActiveBg'] ?? '#ffc940');
        $active_border = $this->bfa_get_color_string($settings['buttonActiveBorder'] ?? '#e6a800');
        $inactive_bg = $this->bfa_get_color_string($settings['buttonInactiveBg'] ?? '#fff');
        $inactive_border = $this->bfa_get_color_string($settings['buttonInactiveBorder'] ?? '#ffc940');
        $border_width = isset($settings['buttonBorderWidth']) ? $settings['buttonBorderWidth'] : '1.5';
        // Strip 'px' if present and ensure it's a valid number
        $border_width = str_replace('px', '', $border_width);
        $border_width = is_numeric($border_width) ? floatval($border_width) : 1.5;
        
        if ($type === 'switch') {
            $output .= '<div class="bfa-toggle-wrapper">';
            $output .= '<label class="bfa-toggle-switch">';
            $output .= '<input type="checkbox" class="bfa-toggle-input">';
            $output .= '<span class="bfa-toggle-slider"></span>';
            $output .= '</label>';
            $output .= '</div>';
        } else {
            $output .= '<div class="bfa-toggle-buttons" role="tablist">';
            for ($i = 0; $i < $count; $i++) {
                $active = $i === 0 ? ' active' : '';
                $is_active = $i === 0;
                $style = $is_active
                    ? "background: $active_bg; border: {$border_width}px solid $active_border;"
                    : "background: $inactive_bg; border: {$border_width}px solid $inactive_border;";
                $output .= sprintf(
                    '<button type="button" class="bfa-toggle-button%s" data-index="%d" data-style="%s" style="%s" role="tab" aria-selected="%s" aria-controls="content-%d">%d</button>',
                    $active,
                    $i,
                    esc_attr($buttonStyle),
                    esc_attr($style),
                    $i === 0 ? 'true' : 'false',
                    $i,
                    $i + 1
                );
            }
            $output .= '</div>';
        }

        return $output;
    }

    /**
     * Enqueue CSS/JS assets
     */
    public function enqueue_scripts() {
        $base = plugin_dir_url(dirname(dirname(dirname(__FILE__)))) . 'assets/';
        wp_enqueue_style(
            'flex-content-switcher',
            $base . 'css/content-toggle.css',
            [],
            '1.0.0'
        );
        wp_enqueue_script(
            'flex-content-switcher',
            $base . 'js/content-toggle.js',
            [],
            '1.0.0',
            true
        );
    }
} 