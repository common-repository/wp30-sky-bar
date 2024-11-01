<?php

/**
 * The settings of the plugin.
 *
 * @link       http://terrytsang.com/wp30/sky-bar
 * @since      1.0.0
 *
 * @package    WP30_Sky_Bar
 * @subpackage WP30_Sky_Bar/admin
 */

/**
 * Class WordPress_Plugin_Template_Settings
 *
 */
class WP30_Sky_Bar_Settings {

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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $wp30_sky_bar       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $wp30_sky_bar, $version ) {

		$this->wp30_sky_bar = $wp30_sky_bar;
		$this->version = $version;

	}

	public function wp30_sky_bar_admin() {
		$labels = array(
			'name'               => _x( 'WP30 - Sky Bars', 'post type general name', $this->wp30_sky_bar ),
			'singular_name'      => _x( 'Sky Bar', 'post type singular name', $this->wp30_sky_bar ),
			'menu_name'          => _x( 'Sky Bar', 'admin menu', $this->wp30_sky_bar ),
			'name_admin_bar'     => _x( 'Sky Bar', 'add new on admin bar', $this->wp30_sky_bar ),
			'add_new'            => _x( 'Add New', 'sky bar', $this->wp30_sky_bar ),
			'add_new_item'       => __( 'Add New Sky Bar', $this->wp30_sky_bar ),
			'new_item'           => __( 'New Sky Bar', $this->wp30_sky_bar ),
			'edit_item'          => __( 'Edit Sky Bar', $this->wp30_sky_bar ),
			'view_item'          => __( 'View Sky Bar', $this->wp30_sky_bar ),
			'all_items'          => __( 'All Sky Bars', $this->wp30_sky_bar ),
			'search_items'       => __( 'Search Sky Bars', $this->wp30_sky_bar ),
			'parent_item_colon'  => __( 'Parent Sky Bars:', $this->wp30_sky_bar ),
			'not_found'          => __( 'No sky bars found.', $this->wp30_sky_bar ),
			'not_found_in_trash' => __( 'No sky bars found in Trash.', $this->wp30_sky_bar )
		);

		$args = array(
			'labels' => $labels,
			'public' => false,
			'show_ui' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'rewrite' => false,
			'publicly_queryable' => false,
			'menu_position' => 100,
			'menu_icon' => 'dashicons-info',
			'has_archive' => false,
			'supports' => array('title')
		);

		register_post_type( 'wp30_sky_bar' , $args );

		// Filter supported post types where user ca override bar on single view
		$force_bar_supported_post_types = apply_filters( 'wp30skybar_force_bar_post_types', array( 'post', 'page' ) );

		if ( ( $key = array_search( 'wp30_sky_bar', $force_bar_supported_post_types ) ) !== false ) {

			unset( $force_bar_supported_post_types[ $key ] );
		}

		$this->force_bar_post_types = $force_bar_supported_post_types;
	}

	/**
	 * Add preview button to edit bar page.
	 *
	 * @since    1.0
	 */
	public function add_preview_button() {
		global $post;
		if ( 'wp30_sky_bar' === $post->post_type ) {
			echo '<div class="misc-pub-section">';
				echo '<a href="#" class="button" id="preview-bar"><i class="dashicons dashicons-visibility"></i> '.__( 'Preview Bar', $this->wp30_sky_bar ).'</a>';
			echo '</div>';
		}
	}

	/**
	 * Add the Meta Box
	 *
	 * @since    1.0
	 */
	public function add_custom_meta_box() {
	    
        add_meta_box(
            'custom_meta_box',
            __( 'Settings', $this->wp30_sky_bar ),
            array( $this, 'show_custom_meta_box' ),
            'wp30_sky_bar',
            'normal',
            'high'
        );
	}

	/**
	 * The Callback, Meta Box Content
	 *
	 * @since    1.0
	 */
	public function show_custom_meta_box( $post ) {

		$general_options = array(
			array(
				'type' => 'select',
				'name' => 'button',
				'label' => __( 'Close Button', $this->wp30_sky_bar ),
				'default'=> 'no_button',
				'options' => array(
					'no_button' => __( 'No Button', $this->wp30_sky_bar ),
					'toggle_button' => __( 'Toggle Button', $this->wp30_sky_bar ),
					'close_button' => __( 'Close Button', $this->wp30_sky_bar ),
				),
				'class' => 'wp30skybar-has-child-opt'
			),
			array(
				'type' => 'number',
				'name' => 'content_width',
				'label' => __( 'Content Width (px)', $this->wp30_sky_bar ),
				'default'=> '960'
			),
			array(
				'type' => 'number',
				'name' => 'content_height',
				'label' => __( 'Content Height (px)', $this->wp30_sky_bar ),
				'default'=> '30'
			),
			array(
				'type' => 'select',
				'name' => 'css_position',
				'label' => __( 'Notification bar CSS position', $this->wp30_sky_bar ),
				'default'=> 'fixed',
				'options' => array(
					'fixed' => __( 'Fixed', $this->wp30_sky_bar ),
					'absolute' => __( 'Absolute', $this->wp30_sky_bar ),
				)
			),
		);

		$style_options = array(
			array(
				'type' => 'color',
				'name' => 'bg_color',
				'label' => __( 'Background Color', $this->wp30_sky_bar ),
				'default'=> '#d35151'
			),
			array(
				'type' => 'color',
				'name' => 'txt_color',
				'label' => __( 'Text Color', $this->wp30_sky_bar ),
				'default'=> '#ffffff'
			),
			array(
				'type' => 'color',
				'name' => 'link_color',
				'label' => __( 'Link Color/Button Color', $this->wp30_sky_bar ),
				'default'=> '#f4a700'
			),
			array(
				'type' => 'number',
				'name' => 'font_size',
				'label' => __( 'Font size (px)', $this->wp30_sky_bar ),
				'default'=> '15'
			),
		);

		$button_content_type_options = array(
			array(
				'type' => 'select',
				'name' => 'basic_link_style',
				'label' => __( 'Link Style', $this->wp30_sky_bar ),
				'default'=> 'link',
				'options' => array(
					'link' => __( 'Link', $this->wp30_sky_bar ),
					'button' => __( 'Button', $this->wp30_sky_bar ),
				)
			),
			array(
				'type' => 'text',
				'name' => 'basic_text',
				'label' => __( 'Text', $this->wp30_sky_bar ),
				'default'=> ''
			),
			array(
				'type' => 'text',
				'name' => 'basic_link_text',
				'label' => __( 'Link/Button Text', $this->wp30_sky_bar ),
				'default'=> ''
			),
			array(
				'type' => 'text',
				'name' => 'basic_link_url',
				'label' => __( 'Link/Button Url', $this->wp30_sky_bar ),
				'default'=> ''
			),
		);

		$custom_content_type_options = array(
			array(
				'type' => 'textarea',
				'name' => 'custom_content',
				'label' => __( 'Add custom content, shortcodes allowed', $this->wp30_sky_bar ),
				'default'=> ''
			),
		);

		// Add an nonce field so we can check for it later.
		wp_nonce_field('wp30skybar_meta_box', 'wp30skybar_meta_box_nonce');
		// Use get_post_meta to retrieve an existing value from the database.
		$value = get_post_meta( $post->ID, '_wp30skybar_data', true );//var_dump($value);
		?>
		<div class="wp30skybar-tabs clearfix">
			<div class="wp30skybar-tabs-inner clearfix">
				<?php $active_tab = ( isset( $value['active_tab'] ) && !empty( $value['active_tab'] ) ) ? $value['active_tab'] : 'general'; ?>
				<input type="hidden" class="wp30skybar-tab-option" name="wp30skybar_fields[active_tab]" id="wp30skybar_fields_active_tab" value="<?php echo $active_tab; ?>" />
				<ul class="wp30skybar-tabs-nav" id="main-tabs-nav">
					<li>
						<a href="#tab-general" <?php if ( $active_tab === 'general' ) echo 'class="active"'; ?>>
							<span class="wp30skybar-tab-title"><i class="dashicons dashicons-admin-generic"></i><?php _e( 'General', $this->wp30_sky_bar ); ?></span>
						</a>
					</li>
					<li>
						<a href="#tab-type" <?php if ( $active_tab === 'type' ) echo 'class="active"'; ?>>
							<span class="wp30skybar-tab-title"><i class="dashicons dashicons-edit"></i><?php _e( 'Content', $this->wp30_sky_bar ); ?></span>
						</a>
					</li>
					<li>
						<a href="#tab-style" <?php if ( $active_tab === 'style' ) echo 'class="active"'; ?>>
							<span class="wp30skybar-tab-title"><i class="dashicons dashicons-admin-appearance"></i><?php _e( 'Design', $this->wp30_sky_bar ); ?></span>
						</a>
					</li>
					<li>
						<a href="#tab-conditions" <?php if ( $active_tab === 'conditions' ) echo 'class="active"'; ?>>
							<span class="wp30skybar-tab-title"><i class="dashicons dashicons-admin-settings"></i><?php _e( 'Rules', $this->wp30_sky_bar ); ?></span>
						</a>
					</li>
				</ul>
				<div class="wp30skybar-tabs-wrap" id="main-tabs-wrap">
					<div id="tab-general" class="wp30skybar-tabs-content <?php if ( $active_tab === 'general' ) echo 'active'; ?>">
						<div class="wp30skybar-tab-desc"><?php _e( 'Select basic settings like close button type and CSS position of the bar.', $this->wp30_sky_bar ); ?></div>
						<div class="wp30skybar-tab-options clearfix">
							<?php
							foreach ( $general_options as $option_args ) {
								$this->custom_meta_field( $option_args, $value );
							}
							?>
						</div>
					</div>
					<div id="tab-type" class="wp30skybar-tabs-content <?php if ( $active_tab === 'type' ) echo 'active'; ?>">
						<div class="wp30skybar-tab-desc"><?php _e( 'Set up sky bar content. Select content type and fill in the fields.', $this->wp30_sky_bar ); ?></div>
						<div class="wp30skybar-tab-options clearfix">
							<?php $content_type = ( isset( $value['content_type'] ) && !empty( $value['content_type'] ) ) ? $value['content_type'] : 'button'; ?>
							<input type="hidden" class="wp30skybar-tab-option" name="wp30skybar_fields[content_type]" id="wp30skybar_fields_content_type" value="<?php echo $content_type; ?>" />
							<ul class="wp30skybar-tabs-nav" id="sub-tabs-nav">
								<li><a href="#tab-button" <?php if ( $content_type === 'button' ) echo 'class="active"'; ?>><?php _e( 'Text and Link/Button', $this->wp30_sky_bar ); ?></a></li>
								<li><a href="#tab-custom" <?php if ( $content_type === 'custom' ) echo 'class="active"'; ?>><?php _e( 'Custom', $this->wp30_sky_bar ); ?></a></li>
							</ul>
							<div class="meta-tabs-wrap" id="sub-tabs-wrap">
								<div id="tab-button" class="wp30skybar-tabs-content <?php if ( $content_type === 'button' ) echo 'active'; ?>">
									<?php
									foreach ( $button_content_type_options as $option_args ) {
										$this->custom_meta_field( $option_args, $value );
									}
									?>
								</div>
								<div id="tab-custom" class="wp30skybar-tabs-content <?php if ( $content_type === 'custom' ) echo 'active'; ?>">
									<?php
									foreach ( $custom_content_type_options as $option_args ) {
										$this->custom_meta_field( $option_args, $value );
									}
									?>
								</div>
							</div>
						</div>
					</div>
					<div id="tab-style" class="wp30skybar-tabs-content <?php if ( $active_tab === 'style' ) echo 'active'; ?>">
						<div class="wp30skybar-tab-desc"><?php _e( 'Change the appearance of the sky bar.', $this->wp30_sky_bar ); ?></div>
						<div class="wp30skybar-tab-options clearfix">
						<?php
						foreach ( $style_options as $option_args ) {
							$this->custom_meta_field( $option_args, $value );
						}
						?>
						</div>
					</div>
					<div id="tab-conditions" class="wp30skybar-tabs-content <?php if ( $active_tab === 'conditions' ) echo 'active'; ?>">
						<div class="wp30skybar-tab-desc"><?php _e( 'Choose when and where to display the sky bar.', $this->wp30_sky_bar ); ?></div>
						<div id="conditions-selector-wrap" class="clearfix">
							<div id="conditions-selector">
								<ul>
									<?php $condition_location_state       = isset( $value['conditions'] ) && isset( $value['conditions']['location'] ) && ( isset( $value['conditions']['location']['state'] ) && !empty( $value['conditions']['location']['state'] ) ) ? $value['conditions']['location']['state'] : ''; ?>
									<?php $condition_notlocation_state    = isset( $value['conditions'] ) && isset( $value['conditions']['notlocation'] ) && ( isset( $value['conditions']['notlocation']['state'] ) && !empty( $value['conditions']['notlocation']['state'] ) ) ? $value['conditions']['notlocation']['state'] : ''; ?>
									<?php $condition_location_disabled    = empty( $condition_notlocation_state ) ? '' : ' disabled'; ?>
									<?php $condition_notlocation_disabled = empty( $condition_location_state ) ? '' : ' disabled'; ?>
									<li id="condition-location" data-disable="notlocation" class="condition-checkbox <?php echo $condition_location_state.$condition_location_disabled; ?>">
										<?php _e( 'On specific locations', $this->wp30_sky_bar ); ?>
										<div class="wp30skybar-check"></div>
										<input type="hidden" class="wp30skybar-condition-checkbox-input" id="wp30skybar_fields_conditions_location_state" name="wp30skybar_fields[conditions][location][state]" value="<?php echo $condition_location_state; ?>">
									</li>
									<li id="condition-notlocation" data-disable="location" class="condition-checkbox <?php echo $condition_notlocation_state.$condition_notlocation_disabled; ?>">
										<?php _e( 'Not on specific locations', $this->wp30_sky_bar ); ?>
										<div class="wp30skybar-check"></div>
										<input type="hidden" class="wp30skybar-condition-checkbox-input" id="wp30skybar_fields_conditions_notlocation_state" name="wp30skybar_fields[conditions][notlocation][state]" value="<?php echo $condition_notlocation_state; ?>">
									</li>
									<?php $condition_google_state       = isset( $value['conditions'] ) && isset( $value['conditions']['google'] ) && ( isset( $value['conditions']['google']['state'] ) && !empty( $value['conditions']['google']['state'] ) ) ? $value['conditions']['google']['state'] : ''; ?>
									<?php $condition_notgoogle_state    = isset( $value['conditions'] ) && isset( $value['conditions']['notgoogle'] ) && ( isset( $value['conditions']['notgoogle']['state'] ) && !empty( $value['conditions']['notgoogle']['state'] ) ) ? $value['conditions']['notgoogle']['state'] : ''; ?>
									<?php $condition_google_disabled    = empty( $condition_notgoogle_state ) ? '' : ' disabled'; ?>
									<?php $condition_notgoogle_disabled = empty( $condition_google_state ) ? '' : ' disabled'; ?>
									<li id="condition-google" data-disable="notgoogle" class="condition-checkbox <?php echo $condition_google_state.$condition_google_disabled; ?>">
										<?php _e( 'From Google', $this->wp30_sky_bar ); ?>
										<div class="wp30skybar-check"></div>
										<input type="hidden" class="wp30skybar-condition-checkbox-input" id="wp30skybar_fields_conditions_google_state" name="wp30skybar_fields[conditions][google][state]" value="<?php echo $condition_google_state; ?>">
									</li>
									<li id="condition-notgoogle" data-disable="google" class="condition-checkbox <?php echo $condition_notgoogle_state.$condition_notgoogle_disabled; ?>">
										<?php _e( 'Not from Google', $this->wp30_sky_bar ); ?>
										<div class="wp30skybar-check"></div>
										<input type="hidden" class="wp30skybar-condition-checkbox-input" id="wp30skybar_fields_conditions_notgoogle_state" name="wp30skybar_fields[conditions][notgoogle][state]" value="<?php echo $condition_notgoogle_state; ?>">
									</li>
									<?php $condition_facebook_state       = isset( $value['conditions'] ) && isset( $value['conditions']['facebook'] ) && ( isset( $value['conditions']['facebook']['state'] ) && !empty( $value['conditions']['facebook']['state'] ) ) ? $value['conditions']['facebook']['state'] : ''; ?>
									<?php $condition_notfacebook_state    = isset( $value['conditions'] ) && isset( $value['conditions']['notfacebook'] ) && ( isset( $value['conditions']['notfacebook']['state'] ) && !empty( $value['conditions']['notfacebook']['state'] ) ) ? $value['conditions']['notfacebook']['state'] : ''; ?>
									<?php $condition_facebook_disabled    = empty( $condition_notfacebook_state ) ? '' : ' disabled'; ?>
									<?php $condition_notfacebook_disabled = empty( $condition_facebook_state ) ? '' : ' disabled'; ?>
									<li id="condition-facebook" data-disable="notfacebook" class="condition-checkbox <?php echo $condition_facebook_state.$condition_facebook_disabled; ?>">
										<?php _e( 'From Facebook', $this->wp30_sky_bar ); ?>
										<div class="wp30skybar-check"></div>
										<input type="hidden" class="wp30skybar-condition-checkbox-input" id="wp30skybar_fields_conditions_facebook_state" name="wp30skybar_fields[conditions][facebook][state]" value="<?php echo $condition_facebook_state; ?>">
									</li>
									<li id="condition-notfacebook" data-disable="facebook" class="condition-checkbox <?php echo $condition_notfacebook_state.$condition_notfacebook_disabled; ?>">
										<?php _e( 'Not from Facebook', $this->wp30_sky_bar ); ?>
										<div class="wp30skybar-check"></div>
										<input type="hidden" class="wp30skybar-condition-checkbox-input" id="wp30skybar_fields_conditions_notfacebook_state" name="wp30skybar_fields[conditions][notfacebook][state]" value="<?php echo $condition_notfacebook_state; ?>">
									</li>
								</ul>
							</div>
							<div id="conditions-panels">
								<div id="condition-location-panel" class="wp30skybar-conditions-panel <?php echo $condition_location_state; ?>">
									<div class="wp30skybar-conditions-panel-title"><?php _e( 'On specific locations', $this->wp30_sky_bar ); ?></div>
									<div class="wp30skybar-conditions-panel-content">
										<div class="wp30skybar-conditions-panel-desc"><?php _e( 'Show Sky Bar on the following locations', $this->wp30_sky_bar ); ?></div>
										<div class="wp30skybar-conditions-panel-opt">
											<?php $location_home       = isset( $value['conditions'] ) && isset( $value['conditions']['location'] ) && ( isset( $value['conditions']['location']['home'] ) && !empty( $value['conditions']['location']['home'] ) ) ? $value['conditions']['location']['home'] : '0'; ?>
											<?php $location_blog_home  = isset( $value['conditions'] ) && isset( $value['conditions']['location'] ) && ( isset( $value['conditions']['location']['blog_home'] ) && !empty( $value['conditions']['location']['blog_home'] ) ) ? $value['conditions']['location']['blog_home'] : '0'; ?>
											<?php $location_pages      = isset( $value['conditions'] ) && isset( $value['conditions']['location'] ) && ( isset( $value['conditions']['location']['pages'] ) && !empty( $value['conditions']['location']['pages'] ) ) ? $value['conditions']['location']['pages'] : '0'; ?>
											<?php $location_posts      = isset( $value['conditions'] ) && isset( $value['conditions']['location'] ) && ( isset( $value['conditions']['location']['posts'] ) && !empty( $value['conditions']['location']['posts'] ) ) ? $value['conditions']['location']['posts'] : '0'; ?>
											<p>
												<label>
													<input type="checkbox" class="wp30skybar-checkbox" name="wp30skybar_fields[conditions][location][home]" id="wp30skybar_fields_conditions_location_home" value="1" <?php checked( $location_home, '1', true ); ?> />
													<?php _e( 'Homepage.', $this->wp30_sky_bar ); ?>
												</label>
											</p>
											<?php if ( 'page' === get_option('show_on_front') && '0' !== get_option('page_for_posts') && '0' !== get_option('page_on_front') ) { ?>
												<p>
													<label>
														<input type="checkbox" class="wp30skybar-checkbox" name="wp30skybar_fields[conditions][location][blog_home]" id="wp30skybar_fields_conditions_location_blog_home" value="1" <?php checked( $location_blog_home, '1', true ); ?> />
														<?php _e( 'Blog Homepage.', $this->wp30_sky_bar ); ?>
													</label>
												</p>
											<?php } ?>
											<p>
												<label>
													<input type="checkbox" class="wp30skybar-checkbox" name="wp30skybar_fields[conditions][location][pages]" id="wp30skybar_fields_conditions_location_pages" value="1" <?php checked( $location_pages, '1', true ); ?> />
													<?php _e( 'Pages.', $this->wp30_sky_bar ); ?>
												</label>
											</p>
											<p>
												<label>
													<input type="checkbox" class="wp30skybar-checkbox" name="wp30skybar_fields[conditions][location][posts]" id="wp30skybar_fields_conditions_location_posts" value="1" <?php checked( $location_posts, '1', true ); ?> />
													<?php _e( 'Posts.', $this->wp30_sky_bar ); ?>
												</label>
											</p>
										</div>
									</div>
								</div>
								<div id="condition-notlocation-panel" class="wp30skybar-conditions-panel <?php echo $condition_notlocation_state; ?>">
									<div class="wp30skybar-conditions-panel-title"><?php _e( 'Not on specific locations', $this->wp30_sky_bar ); ?></div>
									<div class="wp30skybar-conditions-panel-content">
										<div class="wp30skybar-conditions-panel-desc"><?php _e( 'Hide Sky Bar on the following locations', $this->wp30_sky_bar ); ?></div>
										<div class="wp30skybar-conditions-panel-opt">
											<?php $notlocation_home      = isset( $value['conditions'] ) && isset( $value['conditions']['notlocation'] ) && ( isset( $value['conditions']['notlocation']['home'] ) && !empty( $value['conditions']['notlocation']['home'] ) ) ? $value['conditions']['notlocation']['home'] : '0'; ?>
											<?php $notlocation_blog_home = isset( $value['conditions'] ) && isset( $value['conditions']['notlocation'] ) && ( isset( $value['conditions']['notlocation']['blog_home'] ) && !empty( $value['conditions']['notlocation']['blog_home'] ) ) ? $value['conditions']['notlocation']['blog_home'] : '0'; ?>
											<?php $notlocation_pages     = isset( $value['conditions'] ) && isset( $value['conditions']['notlocation'] ) && ( isset( $value['conditions']['notlocation']['pages'] ) && !empty( $value['conditions']['notlocation']['pages'] ) ) ? $value['conditions']['notlocation']['pages'] : '0'; ?>
											<?php $notlocation_posts     = isset( $value['conditions'] ) && isset( $value['conditions']['notlocation'] ) && ( isset( $value['conditions']['notlocation']['posts'] ) && !empty( $value['conditions']['notlocation']['posts'] ) ) ? $value['conditions']['notlocation']['posts'] : '0'; ?>
											<p>
												<label>
													<input type="checkbox" class="wp30skybar-checkbox" name="wp30skybar_fields[conditions][notlocation][home]" id="wp30skybar_fields_conditions_notlocation_home" value="1" <?php checked( $notlocation_home, '1', true ); ?> />
													<?php _e( 'Homepage.', $this->wp30_sky_bar ); ?>
												</label>
											</p>
											<?php if ( 'page' === get_option('show_on_front') && '0' !== get_option('page_for_posts') && '0' !== get_option('page_on_front') ) { ?>
												<p>
													<label>
														<input type="checkbox" class="wp30skybar-checkbox" name="wp30skybar_fields[conditions][notlocation][blog_home]" id="wp30skybar_fields_conditions_notlocation_blog_home" value="1" <?php checked( $notlocation_blog_home, '1', true ); ?> />
														<?php _e( 'Blog Homepage.', $this->wp30_sky_bar ); ?>
													</label>
												</p>
											<?php } ?>
											<p>
												<label>
													<input type="checkbox" class="wp30skybar-checkbox" name="wp30skybar_fields[conditions][notlocation][pages]" id="wp30skybar_fields_conditions_notlocation_pages" value="1" <?php checked( $notlocation_pages, '1', true ); ?> />
													<?php _e( 'Pages.', $this->wp30_sky_bar ); ?>
												</label>
											</p>
											<p>
												<label>
													<input type="checkbox" class="wp30skybar-checkbox" name="wp30skybar_fields[conditions][notlocation][posts]" id="wp30skybar_fields_conditions_notlocation_posts" value="1" <?php checked( $notlocation_posts, '1', true ); ?> />
													<?php _e( 'Posts.', $this->wp30_sky_bar ); ?>
												</label>
											</p>
										</div>
									</div>
								</div>
								<div id="condition-google-panel" class="wp30skybar-conditions-panel <?php echo $condition_google_state; ?>">
									<div class="wp30skybar-conditions-panel-title"><?php _e( 'From Google', $this->wp30_sky_bar ); ?></div>
									<div class="wp30skybar-conditions-panel-content">
										<div class="wp30skybar-conditions-panel-desc">
											<p>
												<label>
													<?php _e( 'Show Sky Bar if visitor arrived via Google search engine.', $this->wp30_sky_bar ); ?>
												</label>
											</p>
										</div>
									</div>
								</div>
								<div id="condition-notgoogle-panel" class="wp30skybar-conditions-panel <?php echo $condition_notgoogle_state; ?>">
									<div class="wp30skybar-conditions-panel-title"><?php _e( 'Not from Google', $this->wp30_sky_bar ); ?></div>
									<div class="wp30skybar-conditions-panel-content">
										<div class="wp30skybar-conditions-panel-desc">
											<p>
												<label>
													<?php _e( 'Hide Sky Bar if visitor arrived via Google search engine.', $this->wp30_sky_bar ); ?>
												</label>
											</p>
										</div>
									</div>
								</div>
								<div id="condition-facebook-panel" class="wp30skybar-conditions-panel <?php echo $condition_facebook_state; ?>">
									<div class="wp30skybar-conditions-panel-title"><?php _e( 'From Facebook', $this->wp30_sky_bar ); ?></div>
									<div class="wp30skybar-conditions-panel-content">
										<div class="wp30skybar-conditions-panel-desc">
											<p>
												<label>
													<?php _e( 'Show Sky Bar if visitor arrived from Facebook.', $this->wp30_sky_bar ); ?>
												</label>
											</p>
										</div>
									</div>
								</div>
								<div id="condition-notfacebook-panel" class="wp30skybar-conditions-panel <?php echo $condition_notfacebook_state; ?>">
									<div class="wp30skybar-conditions-panel-title"><?php _e( 'Not from Facebook', $this->wp30_sky_bar ); ?></div>
									<div class="wp30skybar-conditions-panel-content">
										<div class="wp30skybar-conditions-panel-desc">
											<p>
												<label>
													<?php _e( 'Hide Sky Bar if visitor arrived from Facebook.', $this->wp30_sky_bar ); ?>
												</label>
											</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Helper function for common fields
	 *
	 * @since    1.0
	 */
	public function custom_meta_field( $args, $value, $b = false ) {

		$type = isset( $args['type'] ) ? $args['type'] : '';
		$name = isset( $args['name'] ) ? $args['name'] : '';
		$name = $b ? 'b_'.$name : $name;
		$label = isset( $args['label'] ) ? $args['label'] : '';
		$options = isset( $args['options'] ) ? $args['options'] : array();
		$default = isset( $args['default'] ) ? $args['default'] : '';
		$min = isset( $args['min'] ) ? $args['min'] : '0';

		$class = isset( $args['class'] ) ? $args['class'] : '';

		// Option value
		$opt_val = isset( $value[ $name ] ) ? $value[ $name ] : $default;

		?>
		<div id="wp30skybar_fields_<?php echo $name;?>_row" class="form-row">
			<label class="form-label" for="wp30skybar_fields_<?php echo $name;?>"><?php echo $label; ?></label>
			<div class="form-option <?php echo $class; ?>">
			<?php
			switch ( $type ) {

				case 'text':
				?>
					<input type="text" name="wp30skybar_fields[<?php echo $name;?>]" id="wp30skybar_fields_<?php echo $name;?>" value="<?php echo esc_attr( $opt_val );?>" />
				<?php
				break;
				case 'select':
				?>
					<select name="wp30skybar_fields[<?php echo $name;?>]" id="wp30skybar_fields_<?php echo $name;?>">
					<?php foreach ( $options as $val => $label ) { ?>
						<option value="<?php echo $val; ?>" <?php selected( $opt_val, $val, true); ?>><?php echo $label ?></option>
					<?php } ?>
					</select>
				<?php
				break;
				case 'number':
				?>
					<input type="number" step="1" min="<?php echo $min;?>" name="wp30skybar_fields[<?php echo $name;?>]" id="wp30skybar_fields_<?php echo $name;?>" value="<?php echo $opt_val;?>" class="small-text"/>
				<?php
				break;
				case 'color':
				?>
					<input type="text" name="wp30skybar_fields[<?php echo $name;?>]" id="wp30skybar_fields_<?php echo $name;?>" value="<?php echo $opt_val;?>" class="wp30skybar-color-picker" />
				<?php
				break;
				case 'textarea':
				?>
					<textarea name="wp30skybar_fields[<?php echo $name;?>]" id="wp30skybar_fields_<?php echo $name;?>" class="wp30skybar-textarea"><?php echo esc_textarea( $opt_val );?></textarea>
				<?php
				break;
				case 'checkbox':
				?>
					<input type="checkbox" name="wp30skybar_fields[<?php echo $name;?>]" id="wp30skybar_fields_<?php echo $name;?>" value="1" <?php checked( $opt_val, '1', true ); ?> />
				<?php
				break;
				case 'info':
				?>
					<small class="wp30skybar-option-info">
						<?php echo $default; ?>
					</small>
				<?php
				break;
			}
			?>
			</div>
		</div>
		<?php
	}

	/**
	 * Save the Data
	 *
	 * @since    1.0
	 */
	public function save_custom_meta( $post_id ) {
		// Check if our nonce is set.
		if ( ! isset( $_POST['wp30skybar_meta_box_nonce'] ) ) {
			return;
		}
		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST['wp30skybar_meta_box_nonce'], 'wp30skybar_meta_box' ) ) {
			return;
		}
		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 'wp30_sky_bar' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}

		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}

		/* OK, it's safe for us to save the data now. */
		if ( ! isset( $_POST['wp30skybar_fields'] ) ) {
			return;
		}

		$my_data = $_POST['wp30skybar_fields'];

		// Update the meta field in the database.
		update_post_meta( $post_id, '_wp30skybar_data', $my_data );
	}

	/**
	 * Deactivate plugin if pro is active
	 *
	 * @since    1.0
	 */
	public function check_version() {

		if ( defined( 'WP30_SKY_BAR_PLUGIN_BASE' ) ) {

			if ( is_plugin_active( WP30_SKY_BAR_PLUGIN_BASE ) || class_exists('WP30_Sky_Bar') ) {

				deactivate_plugins( WP30_SKY_BAR_PLUGIN_BASE );
				add_action( 'admin_notices', array( $this, 'disabled_notice' ) );
				if ( isset( $_GET['activate'] ) ) {
					unset( $_GET['activate'] );
				}
			}
		}
	}

	/**
	 * Deactivation notice
	 *
	 * @since    1.0
	 */
	public function disabled_notice() {
		?>
		<div class="updated">
			<p><?php _e( 'Free version of WP Sky Bars plugin disabled. Pro version is active!', $this->wp30_sky_bar ); ?></p>
		</div>
	<?php
	}

	/**
	 * Sky Bar update messages
	 *
	 * @since    1.0
	 *
	 * @param array   $messages
	 * @return array   $messages
	 */
	public function wp30skybar_update_messages( $messages ) {

		global $post;

		$post_ID = $post->ID;
		$post_type = get_post_type( $post_ID );

		if ('wp30_sky_bar' == $post_type ) {

			$messages['wp30_sky_bar'] = array(
				0 => '', // Unused. Messages start at index 1.
				1 => __( 'Sky Bar updated.', $this->wp30_sky_bar ),
				2 => __( 'Custom field updated.', $this->wp30_sky_bar ),
				3 => __( 'Custom field deleted.', $this->wp30_sky_bar ),
				4 => __( 'Sky Bar updated.', $this->wp30_sky_bar ),
				5 => isset($_GET['revision']) ? sprintf( __('Sky Bar restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
				6 => __( 'Sky Bar published.', $this->wp30_sky_bar ),
				7 => __( 'Sky Bar saved.', $this->wp30_sky_bar ),
				8 => __( 'Sky Bar submitted.', $this->wp30_sky_bar),
				9 => sprintf( __('Sky Bar  scheduled for: <strong>%1$s</strong>.', $this->wp30_sky_bar ), date_i18n( __( 'M j, Y @ H:i' ), strtotime( $post->post_date ) ) ),
				10 => __('Sky Bar draft updated.', $this->wp30_sky_bar ),
			);
		}

		return $messages;
	}


	/**
	 * Single post view bar select
	 *
	 * @since    1.0.1
	 */
	public function wp30skybar_select_metabox_insert() {
		
		$force_bar_post_types = $this->force_bar_post_types;

		if ( $force_bar_post_types && is_array( $force_bar_post_types ) ) {

			foreach ( $force_bar_post_types as $screen ) {

				add_meta_box(
					'wp30skybar_single_bar_metabox',
					__( 'Sky Bar', $this->wp30_sky_bar ),
					array( $this, 'wp30skybar_select_metabox_content' ),
					$screen,
					'side',
					'default'
				);
			}
		}
	}
	public function wp30skybar_select_metabox_content( $post ) {

		// Add an nonce field so we can check for it later.
		wp_nonce_field('wp30skybar_select_metabox_save', 'wp30skybar_select_metabox_nonce');

		/*
		* Use get_post_meta() to retrieve an existing value
		* from the database and use the value for the form.
		*/
		$bar = get_post_meta( $post->ID, '_wp30skybar_override_bar', true );

		$processed_item_ids = '';
		if ( !empty( $bar ) ) {
			// Some entries may be arrays themselves!
			$processed_item_ids = array();
			foreach ($bar as $this_id) {
				if (is_array($this_id)) {
					$processed_item_ids = array_merge( $processed_item_ids, $this_id );
				} else {
					$processed_item_ids[] = $this_id;
				}
			}

			if (is_array($processed_item_ids) && !empty($processed_item_ids)) {
				$processed_item_ids = implode(',', $processed_item_ids);
			} else {
				$processed_item_ids = '';
			}
		}
		?>
		<p>
			<label for="wp30skybar_override_bar_field"><?php _e( 'Select Sky Bar (optional):', $this->wp30_sky_bar ); ?></label><br />
			<input style="width: 400px;" type="hidden" id="wp30skybar_override_bar_field" name="wp30skybar_override_bar_field" class="wp30skybar-bar-select"  value="<?php echo $processed_item_ids; ?>" />
		</p>
		<p>
			<i><?php _e( 'Selected sky bar will override any other bar.', $this->wp30_sky_bar ); ?></i>
		</p>
		<?php
	}

	public function wp30skybar_select_metabox_save( $post_id ) {

		// Check if our nonce is set.
		if ( ! isset( $_POST['wp30skybar_select_metabox_nonce'] ) ) {
			return;
		}
		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST['wp30skybar_select_metabox_nonce'], 'wp30skybar_select_metabox_save' ) ) {
			return;
		}
		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check the user's permissions.
		if ( 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return;

		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return;
		}

		/* OK, its safe for us to save the data now. */
		if ( ! isset( $_POST['wp30skybar_override_bar_field'] ) ) {
			return;
		}

		$val = $_POST['wp30skybar_override_bar_field'];

		if (strpos($val, ',') === false) {
			// No comma, must be single value - still needs to be in an array for now
			$post_ids = array( $val );
		} else {
			// There is a comma so it's explodable
			$post_ids = explode(',', $val);
		}

		// Update the meta field in the database.
		update_post_meta( $post_id, '_wp30skybar_override_bar', $post_ids );
	}

	/**
	 * Bar select ajax function
	 *
	 * @since    1.0.1
	 */
	public function wp30skybar_get_bars() {

		$result = array();

		$search = $_REQUEST['q'];

		$ads_query = array(
			'posts_per_page' => -1,
			'post_status' => array('publish'),
			'post_type' => 'wp30_sky_bar',
			'order' => 'ASC',
			'orderby' => 'title',
			'suppress_filters' => false,
			's'=> $search
		);
		$posts = get_posts( $ads_query );

		// We'll return a JSON-encoded result.
		foreach ( $posts as $this_post ) {
			$post_title = $this_post->post_title;
			$id = $this_post->ID;

			$result[] = array(
				'id' => $id,
				'title' => $post_title,
			);
		}

	    echo json_encode( $result );

	    die();
	}

	public function wp30skybar_get_bar_titles() {
		$result = array();

		if (isset($_REQUEST['post_ids'])) {
			$post_ids = $_REQUEST['post_ids'];
			if (strpos($post_ids, ',') === false) {
				// There is no comma, so we can't explode, but we still want an array
				$post_ids = array( $post_ids );
			} else {
				// There is a comma, so it must be explodable
				$post_ids = explode(',', $post_ids);
			}
		} else {
			$post_ids = array();
		}

		if (is_array($post_ids) && ! empty($post_ids)) {

			$posts = get_posts(array(
				'posts_per_page' => -1,
				'post_status' => array('publish'),
				'post__in' => $post_ids,
				'post_type' => 'wp30_sky_bar'
			));
			foreach ( $posts as $this_post ) {
				$result[] = array(
					'id' => $this_post->ID,
					'title' => $this_post->post_title,
				);
			}
		}

		echo json_encode( $result );

		die();
	}


}