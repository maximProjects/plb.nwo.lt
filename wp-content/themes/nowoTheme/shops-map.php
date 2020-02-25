<section id="shops-map" class="shops-map-container">
    <div class="section-header inverse">
        <h2 class="section-title text-uppercase">
            <!--            <img class="category-icon" src="--><?php //echo get_template_directory_uri() . '/img/icons/' ?><!--" alt="">-->
            <?php echo __('Where to buy', 'nowotheme'); ?></h2>
    </div>
    <div class="info-widgets bottom shops-map-block">
        <div class="row">
            <div class="map-filter">

                <div class="heading text-uppercase"><?php echo __('Select country', 'nowotheme') ?></div>

                <div class="select bordered">
                    <div class="country-list scrollable" style="height: 88px; overflow: hidden;">
                        <ul class="nav" name="map_country" id="map_countries"></ul>
                    </div>
                </div>

                <div class="heading text-uppercase"><?php echo __('Select city', 'nowotheme') ?></div>
                <div class="select bordered">
                    <div class="cities-list scrollable" style="height: 150px; overflow: hidden;">
                        <ul class="nav" name="map_city" id="map_cities"></ul>
                    </div>
                </div>
                <div class="current hidden inverse hidden-xs">
                    <h1 class="title"></h1>
                    <img src="" class="photo_file_url img-responsive" alt="">
                    <p class="owner_name"></p>
                </div>

                <div class="heading text-uppercase"><?php echo __('Search cities', 'nowotheme') ?></div>
                <div class="search">
                    <div class="input-group stylish-input-group">
                        <input class="ajax-search-input form-control" type="text" autocomplete="off" name="city_name" placeholder="<?php _e( 'Search', 'nowotheme' ); ?>">
                        <span class="input-group-addon">
                            <button type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <div id="shop-maps-container" class="widget shop-maps-container hidden-xs"></div>

        </div>
    </div>
    <div class="clearfix"></div>

    <div class="city-shops hidden">
        <hr class="separator blank">
        <table class="table table-node table-bordered">
            <thead>
            <tr>
                <th><?php echo __('Name', 'nowotheme'); ?></th>
                <th><?php echo __('Address', 'nowotheme'); ?></th>
                <th><?php echo __('Phone number', 'nowotheme'); ?></th>
                <th><?php echo __('Working hours', 'nowotheme'); ?></th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</section>
