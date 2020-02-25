<?php if (have_posts() || apply_filters('taxonomies_search', get_search_query())): while (have_posts()) : the_post(); ?>

<?php $product = SIM_Product::getById(get_the_ID()); ?>

	<div class="product-block no-padding <?php echo
	(isset($_GET['view']) && $_GET['view'] != '') ? ($_GET['view'] != 'list') ? 'grid' : 'list' : 'list';   ?>">
		<div class="product">
			<div class="product-image-block">
				<div class="block image">
					<img src="<?php echo apply_filters('post_image_url', $product->id, 'product_square_small'); ?>" class="img-responsive center-block" alt="<?php echo $product->post->post_title; ?>" width="290" height="200">
					<?php if($product->get_manufacturer_logo()): ?>
						<img src="<?php echo $product->get_manufacturer_logo() ?>" class="img-responsive center-block" alt="<?php echo $product->post->post_title; ?>" width="290" height="200">
					<?php endif; ?>
				</div>
			</div>
			<div class="product-info-block">
				<div class="main-info-block">
					<div class="block title">
						<a href="<?php echo get_permalink($product->id); ?>">
							<div class="text-left center-block"><?php echo $product->post->post_title; ?></div>
						</a>
					</div>
					<?php if($product->product_dimension || $product->product_weight): ?>
						<?php $params = SIM_Product::get_parameters(); ?>
						<div class="block parameters">
							<div class="col-xs-24 no-padding">
								<div>
									<?php echo $params['blocks']['fields']['product_dimension']; ?> : <span><?php echo $product->product_dimension; ?></span>
								</div>
							</div>
							<!--                                                        <div class="col-xs-12 no-padding">-->
							<!--                                                            <div>-->
							<!--                                                                --><?php //echo $params['blocks']['fields']['product_weight']; ?>
							<!--                                                            </div>-->
							<!--                                                            --><?php //echo $product->product_weight; ?>
							<!--                                                        </div>-->
							<div class="clearfix"></div>
						</div>
					<?php endif; ?>
				</div>
				<div class="price-block">
					<?php if($product->product_price): ?>
						<div class="block price no-border">
							<?php echo SIM_Helper::format_price($product->product_price); ?>/<?php echo __('unit', 'nowotheme'); ?>.<span></span>
						</div>
					<?php endif; ?>
					<div class="block action no-border">
						<a class="btn btn-exclusive" href="<?php echo get_permalink($product->id); ?>">
							<?php echo __('View', 'nowotheme'); ?>
						</a>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>


<?php endwhile; ?>

<?php else: ?>

	<!-- article -->
	<article>
		<h2><?php _e( 'Sorry, nothing to display.', 'scandagra' ); ?></h2>
	</article>
	<!-- /article -->

<?php endif; ?>
