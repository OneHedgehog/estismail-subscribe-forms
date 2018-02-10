<?php
	function estis_sf_notice_delete() {
		delete_option( 'estis_sf_op_array_error' );
		wp_redirect( $_SERVER['HTTP_REFERER'] );
		exit;
	}