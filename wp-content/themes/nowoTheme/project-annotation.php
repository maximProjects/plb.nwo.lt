<?php global $post; ?>

<?php if(!isset($_GET['type'])): ?>

<div class="task-annotation-container col-md-3">
    <div class="annotation">
        <ul>
            <li class="hidden-xs hidden-sm">
                <a href="#" class="noref"><?php echo __('Project', 'nwagency') ?></a>
                <ul>
                    <?php if( apply_filters('project_url', $post->ID) && apply_filters('project_url', $post->ID) != ' '
                    ): ?>
                        <li><a class="project-link" target="_blank" href="http://<?php echo apply_filters('project_url', $post->ID) ?>" rel="nofollow"><?php echo apply_filters('project_url', $post->ID) ?></a></li>
                    <?php else: ?>
                        <li><?php echo $post->post_title; ?></li>
                    <?php endif; ?>
                </ul>
            </li>
            <li>
                <a class="hidden-xs hidden-sm noref" href="#"><?php echo __('Has been done', 'nwagency') ?></a>
                <ul>
                    <?php foreach(apply_filters('project_annotation', $post->ID) as $node): ?>
                        <?php $image = get_field('node_image', 'wa_project_node_' . $node->term_id); ?>
                        <li>
                            <?php if($image): ?>
                                <span><img src="<?php echo $image['url'] ?>" alt=""/></span>
                            <?php  endif; ?>
                            <span class="text"><?php echo $node->name; ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </li>
        </ul>
    </div>
</div>

<?php endif; ?>