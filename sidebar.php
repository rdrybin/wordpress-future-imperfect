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
<section id="sidebar">

   <!-- Intro -->
	<section id="intro">
		<a href="#" class="logo"><img src="/wp-content/themes/future-imperfect/images/logo.jpg" alt="" /></a>
		<header>
			<h2>Future Imperfect</h2>
			<p>Another fine responsive site template by <a href="http://html5up.net">HTML5 UP</a></p>
		</header>
	</section>

	<?php
		if ( is_active_sidebar( 'sidebar-1' ) ) {
			echo '<ul>' . "\n";
			dynamic_sidebar( 'sidebar-1' );
			echo '</ul>' . "\n";
		}
	?>

</section>
