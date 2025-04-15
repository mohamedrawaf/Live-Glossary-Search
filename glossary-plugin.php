<?php
/**
 * Plugin Name: Live Glossary Search
 * Description: A powerful glossary plugin that provides a searchable glossary using [glossary_search_shortcode]. It creates a 'Glossary Item' post type and allows users to browse glossary terms efficiently with live search functionality.
 * Version: 1.2
 * Author: Abdel
 * Author URI: https://www.upwork.com/freelancers/~01e0ebea64e80eb1de
 * License: GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if (!defined('ABSPATH')) {
    exit; // Prevent direct access
}

// Include necessary files
require_once('includes/glossary_post_type.php');
require_once('includes/admin-settings.php');
require_once('includes/glossary-shortcode.php');

/**
 * Enqueue CSS and JS files
 */
function glossary_enqueue_resources() {
    wp_enqueue_style('bootstrap-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
    wp_enqueue_style('glossary-css', plugin_dir_url(__FILE__) . 'assets/css/glossary.css');
    
    wp_enqueue_script('jquery');
    wp_enqueue_script('bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jquery'), '4.5.2', true);
    
    // Custom JS
    wp_enqueue_script('glossary-js', plugin_dir_url(__FILE__) . 'assets/js/glossary-live-search.js', array('jquery'), '1.1.0', true);
}
add_action('wp_enqueue_scripts', 'glossary_enqueue_resources');

/**
 * Add a nonce field for security when saving glossary items
 */
function glossary_add_nonce() {
    wp_nonce_field('glossary_save_nonce', 'glossary_nonce');
}
add_action('edit_form_after_title', 'glossary_add_nonce');

/**
 * Save glossary item metadata securely
 */
function glossary_save_metadata($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    if (!isset($_POST['glossary_nonce']) || !wp_verify_nonce($_POST['glossary_nonce'], 'glossary_save_nonce')) return;
    
    if (isset($_POST['glossary_link'])) {
        update_post_meta($post_id, '_glossary_link', sanitize_text_field($_POST['glossary_link']));
    }
}
add_action('save_post', 'glossary_save_metadata');

/**
 * Modify title to prepend "What is:" on single glossary pages
 */
function glossary_modify_single_title($title) {
    if (is_singular('glossary_item')) {
        $append_whatis_enabled = get_option('glossary_append_whatis_enabled', true);
        if ($append_whatis_enabled) {
            return esc_html__('What is: ', 'glossary') . esc_html($title);
        }
    }
    return $title;
}
add_filter('the_title', 'glossary_modify_single_title');

?>
