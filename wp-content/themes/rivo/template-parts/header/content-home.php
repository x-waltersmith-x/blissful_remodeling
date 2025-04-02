<?php

$site_title = get_bloginfo("title");

?>
<header class="header home">
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
        <?php
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
        ?>
    </div>
</header>