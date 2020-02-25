<div class="container tasks-container">

    <?php $tasks =  apply_filters('project_tasks_list', $post->ID, array('37')); $i = 1; ?>


    <?php foreach($tasks as $task): ?>

        <!--header-container -->

        <?php if($i != 1): ?>
            <div class="row header-container">
                <div class="col-md-6 title-block">
                    <h1>
                        <?php echo $task->post_title; ?>
                    </h1>
                    <h2>
                        <?php echo $post->post_title; ?>
                    </h2>
                </div>
            </div>
        <?php else: ?>
            <div class="row header-container">
                <div class="col-xs-6 col-md-9 title-block">
                    <h1>
                        <?php echo $task->post_title; ?>
                    </h1>
                    <h2>
                        <?php echo $post->post_title; ?>
                    </h2>
                </div>
                <div class="col-xs-6 col-md-3 pull-right enquiry-block">
                    <?php echo get_template_part_leave_variables('popup-form') ?>
                </div>
            </div>
        <?php endif; ?>
        <!-- END header-container  -->

        <div class="row task-container spauda-task">

            <div class="col-md-12 task">

                <div class="header-container">
                    <h2><span class="parag"><?php echo $i; ?>.</span> Idėja</h2>
                </div>
                <div class="content-container">
                    <p><?php echo $task->post_content; ?></p>
                </div>
                <div class="design-image">
                    <?php $img = wp_get_attachment_image_src(get_post_thumbnail_id($task->ID), 'full'); ?>

                    <img src="<?php echo $img[0]; ?>" alt=""/>
                </div>
            </div>
        </div>
        <?php $i++; ?>
    <?php endforeach; ?>

    <?php echo get_template_part_leave_variables('project-footer'); ?>

</div>