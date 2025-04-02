<?php

add_action('wp_enqueue_scripts', function() {
    $blocks_css = ["areas", "before-after", "calculator", "contact-form", "cta", "faq", "gallery", "hero", "instagram", "map", "project-videos", "projects", "ratings", "services", "steps", "testominials", "text-image", "video-reviews"];
    $blocks_js = ["areas", "before-after", "contact-form", "faq", "gallery", "hero", "map"];

    //FONTS
    wp_enqueue_style("roadradio", DIST_FOLDER_PATH . "fonts/roadradio.css", array(), time());
    wp_enqueue_style("inter", DIST_FOLDER_PATH . "fonts/roadradio.css", array(), time());

    // GENERAL STYLES
    wp_enqueue_style("app", DIST_FOLDER_PATH . "css/app.min.css", array(), time());

    // STYLES FOR BLOCKS
    foreach($blocks_css as $block) {
        if (has_block("acf/$block")) {
            wp_enqueue_style("$block-block", DIST_FOLDER_PATH . "css/$block-block.min.css", array(), time());
        }
    }

    // THEME CSS
    wp_enqueue_style("style", get_stylesheet_uri(), array("app"), time());

    wp_enqueue_script("app", DIST_FOLDER_PATH . "js/app.min.js", array(), time(), true);

    foreach($blocks_js as $block) {
        if (has_block("acf/$block")) {
            wp_enqueue_script("$block-block", DIST_FOLDER_PATH . "js/$block.min.js", array("app"), time(), true);
        }
    }
});