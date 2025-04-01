<?php

add_filter("block_categories_all", function ($categories) {
    $categories[] = [
        "slug"  => "rivo-blocks",
        "title" => __("Rivo Blocks", "rivo"),
        "icon"  => "wordpress",
    ];
    return $categories;
});

function rivo_acf_blocks() {
    $blocks = array(
        0 => array(
            "name"              => "areas",
            "title"             => __("Service Areas", "rivo"),
            "render_template"   => "template-parts/blocks/areas.php",
            "icon"              => "smiley",
        ),
        1 => array(
            "name"              => "before-after",
            "title"             => __("Before/After Projects", "rivo"),
            "render_template"   => "template-parts/blocks/before-after.php",
            "icon"              => "smiley",
        ),
        2 => array(
            "name"              => "calculator",
            "title"             => __("Calculator", "rivo"),
            "render_template"   => "template-parts/blocks/calculator.php",
            "icon"              => "smiley",
        ),
        3 => array(
            "name"              => "contact-form",
            "title"             => __("Contacts/Form", "rivo"),
            "render_template"   => "template-parts/blocks/contact-form.php",
            "icon"              => "smiley",
        ),
        4 => array(
            "name"              => "cta",
            "title"             => __("Call-to-Action", "rivo"),
            "render_template"   => "template-parts/blocks/cta.php",
            "icon"              => "smiley",
        ),
        5 => array(
            "name"              => "faq",
            "title"             => __("Frequently Asked Questions (FAQs)", "rivo"),
            "render_template"   => "template-parts/blocks/faq.php",
            "icon"              => "smiley",
        ),
        6 => array(
            "name"              => "gallery",
            "title"             => __("Gallery", "rivo"),
            "render_template"   => "template-parts/blocks/gallery.php",
            "icon"              => "smiley",
        ),
        7 => array(
            "name"              => "instagram",
            "title"             => __("Instagram", "rivo"),
            "render_template"   => "template-parts/blocks/instagram.php",
            "icon"              => "smiley",
        ),
        8 => array(
            "name"              => "map",
            "title"             => __("Map", "rivo"),
            "render_template"   => "template-parts/blocks/map.php",
            "icon"              => "smiley",
        ),
        9 => array(
            "name"              => "project-videos",
            "title"             => __("Project's Videos", "rivo"),
            "render_template"   => "template-parts/blocks/project-videos.php",
            "icon"              => "smiley",
        ),
        10 => array(
            "name"              => "projects",
            "title"             => __("Projects", "rivo"),
            "render_template"   => "template-parts/blocks/projects.php",
            "icon"              => "smiley",
        ),
        11 => array(
            "name"              => "ratings",
            "title"             => __("Ratings", "rivo"),
            "render_template"   => "template-parts/blocks/ratings.php",
            "icon"              => "smiley",
        ),
        12 => array(
            "name"              => "services",
            "title"             => __("Services", "rivo"),
            "render_template"   => "template-parts/blocks/services.php",
            "icon"              => "smiley",
        ),
        13 => array(
            "name"              => "Steps",
            "title"             => __("Steps", "rivo"),
            "render_template"   => "template-parts/blocks/steps.php",
            "icon"              => "smiley",
        ),
        14 => array(
            "name"              => "testominials",
            "title"             => __("Testominials", "rivo"),
            "render_template"   => "template-parts/blocks/testominials.php",
            "icon"              => "smiley",
        ),
        15 => array(
            "name"              => "text-image",
            "title"             => __("Service Areas", "rivo"),
            "render_template"   => "template-parts/blocks/text-image.php",
            "icon"              => "smiley",
        ),
        16 => array(
            "name"              => "hero",
            "title"             => __("Hero", "rivo"),
            "render_template"   => "template-parts/blocks/text-image.php",
            "icon"              => "smiley",
        ),
        17 => array(
            "name"              => "video-reviews",
            "title"             => __("Video Reviews", "rivo"),
            "render_template"   => "template-parts/blocks/video-reviews.php",
            "icon"              => "smiley",
        ),
    );

    foreach($blocks as $key => $block) {
        acf_register_block_type([
            "name"              => $block["name"],
            "title"             => $block["title"],
            "render_template"   => $block["render_template"],
            "category"          => "rivo-blocks", // Group this block under "rivo-blocks" category
            "icon"              => $block["icon"],
        ]);
    }
}

add_action("acf/init", "rivo_acf_blocks");
