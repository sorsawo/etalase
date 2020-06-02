<?php
// Sets the path to the core framework directory.
define( 'ETALASEPRESS_DIR', trailingslashit( trailingslashit( get_template_directory() ) . basename( dirname( __FILE__ ) ) ) );

// General cleanup
include_once ETALASEPRESS_DIR . 'wordpress-cleanup.php';

// TGM Plugin Activation
include_once ETALASEPRESS_DIR . 'tgm-plugin-activation.php';

// Theme
include_once ETALASEPRESS_DIR . 'tha-theme-hooks.php';
include_once ETALASEPRESS_DIR . 'layout.php';
include_once ETALASEPRESS_DIR . 'helper-functions.php';
include_once ETALASEPRESS_DIR . 'navigation.php';
include_once ETALASEPRESS_DIR . 'loop.php';
include_once ETALASEPRESS_DIR . 'template-tags.php';
include_once ETALASEPRESS_DIR . 'site-footer.php';

// Functionality
include_once ETALASEPRESS_DIR . 'general.php';
include_once ETALASEPRESS_DIR . 'social-links.php';
include_once ETALASEPRESS_DIR . 'meta-boxes.php';
include_once ETALASEPRESS_DIR . 'customizer.php';


// Plugin Support
include_once ETALASEPRESS_DIR . 'amp.php';
include_once ETALASEPRESS_DIR . 'shared-counts.php';
include_once ETALASEPRESS_DIR . 'wpforms.php';
include_once ETALASEPRESS_DIR . 'easy-digital-downloads.php';
include_once ETALASEPRESS_DIR . 'woocommerce.php';