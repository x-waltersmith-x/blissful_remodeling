<?php 
/**
 * Service Areas Block Template.
 * 
 */

$id = 'areas-' . $block['id'];
$classes = !empty($block['className']) ? 'areas ' . $block['className'] : 'areas';
   
?>
<div id="<?php echo esc_attr($id);?>" class="<?php echo esc_attr($classes); ?>">

</div>