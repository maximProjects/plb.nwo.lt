<?php if(get_post_type() == 'wa_project'): ?>


<style>
    .main-container .tab-menu-container.smaller,
    .main-container .breadcrumbs-container.smaller,
    .main-container .top-menu-container{
        <?php echo apply_filters('project_dynamic_bg', get_the_ID()); ?>
    }
</style>

<?php endif; ?>