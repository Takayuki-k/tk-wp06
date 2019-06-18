<?php get_sidebar(); ?>
    </main>
    <aside class="col-md-4">
      <?php if ( is_active_sidebar( 'sidebar' ) ) :
        dynamic_sidebar( 'sidebar' );
        endif; ?>
    </aside>