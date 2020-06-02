<?php
// Sets the framework version number.
define( 'ALAMANDA_VERSION', '1.0.0' );

// Sets the path to the core framework directory.
define( 'ALAMANDA_DIR', trailingslashit( trailingslashit( get_template_directory() ) . basename( dirname( __FILE__ ) ) ) );

// General cleanup
include_once ALAMANDA_DIR . 'wordpress-cleanup.php';

// TGM Plugin Activation
include_once ALAMANDA_DIR . 'tgm-plugin-activation.php';

// Theme
include_once ALAMANDA_DIR . 'tha-theme-hooks.php';
include_once ALAMANDA_DIR . 'layout.php';
include_once ALAMANDA_DIR . 'helper-functions.php';
include_once ALAMANDA_DIR . 'navigation.php';
include_once ALAMANDA_DIR . 'loop.php';
include_once ALAMANDA_DIR . 'template-tags.php';
include_once ALAMANDA_DIR . 'site-footer.php';

// Functionality
include_once ALAMANDA_DIR . 'general.php';
include_once ALAMANDA_DIR . 'social-links.php';
include_once ALAMANDA_DIR . 'meta-boxes.php';
include_once ALAMANDA_DIR . 'customizer.php';
include_once ALAMANDA_DIR . 'update-check.php';
include_once ALAMANDA_DIR . 'google-analytics.php';
include_once ALAMANDA_DIR . 'settings.php';

// Modules
include_once ALAMANDA_DIR . 'login-logo.php';
include_once ALAMANDA_DIR . 'custom-sidebar.php';
include_once ALAMANDA_DIR . 'custom-label.php';
include_once ALAMANDA_DIR . 'mega-menu.php';
include_once ALAMANDA_DIR . 'post-type-layout.php';
include_once ALAMANDA_DIR . 'easy-digital-downloads.php';
include_once ALAMANDA_DIR . 'woocommerce.php';

// Plugin Support
include_once ALAMANDA_DIR . 'amp.php';
include_once ALAMANDA_DIR . 'shared-counts.php';
include_once ALAMANDA_DIR . 'wpforms.php';