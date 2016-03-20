<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Future_Imperfect
 */

?>

<!-- Sidebar -->
<section id="menu">

	<?php
	if ( is_active_sidebar( 'right-sidebar' ) ) {
		dynamic_sidebar( 'right-sidebar' );
	}
	?>

</section>
