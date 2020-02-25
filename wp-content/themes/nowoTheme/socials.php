<div class="socials text-right">
    <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?= get_permalink() ?>"><?= file_get_contents(get_template_directory_uri()."/img/facebook.svg") ?></a>
    <a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=<?= get_permalink() ?>"><?= file_get_contents(get_template_directory_uri()."/img/linkedin.svg") ?></a>
    <a target="_blank" href="https://www.facebook.com/dialog/send?app_id=260937461564689&link=<?= get_permalink() ?>&redirect_uri=<?= get_permalink() ?>"><?= file_get_contents(get_template_directory_uri()."/img/messenger.svg") ?></a>
    <a target="_blank" href="http://twitter.com/share?text=<?= get_permalink() ?>"><?= file_get_contents(get_template_directory_uri()."/img/twitter.svg") ?></a>
    <a target="_blank" href="mailto:?subject=<?= the_title() ?>&body=<?= get_permalink() ?>"><?= file_get_contents(get_template_directory_uri()."/img/envelope.svg") ?></a>
    <span><?= file_get_contents(get_template_directory_uri()."/img/share.svg") ?> <span><?= __('Share', nowotheme_DOMAIN) ?></span></span>
</div>
