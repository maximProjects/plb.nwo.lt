<?php get_header(); ?>
<?php
$cats = get_the_category();
$cat = $cats[0];
$catThmb = get_field('thumb', $cat);
$catThmbUrl = wp_get_attachment_url($catThmb);

?>
<?php
$data = [
  'catThmbUrl' => $catThmbUrl,
];

include(locate_template('news-list.php'));

?>


<?php get_footer(); ?>
