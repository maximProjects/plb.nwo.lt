<?php get_header(); ?>

<section class="breadcrumb-block">
	<h1 class="heading breadcrumb"><?php echo get_the_title(); ?></h1>
	<?php echo dimox_breadcrumbs(); ?>
	<div class="clearfix"></div>
</section>

<section class="page-content">

	<div class="">

		<div class="content">

			<?php if (have_posts()): while (have_posts()) : the_post(); ?>


				<h1 class="heading"><?php echo get_the_title(); ?></h1>

				<div class="col-tn-24">
					<?php echo apply_filters('the_content', get_the_content()); ?>
				</div>

				<hr class="separator">

				<?php $gallery = apply_filters('pim_gallery_images', get_the_ID(), false); ?>
				<?php if($gallery): ?>
					<div class="gallery-images">
						<?php foreach($gallery as $image): ?>
							<div class="col-tn-24 col-xs-12 col-sm-15 no-padding gallery-image inverse dark">
								<a href="<?php echo apply_filters('pim_image_url', $image->ID, 'full'); ?>" class="lightbox" data-rel="lightbox">
									<img data-original="<?php echo apply_filters('pim_image_url', $image->ID, 'article_list_medium'); ?>" class="img-responsive center-block lazy" width="290" height="200">
								</a>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
				<div class="clearfix"></div>


			<?php endwhile; ?>

			<?php else: ?>

				<h1><?php _e('Sorry, nothing to display.', 'html5blank'); ?></h1>

			<?php endif; ?>

		</div>

	</div>

</section>


<?php echo get_template_part('info-widgets'); ?>

<?php echo get_template_part('partners'); ?>

<?php get_footer(); ?>