<?php

get_header(); ?>


<?php

	$per_page = !isset($_GET['per_page']) ? get_option('posts_per_page') : $_GET['per_page'];

	$args = array(
		'post_type' => SIM_SpecialOffer::$post_type,
		'posts_per_page' => $per_page,
		'offset' => isset($wp_query->query_vars['paged']) && $wp_query->query_vars['paged'] > 0 ? $wp_query->query_vars['paged'] * $per_page - $per_page : 0,
	);

	$loop = new WP_Query($args);

?>


<section>

	<div class="container">

		<h2 class="title section-header">
			<span><?php echo get_the_title(); ?></span>
		</h2>


		<div class="content-container news-container">
			<div class="row">

				<?php if($loop): ?>


					<?php if($loop->have_posts()): ?>

						<?php while($loop->have_posts()): ?>

							<?php $loop->the_post(); ?>

							<?php $article = SIM_News::getById(get_the_ID()) ?>

							<div class="col-xs-12 col-sm-6 col-md-4">
								<article>
									<img class="img-responsive" src="<?php echo apply_filters('post_image_url', $article->id, 'article_list_medium') ?>" alt="">

									<div class="content">

										<h4 class="title"><?php echo strtoupper($article->post->post_title); ?></h4>

										<?php echo apply_filters('the_content', strip_tags(SIM_Helper::truncateHtml($article->post->post_content, 150))); ?>
									</div>

									<a href="<?php echo get_permalink($article->id); ?>" class="btn-exclusive extra">
										<?php echo __('Read more', 'nowothemr'); ?>
									</a>

								</article>
							</div>

						<?php endwhile; ?>

						<div class="clearfix"></div>
						<?php bootstrap_pagination($loop); ?>

					<?php endif; ?>

				<?php endif; ?>
			</div>
		</div>

	</div>


</section>


<?php
get_footer();
?>
