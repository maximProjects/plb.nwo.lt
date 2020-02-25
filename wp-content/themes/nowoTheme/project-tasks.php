<div class="container tasks-container" id="fullpage">


    <?php $tasks = apply_filters('project_tasks_list', $post->ID);
    $i = 1; ?>


    <?php foreach ($tasks as $task): ?>

        <div class="section" id="slide<?php echo $i; ?>">

            <!--header-container -->

            <?php if ($i != 1): ?>
                <div class="row header-container">
                    <div class="col-md-12 title-block">
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
                    <div class="col-tn-6 col-xs-8 col-sm-8 col-lg-9 title-block">
                        <h1>
                            <?php echo $task->post_title; ?>
                        </h1>

                        <h2>
                            <?php echo $post->post_title; ?>
                        </h2>
                    </div>
                    <div class="col-tn-6 col-xs-4 col-sm-4 col-lg-3 pull-right enquiry-block">
                        <?php echo get_template_part_leave_variables('popup-form') ?>
                    </div>
                </div>
            <?php endif; ?>
            <!-- END header-container  -->

            <div class="row task-container">

                <?php echo $i == 1 ? get_template_part_leave_variables('project-annotation') : ''; ?>

                <div class="col-md-12 task">

                    <div class="header-container">
                        <h2><span class="parag"><?php echo $i; ?>.</span> Idėja</h2>
                    </div>
                    <div class="content-container">

                        <p><?php echo $task->post_content; ?></p>
                    </div>


                    <div class="design-image">

                        <?php if (apply_filters('get_task_type', $task) == 'video'): ?>

                            <?php foreach (apply_filters('task_video_links', $task) as $video_url): ?>

                                <div class="embed-responsive embed-responsive-16by9">

                                    <?php echo apply_filters('youtube_video_display', $video_url, '', ''); ?>

                                </div>
                            <?php endforeach; ?>

                        <?php else: ?>

                            <?php $img = wp_get_attachment_image_src(get_post_thumbnail_id($task->ID), 'full'); ?>

                            <img src="<?php echo $img[0]; ?>" alt=""/>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php $i++; ?>
        </div>
    <?php endforeach; ?>


    <?php echo get_template_part_leave_variables('project-footer'); ?>

</div>