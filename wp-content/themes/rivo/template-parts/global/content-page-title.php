<div class="page-header <?php echo (get_field("ph-type")) ?  get_field("ph-type") : "dark"; ?>">
    <div class="container">
       <?php 
            /** BREADCRUMBS */
            rivo_breadcrumbs(); 

            /** TITLE */
            the_title("<h1>", "</h1>");

            /** SHORT DESCRIPTION */
            if(get_field("ph-description")) {
                echo '<div class="description">';
                    the_field("ph-description");
                echo '</div>';
            }
        ?>
    </div>
</div>