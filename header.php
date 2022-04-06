<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Future_Imperfect
 */

?><!DOCTYPE HTML>
<!--
	Future Imperfect by HTML5 UP
	html5up.net | @n33co
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html <?php language_attributes(); ?>>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Header -->
					<header id="header">
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>

						<?php
						$menu_array = array(
							'container'       => 'nav',
							'theme_location'  => 'primary',
							'container_class' => 'links',
							'fallback_cb'     => false,
						);
						wp_nav_menu( $menu_array );
						?>

						<nav class="main">
							<ul>
								<li class="search">
									<?php get_search_form(); ?>
								</li>
								<?php
								if ( is_active_sidebar( 'right-sidebar' ) ) {
								?>
									<li class="menu">
										<a class="fa-bars" href="#menu"><?php _e( 'Menu', 'future-imperfect' ); ?></a>
									</li>
								<?php
								}
								?>
								<li class="menu">
									<a class="fa-bars" href="#menu">Menu</a>
								</li>
							</ul>
						</nav>
					</header>

				<!-- Menu -->

				<section id="menu">

						<!-- Search -->
							<section>
									<?php get_search_form(); ?>
							</section>
						<!-- Links -->
						<section>
							<?php
							$menu_array = array(
								'container'       => '',
								'theme_location'  => 'primary',
								'container_class' => '',
								'menu_class' => 'links',
								'fallback_cb'     => false,
								'link_before'       => '<h3>', // текст перед текстом ссылки
								'link_after'        => '</h3>', // текст после текста ссылки
							);
							wp_nav_menu( $menu_array );
							?>
						</section>
					</section>

					<?php get_sidebar( 'right' ); ?>
