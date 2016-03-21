<?php
/**
 * Custom widgets that work only for the Future Imperfect theme
 *
 * @package Future_Imperfect
 */

class Future_Imperfect_WP_Nav_Menu_Widget extends WP_Nav_Menu_Widget {

	public function widget( $args, $instance ) {
		// Get menu
		$nav_menu = ! empty( $instance['nav_menu'] ) ? wp_get_nav_menu_object( $instance['nav_menu'] ) : false;

		if ( ! $nav_menu ) {
			return;
		}

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		echo wp_kses_post( $args['before_widget'] );

		if ( ! empty($instance['title']) ) {
			echo wp_kses_post( $args['before_title'] . $instance['title'] . $args['after_title'] );
		}

		$walker = new Future_Imperfect_Menu_With_Description;

		$nav_menu_args = array(
			'fallback_cb' => '',
			'menu'        => $nav_menu,
			'menu_class'  => 'links',
			'walker'      => $walker,
		);

		/**
		 * Filter the arguments for the Custom Menu widget.
		 *
		 * @since 4.2.0
		 * @since 4.4.0 Added the `$instance` parameter.
		 *
		 * @param array    $nav_menu_args {
		 *	   An array of arguments passed to wp_nav_menu() to retrieve a custom menu.
		 *
		 *	   @type callable|bool $fallback_cb Callback to fire if the menu doesn't exist. Default empty.
		 *	   @type mixed		   $menu		Menu ID, slug, or name.
		 * }
		 * @param stdClass $nav_menu	  Nav menu object for the current menu.
		 * @param array    $args		  Display arguments for the current widget.
		 * @param array    $instance	  Array of settings for the current widget.
		 */
		wp_nav_menu( apply_filters( 'widget_nav_menu_args', $nav_menu_args, $nav_menu, $args, $instance ) );

		echo wp_kses_post( $args['after_widget'] );
	}
}

class Future_Imperfect_Menu_With_Description extends Walker_Nav_Menu {
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';

		$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

		$attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) .'"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) .'"' : '';
		$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) .'"' : '';

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . '<h3>' . apply_filters( 'the_title', $item->title, $item->ID ) . '</h3>' . $args->link_after;
		$item_output .= '<p>' . $item->description . '</p>';
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}

