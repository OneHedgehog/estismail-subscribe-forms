<?php

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

require_once( 'constant.php' );

delete_option(ESTIS_SF_PREFIX . '_for_wp_api_key');
delete_option(ESTIS_SF_PREFIX . '_user_and_forms_array');
delete_option(ESTIS_SF_PREFIX . '_op_array_error');