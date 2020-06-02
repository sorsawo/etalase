<?php
// Entry category in header
add_action( 'tha_entry_top', 'etalasepress_entry_category', 8 );

// Entry author in header
add_action( 'tha_entry_top', 'etalasepress_entry_author', 12 );

// Entry header share
function etalasepress_entry_header_share() {
    do_action( 'etalasepress_entry_header_share' );
}

add_action( 'tha_entry_top', 'etalasepress_entry_header_share', 13 );

// After Entry
function etalasepress_single_after_entry() {
    echo '<div class="after-entry">';
    etalasepress_breadcrumbs();
    echo '<p class="publish-date">Published on ' . get_the_date( 'F j, Y' ) . '</p>';
    do_action( 'etalasepress_entry_footer_share' );
}

add_action( 'tha_content_while_after', 'etalasepress_single_after_entry', 8 );

// Build the page
require get_template_directory() . '/index.php';
