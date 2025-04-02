<?php 
/**
 * Gallery Block Template.
 */
$blockname = pathinfo(__FILE__, PATHINFO_FILENAME);
$id = $blockname. '-' . $block['id'];
$classes = !empty($block['className']) ? $blockname.'-block ' . $block['className'] : $blockname.'-block';

$gallery = get_field("gallery");
$videos = get_field("videos");
$description = get_field("description");
   
?>
<div id="<?php echo esc_attr($id);?>" class="<?php echo esc_attr($classes); ?>">
    <div class="container">
        <?php  if(!empty($gallery) || !empty($videos)): ?>
            <div class="gallery">
            <?php 
                if ($gallery): 
                    foreach ($gallery as $image): 
                        $small = wp_get_attachment_image_src($image['ID'], 'small'); // e.g., iPhone
                        $ipad_mini = wp_get_attachment_image_src($image['ID'], 'medium'); // e.g., iPad Mini
                        $ipad_air = wp_get_attachment_image_src($image['ID'], 'medium_large'); // e.g., iPad Air
                        $ipad_pro = wp_get_attachment_image_src($image['ID'], 'large'); // e.g., iPad Pro
                        $desktop = wp_get_attachment_image_src($image['ID'], 'full'); // e.g., Desktop
                        $fullhd = wp_get_attachment_image_src($image['ID'], '1920x1080'); // e.g., Full HD
                        $retina = wp_get_attachment_image_src($image['ID'], '2048x2048'); // e.g., Retina
                        $k4 = wp_get_attachment_image_src($image['ID'], '3840x2160'); // e.g., 4K
                ?>
                    <div class="item">
                        <picture>
                            <?php if(!empty($k4)): ?>
                                <source srcset="<?php echo esc_url($k4[0]); ?>" media="(min-width: 3840px)">
                            <?php endif; if(!empty($retina)): ?>
                                <source srcset="<?php echo esc_url($retina[0]); ?>" media="(min-width: 2560px)">
                            <?php endif; if(!empty($fullhd)): ?>
                                <source srcset="<?php echo esc_url($fullhd[0]); ?>" media="(min-width: 1920px)">
                            <?php endif; if(!empty($fullhd)): ?>
                                <source srcset="<?php echo esc_url($fullhdp[0]); ?>" media="(min-width: 1440px)">
                            <?php endif; if(!empty($ipad_pro)): ?>
                                <source srcset="<?php echo esc_url($ipad_pro[0]); ?>" media="(min-width: 1024px)">
                            <?php endif; if(!empty($ipad_air)): ?>
                                <source srcset="<?php echo esc_url($ipad_air[0]); ?>" media="(min-width: 820px)">
                            <?php endif; if(!empty($ipad_mini)): ?>
                                <source srcset="<?php echo esc_url($ipad_mini[0]); ?>" media="(min-width: 768px)">
                            <?php endif; if(!empty($small)): ?>
                                <source srcset="<?php echo esc_url($small[0]); ?>" media="(max-width: 767px)">
                            <?php endif; ?>
                            <img src="<?php echo esc_url($small[0]); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                        </picture>
                    </div>
                <?php  endforeach;  endif; ?>
            </div>
        <?php endif; ?>
        <?php echo !empty($description) ? "<div class=\"description\">$description</div>" : ''; ?>
    </div>
</div>