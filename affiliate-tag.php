<?php

/**
 * Plugin Name: Compare My Move - Embedded Form
 * Plugin URI: http://www.comparemymove.com/affiliate/
 * Description: This plugin allows those who have signed up to our affiliate program to display our form on the WordPress Site.
 * Version: 1.7.0
 * Author: Matthew Toner
 * Author URI: http://www.comparemymove.com
 * License: GPL2
 */


// Take over the update check
add_filter('cmm_update_plugins', 'check_for_plugin_update');

add_action('admin_menu', 'cmm_plugin_create_menu');
add_action( 'wp_enqueue_scripts', 'cmm_affiliate' );

function cmm_plugin_create_menu() {

    //create new top-level menu
    add_menu_page('Compare My Move Affiliates Plugin', 'Compare My Move', 'administrator', __FILE__, 'cmm_settings_page' , plugins_url('/img/logo.png', __FILE__) );

    //call register settings function
    add_action( 'admin_init', 'cmm_plugin_settings' );
}

function cmm_plugin_settings() {
    //register our settings
    register_setting( 'cmm-settings-group', 'cmm_code' );
}

function cmm_settings_page() { ?>

<div class="wrap">
    <h2>Compare My Move Affiliate Plugin</h2>
    <p>
        Enter your Affiliate Code below to be able to add our form to one of your pages.
        <?php if(esc_attr( get_option('cmm_code') ) != NULL) : ?>
        Once you have entered this and click save, copy and paste the following code: -
    </p>
    <p><code>&lt;div id="cmm_id_<?php echo esc_attr( get_option('cmm_code') ); ?>"&gt;&lt;/div&gt;</code></p>
    <?php else : ?>
    </p>
    <?php endif; ?>
    <form method="post" action="options.php">
        <?php settings_fields( 'cmm-settings-group' ); ?>
        <?php do_settings_sections( 'cmm-settings-group' ); ?>
        <table class="form-table">
            <tr valign="top">
            <th scope="row">Affiliate Code</th>
            <td><input type="text" name="cmm_code" value="<?php echo esc_attr( get_option('cmm_code') ); ?>" /></td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
</div>

<?php }

function cmm_affiliate() {
    // This is to add the script to a site.
    if(esc_attr( get_option('cmm_code') ) != NULL) {
    wp_enqueue_script( 'cmm-affiliate', '//www.comparemymove.com/quote/embed/'.esc_attr( get_option('cmm_code') ), '1.1', true );
    }
}

require 'updates.php';
$myUpdateChecker = PucFactory::buildUpdateChecker(
    'http://wordpress.org/plugins/compare-my-move-affiliate/',
    __FILE__
);

?>