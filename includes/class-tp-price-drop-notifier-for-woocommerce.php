<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       tplugins.com
 * @since      1.0.0
 *
 * @package    Tp_Price_Drop_Notifier_For_Woocommerce
 * @subpackage Tp_Price_Drop_Notifier_For_Woocommerce/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Tp_Price_Drop_Notifier_For_Woocommerce
 * @subpackage Tp_Price_Drop_Notifier_For_Woocommerce/includes
 * @author     TP Plugins <pluginstp@gmail.com>
 */
class Tp_Price_Drop_Notifier_For_Woocommerce {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Tp_Price_Drop_Notifier_For_Woocommerce_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'TP_PRICE_DROP_NOTIFIER_FOR_WOOCOMMERCE_VERSION' ) ) {
			$this->version = TP_PRICE_DROP_NOTIFIER_FOR_WOOCOMMERCE_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'tp-price-drop-notifier-for-woocommerce';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Tp_Price_Drop_Notifier_For_Woocommerce_Loader. Orchestrates the hooks of the plugin.
	 * - Tp_Price_Drop_Notifier_For_Woocommerce_i18n. Defines internationalization functionality.
	 * - Tp_Price_Drop_Notifier_For_Woocommerce_Admin. Defines all hooks for the admin area.
	 * - Tp_Price_Drop_Notifier_For_Woocommerce_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-tp-price-drop-notifier-for-woocommerce-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-tp-price-drop-notifier-for-woocommerce-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-tp-price-drop-notifier-for-woocommerce-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/tp-price-drop-notifier-for-woocommerce-admin-display.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-tp-price-drop-notifier-for-woocommerce-public.php';

		$this->loader = new Tp_Price_Drop_Notifier_For_Woocommerce_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Tp_Price_Drop_Notifier_For_Woocommerce_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Tp_Price_Drop_Notifier_For_Woocommerce_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Tp_Price_Drop_Notifier_For_Woocommerce_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_filter( 'plugin_action_links_'.TPPDN_PLUGIN_BASENAME, $plugin_admin,'settings_link', 10, 2 );
		$this->loader->add_filter( 'plugin_row_meta', $plugin_admin, 'get_pro_link', 10, 2 );

		$this->loader->add_action( 'save_post', $plugin_admin, 'handler_update_product', 10, 3 );

		//Cron Jobs
		$this->loader->add_filter( 'cron_schedules', $plugin_admin, 'check_every_3_hours' );
		$this->loader->add_action( 'wp', $plugin_admin, 'custom_cron_job' );
		$this->loader->add_action( 'woocommerce_send_email_digest', $plugin_admin, 'generate_email_digest' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Tp_Price_Drop_Notifier_For_Woocommerce_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		//woocommerce_single_product_summary
		//woocommerce_before_add_to_cart_form
		//woocommerce_after_add_to_cart_form
		//woocommerce_product_meta_start
		//woocommerce_product_meta_end

		$this->loader->add_action( 'woocommerce_before_add_to_cart_form', $plugin_public, 'init_price_drop_notifier' );

		$this->loader->add_action( 'wp_footer', $plugin_public, 'init_custom_css' );

		$this->loader->add_action( 'wp_ajax_save_price_drop_notifier', $plugin_public, 'save_price_drop_notifier' );
		$this->loader->add_action( 'wp_ajax_nopriv_save_price_drop_notifier', $plugin_public, 'save_price_drop_notifier' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Tp_Price_Drop_Notifier_For_Woocommerce_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
