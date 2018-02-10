<?php
	/*
	* Plugin Name: Estismail subscribe forms
	* Plugin URI: https://estismail.com/
	* Description: Displays your Estismail subscribe form
	* Author: Estismail
	* Version: 1.0
	* Author URI: https://estismail.com/
	* Text Domain: estis_sf_translate
	* Domain Path: /langs/
	*/

	require_once( 'constant.php' );

	if ( version_compare( get_bloginfo( 'version' ), '4', '<' ) ) {
		wp_die( __( 'please, update the WordPress to use our plugin', 'estis_sf_translate' ) );
	}

	function estis_sf_activation_plugin() {
		add_option( ESTIS_SF_PREFIX . '_for_wp_api_key' );
		add_option( ESTIS_SF_PREFIX . '_user_and_forms_array' );
	}

	function estis_sf_widget_init() {
		register_widget( ESTIS_SF_PREFIX . '_widget' );
	}

	register_activation_hook( __FILE__, ESTIS_SF_PREFIX . '_activation_plugin' );

	define( 'ESTIS_SF_ABS_PATH', plugin_dir_path( __FILE__ ) . "index.php" );

	require_once( 'include/shortcodes.php' );
	require_once( 'include/display-options.php' );
	require_once( 'include/menus.php' );
	require_once( 'include/admin-post.php' );
	require_once( 'include/style.php' );
	require_once( 'include/class-widget.php' );
	require_once( 'include/notice-delete.php' );

	add_action( 'admin_menu', ESTIS_SF_PREFIX . '_admin_menu' );
	add_action( 'widgets_init', ESTIS_SF_PREFIX . '_widget_init' );
	add_action( 'plugins_loaded', ESTIS_SF_PREFIX . '_true_load_wp_textdomain' );
	add_action( 'admin_post_' . ESTIS_SF_PREFIX . '_api_key', ESTIS_SF_PREFIX . '_redirect' );
	add_shortcode( 'estis', ESTIS_SF_PREFIX . '_add_shortcode' );
	add_action( 'admin_post_' . ESTIS_SF_PREFIX . '_notice', ESTIS_SF_PREFIX . '_notice_delete' );

	if ( get_option( ESTIS_SF_PREFIX . '_op_array_error' ) ) {
		add_action( 'admin_notices', ESTIS_SF_PREFIX . '_admin_notice_success' );
	}

	if ( isset( $_POST[ESTIS_SF_PREFIX . '_plugin_notice_err'] ) && ! empty( $_POST[ESTIS_SF_PREFIX . '_plugin_notice_err'] ) ) {
		delete_option( ESTIS_SF_PREFIX . '_op_array_error' );
	}

	function estis_sf_true_load_wp_textdomain() {
		load_plugin_textdomain( 'estis_sf_translate', false, dirname( plugin_basename( __FILE__ ) ) . '/langs/' );
	}