<?php

$cities = OpenWeatherMapsApi::getCityList();

?>

<div class="wrap">

    <h2>Select main city</h2>
    <form method="post" action="options.php">
        <?php wp_nonce_field('update-options') ?>
        <?php $meta_pages = get_option('_sim_weather_city_ids'); ?>

        <?php


        ?>

        <h3>Front page blocks</h3>

        <select name="_sim_weather_city_ids[]" class="selectpicker"
                multiple size="<?php echo (count($cities) > 10) ? count($cities) / 2  : 10 ?>">

            <?php foreach($cities as $city): ?>
                <?php $select = in_array($city->city_id, $meta_pages); ?>
                <option <?php echo $select ? 'selected' : '' ?> value="<?php echo $city->city_id ?>"><?php echo $city->name; ?></option>
            <?php endforeach; ?>
        </select>

        <p><input type="submit" name="Submit" value="Store Options" /></p>
        <input type="hidden" name="action" value="update" />
        <input type="hidden" name="page_options" value="_sim_weather_city_ids" />

    </form>
</div>