<!-- Post -->
<article class="post">
	<header>
		<div class="title">
			<h2><a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_the_title()); ?></a></h2>

			<?php
			// check to see if we have subtitles
			if (function_exists('get_the_subtitle')) {
				echo '<p>' . get_the_subtitle(get_the_ID(), '', '', false) . '</p>' . "\n";
			}
			?>

		</div>
	</header>

	<?php
	if (has_post_thumbnail()) {
		echo '<a href="' . esc_url(get_permalink()) . '" class="image featured">';
		the_post_thumbnail('future-imperfect-large');
		echo '</a>';
	}
	?>

	<?php the_content(); ?>

	<footer>
		<ul class="actions">
			<li></li>
		</ul>
		<ul class="stats">
			<li><?php echo get_the_category_list(','); ?></li>
			<li><?php echo get_the_tag_list(' ', ', ', ' '); ?></li>
			<li><a href="<?php comments_link(); ?>" class="icon fa-comment"><?php comments_number('0', '1', '%'); ?></a></li>
		</ul>
	</footer>
</article>