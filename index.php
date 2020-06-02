<?php
get_header();

tha_content_before();

echo '<div class="' . alamanda_class( 'content-area', 'wrap', apply_filters( 'alamanda_content_area_wrap', true ) ) . '">';
tha_content_wrap_before();
echo '<main class="site-main" role="main">';
tha_content_top();
tha_content_loop();
tha_content_bottom();
echo '</main>';
get_sidebar();
tha_content_wrap_after();
echo '</div>';
tha_content_after();

get_footer();
