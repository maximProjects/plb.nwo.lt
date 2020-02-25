<section class="promo-container">
    <div class="container-fluid">
        <div class="row">
            <div class="container">

                <h2 class="title section-header">
                    <span><?php echo __('Benefits', 'nowotheme'); ?></span>
                </h2>

                <div class="row promo">

                    <?php for($i = 0; $i <= 3; $i++): ?>
                        <div class="col-sm-6 col-md-3 col-lg-3 block">
                            <div class="table-view icon-block">
                                <div class="cell-view">
                                    <div class="value">200</div>
                                    <h3 class="title">Lorem ipsum</h3>
                                </div>
                                <img class="cell-view" src="<?php echo get_template_directory_uri().'/img/icons/benefit_ico.png' ?>" alt="">
                            </div>
                            <div class="content">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            </div>
                        </div>
                    <?php endfor; ?>

                </div>
            </div>
        </div>
    </div>
</section>