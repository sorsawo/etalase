<?php
if ( ! in_array( 'login-logo', etalasepress_get_setting_value( 'modules' ) ) ) {
    return;
}

function etalasepress_login_logo() {
    $image_id = get_theme_mod( 'etalasepress_login_image' );
    
    if ( empty( $image_id ) ) {
        return;
    }
    
    $image_src = wp_get_attachment_image_src( $image_id , 'full' );
    ?>
    <style type="text/css">
    .login h1 a {
        background-image: url(<?php echo esc_url( $image_src[0] ); ?>);
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center center;
        display: block;
        overflow: hidden;
        text-indent: -9999em;
        width: <?php echo $image_src[1] ?>px;
        height: <?php echo $image_src[2] ?>px;
    }
    p#backtoblog {
        display: none;
    }
    p#nav {
        text-align: center;
    }
    </style>
    <?php
}

add_action( 'login_head', 'etalasepress_login_logo' );

function etalasepress_login_header_url() {
    return esc_url( home_url() );
}

add_filter( 'login_headerurl', 'etalasepress_login_header_url' );
add_filter( 'login_headertext', '__return_empty_string' );