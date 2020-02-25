<li class="dropdown menu-item">
    <?php foreach(apply_filters('language_switcher_display', $post) as $language): ?>
        <?php if($language['active']): ?>
            <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                <?php echo $language['native_name']; ?> <i class="fa fa-angle-down"></i>
            </a>
        <?php endif; ?>
    <?php endforeach; ?>
    <ul class="dropdown-menu text-center" role="menu">
        <?php foreach(apply_filters('language_switcher_display', $post) as $id => $language): ?>
            <li class="<?php echo $language['active'] ? 'active' : '' ?>">
                <?php if($language['active']): ?>
                <a>
                    <?php echo $language['native_name'] ?></a>
                <?php else: ?>
                    <a href="<?php echo $language['url'] ?>">
                        <?php echo $language['native_name'] ?></a>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</li>