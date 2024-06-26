<?php
/*
Plugin Name: Form XP
Description: Custom table operations with form input and data display
Version: 0.1.1
Author: Denis Bosire
*/

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Include necessary files
require_once plugin_dir_path(__FILE__) . 'includes/class-database-handler.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-form-handler.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-display-handler.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-api-handler.php';


// Activation hook
register_activation_hook(__FILE__, array('Database_Handler', 'create_table'));

// Initialize classes
$db_handler = new Database_Handler();
$form_handler = new Form_Handler($db_handler);
$display_handler = new Display_Handler($db_handler);
$api_handler = new API_Handler($db_handler);

// Register shortcodes
add_shortcode('custom_form', array($form_handler, 'render_form'));
add_shortcode('custom_data_display', array($display_handler, 'render_data'));

// Enqueue scripts and styles
function enqueue_custom_scripts()
{
    wp_enqueue_style('formxp-style', plugin_dir_url(__FILE__) . 'assets/css/styles.css');
    wp_enqueue_script('formxp-script', plugin_dir_url(__FILE__) . 'assets/js/script.js', array('jquery'), '1.0', true);

    // Localize the script with new data
    $script_data_array = array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('custom_form_nonce'),
    );
    wp_localize_script('formxp-script', 'customPluginVars', $script_data_array);

}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');
