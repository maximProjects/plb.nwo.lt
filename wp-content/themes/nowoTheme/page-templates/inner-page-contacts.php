<?php
/**
 * Template Name: Kontaktai
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




<div class="container contacts section">
    <div class="row">
        <div class="col col-lg-12">
            <h1 class="title">
                <?php echo get_the_title(); ?>
                <span class="line"></span>
            </h1>
        </div>
    </div>
    <div class="contacts-content">
        <?php
        $blocks = get_field("contact_blocks");
        if($blocks) {
            foreach ($blocks as $block) {
                if($block['title']) {
                    ?>
                    <div class="scroll-marker-box">
                        <div class="scroll-marker" id="<?= $block['id'] ?>"></div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6 col-md-6">
                            <h2 class="title"><?= $block['title'] ?></h2>

                            <?php
                            if (!empty($block["address"])) {
                                ?>
                                <div class="info-cell address">
                                    <?= file_get_contents(get_template_directory_uri() . "/img/address.svg") ?>
                                    <?= wpautop($block["address"], true) ?>
                                </div>

                                <?php
                            }
                            ?>

                            <?php
                            if (!empty($block["email_1"])) {
                                ?>
                                <div class="info-cell email">
                                    <?= file_get_contents(get_template_directory_uri() . "/img/envelope.svg") ?>
                                    <a href="mailto:<?= $block["email_1"] ?>"><?= $block["email_1"] ?></a>
                                </div>
                                <?php
                            }
                            ?>

                            <?php
                            if (!empty($block["email_2"])) {
                                ?>
                                <div class="info-cell email">
                                    <?= file_get_contents(get_template_directory_uri() . "/img/envelope.svg") ?>
                                    <a href="mailto:<?= $block["email_2"] ?>"><?= $block["email_2"] ?></a>
                                </div>
                                <?php
                            }
                            ?>
                            <?php
                            if (!empty($block["phone_1"])) {
                                ?>
                                <div class="info-cell phone">
                                    <?= file_get_contents(get_template_directory_uri() . "/img/phone.svg") ?>
                                    <a href="tel:<?= $block["phone_1"] ?>"><?= $block["phone_1"] ?></a>
                                </div>
                                <?php
                            }
                            ?>
                            <?php
                            if (!empty($block["phone_2"])) {
                                ?>
                                <div class="info-cell phone">
                                    <?= file_get_contents(get_template_directory_uri() . "/img/phone.svg") ?>
                                    <a href="tel:<?= $block["phone_2"] ?>"><?= $block["phone_2"] ?></a>
                                </div>
                                <?php
                            }
                            ?>

                            <?php
                            if (!empty($block["phone_3"])) {
                                ?>
                                <div class="info-cell phone">
                                    <?= file_get_contents(get_template_directory_uri() . "/img/phone.svg") ?>
                                    <a href="tel:<?= $block["phone_3"] ?>"><?= $block["phone_3"] ?></a>
                                </div>
                                <?php
                            }
                            ?>

                            <?php
                            if (!empty($block["phone_4"])) {
                                ?>
                                <div class="info-cell phone">
                                    <?= file_get_contents(get_template_directory_uri() . "/img/phone.svg") ?>
                                    <a href="tel:<?= $block["phone_4"] ?>"><?= $block["phone_4"] ?></a>
                                </div>
                                <?php
                            }
                            ?>

                            <?php
                            if (!empty($block["phone_5"])) {
                                ?>
                                <div class="info-cell phone">
                                    <?= file_get_contents(get_template_directory_uri() . "/img/phone.svg") ?>
                                    <a href="tel:<?= $block["phone_5"] ?>"><?= $block["phone_5"] ?></a>
                                </div>
                                <?php
                            }
                            ?>

                            <?php
                            if (!empty($block["phone_6"])) {
                                ?>
                                <div class="info-cell phone">
                                    <?= file_get_contents(get_template_directory_uri() . "/img/phone.svg") ?>
                                    <a href="tel:<?= $block["phone_6"] ?>"><?= $block["phone_6"] ?></a>
                                </div>
                                <?php
                            }
                            ?>

                            <?php
                            if (!empty($block["whatsapp"])) {
                                ?>
                                <div class="info-cell whatsapp">
                                    <?= file_get_contents(get_template_directory_uri() . "/img/whatsapp.svg") ?>
                                    <a href="tel:<?= $block["whatsapp"] ?>"><?= $block["whatsapp"] ?></a>
                                </div>
                                <?php
                            }
                            ?>

                            <?php
                            if (!empty($block["contact_person"])) {
                                ?>
                                <div class="info-cell contact_person">
                                    <?= file_get_contents(get_template_directory_uri() . "/img/phone.svg") ?>
                                    <?= $block["contact_person"] ?>
                                </div>
                                <?php
                            }
                            ?>

                            <?php
                            if (!empty($block["website"])) {
                                ?>
                                <div class="info-cell website">
                                    <?= file_get_contents(get_template_directory_uri() . "/img/website.svg") ?>
                                    <a href="http://<?= $block["website"] ?>"
                                       target="_blank"><?= $block["website"] ?></a>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="email-link d-block d-md-none d-lg-none">
                                <a href="#"><?= file_get_contents(get_template_directory_uri() . "/img/envelope.svg") ?></a>
                            </div>
                            <?php
                            $form_mail = $block['form_email'];
                            ?>
                            <div class="d-block d-md-none d-lg-none">

                                <div class="email-form mobile">
                                    <a href="#"
                                       class="close  d-block d-lg-none d-md-none"><?= file_get_contents(get_template_directory_uri() . "/img/close.svg") ?></a>
                                    <?php
                                    get_template_part('cf-messages');
                                    ?>
                                    <?= do_shortcode('[contact-form-7 id="344" title="Employeer" destination-email="'.$form_mail.'" ]') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col col-6 d-none d-lg-block d-md-block">
                            <div class="email-form">

                                <?php
                                get_template_part('cf-messages');
                                ?>
                                <?= do_shortcode('[contact-form-7 id="344" title="Employeer" destination-email="'.$form_mail.'" ]') ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
        }
        ?>
    </div>
</div>





<?php get_footer(); ?>
