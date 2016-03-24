<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Future_Imperfect
 */

get_header(); ?>

	<!-- Main -->
	<div id="main">

		<!-- Post -->
		<article class="post">
			<header>
				<div class="title">
					<h2><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'future-imperfect' ); ?></h2>
				</div>
			</header>
			
			<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'future-imperfect' ); ?></p>

			<?php
				get_search_form();

				the_widget( 'WP_Widget_Recent_Posts' );

				// Only show the widget if site has multiple categories.
				if ( future_imperfect_categorized_blog() ) :
			?>

			<div class="widget widget_categories">
				<h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'future-imperfect' ); ?></h2>
				<ul>
				<?php
					wp_list_categories( array(
						'orderby'	 => 'count',
						'order'		 => 'DESC',
						'show_count' => 1,
						'title_li'	 => '',
						'number'	 => 10,
					) );
				?>
				</ul>
			</div><!-- .widget -->

			<?php
				endif;

				/* translators: %1$s: smiley */
				$archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'future-imperfect' ), convert_smilies( ':)' ) ) . '</p>';
				the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );

				the_widget( 'WP_Widget_Tag_Cloud' );
			?>


			<footer>
			</footer>
		</article>

	</div>

	<?php get_sidebar(); ?>

<?php
get_footer();
