<?php
/**
 * Template file for sidebar
 */
if ( is_active_sidebar( 'sidebar-primary' ) ) : ?>

<!--Sidebar Section-->

<div class="sidebar">

    <?php dynamic_sidebar( 'sidebar-primary' ); ?>	
    
</div>
	
<!--Sidebar Section-->

<?php endif; ?>