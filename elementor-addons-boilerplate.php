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

/**
* Elementor Extension Main Class
* @author Rabiul
* @since 1.0.0
*/
final class Elementor_Addons_Boilerplate {

	/**
	 * Plugin Version
	 */
	const VERSION = '1.0.0';

	/**
	 * Minimum Elementor Version
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

	/**
	 * Minimum PHP Version
	 */
	const MINIMUM_PHP_VERSION = '7.0';

	/**
	 * Instance
	 */
	private static $_instance = null;

	/**
	 * Instance method
	 * @since 1.0.0
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

	/**
	 * Constructor
	 * @since 1.0.0
	 */
	public function __construct() {
		// Call Define Constants Method
		$this->define_constants();

		add_action( 'init', [ $this, 'i18n' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'scripts_styles' ] );
		add_action( 'plugins_loaded', [ $this, 'init' ] );

	}

	/**
	* Define Plugin Constants
	* @since 1.0.0
	*/
	public function define_constants() {
		define( 'PREFIX_PLUGIN_URL', trailingslashit( plugins_url( '/', __FILE__ ) ) );
		define( 'PREFIX_PLUGIN_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
	}

	/**
	* Load Scripts & Styles
	* @since 1.0.0
	*/
	public function scripts_styles() {
		wp_register_style( 'prefix-style', PREFIX_PLUGIN_URL . 'assets/dist/css/public.min.css', [], rand(), 'all' );
		wp_register_script( 'prefix-script', PREFIX_PLUGIN_URL . 'assets/dist/js/public.min.js', [ 'jquery' ], rand(), true );

		wp_enqueue_style( 'prefix-style' );
		wp_enqueue_script( 'prefix-script' );
	}

	/**
	 * Load Textdomain
	 * @since 1.0.0
	 */
	public function i18n() {

		load_plugin_textdomain( 'elementor-addons-boilerplate' );

	}

	/**
	 * Initialize the plugin
	 * @since 1.0.0
	 */
	public function init() {
		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}

		// Add Plugin actions
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
		add_action( 'elementor/controls/controls_registered', [ $this, 'init_controls' ] );
		add_action( 'elementor/init', [ $this, 'init_category' ] );
	}

	/**
	 * Admin notice
	 * Warning when the site doesn't have Elementor installed or activated.
	 * @since 1.0.0
	 */
	public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'elementor-addons-boilerplate' ),
			'<strong>' . esc_html__( 'Elementor Addons Boilerplate', 'elementor-addons-boilerplate' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'elementor-addons-boilerplate' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 * Warning when the site doesn't have a minimum required Elementor version.
	 * @since 1.0.0
	 */
	public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-addons-boilerplate' ),
			'<strong>' . esc_html__( 'Elementor Addons Boilerplate', 'elementor-addons-boilerplate' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'elementor-addons-boilerplate' ) . '</strong>',
			 self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 * Warning when the site doesn't have a minimum required PHP version.
	 * @since 1.0.0
	 */
	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-addons-boilerplate' ),
			'<strong>' . esc_html__( 'Elementor Addons Boilerplate', 'elementor-addons-boilerplate' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'elementor-addons-boilerplate' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Init Widgets
	 * @since 1.0.0
	 */
	public function init_widgets() {
		// Include Widget files
		require_once PREFIX_PLUGIN_PATH . '/widgets/blank.php';
	}

	/**
	 * Init Controls
	 * @since 1.0.0
	 */
	public function init_controls() {
		// Include Control files
		// require_once( __DIR__ . '/controls/test-control.php' );

		// // Register control
		// \Elementor\Plugin::$instance->controls_manager->register_control( 'control-type-', new \Test_Control() );
    }
    
    /**
     * Init Category Section
     * @since 1.0.0
     */
    public function init_category(){
        Elementor\Plugin::instance()->elements_manager->add_category(
            'prefix-for-elementor',
            [
                'title'     => 'Prefix Elements',
                'icon'      => 'font'
            ],
            1
        );
    }

}

// Run the plugin
Elementor_Addons_Boilerplate::instance();