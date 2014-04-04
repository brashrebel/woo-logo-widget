<?php
/*
Plugin Name: Woo Logo Widget
Description: This plugin creates a widget that displays the custom logo from the Woo Theme options and links to the site home page.
Author: Kyle Maurer
Author URI: http://realbigmarketing.com/staff/kyle
Version: 1.0
License: GPL2
*/
class Woo_Logo_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'woo_logo_widget', // Base ID
			__('Woo Logo', 'text_domain'), // Name
			array( 'description' => __( 'This widget displays the logo as defined in the Woo theme options.', 'text_domain' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) { 
		$text = apply_filters( 'text', $instance['text'] );
		?>
	<?php echo $args['before_widget']; ?>
		<div id="logo">
				<?php $logo = get_option('woo_logo'); ?>

<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'description' ) ); ?>">
	<img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
</a>
<?php if ( ! empty( $text ) ) {
	echo $text;
} ?>
			</div><!-- /#logo -->
			<?php echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) { 
		//The widget text
		if ( isset( $instance[ 'text' ] ) ) {
			$text = $instance[ 'text' ];
		}
		else {
			$text = __( 'Enter text here...', 'text_domain' );
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Text:' ); ?></label> 
		<textarea class="widefat" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>" rows="6" columns="4">
			<?php echo esc_attr( $text ); ?>
		</textarea>
		</p>
		<?php }
	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['text'] = ( ! empty( $new_instance['text'] ) ) ? strip_tags( $new_instance['text'] ) : '';
		return $instance;
	}
} // class Woo_Logo_Widget
// register Woo_Logo_Widget widget
function register_woo_logo_widget() {
    register_widget( 'Woo_Logo_Widget' );
}
add_action( 'widgets_init', 'register_woo_logo_widget' );
?>