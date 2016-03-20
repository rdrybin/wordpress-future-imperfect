<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Future_Imperfect
 */

get_header(); ?>

		<!-- Main -->
		<div id="main">

		<?php
		// see if we have any posts
		if ( have_posts() ) :
		?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'future-imperfect' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header><!-- .page-header -->

			<?php

			// if this is an author archive, print the author
			if ( is_author() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php _e( 'Author Archive' ); ?>: <?php echo get_the_author(); ?></h1>
				</header>

			<?php
			endif;

			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/archive-content', 'single' );

			endwhile;

			// check to see if we have a previous link
			if ( ! get_previous_posts_link() ) :
				$prev_disable = 'disabled ';
				else :
				$prev_disable = '';
			endif;

			// check to see if we have a next link
			if ( ! get_next_posts_link() ) :
				$next_disable = 'disabled ';
				else :
				$next_disable = '';
			endif;

			// make pagination
			echo '<ul class="actions pagination">' . "\n";
				echo '<li><a href="' . get_previous_posts_page_link() . '" class="' . $prev_disable . 'button big previous">Previous Page</a></li>' . "\n";
				echo '<li><a href="' . get_next_posts_page_link() . '" class="' , $next_disable . 'button big next">Next Page</a></li>' . "\n";
			echo '</ul>' . "\n";

		endif; ?>

		</div>

		<?php get_sidebar(); ?>

<?php
get_footer();
