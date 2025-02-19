<?php
// Add admin settings page
function glossary_settings_page() {
    add_options_page('Glossary Settings', 'Glossary Settings', 'manage_options', 'glossary_settings', 'glossary_settings_page_content');
}
add_action('admin_menu', 'glossary_settings_page');

function glossary_settings_page_content() {
    $append_whatis_enabled = get_option('glossary_append_whatis_enabled', true);
    ?>
    <div class="wrap">
        <h2>Glossary Plugin Settings</h2>
        <hr>
        <form method="post" action="options.php">
            <?php settings_fields('glossary_settings_group'); ?>
            <h3>Single Posts</h3>
            <label for="append_whatis_enabled">
                <input type="checkbox" id="append_whatis_enabled" name="glossary_append_whatis_enabled" value="1" <?php checked($append_whatis_enabled, true); ?>>
                Append "What is" to post titles?
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
