<?php if (have_posts() || apply_filters('taxonomies_search', get_search_query())): while (have_posts()) : the_post(); ?>

	<div class="row" id="post-<?php the_ID(); ?>">
		<article class="collapsed">
			<div class="col-sm-12">
				<h3 class="heading"><a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title; ?></a></h3>
				<?php echo apply_filters( 'the_content', $post->post_content ); ?>
			</div>
			<div class="clearfix"></div>
		</article>
	</div>
	<hr>

<?php endwhile; ?>

<?php else: ?>

	<!-- article -->
	<article>
		<h2><?php _e( 'Sorry, nothing to display.', 'scandagra' ); ?></h2>
	</article>
	<!-- /article -->

<?php endif; ?>
