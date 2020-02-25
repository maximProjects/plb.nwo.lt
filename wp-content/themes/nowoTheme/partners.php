<?php
?>

<section>
    <div class="section-header inverse">
        <h2 class="section-title text-uppercase">
            <a href="<?php echo get_permalink(apply_filters('post_by_current_language', 224)); ?>">
                <?php echo __('Partners', 'nowotheme'); ?>
            </a>
        </h2>
    </div>
    <div class="partners partner-slider section-slider">
        <?php foreach(apply_filters('post_type_list', 'sim_partner') as $partner): ?>
            <?php $img_ulr = apply_filters('post_image_url', $partner->ID, 'large'); ?>
            <?php if($img_ulr): ?>
                <div class="slide">
                    <a href="<?php echo get_permalink(apply_filters('post_by_current_language', 224)); ?>" target="_blank">
                        <img src="<?php echo $img_ulr; ?>" alt="" class="grayscale">
                    </a>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</section>