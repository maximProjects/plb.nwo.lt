<?php

get_header(); ?>


<?php

	$per_page = !isset($_GET['per_page']) ? get_option('posts_per_page') : $_GET['per_page'];

	$args = array(
		'post_type' => SIM_Video::$post_type,
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


		<div class="content-container video-container">
			<div class="row">

				<?php if($loop): ?>


					<?php if($loop->have_posts()): ?>

						<?php while($loop->have_posts()): ?>

							<?php $loop->the_post(); ?>

							<?php $article = SIM_News::getById(get_the_ID()) ?>

							<div class="col-xs-12 col-sm-6 col-md-4 video">
								<article>
<!--									<img class="img-responsive" src="--><?php //echo apply_filters('post_image_url', $article->id, 'article_list_medium') ?><!--" alt="">-->


									<?php $videos = $article->get_article_videos(1); ?>

									<?php if(!empty($videos)): ?>
										<div class="media-container" id="v-<?php echo $article->id; ?>">
											<?php echo apply_filters('youtube_video_display', reset($videos)->_article_video_url, '100%', ''); ?>
											<img src="https://img.youtube.com/vi/<?php echo apply_filters('youtube_video_display', reset($videos)->_article_video_url, '100%', '', true); ?>/hqdefault.jpg" class="img-responsive img-placeholder"  data-target="v-<?php echo $article->id; ?>" alt="">
										</div>
									<?php endif; ?>

									<time><?php echo date('Y-m-d', strtotime($article->post->post_date)); ?></time>
									<h4 class="title"><?php echo $article->post->post_title; ?></h4>

									<!--googleoff: index-->
									<div class="content excerpt show">
										<?php echo apply_filters('the_content', SIM_Helper::truncateHtml($article->post->post_content, 150)); ?>

										<hr>
										<a class="toggle" data-toggle="full">
											<span class="show">
												<?php echo __('Read more', 'nowotheme'); ?>
											</span>
										</a>
									</div>
									<!--googleon: index>-->

									<div class="content full">

										<div class="scrollable">

											<time><?php echo date('Y-m-d', strtotime($article->post->post_date)); ?></time>
											<h4 class="title"><?php echo $article->post->post_title; ?></h4>

											<?php echo apply_filters('the_content', $article->post->post_content); ?>
										</div>

										<hr>

										<a class="toggle" data-toggle="full">
											<span class="show">
												<?php echo __('Close', 'nowotheme'); ?>
											</span>
										</a>
									</div>

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
