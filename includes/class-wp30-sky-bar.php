<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       www.terrytsang.com
 * @since      1.0.0
 *
 * @package    WP30_Sky_Bar
 * @subpackage WP30_Sky_Bar/includes
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
 * @package    WP30_Sky_Bar
 * @subpackage WP30_Sky_Bar/includes
 * @author     Terry Tsang <terry@terrytsang.com>
 */
class WP30_Sky_Bar {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      WP30_Sky_Bar_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $wp30_sky_bar    The string used to uniquely identify this plugin.
	 */
	protected $wp30_sky_bar;

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
		if ( defined( 'WP30_VERSION' ) ) {
			$this->version = WP30_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->wp30_sky_bar = 'wp30-sky-bar';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_shared_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - WP30_Sky_Bar_Loader. Orchestrates the hooks of the plugin.
	 * - WP30_Sky_Bar_i18n. Defines internationalization functionality.
	 * - WP30_Sky_Bar_Admin. Defines all hooks for the admin area.
	 * - WP30_Sky_Bar_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp30-sky-bar-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp30-sky-bar-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wp30-sky-bar-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wp30-sky-bar-settings.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wp30-sky-bar-public.php';

		/**
		 * The class responsible for defining all actions that occur in both sides of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp30-sky-bar-shared.php';

		$this->loader = new WP30_Sky_Bar_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the WP30_Sky_Bar_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new WP30_Sky_Bar_i18n();

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

		$plugin_admin = new WP30_Sky_Bar_Admin( $this->get_wp30_sky_bar(), $this->get_version() );
		$plugin_settings = new WP30_Sky_Bar_Settings( $this->get_wp30_sky_bar(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		// Register our post type
		$this->loader->add_action( 'init', $plugin_settings, 'wp30_sky_bar_admin' );

		// Metaboxes
		$this->loader->add_action( 'add_meta_boxes', $plugin_settings, 'add_custom_meta_box' );
		$this->loader->add_action( 'save_post', $plugin_settings, 'save_custom_meta' );

		// Add preview button to poblish metabox
		$this->loader->add_action( 'post_submitbox_misc_actions', $plugin_settings, 'add_preview_button' );

		$this->loader->add_filter( 'post_updated_messages', $plugin_settings, 'wp30skybar_update_messages' );

		// Force notification bar metabox
		$this->loader->add_action( 'add_meta_boxes', $plugin_settings, 'wp30skybar_select_metabox_insert' );
		$this->loader->add_action( 'save_post', $plugin_settings, 'wp30skybar_select_metabox_save' );
		$this->loader->add_action( 'wp_ajax_wp30skybar_get_bars', $plugin_settings, 'wp30skybar_get_bars' );
		$this->loader->add_action( 'wp_ajax_wp30skybar_get_bar_titles', $plugin_settings, 'wp30skybar_get_bar_titles' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new WP30_Sky_Bar_Public( $this->get_wp30_sky_bar(), $this->get_version() );
	}


	/**
	 * Register all of the hooks related to both public and dashboard functionality
	 * of the plugin.
	 *
	 * @since    1.0
	 * @access   private
	 */
	private function define_shared_hooks() {

		$plugin_shared = new WP30_Sky_Bar_Shared( $this->get_wp30_sky_bar(), $this->get_version() );

		// get/set bar settings
		$this->loader->add_action( 'wp', $plugin_shared, 'get_wp30skybar_data' );
		// Display bar on front end
		$this->loader->add_action( 'wp_footer', $plugin_shared, 'wp30_display_bar' );
		// Ajax Preview on backend
		$this->loader->add_action( 'wp_ajax_preview_bar', $plugin_shared, 'wp30_preview_bar' );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_shared, 'enqueue_styles', -1 );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_shared, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_shared, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_shared, 'enqueue_scripts' );
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
	public function get_wp30_sky_bar() {
		return $this->wp30_sky_bar;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    WP30_Sky_Bar_Loader    Orchestrates the hooks of the plugin.
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
