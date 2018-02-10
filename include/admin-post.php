<?php defined( 'ABSPATH' ) or exit;

	function estis_sf_wp_remote_get( $url, $key ) {
			$response = wp_remote_get($url,
				array(
					'timeout' => 3,
					'httpversion' => '1.1',
					'sslverify' => true,
					'headers' => array('X-Estis-Auth' => $key))
			);

			if (wp_remote_retrieve_response_code($response) !== 200) {
				update_option(ESTIS_SF_PREFIX . 'op_array_error', $response['body']);
				return false;
			} else {
				return json_decode($response['body'], true);
			}
		};

	function estis_sf_redirect_update( $option, $data ) {

		update_option( $option, $data );
		wp_redirect( $_SERVER['HTTP_REFERER'] );
		exit;
	}

	function estis_sf_redirect() {

		delete_option( 'estismail_forms_error_notice' );

		if ( isset( $_POST['estis_sf_api_key'] ) && ! empty( $_POST['estis_sf_api_key'] ) ) {
			$api_key = $_POST['estis_sf_api_key'];
		} else {
			$api_key = '';
		}

		estis_sf_redirect_update( 'estis_sf_api_key', trim($api_key) );
 }