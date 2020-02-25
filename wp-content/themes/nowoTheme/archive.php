<?php get_header(); ?>

	<div class="row">
		<!-- section -->
		<div class="page-content">

			<?php echo dimox_breadcrumbs(); ?>
			<div class="clearfix"></div>

			<section class="content">

				<h1><?php debugvar(post_type_archive_title()); ?></h1>


				<?php get_template_part('loop'); ?>

				<?php get_template_part('pagination'); ?>

			</section>
		</div>
		<!-- /section -->
	</div>

<?php get_footer(); ?>
