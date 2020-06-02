<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label>
        <span class="screen-reader-text"><?php echo __( 'Search for', 'etalasepress' ) ?></span>
        <input type="search" class="search-field" placeholder="<?php echo __( 'Search', 'etalasepress' ) ?>&hellip;" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo __( 'Search for', 'etalasepress' ) ?>" />
    </label>
    <button type="submit" class="search-submit"><?php echo etalasepress_icon( array( 'icon' => 'search', 'title' => __( 'Submit', 'etalasepress' ) ) ); ?></button>
</form>
