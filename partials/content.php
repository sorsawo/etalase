<?php
echo '<article class="' . join( ' ', get_post_class() ) . '">';

if ( etalasepress_has_action( 'tha_entry_top' ) ) {
    echo '<header class="entry-header">';
    tha_entry_top();
    echo '</header>';
}

echo '<div class="entry-content">';
tha_entry_content_before();

the_content();

wp_link_pages( array(
    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'etalasepress' ),
    'after' => '</div>',
) );

tha_entry_content_after();
echo '</div>';

if ( etalasepress_has_action( 'tha_entry_bottom' ) ) {
    echo '<footer class="entry-footer">';
    tha_entry_bottom();
    echo '</footer>';
}

echo '</article>';
