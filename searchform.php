<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label>
        <span class="screen-reader-text"><?php echo __( 'Search for', 'alamanda' ) ?></span>
        <input type="search" class="search-field" placeholder="<?php echo __( 'Search', 'alamanda' ) ?>&hellip;" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo __( 'Search for', 'alamanda' ) ?>" />
    </label>
    <button type="submit" class="search-submit"><?php echo alamanda_icon( array( 'icon' => 'search', 'title' => __( 'Submit', 'alamanda' ) ) ); ?></button>
</form>
