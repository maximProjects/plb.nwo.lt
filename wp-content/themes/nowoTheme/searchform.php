<!-- search -->
<form class="search navbar-top" method="get" action="<?php echo home_url(); ?>" role="search">
	<div class="input-group stylish-input-group">
		<input class="search-input form-control" type="search" autocomplete="off" name="s" placeholder="<?php _e( 'Type to search', 'html5blank' ); ?>" value="<?php echo get_search_query(); ?>">
                    <span class="input-group-addon">
                        <button type="submit">
							<i class="fa fa-search"></i>
						</button>
                    </span>
	</div>
</form>
<!-- /search -->
