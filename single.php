<?php
// Entry category in header
add_action( 'tha_entry_top', 'alamanda_entry_category', 8 );

// Entry author in header
add_action( 'tha_entry_top', 'alamanda_entry_author', 12 );

// Entry header share
function alamanda_entry_header_share() {
    do_action( 'alamanda_entry_header_share' );
}

add_action( 'tha_entry_top', 'alamanda_entry_header_share', 13 );

// After Entry
function alamanda_single_after_entry() {
    echo '<div class="after-entry">';
    alamanda_breadcrumbs();
    echo '<p class="publish-date">Published on ' . get_the_date( 'F j, Y' ) . '</p>';
    do_action( 'alamanda_entry_footer_share' );
}

add_action( 'tha_content_while_after', 'alamanda_single_after_entry', 8 );

// Build the page
require get_template_directory() . '/index.php';
