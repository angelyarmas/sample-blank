<?php
/*
Plugin Name: Coming Soon Plugin
Description: Put site into "coming soon" mode with a simple checkbox.
Version: 1.0
Author: Your Name
*/

// Register the settings page
target',
    'menu_title' => 'Coming Soon',
    'capability' => 'manage_options',
    'menu_slug'  => 'coming-soon-settings',
    'callback'   => 'coming_soon_settings_page'
    ));
}
add_action( 'admin_menu', 'coming_soon_register_settings_page' );

// Callback function to display the settings page
function coming_soon_settings_page() {
    ?>
    <div class="wrap">
        <h1>Coming Soon Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields( 'coming_soon_options_group' );
            do_settings_sections( 'coming-soon-settings' );
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Register the settings
function coming_soon_register_settings() {
    register_setting( 'coming_soon_options_group', 'coming_soon_enabled' );

    add_settings_section(
        'coming_soon_section',
        '',
        null,
        'coming-soon-settings'
    );

    add_settings_field(
        'coming_soon_field',
        'Enable Coming Soon Mode',
        'coming_soon_checkbox_callback',
        'coming-soon-settings',
        'coming_soon_section'
    );
}
add_action( 'admin_init', 'coming_soon_register_settings' );

// Checkbox callback
function coming_soon_checkbox_callback() {
    $option = get_option( 'coming_soon_enabled' );
    echo '<input type="checkbox" name="coming_soon_enabled" value="1" ' . checked( 1, $option, false ) . ' />';
}

// Redirect to Coming Soon page if enabled
function coming_soon_init() {
    if ( !is_admin() && !is_user_logged_in() && get_option( 'coming_soon_enabled' ) ) {
        wp_die('<h1>Coming Soon</h1><p>Our website is coming soon. Stay tuned!</p>');
    }
}
add_action( 'template_redirect', 'coming_soon_init' );