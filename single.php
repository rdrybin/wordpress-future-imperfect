<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Future_Imperfect
 */

get_header(); ?>

	<!-- Main -->
	<div id="main">


		<?php
		while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content', 'single' );

			// pagination
			echo '<ul class="actions pagination">' . "\n";
			echo  wp_kses_post( get_previous_post_link( '<li>%link</li>', '%title' ) );
			echo  wp_kses_post( get_next_post_link( '<li>%link</li>', '%title' ) );
			echo '</ul>' . "\n";

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

		</div>

		<?php get_sidebar(); ?>

<?php
get_footer();

