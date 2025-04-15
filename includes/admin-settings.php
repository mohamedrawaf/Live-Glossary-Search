<?php
// Add admin settings page
function glossary_settings_page() {
    add_options_page(__('Glossary Settings', 'Live-Glossary-Search'), __('Glossary Settings', 'Live-Glossary-Search'), 'manage_options', 'glossary_settings', 'glossary_settings_page_content');
}
add_action('admin_menu', 'glossary_settings_page');

function glossary_settings_page_content() {
    if (!current_user_can('manage_options')) {
        return;
    }
    ?>
    <div class="wrap">
        <h2><?php esc_html_e('Glossary Plugin Settings', 'Live-Glossary-Search'); ?></h2>
        <hr>
        <form method="post" action="options.php">
            <?php 
            settings_fields('glossary_settings_group');
            do_settings_sections('glossary_settings_group');
            $append_whatis_enabled = get_option('glossary_append_whatis_enabled', true);
            ?>
            <h3><?php esc_html_e('Single Posts', 'Live-Glossary-Search'); ?></h3>
            <label for="append_whatis_enabled">
                <input type="checkbox" id="append_whatis_enabled" name="glossary_append_whatis_enabled" value="1" <?php checked($append_whatis_enabled, true); ?>>
                <?php esc_html_e('Append "What is" to post titles?', 'Live-Glossary-Search'); ?>
            </label>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

function glossary_settings_init() {
    register_setting('glossary_settings_group', 'glossary_append_whatis_enabled');
}
add_action('admin_init', 'glossary_settings_init');