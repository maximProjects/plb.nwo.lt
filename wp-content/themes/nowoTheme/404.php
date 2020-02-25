<?php get_header(); ?>


<section class="breadcrumb-block">
	<h1 class="heading breadcrumb"><?php echo 'Puslapis nerastas'; ?></h1>
	<?php echo dimox_breadcrumbs(); ?>
	<div class="clearfix"></div>
</section>

<section class="page-content">

	<div class="col-md-24 no-padding-right center-content">
		<div class="content">
			<h1><?php _e( 'Page not found', 'html5blank' ); ?></h1>
			<h2>
				<a href="<?php echo home_url(); ?>"><?php _e( 'Return home?', 'html5blank' ); ?></a>
			</h2>
		</div>
	</div>
</section>



<?php get_footer(); ?>
