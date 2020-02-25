<?php



get_header(); ?>

<?php global $wp_query; ?>

<?php

$per_page = !isset($_GET['per_page']) ? get_option('posts_per_page') : $_GET['per_page'];

$args = array(
	'post_type' => SIM_News::$post_type,
	'posts_per_page' => $per_page,
	'offset' => isset($wp_query->query_vars['paged']) && $wp_query->query_vars['paged'] > 0 ? $wp_query->query_vars['paged'] * $per_page - $per_page : 0,
);

$loop = new WP_Query($args);

?>

<?php if(isset($_GET['post_type']))
	$loop = $wp_query;
?>


<?php $args = array(
	'type'            => 'yearly',
	'limit'           => '',
	'format'          => 'custom',
	'before'          => '<li>',
	'after'           => '</li>',
	'show_post_count' => false,
	'echo'            => 0,
	'order'           => 'DESC',
	'post_type'     => SIM_News::$post_type
);


; ?>


<section>

	<div class="container">

		<h2 class="title section-header">
			<span><?php echo is_page() ? get_the_title() : get_post_type_object(SIM_News::$post_type)->label; ?></span>
		</h2>

		<?php $page_id = is_page() ? get_the_ID() : get_page_by_template('inner-page-news'); ?>

		<div class="archived-block page-content">
			<div class="content-block">
				<div class="content">
					<?php echo apply_filters('the_content', get_post($page_id)->post_content); ?>
				</div>
			</div>

			<hr class="narrow">

			<div class="select-block">
				<span class="title"><?php echo __('Archive', 'nowotheme'); ?></span>

				<ul class="nav js-select select" name="archive_year" id="archive_year">
					<li role="presentation" class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">

							<?php if(isset($wp_query->query['year'])): ?>
								<?php echo $wp_query->query['year']; ?> <span class="caret"></span>
							<?php else: ?>
								<?php echo __('All', 'nowotheme'); ?> <span class="caret"></span>
							<?php endif; ?>
						</a>
						<ul class="dropdown-menu">
							<?php if(isset($wp_query->query['year'])): ?>
								<li>
									<a href="<?php echo get_post_type_archive_link(SIM_News::$post_type) ?>"><?php echo __('All', 'nowotheme'); ?></a>
								</li>
							<?php endif; ?>
							<?php echo wp_get_archives( $args );?>
						</ul>
					</li>
				</ul>
			</div>
			<div class="clearfix"></div>
			<hr class="narrow">
			<br>
		</div>

		<div class="clearfix"></div>

		<div class="content-container news-container">
			<div class="row">

				<?php if($loop): ?>

					<?php if($loop->have_posts()): ?>

						<?php while($loop->have_posts()): ?>

							<?php $loop->the_post(); ?>

							<?php $article = SIM_News::getById(get_the_ID()); ?>

							<div class="col-tn-12 col-xs-6 col-sm-6 col-md-4">
								<div class="news-article">
									<img class="img-responsive" src="<?php echo apply_filters('post_image_url', $article->id, 'article_list_medium') ?>" alt="">

									<time><?php echo date('Y-m-d', strtotime($article->post->post_date)); ?></time>
									<h4 class="title"><?php echo $article->post->post_title; ?></h4>

									<div class="content">
										<?php echo apply_filters('the_content', SIM_Helper::truncateHtml($article->post->post_content, 100)); ?>
									</div>

									<a href="<?php echo get_permalink($article->id); ?>" class="btn btn-exclusive">
										<?php echo __('Read more', 'nowotheme'); ?>
									</a>

								</div>
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
