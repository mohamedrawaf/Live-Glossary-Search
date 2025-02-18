<?php
/*
Plugin Name: Live Glossary Search
Description: A powerful glossary plugin that provides a searchable glossary using [glossary_search_shortcode]. It creates a 'Glossary Item' post type and allows users to browse glossary terms efficiently with live search functionality.
Version: 1.1
Author: Abdel
Author URI: https://www.upwork.com/freelancers/~01e0ebea64e80eb1de
*/


// Include necessary files
require_once('includes/glossary_post_type.php');
require_once('includes/admin-settings.php');
require_once('includes/glossary-shortcode.php');

/**
 * Enqueue css and js files
 */
function enqueue_scripts_and_styles() {
    // Enqueue Bootstrap CSS
    wp_enqueue_style('bootstrap-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
    // Enqueue custom CSS
    wp_enqueue_style('glossary-live-search-css', plugin_dir_url( __FILE__ ) . 'assets/css/glossary-live-search.css');
    
    // Enqueue jQuery and Bootstrap JS
    wp_enqueue_script('jquery');
    wp_enqueue_script('bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jquery'), '4.5.2', true);
    
    // Enqueue custom JavaScript
    wp_enqueue_script('glossary-live-search-js', plugin_dir_url( __FILE__ ) . 'assets/js/glossary-live-search.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'enqueue_scripts_and_styles');