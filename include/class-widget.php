<?php
	defined( 'ABSPATH' ) or exit;

	class Estis_SF_Widget extends WP_Widget {

		function __construct() {
			parent::__construct(
				'estismail_widget',
				__( 'Estismail subscribe form', 'estis_sf_translate' ),
				array(
					'description' => __( 'Displays your Estismail subscribe form', 'estis_sf_translate' ),
				)
			);
		}

		function widget( $args, $instance ) {

			$id = empty( $instance['id'] ) ? '' : apply_filters( 'estismail_widget_id', $instance['id'], $args, $instance );

			if ( ! empty( $id ) ) {
				echo do_shortcode( '[estis id=' . $id . ']' );
			}
		}

		public function form( $instance ) {

			$instance = wp_parse_args( (array) $instance, array( 'id' => '' ) );
			$forms_db = get_option( 'estis_sf_user_and_forms_array' );

			?>
			<p>
			<?php if ( isset( $forms_db['forms'] ) && ! empty( $forms_db['forms'] ) ): ?>
				<label for="<?php echo $this->get_field_id( 'id' ); ?>"><?php _e( 'Choose form', 'estis_sf_translate' ) ?>
					<select class="widefat" id="<?php echo $this->get_field_id( 'id' ); ?>" size="1"
							name="<?php echo $this->get_field_name( 'id' ); ?>">
						<?php foreach ( $forms_db['forms'] as $value ): ?>
							<option value="<?php echo $value['id']; ?>" <?php echo ( $value['id'] == $instance['id'] ) ? 'selected' : ''; ?>><?php echo $value['title']; ?></option>
						<?php endforeach; ?>
					</select>
				</label>
			<?php else: ?>
				<b><?php _e( 'No forms found', 'estis_sf_translate' ) ?></b>
			<?php endif; ?>
			</p>
			<?php
		}

		function update( $new_instance, $old_instance ) {
			$instance       = $old_instance;
			$instance['id'] = $new_instance['id'];
			return $instance;
		}
	}