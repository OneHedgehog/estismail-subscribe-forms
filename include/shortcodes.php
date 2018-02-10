<?php
	defined( 'ABSPATH' ) or exit;

	function estis_sf_add_shortcode( $atts ) {
		$form_id = $atts['id'] * 1;
		$post_id = get_the_ID();

		$db = get_option( ESTIS_SF_PREFIX . '_user_and_forms_array' );
		if ( empty( $db['forms'][ $form_id ] ) || $form_id == 0 ) {
			update_option( ESTIS_SF_PREFIX. '_op_array_error', $post_id );
			return '';
		} else {
			delete_option( ESTIS_SF_PREFIX . '_op_array_error' );
		}

		$form = $db['forms'][ $form_id ];

		return $form['body'];
	}

	function estis_sf_admin_notice_success() {

		$plug = get_plugin_data( ESTIS_SF_ABS_PATH );

		?>
		<style>
			#estimail_for_wp_notice {
				float: none;
				display: block;
				border-left: 4px solid #e35950;
			}

			#estimail_for_wp_notice .estis_sf_for_wp_alert {
				background: #f2dede;
				padding: 14px 7px;
				-webkit-border-radius: 12px;
				-moz-border-radius: 12px;
				border-radius: 5px;
				color: #a94442;
			}
		</style>

		<div class="update-nag is-dismissible" id="estimail_for_wp_notice">
			<form action="admin-post.php" method="POST">
				<input type="hidden" name="action" value="<?php echo(ESTIS_SF_PREFIX . '_notice') ?>"/>
				<b class="">
					<?php echo( $plug['Name'] ); ?>:
				</b>

				<?php _e( 'You used a non-existent shortcode in post', 'estis_sf_translate' ); ?>.
				<a href="<?php echo ( admin_url() . 'post.php?post=' . get_option( 'estis_sf_op_array_error' ) ) . "&action=edit"; ?>">
					<?php _e( 'Edit', 'estis_sf_translate' ) ?>
				</a>
				<input type="hidden" name="<?php echo(ESTIS_SF_PREFIX . '_plugin_notice_err')?>">
				<p>
					<button class="button">
						<?php _e( 'Ok', 'estis_sf_translate' ) ?>
					</button>
				</p>

			</form>
		</div>
		<?php
	}

?>