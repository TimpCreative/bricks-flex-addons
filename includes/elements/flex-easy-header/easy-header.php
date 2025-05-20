<?php
/**
 * Easy Header Element
 */

if ( ! defined( 'ABSPATH' ) || ! defined( 'BRICKS_VERSION' ) ) {
    return;
}

class BFA_Easy_Header extends \Bricks\Element {
    /* ---------- Meta ---------- */
    public $category = 'Flex Addons Layout';
    public $name = 'easy-header';
    public $icon = 'fa-solid fa-window-maximize';
    public $scripts = ['bfaEasyHeader'];
    public $nestable = false;
    public $forceRender = true;

    public function get_label() {
        return esc_html__( 'Easy Header', 'bricks-flex-addons' );
    }

    public function get_keywords() {
        return ['header', 'navigation', 'menu', 'logo', 'search'];
    }

    /* ---------- Enqueue Scripts ---------- */
    public function enqueue_scripts() {
        $base = plugin_dir_url(dirname(dirname(dirname(__FILE__)))) . 'assets/';

        // Enqueue Font Awesome
        wp_enqueue_style(
            'bfa-fontawesome',
            'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
            [],
            '6.4.0'
        );

        // Enqueue Easy Header CSS
        wp_enqueue_style(
            'bfa-easy-header',
            $base . 'css/easy-header.css',
            ['bfa-fontawesome'],
            BFA_VERSION
        );

        // Enqueue Easy Header JS
        wp_enqueue_script(
            'bfa-easy-header',
            $base . 'js/easy-header.js',
            ['jquery'],
            BFA_VERSION,
            true
        );

        // Register the script with Bricks
        wp_localize_script('bfa-easy-header', 'bfaEasyHeaderData', [
            'forceRender' => time(),
            'isBuilder' => bricks_is_builder()
        ]);
    }

    /* ---------- Controls ---------- */
    public function set_controls() {
        // Logo group
        $this->controls['logo'] = [
            'tab' => 'content',
            'group' => 'logo',
            'label' => esc_html__('Logo Image', 'bricks-flex-addons'),
            'type' => 'image',
            'description' => esc_html__('Upload your logo image', 'bricks-flex-addons'),
        ];

        $this->controls['logoLink'] = [
            'tab' => 'content',
            'group' => 'logo',
            'label' => esc_html__('Logo Link', 'bricks-flex-addons'),
            'type' => 'link',
            'default' => [
                'url' => home_url(),
            ],
        ];

        $this->controls['logoWidth'] = [
            'tab' => 'content',
            'group' => 'logo',
            'label' => esc_html__('Logo Width', 'bricks-flex-addons'),
            'type' => 'number',
            'inline' => true,
            'min' => 20,
            'max' => 500,
            'default' => 150,
            'unit' => 'px',
        ];

        // Menu group
        $this->controls['menu'] = [
            'tab' => 'content',
            'group' => 'menu',
            'label' => esc_html__('Select Menu', 'bricks-flex-addons'),
            'type' => 'select',
            'options' => $this->get_menus(),
            'default' => '',
        ];

        $this->controls['menuAlignment'] = [
            'tab' => 'content',
            'group' => 'menu',
            'label' => esc_html__('Menu Alignment', 'bricks-flex-addons'),
            'type' => 'align-items',
            'default' => 'center',
            'css' => [
                [
                    'property' => 'align-items',
                    'selector' => '.bfa-easy-header-menu',
                ],
            ],
        ];

        $this->controls['menuColor'] = [
            'tab' => 'content',
            'group' => 'menu',
            'label' => esc_html__('Menu Color', 'bricks-flex-addons'),
            'type' => 'color',
            'css' => [
                [
                    'property' => 'color',
                    'selector' => '.bfa-easy-header-menu a',
                ],
            ],
        ];

        $this->controls['menuHoverColor'] = [
            'tab' => 'content',
            'group' => 'menu',
            'label' => esc_html__('Menu Hover Color', 'bricks-flex-addons'),
            'type' => 'color',
            'css' => [
                [
                    'property' => 'color',
                    'selector' => '.bfa-easy-header-menu a:hover',
                ],
            ],
        ];

        $this->controls['menuTypography'] = [
            'tab' => 'content',
            'group' => 'menu',
            'label' => esc_html__('Menu Typography', 'bricks-flex-addons'),
            'type' => 'typography',
            'css' => [
                [
                    'property' => 'font',
                    'selector' => '.bfa-easy-header-menu-items a',
                ],
            ],
        ];

        $this->controls['menuItemMargin'] = [
            'tab' => 'content',
            'group' => 'menu',
            'label' => esc_html__('Menu Item Margin', 'bricks-flex-addons'),
            'type' => 'spacing',
            'css' => [
                [
                    'property' => 'margin',
                    'selector' => '.bfa-easy-header-menu-items li',
                ],
            ],
        ];

        $this->controls['menuContainerMargin'] = [
            'tab' => 'content',
            'group' => 'menu',
            'label' => esc_html__('Menu Container Margin', 'bricks-flex-addons'),
            'type' => 'spacing',
            'css' => [
                [
                    'property' => 'margin',
                    'selector' => '.bfa-easy-header-menu',
                ],
            ],
        ];

        $this->controls['menuTransition'] = [
            'tab' => 'content',
            'group' => 'menu',
            'label' => esc_html__('Transition Time', 'bricks-flex-addons'),
            'type' => 'number',
            'min' => 0,
            'max' => 1000,
            'step' => 50,
            'default' => 300,
            'unit' => 'ms',
            'css' => [
                [
                    'property' => 'transition',
                    'selector' => '.bfa-easy-header-menu a',
                    'value' => 'color %s ease',
                ],
            ],
        ];

        // Mobile Menu group
        $this->controls['_addedClasses'] = [
            'tab' => 'content',
            'group' => 'mobile',
            'label' => esc_html__('Keep open while styling', 'bricks-flex-addons'),
            'type' => 'checkbox',
            'default' => false,
            'css' => [
                [
                    'property' => 'class',
                    'selector' => '.bfa-easy-header-mobile-menu',
                    'value' => 'brx-open',
                ],
            ],
        ];

        $this->controls['mobileMenuPosition'] = [
            'tab' => 'content',
            'group' => 'mobile',
            'label' => esc_html__('Menu Position', 'bricks-flex-addons'),
            'type' => 'select',
            'options' => [
                'right' => esc_html__('Right', 'bricks-flex-addons'),
                'left' => esc_html__('Left', 'bricks-flex-addons'),
            ],
            'default' => 'right',
        ];

        $this->controls['mobileMenuItemMargin'] = [
            'tab' => 'content',
            'group' => 'mobile',
            'label' => esc_html__('Menu Item Margin', 'bricks-flex-addons'),
            'type' => 'spacing',
            'css' => [
                [
                    'property' => 'margin',
                    'selector' => '.bfa-easy-header-mobile-menu-items li',
                ],
            ],
        ];

        $this->controls['mobileMenuContainerMargin'] = [
            'tab' => 'content',
            'group' => 'mobile',
            'label' => esc_html__('Menu Container Margin', 'bricks-flex-addons'),
            'type' => 'spacing',
            'css' => [
                [
                    'property' => 'margin',
                    'selector' => '.bfa-easy-header-mobile-menu',
                ],
            ],
        ];

        $this->controls['mobileMenuWidth'] = [
            'tab' => 'content',
            'group' => 'mobile',
            'label' => esc_html__('Menu Width', 'bricks-flex-addons'),
            'type' => 'number',
            'min' => 20,
            'max' => 100,
            'default' => 300,
            'css' => [
                [
                    'property' => 'width',
                    'selector' => '.bfa-easy-header-mobile-menu, .bfa-easy-header-mobile-menu-inner',
                ],
            ],
            'inline' => true,
            'pasteStyles' => true,
        ];

        $this->controls['mobileButtonIcon'] = [
            'tab' => 'content',
            'group' => 'mobile',
            'label' => esc_html__('Button Icon', 'bricks-flex-addons'),
            'type' => 'icon',
            'default' => [
                'library' => 'Font Awesome 6',
                'icon' => 'fa-solid fa-bars',
            ],
        ];

        $this->controls['mobileButtonSize'] = [
            'tab' => 'content',
            'group' => 'mobile',
            'label' => esc_html__('Button Size', 'bricks-flex-addons'),
            'type' => 'number',
            'min' => 16,
            'max' => 48,
            'default' => 24,
            'unit' => 'px',
            'css' => [
                [
                    'property' => 'font-size',
                    'selector' => '.bfa-easy-header-mobile-toggle i',
                ],
            ],
        ];

        $this->controls['mobileMenuBackground'] = [
            'tab' => 'content',
            'group' => 'mobile',
            'label' => esc_html__('Mobile Menu Background', 'bricks-flex-addons'),
            'type' => 'background',
            'css' => [
                [
                    'property' => 'background',
                    'selector' => '.bfa-easy-header-mobile-menu',
                ],
            ],
        ];

        $this->controls['mobileMenuColor'] = [
            'tab' => 'content',
            'group' => 'mobile',
            'label' => esc_html__('Mobile Menu Color', 'bricks-flex-addons'),
            'type' => 'color',
            'css' => [
                [
                    'property' => 'color',
                    'selector' => '.bfa-easy-header-mobile-menu a',
                ],
            ],
        ];

        $this->controls['mobileMenuTypography'] = [
            'tab' => 'content',
            'group' => 'mobile',
            'label' => esc_html__('Mobile Menu Typography', 'bricks-flex-addons'),
            'type' => 'typography',
            'css' => [
                [
                    'property' => 'font',
                    'selector' => '.bfa-easy-header-mobile-menu-items a',
                ],
            ],
        ];

        // Search group
        $this->controls['showSearch'] = [
            'tab' => 'content',
            'group' => 'search',
            'label' => esc_html__('Show Search in Mobile Menu', 'bricks-flex-addons'),
            'type' => 'checkbox',
            'default' => true,
        ];

        $this->controls['searchPlaceholder'] = [
            'tab' => 'content',
            'group' => 'search',
            'label' => esc_html__('Search Placeholder', 'bricks-flex-addons'),
            'type' => 'text',
            'default' => esc_html__('Search...', 'bricks-flex-addons'),
        ];

        $this->controls['searchWidth'] = [
            'tab' => 'content',
            'group' => 'search',
            'label' => esc_html__('Search Width', 'bricks-flex-addons'),
            'type' => 'number',
            'min' => 100,
            'max' => 500,
            'default' => 200,
            'unit' => 'px',
            'css' => [
                [
                    'property' => 'width',
                    'selector' => '.bfa-easy-header-search .search-field',
                ],
            ],
        ];

        $this->controls['searchBorder'] = [
            'tab' => 'content',
            'group' => 'search',
            'label' => esc_html__('Search Border', 'bricks-flex-addons'),
            'type' => 'border',
            'css' => [
                [
                    'property' => 'border',
                    'selector' => '.bfa-easy-header-search .search-field',
                ],
            ],
        ];

        $this->controls['searchBackground'] = [
            'tab' => 'content',
            'group' => 'search',
            'label' => esc_html__('Search Background', 'bricks-flex-addons'),
            'type' => 'background',
            'css' => [
                [
                    'property' => 'background',
                    'selector' => '.bfa-easy-header-search .search-field',
                ],
            ],
        ];

        $this->controls['searchIconColor'] = [
            'tab' => 'content',
            'group' => 'search',
            'label' => esc_html__('Search Icon Color', 'bricks-flex-addons'),
            'type' => 'color',
            'css' => [
                [
                    'property' => 'color',
                    'selector' => '.bfa-easy-header-search .search-submit i',
                ],
            ],
        ];

        $this->controls['searchTypography'] = [
            'tab' => 'content',
            'group' => 'search',
            'label' => esc_html__('Search Typography', 'bricks-flex-addons'),
            'type' => 'typography',
            'css' => [
                [
                    'property' => 'font',
                    'selector' => '.bfa-easy-header-search .search-field',
                ],
            ],
        ];

        // Custom Links group
        $this->controls['customLinks'] = [
            'tab' => 'content',
            'group' => 'custom_links',
            'label' => esc_html__('Custom Links', 'bricks-flex-addons'),
            'type' => 'repeater',
            'fields' => [
                'text' => [
                    'label' => esc_html__('Text', 'bricks-flex-addons'),
                    'type' => 'text',
                ],
                'link' => [
                    'label' => esc_html__('Link', 'bricks-flex-addons'),
                    'type' => 'link',
                ],
                'icon' => [
                    'label' => esc_html__('Icon', 'bricks-flex-addons'),
                    'type' => 'icon',
                ],
            ],
        ];

        $this->controls['showCustomLinksInMobile'] = [
            'tab' => 'content',
            'group' => 'custom_links',
            'label' => esc_html__('Show in Mobile Menu', 'bricks-flex-addons'),
            'type' => 'checkbox',
            'default' => false,
            'description' => esc_html__('If checked, custom links will be hidden on mobile and shown in the mobile menu', 'bricks-flex-addons'),
        ];

        $this->controls['customLinksColor'] = [
            'tab' => 'content',
            'group' => 'custom_links',
            'label' => esc_html__('Links Color', 'bricks-flex-addons'),
            'type' => 'color',
            'css' => [
                [
                    'property' => 'color',
                    'selector' => '.bfa-easy-header-custom-link',
                ],
            ],
        ];

        $this->controls['customLinksHoverColor'] = [
            'tab' => 'content',
            'group' => 'custom_links',
            'label' => esc_html__('Links Hover Color', 'bricks-flex-addons'),
            'type' => 'color',
            'css' => [
                [
                    'property' => 'color',
                    'selector' => '.bfa-easy-header-custom-link:hover',
                ],
            ],
        ];

        $this->controls['customLinksTransition'] = [
            'tab' => 'content',
            'group' => 'custom_links',
            'label' => esc_html__('Transition Time', 'bricks-flex-addons'),
            'type' => 'number',
            'min' => 0,
            'max' => 1000,
            'step' => 50,
            'default' => 300,
            'unit' => 'ms',
            'css' => [
                [
                    'property' => 'transition',
                    'selector' => '.bfa-easy-header-custom-link',
                    'value' => 'color %s ease',
                ],
            ],
        ];

        $this->controls['customLinksTypography'] = [
            'tab' => 'content',
            'group' => 'custom_links',
            'label' => esc_html__('Custom Links Typography', 'bricks-flex-addons'),
            'type' => 'typography',
            'css' => [
                [
                    'property' => 'font',
                    'selector' => '.bfa-easy-header-custom-link',
                ],
            ],
        ];

        // Layout group
        $this->controls['layoutAlignment'] = [
            'tab' => 'content',
            'group' => 'layout',
            'label' => esc_html__('Layout Alignment', 'bricks-flex-addons'),
            'type' => 'align-items',
            'default' => 'center',
            'css' => [
                [
                    'property' => 'align-items',
                    'selector' => '.bfa-easy-header',
                ],
            ],
        ];

        $this->controls['componentOrder'] = [
            'tab' => 'content',
            'group' => 'layout',
            'label' => esc_html__('Component Order', 'bricks-flex-addons'),
            'type' => 'repeater',
            'fields' => [
                'component' => [
                    'label' => esc_html__('Component', 'bricks-flex-addons'),
                    'type' => 'select',
                    'options' => [
                        'logo' => esc_html__('Logo', 'bricks-flex-addons'),
                        'menu' => esc_html__('Menu', 'bricks-flex-addons'),
                        'search' => esc_html__('Search', 'bricks-flex-addons'),
                        'custom_links' => esc_html__('Custom Links', 'bricks-flex-addons'),
                    ],
                ],
            ],
            'default' => [
                ['component' => 'logo'],
                ['component' => 'menu'],
                ['component' => 'search'],
                ['component' => 'custom_links'],
            ],
        ];
    }

    public function set_control_groups() {
        $this->control_groups['logo'] = [
            'title' => esc_html__('Logo', 'bricks-flex-addons'),
            'tab' => 'content',
        ];
        $this->control_groups['menu'] = [
            'title' => esc_html__('Menu', 'bricks-flex-addons'),
            'tab' => 'content',
        ];
        $this->control_groups['mobile'] = [
            'title' => esc_html__('Mobile Menu', 'bricks-flex-addons'),
            'tab' => 'content',
        ];
        $this->control_groups['search'] = [
            'title' => esc_html__('Search', 'bricks-flex-addons'),
            'tab' => 'content',
        ];
        $this->control_groups['custom_links'] = [
            'title' => esc_html__('Custom Links', 'bricks-flex-addons'),
            'tab' => 'content',
        ];
        $this->control_groups['layout'] = [
            'title' => esc_html__('Layout', 'bricks-flex-addons'),
            'tab' => 'content',
        ];
    }

    /* ---------- Render ---------- */
    public function render() {
        $settings = $this->settings;
        $root_classes = ['bfa-easy-header'];
        $logo_classes = ['bfa-easy-header-logo'];
        $menu_classes = ['bfa-easy-header-menu'];
        $mobile_menu_classes = ['bfa-easy-header-mobile-menu'];
        $custom_links_classes = ['bfa-easy-header-custom-links'];

        // Add mobile menu classes
        if (!empty($settings['mobileMenuPosition'])) {
            $mobile_menu_classes[] = 'bfa-mobile-menu-' . $settings['mobileMenuPosition'];
        }

        // Add custom links mobile visibility class
        if (!empty($settings['showCustomLinksInMobile'])) {
            $custom_links_classes[] = 'bfa-hide-on-mobile';
        }

        // Add data attributes
        $mobile_position = !empty($settings['mobileMenuPosition']) ? $settings['mobileMenuPosition'] : 'right';
        $mobile_width = !empty($settings['mobileMenuWidth']) ? $settings['mobileMenuWidth'] : 300;
        $preview_mobile = !empty($settings['_addedClasses']) && bricks_is_builder();
        
        // Set root attributes
        $this->set_attribute('_root', 'class', $root_classes);
        $this->set_attribute('_root', 'data-mobile-position', $mobile_position);
        $this->set_attribute('_root', 'data-mobile-width', $mobile_width);

        // Start output
        echo "<div {$this->render_attributes('_root')}>";
        
        // Get component order
        $component_order = !empty($settings['componentOrder']) ? $settings['componentOrder'] : [
            ['component' => 'logo'],
            ['component' => 'menu'],
            ['component' => 'search'],
            ['component' => 'custom_links'],
        ];

        // Render components in order
        foreach ($component_order as $component) {
            switch ($component['component']) {
                case 'logo':
                    if (!empty($settings['logo'])) {
                        $logo_link = !empty($settings['logoLink']['url']) ? $settings['logoLink']['url'] : home_url();
                        $logo_width = !empty($settings['logoWidth']) ? $settings['logoWidth'] : 150;
                        
                        echo '<div class="bfa-easy-header-logo">';
                        echo '<a href="' . esc_url($logo_link) . '">';
                        echo wp_get_attachment_image($settings['logo']['id'], 'full', false, [
                            'style' => 'width:' . esc_attr($logo_width) . 'px;',
                            'alt' => get_bloginfo('name'),
                        ]);
                        echo '</a>';
                        echo '</div>';
                    }
                    break;

                case 'menu':
                    if (!empty($settings['menu'])) {
                        $menu_alignment = !empty($settings['menuAlignment']) ? $settings['menuAlignment'] : 'center';
                        
                        echo '<nav class="bfa-easy-header-menu" style="align-items:' . esc_attr($menu_alignment) . '">';
                        wp_nav_menu([
                            'menu' => $settings['menu'],
                            'container' => false,
                            'menu_class' => 'bfa-easy-header-menu-items',
                            'fallback_cb' => false,
                        ]);
                        echo '</nav>';
                    }
                    break;

                case 'search':
                    $placeholder = !empty($settings['searchPlaceholder']) ? $settings['searchPlaceholder'] : esc_html__('Search...', 'bricks-flex-addons');
                    
                    echo '<div class="bfa-easy-header-search">';
                    echo '<form role="search" method="get" class="search-form" action="' . esc_url(home_url('/')) . '">';
                    echo '<input type="search" class="search-field" placeholder="' . esc_attr($placeholder) . '" value="' . get_search_query() . '" name="s" />';
                    echo '<button type="submit" class="search-submit">';
                    echo '<span class="screen-reader-text">' . esc_html__('Search', 'bricks-flex-addons') . '</span>';
                    echo '<i class="fa-solid fa-search"></i>';
                    echo '</button>';
                    echo '</form>';
                    echo '</div>';
                    break;

                case 'custom_links':
                    if (!empty($settings['customLinks'])) {
                        echo '<div class="' . implode(' ', $custom_links_classes) . '">';
                        foreach ($settings['customLinks'] as $link) {
                            $link_classes = ['bfa-easy-header-custom-link'];
                            if (!empty($settings['customLinksColor'])) {
                                $link_classes[] = 'bfa-custom-link-' . $settings['customLinksColor'];
                            }
                            echo '<a href="' . esc_url($link['link']['url']) . '" class="' . implode(' ', $link_classes) . '"' . 
                                 (!empty($link['link']['target']) ? ' target="' . esc_attr($link['link']['target']) . '"' : '') . '>';
                            if (!empty($link['icon'])) {
                                echo '<i class="' . esc_attr($link['icon']) . '"></i>';
                            }
                            echo esc_html($link['text']);
                            echo '</a>';
                        }
                        echo '</div>';
                    }
                    break;
            }
        }

        // Mobile Menu Button
        $mobile_icon = !empty($settings['mobileButtonIcon']['icon']) ? $settings['mobileButtonIcon']['icon'] : 'fa-solid fa-bars';
        
        echo '<button type="button" class="bfa-easy-header-mobile-toggle" aria-label="' . esc_attr__('Toggle mobile menu', 'bricks-flex-addons') . '">';
        echo '<i class="' . esc_attr($mobile_icon) . '"></i>';
        echo '</button>';

        // Mobile Menu
        echo '<div class="' . implode(' ', $mobile_menu_classes) . '">';
        echo '<div class="bfa-easy-header-mobile-menu-inner">';
        
        // Mobile Menu Content
        echo '<div class="bfa-easy-header-mobile-menu-content">';
        
        // Mobile Menu
        if (!empty($settings['menu'])) {
            wp_nav_menu([
                'menu' => $settings['menu'],
                'container' => false,
                'menu_class' => 'bfa-easy-header-mobile-menu-items',
                'fallback_cb' => false,
            ]);
        }

        // Custom Links in Mobile Menu
        if (!empty($settings['customLinks']) && !empty($settings['showCustomLinksInMobile'])) {
            echo '<div class="bfa-easy-header-mobile-custom-links">';
            foreach ($settings['customLinks'] as $link) {
                $link_classes = ['bfa-easy-header-mobile-custom-link'];
                if (!empty($settings['customLinksColor'])) {
                    $link_classes[] = 'bfa-custom-link-' . $settings['customLinksColor'];
                }
                echo '<a href="' . esc_url($link['link']['url']) . '" class="' . implode(' ', $link_classes) . '"' . 
                     (!empty($link['link']['target']) ? ' target="' . esc_attr($link['link']['target']) . '"' : '') . '>';
                if (!empty($link['icon'])) {
                    echo '<i class="' . esc_attr($link['icon']) . '"></i>';
                }
                echo esc_html($link['text']);
                echo '</a>';
            }
            echo '</div>';
        }

        // Mobile Search
        if (!empty($settings['showSearch'])) {
            echo '<form role="search" method="get" class="bfa-easy-header-mobile-search" action="' . esc_url(home_url('/')) . '">';
            echo '<input type="search" class="bfa-easy-header-mobile-search-field" placeholder="' . esc_attr($settings['searchPlaceholder'] ?? 'Search...') . '" value="' . get_search_query() . '" name="s" />';
            echo '<button type="submit" class="bfa-easy-header-mobile-search-submit">';
            if (!empty($settings['searchIcon'])) {
                echo '<i class="' . esc_attr($settings['searchIcon']) . '"></i>';
            } else {
                echo '<i class="fas fa-search"></i>';
            }
            echo '</button>';
            echo '</form>';
        }
        
        echo '</div>'; // End mobile menu content
        echo '</div>'; // End mobile menu inner
        echo '<div class="bfa-easy-header-mobile-menu-backdrop"></div>';
        echo '</div>'; // End mobile menu
        echo '</div>'; // End .bfa-easy-header
    }

    private function get_menus() {
        $menus = wp_get_nav_menus();
        $options = ['' => esc_html__('Select a menu', 'bricks-flex-addons')];
        
        if (!empty($menus)) {
            foreach ($menus as $menu) {
                $options[$menu->term_id] = $menu->name;
            }
        }
        
        return $options;
    }
}