<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Future_Imperfect
 */

?>
		</div>
		<?php
	if ( is_active_sidebar( 'footer-sidebar' ) ) {
		echo '<ul>' . "\n";
		dynamic_sidebar( 'footer-sidebar' );
		echo '</ul>' . "\n";
	}
	?>

		<?php wp_footer(); ?>
		

	</body>
</html>
