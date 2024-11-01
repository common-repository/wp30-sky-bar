<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       www.terrytsang.com
 * @since      1.0.0
 *
 * @package    WP30_Sky_Bar
 * @subpackage WP30_Sky_Bar/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WP30_Sky_Bar
 * @subpackage WP30_Sky_Bar/admin
 * @author     Terry Tsang <terry@terrytsang.com>
 */
class WP30_Sky_Bar_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $wp30_sky_bar    The ID of this plugin.
	 */
	private $wp30_sky_bar;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Slug
	 *
	 * @since 1.0
	 *
	 * @var   string
	 */
	private $plugin_screen_hook_suffix = null;

	private $force_bar_post_types = array( 'post', 'page' );

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $wp30_sky_bar       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $wp30_sky_bar, $version ) {

		$this->wp30_sky_bar = $wp30_sky_bar;
		$this->version = $version;

		$this->load_dependencies();

	}

	/**
	 * Load the required dependencies for the Admin facing functionality.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - WP30_Sky_Bar_Admin_Settings. Registers the admin settings and page.
	 *
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) .  'admin/class-wp30-sky-bar-settings.php';

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in WP30_Sky_Bar_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The WP30_Sky_Bar_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$screen = get_current_screen();
		$screen_id = $screen->id;

		$force_bar_post_types = $this->force_bar_post_types;

		if ( 'wp30_sky_bar' === $screen_id || in_array( $screen_id, $force_bar_post_types ) ) {

			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_style( $this->wp30_sky_bar, plugin_dir_url( __FILE__ ) . 'css/wp30-sky-bar-admin.css', array(), $this->version, 'all' );
			if ( 'wp30_sky_bar' !== $screen_id ) {
				wp_enqueue_style( $this->wp30_sky_bar.'_select2', plugin_dir_url( __FILE__ ) . 'css/select2.min.css', array(), $this->version, 'all' );
			}
		}

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in WP30_Sky_Bar_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The WP30_Sky_Bar_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$screen = get_current_screen();
		$screen_id = $screen->id;

		$force_bar_post_types = $this->force_bar_post_types;

		if ( 'wp30_sky_bar' === $screen_id || in_array( $screen_id, $force_bar_post_types ) ) {

			wp_enqueue_script( 'wp-color-picker' );

			if ( 'wp30_sky_bar' !== $screen_id ) {

				wp_enqueue_script(
					$this->wp30_sky_bar.'_select2',
					plugin_dir_url( __FILE__ ) . 'js/select2.full.min.js',
					array('jquery'),
					$this->version,
					false
				);
			}

			wp_enqueue_script(
				$this->wp30_sky_bar,
				plugin_dir_url( __FILE__ ) . 'js/wp30-sky-bar-admin.js',
				array(
					'jquery',
					'wp-color-picker',
				),
				$this->version, false
			);

			wp_localize_script(
				$this->wp30_sky_bar,
				'wp30skybar_locale',
				array(
					'select_placeholder' => __( 'Enter Sky Bar Title', $this->wp30_sky_bar ),
				)
			);
		}

	}

}
