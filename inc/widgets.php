<?php
/**
 * Custom widgets that work only for the Future Imperfect theme
 *
 * @package Future_Imperfect
 */

// register future_imperfect widgets
function register_future_imperfect_widgets() {
    register_widget( 'Future_Imperfect_Title_Widget' );
    register_widget( 'Future_Imperfect_Large_Post_List_Widget' );
    register_widget( 'Future_Imperfect_Small_Post_List_Widget' );
    register_widget( 'Future_Imperfect_Title_List_Widget' );
}
add_action( 'widgets_init', 'register_future_imperfect_widgets' );

/**
 * Adds Future_Imperfect_Title_Widget widget.
 */
class Future_Imperfect_Title_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'future_imperfect_title_widget', // Base ID
			__( 'Future Imperfect Title Widget', 'future-imperfect' ), // Name
			array( 'description' => __( 'Intended to be in the top of the left sidebar.', 'future-imperfect' ), ) // Args
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
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		echo __( 'Hello, World!', 'future-imperfect' );
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'New title', 'future-imperfect' );
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php 
	}

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
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

} // class Future_Imperfect_Title_Widget


/**
 * Adds Future_Imperfect_Large_Post_List_Widget widget.
 */
class Future_Imperfect_Large_Post_List_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'future_imperfect_large_post_list_widget', // Base ID
			__( 'Future Imperfect Large Post List', 'future-imperfect' ), // Name
			array( 'description' => __( 'Lists posts with a large icon', 'future-imperfect' ), ) // Args
		);
	}

	/**
	 * Go get the data
	 *
	 * @param array $args     Query arguments.
	 */
	function get_data( $instance = '' ) {

		$output = '';

		$args = array(
			'posts_per_page' => 5,
		);

		if ( isset( $instance['cat'] ) && '' != $instance['cat'] ) {
			$args['cat'] = $instance['cat'];
		}

		if ( isset( $instance['posts_per_page'] ) && '' != $instance['posts_per_page'] ) {
			$args['posts_per_page']         = $instance['posts_per_page'];
			$args['posts_per_archive_page'] = $instance['posts_per_page'];
			$args['ignore_sticky_posts']    = true;
			$args['no_found_rows']          = true;
		}

		// The Query
		$the_query = new WP_Query( $args );

		$output .= '<section>' . "\n";
		$output .= '<div class="mini-posts">' . "\n";


		// The Loop
		if ( $the_query->have_posts() ) {

			while ( $the_query->have_posts() ) {
				$the_query->the_post();

				$output .= '<article class="mini-post">' . "\n";
					$output .= '<header>' . "\n";
						$output .= '<h3><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>' . "\n";
						$output .= '<time class="published" datetime="' . esc_attr( get_the_date( 'Y-m-d') ) . '">' . esc_attr( get_the_date( 'F j, Y') ) . '</time>' . "\n";
						$output .= '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" class="author">' . get_avatar( get_the_author_meta( 'ID' ), 36 ) . '</a>' . "\n";
					$output .= '</header>' . "\n";

				$output .= '</article>' . "\n";

			}

		} else {
			// no posts found
		}

		$output .= '</div>' . "\n";
		$output .= '</section>' . "\n";


		/* Restore original Post Data */
		wp_reset_postdata();

		return $output;

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
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}

		// list posts
		echo $this->get_data( $instance );

		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'cat' ); ?>"><?php _e( 'Category:' ); ?></label> 
		<?php
			$cat_args['name']             = $this->get_field_name( 'cat' );
			$cat_args['selected']         = esc_html( $instance['cat'] );
			$cat_args['show_option_none'] = 'No Category';

			wp_dropdown_categories( $cat_args );
		?>
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label> 
		<select id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>">

		<?php
			// make options 1-20
			$count = 1;
			$max = 20;
			while ( $count <= $max ) {
				if ( $count == $instance['posts_per_page'] ) {
					$selected = ' selected="selected"';
				} else {
					$selected = '';
				}
				echo '<option value="' . $count . '"' . $selected . '>' . $count . '</option>' . "\n";
				$count++;
			}
		?>

		</select>

		<?php

	}

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
		$instance['title']          = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['cat']            = ( ! empty( $new_instance['cat'] ) ) ? strip_tags( $new_instance['cat'] ) : '';
		$instance['posts_per_page'] = ( ! empty( $new_instance['posts_per_page'] ) ) ? absint( $new_instance['posts_per_page'] ) : '';

		return $instance;
	}

} // class Future_Imperfect_Large_Post_List_Widget



/**
 * Adds Future_Imperfect_Small_Post_List_Widget widget.
 */
class Future_Imperfect_Small_Post_List_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'future_imperfect_small_post_list_widget', // Base ID
			__( 'Future Imperfect Small Post List', 'future-imperfect' ), // Name
			array( 'description' => __( 'Lists posts with a small icon', 'future-imperfect' ), ) // Args
		);
	}

	/**
	 * Go get the data
	 *
	 * @param array $args     Query arguments.
	 */
	function get_data( $instance = '' ) {

		$output = '';

		$args = array(
			'posts_per_page' => 5,
		);

		if ( isset( $instance['cat'] ) && '' != $instance['cat'] && '-1' != $instance['cat'] ) {
			$args['cat'] = $instance['cat'];
		}

		if ( isset( $instance['posts_per_page'] ) && '' != $instance['posts_per_page'] ) {
			$args['posts_per_page']         = $instance['posts_per_page'];
			$args['posts_per_archive_page'] = $instance['posts_per_page'];
			$args['ignore_sticky_posts']    = true;
			$args['no_found_rows']          = true;
		}

		// The Query
		$the_query = new WP_Query( $args );

		$output .= '<section>' . "\n";
		$output .= '<ul class="posts">' . "\n";


		// The Loop
		if ( $the_query->have_posts() ) {

			while ( $the_query->have_posts() ) {
				$the_query->the_post();

				$output .= '<li>' . "\n";
				$output .= '<article>' . "\n";
					$output .= '<header>' . "\n";
						$output .= '<h3><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>' . "\n";
						$output .= '<time class="published" datetime="' . esc_attr( get_the_date( 'Y-m-d') ) . '">' . esc_attr( get_the_date( 'F j, Y') ) . '</time>' . "\n";
					$output .= '</header>' . "\n";

					if ( has_post_thumbnail() ) {
						$output .= '<a href="' . esc_url( get_permalink() ) . '" class="image">';
						$output .= get_the_post_thumbnail( $post->ID, array( 51, 51 ) ); 
						$output .= '</a>';
					}

				$output .= '</article>' . "\n";
				$output .= '</li>' . "\n";

			}

		} else {
			// no posts found
		}


		$output .= '</ul>' . "\n";
		$output .= '</section>' . "\n";


		/* Restore original Post Data */
		wp_reset_postdata();

		return $output;

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
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}

		// list posts
		echo $this->get_data( $instance );

		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_html( $instance['title'] ); ?>">
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'cat' ); ?>"><?php _e( 'Category:' ); ?></label> 
		<?php
			$cat_args['name']             = $this->get_field_name( 'cat' );
			$cat_args['selected']         = esc_html( $instance['cat'] );
			$cat_args['show_option_none'] = 'No Category';

			wp_dropdown_categories( $cat_args );
		?>
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label> 
		<select id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>">

		<?php
			// make options 1-20
			$count = 1;
			$max = 20;
			while ( $count <= $max ) {
				if ( $count == $instance['posts_per_page'] ) {
					$selected = ' selected="selected"';
				} else {
					$selected = '';
				}
				echo '<option value="' . $count . '"' . $selected . '>' . $count . '</option>' . "\n";
				$count++;
			}
		?>

		</select>

		<?php

	}

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
		$instance['title']          = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['cat']            = ( ! empty( $new_instance['cat'] ) ) ? strip_tags( $new_instance['cat'] ) : '';
		$instance['posts_per_page'] = ( ! empty( $new_instance['posts_per_page'] ) ) ? absint( $new_instance['posts_per_page'] ) : '';

		return $instance;
	}

} // class Future_Imperfect_Snall_Post_List_Widget


/**
 * Adds Future_Imperfect_Title_List_Widget widget.
 */
class Future_Imperfect_Title_List_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'future_imperfect_title_list_widget', // Base ID
			__( 'Future Imperfect Title List', 'future-imperfect' ), // Name
			array( 'description' => __( 'Lists posts with optional subtitles', 'future-imperfect' ), ) // Args
		);
	}

	/**
	 * Go get the data
	 *
	 * @param array $args     Query arguments.
	 */
	function get_data( $instance = '' ) {

		$output = '';

		$args = array(
			'posts_per_page' => 5,
		);

		if ( isset( $instance['cat'] ) && '' != $instance['cat'] && '-1' != $instance['cat'] ) {
			$args['cat'] = $instance['cat'];
		}

		if ( isset( $instance['posts_per_page'] ) && '' != $instance['posts_per_page'] ) {
			$args['posts_per_page']         = $instance['posts_per_page'];
			$args['posts_per_archive_page'] = $instance['posts_per_page'];
			$args['ignore_sticky_posts']    = true;
			$args['no_found_rows']          = true;
		}

		// The Query
		$the_query = new WP_Query( $args );

		$output .= '<ul class="links">' . "\n";

		// The Loop
		if ( $the_query->have_posts() ) {

			while ( $the_query->have_posts() ) {
				$the_query->the_post();

				$output .= '<li>' . "\n";
					$output .= '<a href="' . get_permalink() . '">' . "\n";
						$output .= '<h3>' . get_the_title() . '</h3>' . "\n";

						// check to see if we have subtitles
						if ( function_exists( 'get_the_subtitle' ) && '' != get_the_subtitle( get_the_ID(), '', '', false ) ) {
							$output .= '<p>' . get_the_subtitle( get_the_ID(), '', '', false ) . '</p>' . "\n";
						}

					$output .= '</a>' . "\n";
				$output .= '</li>' . "\n";

			}

		} else {
			// no posts found
		}


		$output .= '</ul>' . "\n";


		/* Restore original Post Data */
		wp_reset_postdata();

		return $output;

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
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}

		// list posts
		echo $this->get_data( $instance );

		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_html( $instance['title'] ); ?>">
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'cat' ); ?>"><?php _e( 'Category:' ); ?></label> 
		<?php
			$cat_args['name']             = $this->get_field_name( 'cat' );
			$cat_args['selected']         = esc_html( $instance['cat'] );
			$cat_args['show_option_none'] = 'No Category';

			wp_dropdown_categories( $cat_args );
		?>
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label> 
		<select id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>">

		<?php
			// make options 1-20
			$count = 1;
			$max = 20;
			while ( $count <= $max ) {
				if ( $count == $instance['posts_per_page'] ) {
					$selected = ' selected="selected"';
				} else {
					$selected = '';
				}
				echo '<option value="' . $count . '"' . $selected . '>' . $count . '</option>' . "\n";
				$count++;
			}
		?>

		</select>

		<?php

	}

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
		$instance['title']          = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['cat']            = ( ! empty( $new_instance['cat'] ) ) ? strip_tags( $new_instance['cat'] ) : '';
		$instance['posts_per_page'] = ( ! empty( $new_instance['posts_per_page'] ) ) ? absint( $new_instance['posts_per_page'] ) : '';

		return $instance;
	}

} // class Future_Imperfect_Title_List_Widget

