<?php
/**
 * Admin menu and page content for Flex Addons
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Add the top-level menu and submenu
add_action( 'admin_menu', 'bfa_add_menu_pages' );
function bfa_add_menu_pages() {
    // Main menu
    add_menu_page(
        'Flex Addons', // Page title
        'Flex Addons', // Menu title
        'manage_options', // Capability
        'flex-addons', // Menu slug
        'bfa_options_page_html', // Function to display the page
        'dashicons-plus-alt', // Icon
        20 // Position
    );

    // Settings submenu
    add_submenu_page(
        'flex-addons', // Parent slug
        'Settings', // Page title
        'Settings', // Menu title
        'manage_options', // Capability
        'flex-addons-settings', // Menu slug
        'bfa_settings_page_html' // Function to display the page
    );
}

// The function that displays the main page content
function bfa_options_page_html() {
    // Check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?> <span style="font-size: 1rem; color: #888; font-weight: normal;">v0.2.2-alpha</span></h1>
        
        <div class="bfa-get-started">
            <div class="bfa-section">
                <h2>🚀 Get Started with Flex Addons</h2>
                <p>Welcome to Flex Addons! Here's how to get started:</p>
                
                <div class="bfa-steps">
                    <div class="bfa-step">
                        <h3>1. Configure Settings</h3>
                        <p>Head to the <a href="<?php echo esc_url( admin_url( 'admin.php?page=flex-addons-settings' ) ); ?>">Settings</a> page to enable/disable elements and dynamic tags.</p>
                    </div>
                    
                    <div class="bfa-step">
                        <h3>2. Available Elements</h3>
                        <ul>
                            <li><strong>Modal</strong> - Create beautiful modals with nested content</li>
                            <li><strong>Flip Box</strong> - Interactive flip boxes with front and back content</li>
                            <li><strong>Stylable Card</strong> - Fully customizable card element</li>
                            <li><strong>Before/After Slider</strong> - Interactive image comparison slider</li>
                        </ul>
                    </div>
                    
                    <div class="bfa-step">
                        <h3>3. Dynamic Tags</h3>
                        <p>Access additional dynamic tags in the Bricks builder:</p>
                        <ul>
                            <li>Parent Page Title</li>
                            <li>Parent Page Content</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bfa-get-started {
            max-width: 800px;
            margin-top: 20px;
        }
        .bfa-section {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .bfa-steps {
            margin-top: 20px;
        }
        .bfa-step {
            margin-bottom: 25px;
            padding-bottom: 25px;
            border-bottom: 1px solid #eee;
        }
        .bfa-step:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .bfa-step h3 {
            margin-top: 0;
            color: #2271b1;
        }
        .bfa-step ul {
            margin-left: 20px;
        }
    </style>
    <?php
}

// The function that displays the settings page content
function bfa_settings_page_html() {
    // Check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    // Save settings if form is submitted
    if ( isset( $_POST['bfa_settings_nonce'] ) && wp_verify_nonce( $_POST['bfa_settings_nonce'], 'bfa_save_settings' ) ) {
        $settings = array(
            'elements' => array(
                'layout_navigation' => array(
                    'enabled' => isset( $_POST['bfa_elements']['layout_navigation']['enabled'] ),
                    'modal' => isset( $_POST['bfa_elements']['layout_navigation']['modal'] ),
                    'flip_box' => isset( $_POST['bfa_elements']['layout_navigation']['flip_box'] ),
                    'style_card' => isset( $_POST['bfa_elements']['layout_navigation']['style_card'] ),
                    'back_to_top' => isset( $_POST['bfa_elements']['layout_navigation']['back_to_top'] ),
                    'slider' => isset( $_POST['bfa_elements']['layout_navigation']['slider'] ),
                ),
                'interactive_animation' => array(
                    'enabled' => isset( $_POST['bfa_elements']['interactive_animation']['enabled'] ),
                ),
                'media_galleries' => array(
                    'enabled' => isset( $_POST['bfa_elements']['media_galleries']['enabled'] ),
                    'slider' => isset( $_POST['bfa_elements']['media_galleries']['slider'] ),
                ),
                'content_typography' => array(
                    'enabled' => isset( $_POST['bfa_elements']['content_typography']['enabled'] ),
                ),
                'data_displays' => array(
                    'enabled' => isset( $_POST['bfa_elements']['data_displays']['enabled'] ),
                ),
                'woo_enhancements' => array(
                    'enabled' => isset( $_POST['bfa_elements']['woo_enhancements']['enabled'] ),
                ),
                'utility_admin' => array(
                    'enabled' => isset( $_POST['bfa_elements']['utility_admin']['enabled'] ),
                ),
                'logic_conditions' => array(
                    'enabled' => isset( $_POST['bfa_elements']['logic_conditions']['enabled'] ),
                ),
            ),
            'dynamic_tags' => array(
                'enabled' => isset( $_POST['bfa_dynamic_tags']['enabled'] ),
                'parent_page_title' => isset( $_POST['bfa_dynamic_tags']['parent_page_title'] ),
                'parent_page_content' => isset( $_POST['bfa_dynamic_tags']['parent_page_content'] ),
            ),
        );
        update_option( 'bfa_settings', $settings );
        echo '<div class="notice notice-success"><p>Settings saved successfully!</p></div>';
    }

    // Get current settings
    $settings = get_option( 'bfa_settings', array(
        'elements' => array(
            'layout_navigation' => array(
                'enabled' => true,
                'modal' => true,
                'flip_box' => true,
                'style_card' => true,
                'back_to_top' => true,
                'slider' => false,
            ),
            'interactive_animation' => array(
                'enabled' => false,
            ),
            'media_galleries' => array(
                'enabled' => false,
                'slider' => false,
            ),
            'content_typography' => array(
                'enabled' => false,
            ),
            'data_displays' => array(
                'enabled' => false,
            ),
            'woo_enhancements' => array(
                'enabled' => false,
            ),
            'utility_admin' => array(
                'enabled' => false,
            ),
            'logic_conditions' => array(
                'enabled' => false,
            ),
        ),
        'dynamic_tags' => array(
            'enabled' => true,
            'parent_page_title' => true,
            'parent_page_content' => true,
        ),
    ) );
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?> <span style="font-size: 1rem; color: #888; font-weight: normal;">v0.2.2-alpha</span></h1>
        
        <form method="post" action="">
            <?php wp_nonce_field( 'bfa_save_settings', 'bfa_settings_nonce' ); ?>
            
            <div class="bfa-settings-grid">
                <div class="bfa-settings-section">
                    <div class="bfa-section-header">
                        <h2>Layout & Navigation</h2>
                        <label class="bfa-toggle">
                            <input type="checkbox" 
                                   name="bfa_elements[layout_navigation][enabled]" 
                                   value="1" 
                                   <?php checked( $settings['elements']['layout_navigation']['enabled'] ); ?>
                                   class="bfa-section-toggle">
                            <span class="bfa-toggle-slider"></span>
                        </label>
                    </div>
                    <div class="bfa-section-content">
                        <table class="form-table bfa-tight-table">
                            <tr>
                                <th scope="row">Modal</th>
                                <td>
                                    <label>
                                        <input type="checkbox" 
                                               name="bfa_elements[layout_navigation][modal]" 
                                               value="1" 
                                               <?php checked( $settings['elements']['layout_navigation']['modal'] ); ?>>
                                        Enable Modal element
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Flip Box</th>
                                <td>
                                    <label>
                                        <input type="checkbox" 
                                               name="bfa_elements[layout_navigation][flip_box]" 
                                               value="1" 
                                               <?php checked( $settings['elements']['layout_navigation']['flip_box'] ); ?>>
                                        Enable Flip Box element
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Stylable Card</th>
                                <td>
                                    <label>
                                        <input type="checkbox" 
                                               name="bfa_elements[layout_navigation][style_card]" 
                                               value="1" 
                                               <?php checked( $settings['elements']['layout_navigation']['style_card'] ); ?>>
                                        Enable Stylable Card element
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Back to Top</th>
                                <td>
                                    <label>
                                        <input type="checkbox" name="bfa_elements[layout_navigation][back_to_top]" value="1" <?php checked( $settings['elements']['layout_navigation']['back_to_top'] ); ?>>
                                        Enable Back to Top element
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Before/After Slider</th>
                                <td>
                                    <label>
                                        <input type="checkbox" name="bfa_elements[layout_navigation][slider]" value="1" <?php checked( $settings['elements']['layout_navigation']['slider'] ); ?>>
                                        Enable Before/After Slider element
                                    </label>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="bfa-settings-section">
                    <div class="bfa-section-header">
                        <h2>Interactive & Animation</h2>
                        <label class="bfa-toggle">
                            <input type="checkbox" 
                                   name="bfa_elements[interactive_animation][enabled]" 
                                   value="1" 
                                   <?php checked( $settings['elements']['interactive_animation']['enabled'] ); ?>
                                   class="bfa-section-toggle">
                            <span class="bfa-toggle-slider"></span>
                        </label>
                    </div>
                    <div class="bfa-section-content">
                        <p class="description">Coming soon...</p>
                    </div>
                </div>

                <div class="bfa-settings-section">
                    <div class="bfa-section-header">
                        <h2>Media & Galleries</h2>
                        <label class="bfa-toggle">
                            <input type="checkbox" 
                                   name="bfa_elements[media_galleries][enabled]" 
                                   value="1" 
                                   <?php checked( $settings['elements']['media_galleries']['enabled'] ); ?>
                                   class="bfa-section-toggle">
                            <span class="bfa-toggle-slider"></span>
                        </label>
                    </div>
                    <div class="bfa-section-content">
                        <table class="form-table bfa-tight-table">
                            <tr>
                                <th scope="row">Before/After Slider</th>
                                <td>
                                    <label>
                                        <input type="checkbox" name="bfa_elements[media_galleries][slider]" value="1" <?php checked( $settings['elements']['media_galleries']['slider'] ); ?>>
                                        Enable Before/After Slider element
                                    </label>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="bfa-settings-section">
                    <div class="bfa-section-header">
                        <h2>Dynamic Tags</h2>
                        <label class="bfa-toggle">
                            <input type="checkbox" 
                                   name="bfa_dynamic_tags[enabled]" 
                                   value="1" 
                                   <?php checked( $settings['dynamic_tags']['enabled'] ); ?>
                                   class="bfa-section-toggle">
                            <span class="bfa-toggle-slider"></span>
                        </label>
                    </div>
                    <div class="bfa-section-content">
                        <table class="form-table bfa-tight-table">
                            <tr>
                                <th scope="row">Parent Page Title</th>
                                <td>
                                    <label>
                                        <input type="checkbox" 
                                               name="bfa_dynamic_tags[parent_page_title]" 
                                               value="1" 
                                               <?php checked( $settings['dynamic_tags']['parent_page_title'] ); ?>>
                                        Enable Parent Page Title tag
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Parent Page Content</th>
                                <td>
                                    <label>
                                        <input type="checkbox" 
                                               name="bfa_dynamic_tags[parent_page_content]" 
                                               value="1" 
                                               <?php checked( $settings['dynamic_tags']['parent_page_content'] ); ?>>
                                        Enable Parent Page Content tag
                                    </label>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <?php submit_button( 'Save Settings' ); ?>
        </form>
    </div>

    <style>
        .bfa-settings-grid {
            display: grid;
            grid-template-columns: minmax(320px, 2fr) minmax(320px, 2fr);
            gap: 25px 25px;
            margin-bottom: 32px;
            max-width: 1000px;
            background: none;
        }
        .bfa-settings-section {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            border: 1.5px solid #e5e7eb;
            display: flex;
            flex-direction: column;
        }
        .bfa-section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .bfa-section-header h2 {
            margin: 0;
        }
        .bfa-section-content {
            margin-top: 15px;
            flex: 1 1 auto;
        }
        .bfa-tight-table {
            margin-top: 0;
        }
        .bfa-tight-table tr {
            height: 25px;
        }
        .bfa-tight-table th {
            padding: 8px 10px 8px 0;
            width: 35%;
        }
        .bfa-tight-table td {
            padding: 8px 10px;
        }
        /* Toggle Switch Styles */
        .bfa-toggle {
            position: relative;
            display: inline-block;
            width: 40px;
            height: 20px;
        }
        .bfa-toggle input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .bfa-toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 20px;
        }
        .bfa-toggle-slider:before {
            position: absolute;
            content: "";
            height: 14px;
            width: 14px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        .bfa-toggle input:checked + .bfa-toggle-slider {
            background-color: #2271b1;
        }
        .bfa-toggle input:checked + .bfa-toggle-slider:before {
            transform: translateX(20px);
        }
        .description {
            color: #666;
            font-style: italic;
            margin: 0;
        }
        /* Add margin to submit button */
        .wrap #submit {
            margin-top: 20px;
        }
    </style>

    <script>
    jQuery(document).ready(function($) {
        // Handle section toggles
        $('.bfa-section-toggle').on('change', function() {
            var $section = $(this).closest('.bfa-settings-section');
            var $inputs = $section.find('input[type="checkbox"]:not(.bfa-section-toggle)');
            $inputs.prop('checked', $(this).prop('checked'));
        });

        // Update section toggle state based on individual checkboxes
        $('input[type="checkbox"]:not(.bfa-section-toggle)').on('change', function() {
            var $section = $(this).closest('.bfa-settings-section');
            var $toggle = $section.find('.bfa-section-toggle');
            var $checkboxes = $section.find('input[type="checkbox"]:not(.bfa-section-toggle)');
            var allChecked = $checkboxes.length === $checkboxes.filter(':checked').length;
            $toggle.prop('checked', allChecked);
        });
    });
    </script>
    <?php
} 