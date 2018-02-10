<?php

	defined( 'ABSPATH' ) or exit;

	function estis_sf_style_function() {

		wp_register_style( 'boost_css', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css', array(), null );
		wp_register_style( 'custom_css', plugin_dir_url( dirname( __FILE__ ) ) . 'css/custom.css', array(), '1.0', 'all' );

		wp_enqueue_style( 'boost_css', false );
		wp_enqueue_style( 'custom_css' );

		wp_register_script( 'custom-script', plugin_dir_url( dirname( __FILE__ ) ) . 'js/common.js' );
		wp_enqueue_script( 'custom-script' );

	}