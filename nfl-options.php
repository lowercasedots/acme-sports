<?php

//create an options page for the plugin's settings, using the Wordpress Settings API
add_action('admin_menu', 'create_options_page');

function create_options_page() {
    add_options_page('NFL Teams Options', 'NFL Teams Options', 'administrator', __FILE__, 'build_options_page');
}

function build_options_page() {
?>
    <div id="nfl-options-wrap">
        <h2>NFL Teams</h2>
        <form method="post" action="options.php" enctype="multipart/form-data">
            <?php settings_fields('nfl_options'); ?>
            <?php do_settings_sections(__FILE__); ?>
            <div class="submit">
                <input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
            </div>
        </form>

    </div>
<?php
}

//continue to build out the options page by creating some fields for the API key/default theme
add_action('admin_init', 'register_and_build_fields');

function register_and_build_fields() {
    register_setting('nfl_options', 'nfl_options');
    add_settings_section('main_section', 'Plugin Settings', '__return_null', __FILE__);
    add_settings_field('apikey', 'API Key:', 'apikey_setting', __FILE__, 'main_section');
    add_settings_field('theme', 'Default Theme:', 'theme_setting', __FILE__, 'main_section');
}

//create an input for the API key, and pre-fill the field with the saved value, once set
function apikey_setting() {
    $options = get_option('nfl_options');
    echo "<input name='nfl_options[apikey]' type='text' value='" . ( empty($options['apikey'] ) ? '' : $options['apikey'] ) . "' />";
}

//display which theme has been set as default. (Note: There's a hidden third theme not shown here...)
function theme_setting() {
    $options = get_option('nfl_options');
    echo "<input name='nfl_options[theme]' type='radio' value='light'". ($options['theme'] == 'light' ? "checked" : "") ." /> Light <br><br>";
    echo "<input name='nfl_options[theme]' type='radio' value='dark'". ($options['theme'] == 'dark' ? "checked" : "") ." /> Dark <br><br>";
    echo '<small>Note: This default theme can be overwritten by using the "theme" shortcode attribute. [nfl_teams theme="dark"]</small>';
}