<div class="cf-message error">
    <div class="txt">
        <?= __('Something wrong?', nowotheme_DOMAIN) ?>
    </div>
    <?= file_get_contents(get_template_directory_uri()."/img/cf7_error.svg") ?>
</div>

<div class="cf-message success">
    <div class="txt">
        <?= __('Your message send', nowotheme_DOMAIN) ?>
    </div>
    <?= file_get_contents(get_template_directory_uri()."/img/cf7_sent.svg") ?>
</div>