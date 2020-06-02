<?php
if ( ! in_array( 'custom-sidebar', etalasepress_get_setting_value( 'modules' ) ) ) {
    return;
}

function etalasepress_custom_sidebar_admin_init() {
    $sendback = remove_query_arg( array( '_wp_http_referer', '_wpnonce', 'action', 'category', 'add_new' ), wp_get_referer() );
    
    if ( isset( $_REQUEST['page'] ) && 'etalasepress-custom-sidebar' === $_REQUEST['page'] ) {
        if ( ! empty( $_POST['add_new_sidebar'] ) ) {
            
        } elseif ( ! empty( $_POST['save_sidebar'] ) && ! empty( $_GET['edit'] ) ) {
            
        } elseif ( ! empty( $_GET['delete'] ) ) {
            
        }
    }
}

add_action( 'admin_init', 'etalasepress_custom_sidebar_admin_init' );

function etalasepress_custom_sidebar_admin_menu() {
    add_theme_page( __( 'Custom Sidebars', 'etalasepress' ), __( 'Custom Sidebars', 'etalasepress' ), 'manage_options', 'etalasepress-custom-sidebar', 'etalasepress_custom_sidebar_page' );
}

add_action( 'admin_menu', 'etalasepress_custom_sidebar_admin_menu' );

function etalasepress_custom_sidebar_page() {
    $custom_sidebars = ( array ) get_option( 'etalasepress_custom_sidebars', array() );
    
    if ( ! empty( $_GET['edit'] ) ) {
        $sidebar_id = sanitize_text_field( $_GET['edit'] );
        $current_sidebar = $custom_sidebars[$sidebar_id];
    }
    ?>
    <div class="wrap">
        <h2><?php _e( 'Custom Sidebars', 'etalasepress' );?></h2>
        <?php if ( ! empty( $_GET['edit'] ) ): ?>
        <form method="post" action="<?php echo admin_url( 'themes.php?page=etalasepress-custom-sidebar&amp;edit=' . $sidebar_id ); ?>">
			<?php wp_nonce_field( 'sidebar_edit' ); ?>
            <input name="edit_sidebar[id]" type="hidden" value="<?php echo esc_html( $sidebar_id ); ?>" />
			<table class="form-table">
                <tr>
					<th scope="row"><label for="name"><?php _e( 'Name', 'etalasepress' ); ?></label></th>
                    <td><input id="name" type="text" name="edit_sidebar[name]" value="<?php echo esc_html( $sidebar['name'] ) ?>" class="regular-text"></td>
				</tr>
                <tr>
					<th scope="row"><label for="description"><?php _e( 'Description', 'etalasepress' ); ?></label></th>
                    <td><textarea id="description" name="edit_sidebar[description]" rows="5" cols="40" class="regular-text"><?php echo esc_html( $sidebar['description'] ) ?></textarea></td>
				</tr>
			</table>
			<p class="submit"><input type="submit" class="button-primary" name="save_sidebar" value="<?php _e( 'Update', 'etalasepress' ); ?>" /></p>
		</form>
        <?php else: ?>
        <div id="col-container">
			<div id="col-right">
				<div class="col-wrap">
					<h3><?php _e( 'Available Custom Sidebars', 'etalasepress' ); ?></h3>
					<table class="wp-list-table widefat fixed striped">
						<thead>
							<tr>
                                <th scope="col" class="column-name"><?php _e( 'Name', 'etalasepress' ); ?></th>
                                <th scope="col" class="column-desc"><?php _e( 'Description', 'etalasepress' ); ?></th>
                                <th scope="col" class="column-id"><?php _e( 'ID', 'etalasepress' ); ?></th>
							</tr>
						</thead>
						<tfoot>
							<tr>
                                <th scope="col" class="column-name"><?php _e( 'Name', 'etalasepress' ); ?></th>
                                <th scope="col" class="column-desc"><?php _e( 'Description', 'etalasepress' ); ?></th>
                                <th scope="col" class="column-id"><?php _e( 'ID', 'etalasepress' ); ?></th>
							</tr>
						</tfoot>
						<tbody id="the-list">	
                            <?php if ( empty( $custom_sidebars ) ): ?>
                            <tr class="no-items"><td colspan="3" class="colspanchange"><?php echo __( 'No sidebars found.', 'etalasepress' ) ?></td></tr>
                            <?php else: ?>
                            <?php $alt = true; 
                            foreach ( $custom_sidebars as $id => $sidebar ): 
                            ?>
                        	<tr <?php if ( $alt ) { echo 'class="alternate"'; $alt = false; } else { $alt = true; } ?>>
								<td class="column-name">
                                <?php printf( '<a class="row-title" href="%s" title="Edit %s">%s</a>', admin_url( 'themes.php?page=etalasepress-custom-sidebar&amp;edit=' . esc_html( $id ) ), esc_html( $sidebar['name'] ), esc_html( $sidebar['name'] ) ); ?>	
                                <br />
								<div class="row-actions">
									<span class="edit"><a
										href="<?php echo admin_url( 'themes.php?page=etalasepress-custom-sidebar&amp;edit=' . esc_html( $id ) ); ?>"><?php _e('Edit', 'etalasepress'); ?></a>
										| </span> <span class="delete"><a class="delete-tag"
										href="<?php echo wp_nonce_url( admin_url( 'themes.php?page=etalasepress-custom-sidebar&amp;delete=' . esc_html( $id ) ), 'sidebar_delete' ); ?>"><?php _e( 'Delete', 'etalasepress' ); ?></a></span>
								</div>
                            	</td>
                                <td class="column-desc"><?php echo esc_html( $sidebar['description'] ); ?></td>
                                <td class="column-id"><?php echo esc_html( $id ); ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif ?>
                    	</tbody>
					</table>
				</div>
			</div>
			<!-- /col-right -->
			<div id="col-left">
				<div class="col-wrap">
					<div class="form-wrap">
						<h3><?php _e( 'Add Custom Sidebar', 'etalasepress' ); ?></h3>
						<form method="post" action="<?php echo admin_url( 'themes.php?page=etalasepress-custom-sidebar' ); ?>">
                            <?php wp_nonce_field( 'sidebar_create' ); ?>	
                            <div class="form-field form-required">
                                <label for="name"><?php _e( 'Name', 'etalasepress' ); ?></label> 
                                <input id="name" type="text" name="new_sidebar[name]" value="">
							</div>
                            <div class="form-field form-required">
                                <label for="id"><?php _e( 'ID', 'etalasepress' ); ?></label> 
                                <input id="id" type="text" name="new_sidebar[id]" value="">
							</div>
                            <div class="form-field form-required">
                                <label for="description"><?php _e( 'Description', 'etalasepress' ); ?></label> 
                                <textarea id="description" name="new_sidebar[description]" rows="5" cols="40"></textarea>
							</div>
							<p class="submit">
								<input type="submit" class="button button-primary" name="add_new_sidebar" id="submit" value="<?php _e( 'Add Sidebar', 'etalasepress' ); ?>" />
							</p>
						</form>
					</div>
				</div>
			</div>
			<!-- /col-left -->
		</div>
        <?php endif ?>
    </div>
    <?php
}