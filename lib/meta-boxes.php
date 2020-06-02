<?php
function alamanda_add_meta_boxes() {
    add_meta_box( 'alamanda-page-settings', __( 'Alamanda Page Settings', 'alamanda' ), 'alamanda_add_page_settings_meta_box', 'page', 'normal', 'high' );
}

add_action( 'add_meta_boxes', 'alamanda_add_meta_boxes', 30 );
    
function alamanda_add_page_settings_meta_box( $post, $box ) {
    $layout_setting  = get_post_meta( $post->ID, '_alamanda_page_layout', true );
    
    $layout_options = array(
        'content-sidebar'    => __( 'Content - Sidebar', 'alamanda' ),
        'sidebar-content'    => __( 'Sidebar - Content', 'alamanda' ),
        'content'            => __( 'Content - No Sidebar', 'alamanda' ),
        'full-width-content' => __( 'Full Width Content', 'alamanda' ),
    );

    wp_nonce_field( 'alamanda_save_meta_boxes', 'alamanda_nonce' );
    ?>
    <table class="form-table">
        <tr valign="top">
            <th scope="row" class="titledesc"><?php echo esc_html__( 'Page Layout', 'alamanda' ) ?></th>
            <td class="forminp">
                <select name="page_layout">
                    <option value=""><?php echo __( 'Default Layout', 'alamanda' ) ?></option>
                    <?php foreach ( $layout_options as $layout => $label ): ?>
                    <option <?php selected( $layout_setting, $layout ) ?> value="<?php echo $layout ?>"><?php echo $label ?></option>
                    <?php endforeach ?>
                </select>
            </td>
        </tr>
    </table>
    <?php
    do_action( 'alamanda_add_page_settings_metabox' );
}
    
function alamanda_save_meta_boxes( $post_id, $post ) {
    if ( empty( $post_id ) || empty( $post ) ) {
        return;
    }

    // Dont' save meta boxes for revisions or autosaves
    if ( defined( 'DOING_AUTOSAVE' ) || is_int( wp_is_post_revision( $post ) ) || is_int( wp_is_post_autosave( $post ) ) ) {
        return;
    }

    // Check the post being saved == the $post_id to prevent triggering this call for other save_post events
    if ( empty( $_POST['post_ID'] ) || $_POST['post_ID'] != $post_id ) {
        return;
    }

    // Check user has permission to edit
    if ( !current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Check the nonce
    if ( empty( $_POST['alamanda_nonce'] ) || !wp_verify_nonce( $_POST['alamanda_nonce'], 'alamanda_save_meta_boxes' ) ) {
        return;
    }

    if ( isset( $_POST['page_layout'] ) ) {
        update_post_meta( $post_id, '_alamanda_page_layout', sanitize_text_field( $_POST['page_layout'] ) );
    }
    
    do_action( 'alamanda_save_page_settings_metabox' );
}

add_action( 'save_post', 'alamanda_save_meta_boxes', 1, 2 );