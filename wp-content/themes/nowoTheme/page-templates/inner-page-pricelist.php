<?php
/**
 * Template Name: Kainoraštis
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


<section>

    <div class="container">

        <h2 class="title section-header">
            <span><?php echo get_the_title(); ?></span>
        </h2>



        <div class="content-container pricelist-container">
            <div class="row">
                <div class="col-md-12 content">
                    <div class="collapsible">
                        <ul class="collapsibleList">
                            <?php foreach(SIM_Service::get_list() as $service): ?>


                                <?php if(!$service->service_hide_price): ?>

                                    <?php $content = get_field('price_list_html', $service->id); ?>

                                    <!--                                --><?php //$service_pricelist = $service->get_price_list(); ?>

                                    <li class="collapsibleList">
                                        <h4 class="title"><?php echo $service->post->post_title; ?></h4>
                                        <ul class="table-responsive table-pricelist">

                                            <?php echo apply_filters('the_content', $content); ?>

                                            <!--                                        <table class="table table-pricelist table-bordered">-->
                                            <!---->
                                            <!--                                            --><?php //if($service_pricelist): ?>
                                            <!---->
                                            <!--                                                <thead>-->
                                            <!--                                                <tr>-->
                                            <!--                                                    <th>--><?php //echo __('Service', 'nowotheme'); ?><!--</th>-->
                                            <!--                                                    <th>--><?php //echo __('Price for registered patients', 'nowotheme'); ?><!--, EUR</th>-->
                                            <!--                                                    <th>--><?php //echo __('Price for unregistered patients', 'nowotheme'); ?><!--, EUR</th>-->
                                            <!--                                                </tr>-->
                                            <!--                                                </thead>-->
                                            <!---->
                                            <!--                                                <tbody>-->
                                            <!---->
                                            <!--                                                --><?php //foreach($service_pricelist as $pricelist): ?>
                                            <!--                                                    <tr class="pricelist-header">-->
                                            <!--                                                        <td colspan="3">--><?php //echo $pricelist->name; ?><!--</td>-->
                                            <!--                                                    </tr>-->
                                            <!--                                                    --><?php //$service_pricelist = $service->get_price_list($pricelist->term_id); ?>
                                            <!---->
                                            <!--                                                    --><?php //foreach($service_pricelist as $pricelist): ?>
                                            <!--                                                        <tr>-->
                                            <!--                                                            <td>--><?php //echo $pricelist->name; ?><!--</td>-->
                                            <!--                                                            <td>--><?php //echo $service->get_price_list_price($pricelist); ?><!--</td>-->
                                            <!--                                                            <td>--><?php //echo $service->get_price_list_price_registered($pricelist); ?><!--</td>-->
                                            <!--                                                        </tr>-->
                                            <!--                                                    --><?php //endforeach; ?>
                                            <!---->
                                            <!--                                                --><?php //endforeach; ?>
                                            <!--                                                </tbody>-->
                                            <!---->
                                            <!---->
                                            <!--                                            --><?php //else: ?>
                                            <!---->
                                            <!--                                                <tr>-->
                                            <!--                                                    <td>--><?php //echo __('This section is empty', 'nowotheme'); ?><!--</td>-->
                                            <!--                                                </tr>-->
                                            <!---->
                                            <!--                                            --><?php //endif; ?>
                                            <!---->
                                            <!--                                        </table>-->

                                            <?php echo do_shortcode("[download-attachments post_id='" . $service->id . "']"); ?>
                                        </ul>
                                    </li>

                                <?php endif; ?>

                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>


</section>


<?php
get_footer();
?>
