<?php

if (!defined('ABSPATH')) {
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <div class="content">
        <?php 
            if(is_front_page() && !wp_is_mobile()) {
                get_template_part("template-parts/header/content", "home"); // GET HOME HEADER 
            }

            get_template_part("template-parts/header/content", "general"); // GET HEADER 
        ?>
        <main class="main">
        <?php 
            if(!is_front_page() && !get_field("ph-disable")) {
                get_template_part("template-parts/global/content", "page-title");
            }
        ?>