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
<div class="threeDee-container wrap">
    <h2><?php _e('ThreeDee Settings', 'ThreeDee'); ?></h2>
    <div id="ThreeDee_tabs">
    <div class="row mx-xl-n5">
    <div class="col-lg-3 px-xl-5">
        <ul class="nav nav-tabs sticky-lg-top flex-column mb-5 mb-lg-0" role="tablist">
            <li class="nav-item active"><a data-toggle="tab" data-filter="all" role="tab" aria-selected="false" class="nav-link" href="#ThreeDee_tabs-0"><?php _e('General Settings', 'pizzatime'); ?></a></li>
            <li class="nav-item"><a data-toggle="tab" data-filter="all" role="tab" aria-selected="false" class="nav-link" href="#ThreeDee_tabs-1"><?php _e('Object Settings', 'pizzatime'); ?></a></li>
            <li class="nav-item"><a data-toggle="tab" data-filter="all" role="tab" aria-selected="false" class="nav-link" href="#ThreeDee_tabs-2"><?php _e('Advanced Settings', 'pizzatime'); ?></a></li>
            <li class="nav-item"><a data-toggle="tab" data-filter="all" role="tab" aria-selected="false" class="nav-link" href="#ThreeDee_tabs-3"><?php _e('Shortcode Builder', 'pizzatime'); ?></a></li>
        </ul>
    </div>
    <div class="col-lg-9 px-xl-5">
        <?php include('admin-globalSettings.php'); ?>
        <?php include('admin-objectSettings.php'); ?>
        <?php include('admin-advancedSettings.php'); ?>
        <div id="ThreeDee_tabs-3">
            <?php
            include_once('ThreeDee-admin-shortcode-builder.php');
            ?>
        </div>
        </div>
    </div><!-- ThreeDee_tabs -->
    </div>
</div> <!-- wrap -->
<?php

?>