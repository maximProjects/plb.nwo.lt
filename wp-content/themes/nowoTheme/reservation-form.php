<?php

global $sitepress;

$locale = $sitepress->get_language_tag(ICL_LANGUAGE_CODE);

?>


<script charset="UTF-8" type="text/javascript">var easyAccessHotelsWidgetScriptLoaded = false;function easyAccessHotelsInitJQuery() {if (typeof (easyAccessHotelsOwnJQuery) == "undefined") {if (!easyAccessHotelsWidgetScriptLoaded) {easyAccessHotelsWidgetScriptLoaded = true;document.write("<scr" + "ipt charset=\"UTF-8\" type=\"text/javascript\" src=\"//online.bookvisit.com/Content/widget/script/WidgetScripts.min.js\"></scr" + "ipt>");}setTimeout("easyAccessHotelsInitJQuery()", 50);}else {var baseUrl = "//online.bookvisit.com/widget/GetWidgetSearchFormMultipleRooms";(function ($) {$.getJSON(baseUrl +
        "?channelId=6364fb85-adf5-4395-a6bd-5d44f2429934&openOption=iframe&culture=<?php echo $locale ; ?>&containerId=searchContainer&displayPromoCode=true&displayCorpCode=true&displayIATACode=false&jsoncallback=?",function (json) {$("#searchContainer").html(json.Widget);});})(easyAccessHotelsOwnJQuery);}}easyAccessHotelsInitJQuery();</script>
<style type="text/css">
    .form-container .form-info {margin-bottom:25px}
    .cb-arrival, .cb-stay, .cb-room {
        width: 100% !important
    float: none !important;
        clear: both !important
    }
    /*.cb-arrival::after, .cb-stay::after, .cb-room::after {*/
        /*background-position: right center !important;*/
        /*bottom: 10px !important;*/
        /*right: 10px !important;*/
        /*left: auto;*/
        /*height: 20px;*/
        /*width: 38px;*/
        /*cursor: pointer;*/
        /*z-index: 0;*/
    /*}*/
    /*.cb-stay::after {background-image: none}*/
    .cb-stay label {font-weight: 400}
    .cb-arrival, .cb-stay, .cb-room {
        float: initial !important;
        width: auto !important
    }
    .cb-widget .cb-item{
        margin-bottom: 25px;
    }
    .cb-widget .cb-widget-inner .cb-item .cb-js-room-config > div, .cb-widget .cb-widget-inner .cb-item .cb-input-box > select, .cb-widget .cb-widget-inner .cb-item .cb-input-box > input {
        height: 45px !important;
        text-align: initial !important;
        background-image: url(<?php echo get_template_directory_uri() . '/img/icons/form_arrow.png'; ?>) !important;
        background-repeat: no-repeat;
        background-position: 98% 7px !important;
    }

    .cb-arrival:nth-child(3), .cb-stay:nth-child(3), .cb-room:nth-child(3) {
        margin-left: 0 !important;
        margin-right: 0 !important
    }
    .cb-codes {margin-top: 0 !important}
    .cb_js_search .cb-btn-inner {padding: 20px 0 !important}
    .cb-search-item {top: 0px !important}
    .cb-widget .cb-widget-inner .cb-button:hover {background-color: #9E815D !important;}
    .cb-widget .cb-widget-inner .cb-button{
        float: none !important;
    }
    .cb-widget .cb-widget-inner input[type="text"], .cb-widget .cb-widget-inner select {font-size: 14px !important}
    .cb-widget .cb-widget-inner select{
        background-image: url('') !important;
        background-repeat: no-repeat;
        background-position: right center !important;
        padding-right: 20px !important;
        -moz-appearance: none;
    }
    .cb-js-num-rooms, .cb-js-num-persons {
        margin: 0 !important;
        display: initial !important;
        color: #fff !important;
        width: auto !important;
        text-transform: none;
        font-size: 14px !important;
        line-height: 24px
    }

    @media screen and (min-width: 992px) and (max-width: 1680px){
        .cb-widget .cb-item{
            margin-bottom:0px !important;
        }
        .cb_js_search .cb-btn-inner {padding: 10px 0px !important}
    }
</style>


<div class="row">
    <div class="col-md-12 col-lg-12 col-llg-9 col-llg-push-2 form-container">
        <h2 class="title"><?php echo __('Fast reservation', 'corner'); ?></h2>
        <div class="form-info">
            <hr>
            <span>
                <?php echo ot_custom_get_option('reservation_subtitle'); ?>
            </span>
            <hr>
        </div>
        <div style="width: 100%;" class="cb-widget">
            <div id="searchContainer"></div>
        </div>
    </div>
</div>

<div class="row">
    <?php if(!is_front_page()): ?>
        <div class="form-contacts col-md-12 col-lg-9 col-lg-push-2 col-llg-9 col-llg-push-2">
            <h3><?php echo __('Contact us', 'corner'); ?> <?php echo __('by phone', 'corner'); ?></h3>
            <h4><?php echo ot_custom_get_option('company_phone') ?></h4>
            <h3><?php echo __('by email', 'corner'); ?></h3>
            <h4><?php echo ot_custom_get_option('company_email') ?></h4>
        </div>
    <?php endif; ?>
</div>