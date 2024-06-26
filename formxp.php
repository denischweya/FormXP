<?php
/*
Plugin Name: Form XP
Description: Custom table operations with form input and data display
Version: 1.0
Author: Your Name
*/

defined('ABSPATH') or die('Direct access not allowed');

// Include necessary files
require_once plugin_dir_path(__FILE__) . 'includes/class-database-handler.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-form-handler.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-display-handler.php';

// Activation hook
register_activation_hook(__FILE__, array('Database_Handler', 'create_table'));

// Initialize classes
$db_handler = new Database_Handler();
$form_handler = new Form_Handler($db_handler);
$display_handler = new Display_Handler($db_handler);

// Register shortcodes
add_shortcode('custom_form', array($form_handler, 'render_form'));
add_shortcode('custom_data_display', array($display_handler, 'render_data'));

// Enqueue scripts and styles
function enqueue_custom_scripts()
{
    wp_enqueue_style('custom-plugin-style', plugin_dir_url(__FILE__) . 'assets/css/styles.css');
    wp_enqueue_script('custom-plugin-script', plugin_dir_url(__FILE__) . 'assets/js/script.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');
