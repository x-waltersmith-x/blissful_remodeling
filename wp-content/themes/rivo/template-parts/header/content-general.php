<?php

$detect = get_mobile_detect();
$is_mobile_tablet = wp_is_mobile();
$site_title = get_bloginfo("title");

?>
<header class="header general">
    <div class="container">
        <a href="<?php echo home_url(); ?>" class="site-url">
            <?php 


                if(get_field("logo_header", "option")) {
                    echo wp_get_attachment_image(get_field("logo_header", "option"), 'full');
                } else {
                    echo "<span class=\"site-title\">$site_title</span>";
                }
            ?>   
        </a>
        <?php if($is_mobile_tablet): ?>
            <button class="menu">
                <img src="<?php echo DIST_FOLDER_PATH . 'media/open.svg'; ?>" alt="open" class="icon open">
                <img src="<?php echo DIST_FOLDER_PATH . 'media/close.svg'; ?>" alt="open" class="icon close">
                <span class="title open"><?php _e('Menu', 'rivo'); ?></span>
                <span class="title close"><?php _e('Close', 'rivo'); ?></span>
            </button>
        <?php
            endif; 
            echo ($is_mobile_tablet) ? '<div class="navigation-mobile">': '';
            if (has_nav_menu('header')) {
                wp_nav_menu([
                    'theme_location' => 'header',
                    'container' => 'nav',
                    'container_class' => 'navigation',
                    'menu_class' => 'menu',
                    'walker' => new Clean_Menu_Walker(),
                    'items_wrap' => '<ul>%3$s</ul>',
                ]);
            }

            echo <<<EOT
                <a href="tel:+1 916 534 9628" class="btn arrow">916 534 9628</a>
            EOT;

            echo ($is_mobile_tablet) ? '</div>': '';
        ?>
    </div>
</header>