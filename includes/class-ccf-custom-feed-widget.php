<?php
/**
 * The file that defines the custom feed widget class.
 *
 * A class definition that holds custom widget for display WordPress feeds.
 *
 * @link       https://github.com/priyankasoni97/
 * @since      1.0.0
 *
 * @package    CMS_Custom_Feed
 * @subpackage CMS_Custom_Feed/Includes
 * @since 1.0.0
 */

/**
 * The custom feed widget class
 *
 * A class definition that holds custom widget for display WordPress feeds.
 *
 * @since      1.0.0
 * @package    CMS_Custom_Feed
 * @author     Priyanka Soni <priyanka.soni@cmsminds.com>
 */
class CCF_Custom_Feed_Widget extends WP_Widget {
	/**
	 * Sets up a new custom feed widget instance.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$widget_ops = array(
			'description'                 => __( 'Entries from any RSS or Atom feed.' ),
			'customize_selective_refresh' => true,
			'show_instance_in_rest'       => true,

		);
		parent::__construct( 'custom_rss_feed', __( 'Custom RSS Feed' ), $widget_ops );

		add_action( 'widgets_init', array( $this, 'widgets_init_callback' ) );
	}

	/**
	 * Function for register custom widget.
	 */
	public function widgets_init_callback() {
		register_widget( 'CCF_Custom_Feed_Widget' );
	}

	/**
	 * Public variable which Holds widget argument.
	 *
	 * @var array $args Holds widget argument array.
	 */
	public $args = array(
		'before_title'  => '<h4 class="widgettitle">',
		'after_title'   => '</h4>',
		'before_widget' => '<div class="widget-wrap">',
		'after_widget'  => '</div></div>',
	);

	/**
	 * Outputs the content for the custom feed widget instance.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current RSS widget instance.
	 */
	public function widget( $args, $instance ) {
		$url      = $instance['url'];
		$feeds    = fetch_feed( $url );
		$maxitems = $instance['max_items'];

		// Checks that the object is created correctly.
		if ( ! is_wp_error( $feeds ) ) {

			// Figure out how many total items there are.
			$item_qty = $feeds->get_item_quantity( $maxitems );

			// Build an array of all the items, starting with element 0 (first element).
			$feed_items = $feeds->get_items( 0, $item_qty );

			// Check if feed item is not empty.
			echo '<ul>';
			if ( ! empty( $feed_items ) ) {
				foreach ( $feed_items as $feed ) {
					$desc = html_entity_decode( $feed->get_description(), ENT_QUOTES, get_option( 'blog_charset' ) );
					$desc = esc_attr( wp_trim_words( $desc, 40, '&hellip;' ) );
					?>
					<li class="feed_item">
						<a href ="<?php echo esc_url( $feed->get_permalink() ); ?>">
							<?php echo esc_html( $feed->get_title() ); ?>
						</a>
						<br>
						<?php echo esc_html( $desc ); ?>
					</li>
					<?php
				}
			}
			echo '</ul>';
		}

	}

	/**
	 * Outputs the settings form for the custom feed widget
	 *
	 * @since 1.0.0
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$url       = ! empty( $instance['url'] ) ? $instance['url'] : '';
		$max_items = ! empty( $instance['max_items'] ) ? $instance['max_items'] : '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>"><?php echo esc_html__( 'Enter a feed URL:', 'cms-custom-feeds' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'url' ) ); ?>" type="text" value="<?php echo esc_attr( $url ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'max_items' ) ); ?>"><?php echo esc_html__( 'Number of items to show:', 'cms-custom-feeds' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'max_items' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'max_items' ) ); ?>" type="number" value="<?php echo esc_attr( $max_items ); ?>">
		</p>
		<?php

	}

	/**
	 * Handles updating settings for the  custom feed widget instance.
	 *
	 * @since 1.0.0
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = array();

		$instance['url']       = ( ! empty( $new_instance['url'] ) ) ? $new_instance['url'] : '';
		$instance['max_items'] = ( ! empty( $new_instance['max_items'] ) ) ? $new_instance['max_items'] : '';

		return $instance;
	}
}
