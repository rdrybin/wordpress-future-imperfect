<!-- Post -->
<article class="post">
	<header>
		<div class="title">
			<h2><a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( get_the_title() ); ?></a></h2>
			<?php
			// check to see if we have subtitles
			if ( function_exists( 'get_the_subtitle' ) ) {
				echo '<p>' . esc_html( get_the_subtitle( get_the_ID(), '', '', false ) ) . '</p>' . "\n";
			}
			?>

		</div>
		<div class="meta">
			<time class="published" datetime="<?php echo esc_attr( get_the_time( 'Y-m-d' ) ); ?>"><?php echo esc_attr( get_the_time( 'F j, Y' ) ); ?></time>
			<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="author"><span class="name"><?php echo esc_html( get_the_author() ); ?></span><?php echo get_avatar( get_the_author_meta( 'ID' ), 36 ); ?></a>
		</div>
	</header>
	
	<?php
	if ( has_post_thumbnail() ) {
		// get the image dimensions
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'future-imperfect-large' );

		// if the image is wider than tall then print it
		if ( $image[1] > $image[2] ) {
			echo '<a href="' . esc_url( get_permalink() ) . '" class="image featured">';
			the_post_thumbnail( 'future-imperfect-large' );
			echo '</a>';
		}
	}
	?>

	<?php the_excerpt(); ?>

	<footer>
		<ul class="actions">
			<li><a href="<?php esc_url( the_permalink() ); ?>" class="button big"><?php _e( 'Continue Reading', 'future-imperfect' ); ?></a></li>
		</ul>
		<ul class="stats">
			<li class="categories"><?php echo wp_kses_post( get_the_category_list( ',' ) ); ?></li>
			<?php // <li><a href="#" class="icon fa-heart">28</a></li> ?>
			<li><a href="<?php comments_link(); ?>" class="icon fa-comment"><?php comments_number( '0', '1', '%' ); ?></a></li>
		</ul>
	</footer>
</article>
