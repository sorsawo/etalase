<?php

function etalasepress_wpforms_match_button_block( $form_data ) {
    $form_data['settings']['submit_class'] .= ' wp-block-button__link';
    return $form_data;
}

add_filter( 'wpforms_frontend_form_data', 'etalasepress_wpforms_match_button_block' );
