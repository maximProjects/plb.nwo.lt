<?php debugvar($project); ?>
<div class="col-lg-4 col-sm-6 col-xs-12 project-block img-wrapper" style="padding: 0px;">
    <a class="fill-block" href="<?php echo get_permalink($project->ID); ?>">
        <img class="zoomin" src="<?php echo apply_filters('project_main_image_url', $project->ID) ?>" alt=""/>
    </a>
</div>