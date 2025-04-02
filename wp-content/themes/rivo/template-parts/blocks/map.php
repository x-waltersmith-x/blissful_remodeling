<?php 
/**
 * Google Map Block Template.
 */
$blockname = pathinfo(__FILE__, PATHINFO_FILENAME);
$id = $blockname. '-' . $block['id'];
$classes = !empty($block['className']) ? $blockname.'-block ' . $block['className'] : $blockname.'-block';

   
?>
<div id="<?php echo esc_attr($id);?>" class="<?php echo esc_attr($classes); ?>">

</div>