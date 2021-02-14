<?php


?>
<script language="javascript">
    jQuery(document).ready(function() {
        jQuery('.ThreeDee-tooltip').tooltipster({
            contentAsHTML: true,
            multiple: true
        });
    });
</script>
<div class="wrap">
    <h2><?php _e('ThreeDee Settings', 'ThreeDee'); ?></h2>
    <div id="ThreeDee_tabs">
        <ul>
            <li><a href="#ThreeDee_tabs-0"><?php _e('General Settings', 'pizzatime'); ?></a></li>
            <li><a href="#ThreeDee_tabs-1"><?php _e('Object Settings', 'pizzatime'); ?></a></li>
            <li><a href="#ThreeDee_tabs-2"><?php _e('Advanced Settings', 'pizzatime'); ?></a></li>
            <li><a href="#ThreeDee_tabs-3"><?php _e('Shortcode Builder', 'pizzatime'); ?></a></li>
        </ul>
        <?php include('tabs/admin-globalSettings.php'); ?>
        <?php include('tabs/admin-objectSettings.php'); ?>
        <?php include('tabs/admin-advancedSettings.php'); ?>
        <div id="ThreeDee_tabs-1">

        </div>
        <div id="ThreeDee_tabs-3">
            <?php
            include_once('ThreeDee-admin-shortcode-builder.php');
            ?>
        </div>
    </div><!-- ThreeDee_tabs -->
</div> <!-- wrap -->
<?php

?>