<?php
// Breadcrumbs above page title
add_action( 'tha_entry_top', 'etalasepress_breadcrumbs', 8 );

// Build the page
require get_template_directory() . '/index.php';
