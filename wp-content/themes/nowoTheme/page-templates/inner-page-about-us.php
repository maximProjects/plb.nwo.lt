<?php
/**
 * Template Name: Apie mus
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */


get_header(); ?>

<div class="background-book align-items-center">
</div>
<div class="container about-us header">
    <div class="row">
            <div class="col-lg-6 d-none d-lg-block d-md-block">
                <div class="content">
                    <h1 class="title"><?= the_title() ?>
                    <span class="line green"></span>
                    </h1>
                    <?php the_content(); ?>
                </div>
            </div>
        <div class="col-lg-6 d-none d-lg-block d-md-block">
            <?php
            $thmbUrl = get_the_post_thumbnail_url(get_the_ID(), 'full');
            ?>
            <img src="<?= $thmbUrl ?>">
        </div>

        <div class="col-lg-12 d-block d-lg-none d-md-none">
            <div class="content">
                <h1 class="title"><?= the_title() ?></h1>
                <?php
                $thmbUrl = get_the_post_thumbnail_url(get_the_ID(), 'about_mobile');
                ?>
                <img src="<?= $thmbUrl ?>">
                <div class="mobile-text">
                    <?php
                    $mtext = get_field('mobile_header');
                    ?>
                    <?= $mtext ?>
                </div>
            </div>
        </div>


    </div>
</div>


<div class="container-fluid overflow-hidden">
    <?php
    $blocks = get_field('text_blocks');
    ?>

    <div class="container about-us-blocks  d-block d-lg-block d-md-block">

        <?php
        foreach ($blocks as $key=>$block) {
            $class_width = "col-12 col-md-12 col-lg-12 without-image";
            if($block['image']) {
                $class_width = "col-12 col-md-6 col-lg-6";
            }

         ?>

    <?php
            if(($key % 2) == 0){
                //left
               ?>
                <div class="scroll-marker-box">
                    <div class="scroll-marker" id="<?= $block['id'] ?>"></div>
                </div>
                <div class="text-left">
                    <h2 class="title right">
                        <?= $block['title'] ?>
                    </h2>
                </div>

                <div class="row row-eq-height  align-self-center">
                    <div class="col <?= $class_width ?> align-self-center ">
                        <p>
                            <?= $block['content'] ?>
                        </p>
                    </div>

                    <?php
                    if($block['image']) {
                        ?>
                        <div class="col-12 col-md-12 col-lg-6  align-self-center">
                            <img src="<?= get_the_post_thumbnail_url(get_the_ID(), 'about_image'); ?>" />
                        </div>
                        <?php
                    }
                    ?>

                </div>
                <?php
            } else {
                ?>
                <div class="text-right">
                    <h2 class="title right" id="<?= $block['id'] ?>">
                        <?= $block['title'] ?>
                    </h2>
                </div>

                <div class="row row-eq-height  align-self-center">
                    <?php
                    if($block['image']) {
                        ?>
                        <div class="col-12 col-md-6 col-lg-6  align-self-center">
                            <img src="<?= get_the_post_thumbnail_url(get_the_ID(), 'about_image'); ?>" />
                        </div>
                        <?php
                    }
                    ?>
                    <div class="col <?= $class_width ?> align-self-center ">
                        <p>
                            <?= $block['content'] ?>
                        </p>
                    </div>



                </div>
                <?php
            }
            ?>


        <?php
        }
        ?>

</div>
</div>
<?php
get_footer();
?>
