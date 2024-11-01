<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       www.terrytsang.com
 * @since      1.0.0
 *
 * @package    WP30_Sky_Bar
 * @subpackage WP30_Sky_Bar/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    WP30_Sky_Bar
 * @subpackage WP30_Sky_Bar/public
 * @author     Terry Tsang <terry@terrytsang.com>
 */
class WP30_Sky_Bar_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $wp30_sky_bar;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0
	 * @param    string    $plugin_name    The name of the plugin.
	 * @param    string    $version        The version of this plugin.
	 */
	public function __construct( $wp30_sky_bar, $version ) {

		$this->wp30_sky_bar = $wp30_sky_bar;
		$this->version = $version;
	}
}
