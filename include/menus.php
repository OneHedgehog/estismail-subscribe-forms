<?php

	defined( 'ABSPATH' ) or exit;

	function estis_sf_admin_menu() {

		$plug = ( get_plugin_data( ESTIS_SF_ABS_PATH ) );

		$hook_suffix = add_options_page(
			$plug['Name'],
			$plug['Name'],
			'manage_options',
			'estis_sf_menu',
			'estis_sf_admin_menu_view' );

		add_action( "load-{$hook_suffix}", 'estis_sf_style_function' );
	}