<?php $tax = $wp_query->get_queried_object();
$subtypes = apply_filters('term_subterms_list', $tax->term_id);
$i = 1;
?>

<?php if (!in_array(icl_object_id($tax->term_id, 'wa_project_type'), array('11', '10', '38'))): ?>

    <?php foreach ($subtypes as $term_id): ?>

        <?php $term = get_term_by('id', $term_id, get_query_var('taxonomy')); ?>

        <div class="col-md-12 project-type-block" id="<?php echo "section_{$i}"; ?>">
            <div class="row">
                <div class="row-lg-height">
                    <div class="col-sm-8 title col-md-height text-left">
                        <h2>
                            <?php echo $term->name; ?>
                        </h2>
                        <h4>
                            <?php echo apply_filters('project_type_description', $term); ?>
                        </h4>
                    </div>
                    <div class="col-sm-4 info col-md-height">
                        <div><?php echo ot_custom_get_option('category_inquiry_text_') ?></div>
                        <div><?php echo ot_custom_get_option('category_phone_text') ?> <span><?php echo ot_custom_get_option('category_inquiry_phone') ?></span></div>
                    </div>
                </div>
            </div>

            <?php $subtype_projects = apply_filters('term_projects_list', $term->term_id); ?>

            <div class="row projects-container">

                <?php foreach ($subtype_projects as $project): ?>

                    <div class="col-lg-4 col-sm-6 col-xs-12 project-block img-wrapper" style="padding: 0px;">
                        <a class="fill-block" href="<?php echo apply_filters('project_link_with_hash', $project->ID, $tax->term_id) ?>">
                            <img
                                 src="<?php echo apply_filters('project_main_image_url', $project->ID) ?>" alt=""/>
                            <img class="zoomin"
                                 src="<?php echo apply_filters('project_task_hover_image_url', $project->ID, $tax, '') ?>" alt=""/>
                        </a>
                    </div>

                <?php endforeach; ?>

            </div>
        </div>
        <?php $i++; ?>
    <?php endforeach; ?>

<?php else: ?>

    <?php if (!$subtypes): ?>

        <?php $subtype_projects = apply_filters('term_projects_list', $tax->term_id); ?>

        <div class="col-md-12 project-type-block">

            <div class="row">
                <div class="row-lg-height">
                    <div class="col-sm-8 title col-md-height text-left">
                        <h2>
                            <?php echo $tax->name; ?>
                        </h2>
                        <h4>
                            <?php echo $tax->description; ?>
                        </h4>
                    </div>
                    <div class="col-sm-4 info col-md-height">
                        <div><?php echo ot_custom_get_option('category_inquiry_text_') ?></div>
                        <div><?php echo ot_custom_get_option('category_phone_text') ?> <span><?php echo ot_custom_get_option('category_inquiry_phone') ?></span></div>
                    </div>
                </div>
            </div>


            <div class="row projects-container">

                <?php foreach ($subtype_projects as $project): ?>
                    <div class="col-lg-4 col-sm-6 col-xs-12 project-block img-wrapper" style="padding: 0px;">
                        <a class="fill-block"
                           href="<?php echo apply_filters('project_link_by_term', $project->ID, $tax); ?>">
                            <img
                                 src="<?php echo apply_filters('project_main_image_url', $project->ID) ?>" alt=""/>
                            <img class="zoomin"
                                 src="<?php echo apply_filters('project_task_hover_image_url', $project->ID, $tax, '') ?>" alt=""/>
                        </a>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>

    <?php endif; ?>

<?php endif; ?>