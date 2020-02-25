<?php foreach( $events as $post ):

    //setup_postdata( $post );

    ?>
    <div class="news-vertical-box bg-white d-flex flex-row" data-id="<?= $post->ID ?>" data-date="<?= get_field('start_date') ?>">
        <?php
        $thmbUrl = get_the_post_thumbnail_url(get_the_ID(), 'event-thmb');


        $cats = get_the_category();
        $cat = $cats[0];

        //    $catThmb = get_field('thumb', $cat);
        //   $catThmbUrl = wp_get_attachment_url($catThmb);



        ?>
        <div class="thmb">
            <a href="<?php the_permalink(); ?>">
                <img src="<?= $thmbUrl ?>" />
            </a>
        </div>
        <div class="content flex-grow-1 text-left ">
            <a href="<?php the_permalink(); ?>" class="title"><?php the_title(); ?></a>
            <div class="date">
                                <span class="icon calendar">
                                    <?= file_get_contents(get_template_directory_uri()."/img/date_icon.svg") ?>
                                </span>
                <span class="txt">
                                    <?= get_the_date('Y-m-d') ?>
                                </span>
            </div>

            <?php
            $location = get_field('event_location');
            if($location) {
                ?>
                <div class="date">
                                                <span class="icon calendar">
                                                     <?= file_get_contents(get_template_directory_uri()."/img/address.svg") ?>
                                                </span>
                    <span class="txt">
                                                    <?= $location ?>
                                                </span>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="cls"></div>
    </div>

<?php endforeach; ?>
<?php wp_reset_postdata(); ?>