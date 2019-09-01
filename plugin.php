<?php 
/**
 * @link            https://yourwebsitelink.com
 * @since           1.0.0
 * @package         Elementor Addons Boilerplate
 * 
 * Plugin Name:     Elementor Addons Boilerplate
 * Plugin URI:      https://yourwebsitelink.com
 * Description:     A standard boilerplate for elementor addons
 * Version:         1.0.0 
 * Author:          Md. Rabiul Islam Robi
 * Author URI:      https://authorswebsitelink.com
 * License:         Elementor Addons Boilerplate 
 * License URI:     https://www.license.com/product-license
 * Text Domain:     boilerplate-textdomain
 */

if( !defined( 'ABSPATH' ) ) exit();

define( 'PREFIX_PLUGIN_URL', plugins_url( '/', __FILE__ ) );
define( 'PREFIX_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

require_once PREFIX_PLUGIN_PATH .'/inc/elementor-helpers/helper.php';
require_once PREFIX_PLUGIN_PATH .'/inc/elementor-helpers/activator.php';
require_once PREFIX_PLUGIN_PATH .'/inc/utilities.php';
require_once PREFIX_PLUGIN_PATH .'/inc/shortcodes.php';

/**
 * Init Styles and Scripts
 */
add_action( 'wp_enqueue_scripts', 'prefix_elementor_core_scripts_styles' );
function prefix_elementor_core_scripts_styles() {
    wp_enqueue_style('prefix-public', plugins_url('/assets/dist/css/public.min.css', __FILE__), '', rand());
    wp_enqueue_script('prefix-public', plugins_url('/assets/dist/js/public.min.js', __FILE__), array('jquery', 'wp-util'), rand(), true);
    
    $options = array(
        'admin_url'         => admin_url(''),
        'ajax_url'          => admin_url('admin-ajax.php'),
        'ajax_nonce'        => wp_create_nonce('ah3jhlk(765%^&ksk!@45'),
    );
    wp_localize_script('prefix-public', 'public_localizer', $options);
}