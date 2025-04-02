<?php

class Clean_Menu_Walker extends Walker_Nav_Menu {
    // Start the <ul> element
    function start_lvl(&$output, $depth = 0, $args = null) {
        $output .= "\n<ul class=\"sub-menu\">\n";
    }

    // Start the <li> element
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? [] : (array) $item->classes;
        $hasChildren = in_array('menu-item-has-children', $classes) ? ' has-submenu' : '';

        $output .= sprintf(
            '<li class="menu-item%s"><a href="%s">%s</a>',
            esc_attr($hasChildren),
            esc_url($item->url),
            esc_html($item->title)
        );
    }

    // End the <li> element
    function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= "</li>\n";
    }
}


function rivo_breadcrumbs($custom_class = '') {
    // Settings
    $separator = '<svg class="separator" width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.5 12L10.5 8L6.5 4" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>'; // Visual separator
    $home_title = get_the_title(get_option("page_on_front"));
    $home_url = home_url(); // Home URL
    $breadcrumbs = []; // To store breadcrumb items

    // Add home link
    $breadcrumbs[] = [
        'url' => $home_url,
        'label' => $home_title
    ];

    // Get the current query and post details
    global $post;

    if (is_front_page()) {
        // Home page (front page)
        $breadcrumbs[] = ['url' => '', 'label' => $home_title];
    } elseif (is_home()) {
        // Blog page
        $blog_page_id = get_option('page_for_posts');
        $breadcrumbs[] = ['url' => get_permalink($blog_page_id), 'label' => get_the_title($blog_page_id)];
    } elseif (is_singular()) {
        // Single post, page, or custom post type
        if ($post->post_type !== 'post' && $post->post_type !== 'page') {
            // Custom post type archive, avoid adding breadcrumb for "page"
            $post_type_obj = get_post_type_object($post->post_type);
            $breadcrumbs[] = [
                'url' => get_post_type_archive_link($post->post_type),
                'label' => $post_type_obj->labels->name
            ];
        }

        if ($post->post_parent) {
            // If the post has a parent, include its hierarchy
            $ancestors = array_reverse(get_post_ancestors($post->ID));
            foreach ($ancestors as $ancestor) {
                $breadcrumbs[] = [
                    'url' => get_permalink($ancestor),
                    'label' => get_the_title($ancestor)
                ];
            }
        }

        $breadcrumbs[] = ['url' => '', 'label' => get_the_title()];
    } elseif (is_archive()) {
        if (is_category() || is_tag() || is_tax()) {
            // Taxonomy archive
            $taxonomy = get_queried_object();
            if ($taxonomy->taxonomy === 'genre') {
                // Get the 'Genres' page by slug
                $genres_page = get_page_by_path("genres");
            
                if ($genres_page) {
                    // If the page exists, add it to the breadcrumbs
                    $breadcrumbs[] = [
                        'url' => get_the_permalink($genres_page),
                        'label' => get_the_title($genres_page)
                    ];
                }
            }

            if ($taxonomy->parent) {
                // Display parent taxonomy if exists
                $parent_id = $taxonomy->parent;
                $parent = get_term($parent_id);
                $breadcrumbs[] = [
                    'url' => get_term_link($parent),
                    'label' => $parent->name
                ];
            }
            $breadcrumbs[] = ['url' => '', 'label' => single_term_title('', false)];
        } elseif (is_post_type_archive()) {
            // Custom post type archive
            $breadcrumbs[] = [
                'url' => '',
                'label' => post_type_archive_title('', false)
            ];
        } elseif (is_date()) {
            // Date archive
            if (is_year()) {
                $breadcrumbs[] = ['url' => '', 'label' => get_the_date('Y')];
            } elseif (is_month()) {
                $breadcrumbs[] = [
                    'url' => get_year_link(get_the_date('Y')),
                    'label' => get_the_date('Y')
                ];
                $breadcrumbs[] = ['url' => '', 'label' => get_the_date('F')];
            } elseif (is_day()) {
                $breadcrumbs[] = [
                    'url' => get_year_link(get_the_date('Y')),
                    'label' => get_the_date('Y')
                ];
                $breadcrumbs[] = [
                    'url' => get_month_link(get_the_date('Y'), get_the_date('m')),
                    'label' => get_the_date('F')
                ];
                $breadcrumbs[] = ['url' => '', 'label' => get_the_date('j')];
            }
        } elseif (is_author()) {
            // Author archive
            $breadcrumbs[] = ['url' => '', 'label' => get_the_author()];
        }
    } elseif (is_search()) {
        // Search results
        $breadcrumbs[] = [
            'url' => '',
            'label' => 'Search results for "' . get_search_query() . '"'
        ];
    } elseif (is_404()) {
        // 404 page
        $breadcrumbs[] = ['url' => '', 'label' => 'Page not found'];
    }

    // Render the breadcrumbs
    echo '<nav class="breadcrumbs'. esc_attr(" " . $custom_class) .'" aria-label="breadcrumbs">';
    echo '<ol itemscope itemtype="https://schema.org/BreadcrumbList">';

    $crumb_count = count($breadcrumbs);

    foreach ($breadcrumbs as $index => $crumb) {
        echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        if (!empty($crumb['url'])) {
            echo '<a href="' . esc_url($crumb['url']) . '" itemprop="item">';
            echo '<span itemprop="name">' . esc_html($crumb['label']) . '</span>';
            echo '</a>';
        } else {
            echo '<span itemprop="name">' . esc_html($crumb['label']) . '</span>';
        }

        // Add separator, but not after the last breadcrumb
        if ($index < $crumb_count - 1) {
            echo $separator;
        }

        echo '<meta itemprop="position" content="' . ($index + 1) . '" />';
        echo '</li>';
    }

    echo '</ol>';
    echo '</nav>';
}


function rivo_navigations() {
    register_nav_menus(array(
        'header' => __('Header Menu', 'rivo'),
        'footer' => __('Footer General Menu', 'rivo'),
        'services' => __('Footer Services Menu', 'rivo'),
    ));
}
add_action('init', 'rivo_navigations');


add_filter('upload_mimes', function($mime_types) {
    $mime_types['svg'] = 'image/svg+xml'; // Allow SVG
    $mime_types['svgz'] = 'image/svg+xml'; // Allow Compressed SVG
    return $mime_types;
});


add_filter('wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    if ($ext === 'svg') {
        $data['ext'] = 'svg';
        $data['type'] = 'image/svg+xml';
    }
    return $data;
}, 10, 4);


add_image_size('small', 480, 320, true); // iPhone
add_image_size('medium_large', 820, 461, true); // iPad Air
add_image_size('1920x1080', 1920, 1080, true); // Full HD
add_image_size('2048x2048', 2048, 2048, true); // Retina
add_image_size('3840x2160', 3840, 2160, true); // 4K