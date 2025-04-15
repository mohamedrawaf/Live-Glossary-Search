<?php
// Register Glossary Item custom post type
function glossary_item_post_type() {
    $labels = array(
        'name'          => __('Glossary Items', 'Live-Glossary-Search'),
        'singular_name' => __('Glossary Item', 'Live-Glossary-Search'),
    );

    $args = array(
        'labels'        => $labels,
        'public'        => true,
        'has_archive'   => true,
        'supports'      => array('title', 'editor'),
        'menu_position' => 5,
        'show_in_menu'  => true,
    );

    register_post_type('glossary_item', $args);
}
add_action('init', 'glossary_item_post_type');

// Add custom metabox for Link field
function glossary_item_link_metabox() {
    add_meta_box('glossary_link', __('Link Override', 'Live-Glossary-Search'), 'glossary_link_callback', 'glossary_item', 'normal');
}
add_action('add_meta_boxes', 'glossary_item_link_metabox');

function glossary_link_callback($post) {
    wp_nonce_field('glossary_save_link', 'glossary_link_nonce');
    $link = get_post_meta($post->ID, '_glossary_link', true);
    ?>
    <label for="glossary-link"><?php esc_html_e('Link Override:', 'Live-Glossary-Search'); ?></label>
    <input type="text" id="glossary-link" name="glossary_link" value="<?php echo esc_attr($link); ?>" class="widefat">
    <?php
}

function save_glossary_link($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!isset($_POST['glossary_link_nonce']) || !wp_verify_nonce($_POST['glossary_link_nonce'], 'glossary_save_link')) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['glossary_link'])) {
        update_post_meta($post_id, '_glossary_link', sanitize_text_field($_POST['glossary_link']));
    }
}
add_action('save_post', 'save_glossary_link');

// Append "What is:" before the title on single pages
function modify_single_post_title($title) {
    if (is_singular('glossary_item')) {
        $append_whatis_enabled = get_option('glossary_append_whatis_enabled', true);
        if ($append_whatis_enabled) {
            return __('What is: ', 'Live-Glossary-Search') . $title;
        }        
    }
    return $title;
}
add_filter('the_title', 'modify_single_post_title');