<?php

function alamanda_entry_category() {
    $term = alamanda_first_term();
    
    if ( !empty( $term ) && !is_wp_error( $term ) ) {
        echo '<p class="entry-category"><a href="' . get_term_link( $term, 'category' ) . '">' . $term->name . '</a></p>';
    }
}

function alamanda_entry_tags() {
    $tags = get_the_tag_list();
    
    if ( !$tags ) {
        return;
    }
    
    printf( '<p class="entry-tags">%s</p>', $tags );
}

function alamanda_post_summary_title() {
    global $wp_query;
    $tag = ( is_singular() || -1 === $wp_query->current_post ) ? 'h3' : 'h2';
    echo '<' . $tag . ' class="post-summary__title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></' . $tag . '>';
}

function alamanda_post_summary_image( $size = 'thumbnail_medium' ) {
    echo '<a class="post-summary__image" href="' . get_permalink() . '" tabindex="-1" aria-hidden="true">' . wp_get_attachment_image( alamanda_entry_image_id(), $size ) . '</a>';
}

function alamanda_entry_image_id() {
    return has_post_thumbnail() ? get_post_thumbnail_id() : get_option( 'options_alamanda_default_image' );
}

function alamanda_entry_author() {
    $id = get_the_author_meta( 'ID' );
    echo '<p class="entry-author"><a href="' . get_author_posts_url( $id ) . '" aria-hidden="true" tabindex="-1">' . get_avatar( $id, 40 ) . '</a><em>by</em> <a href="' . get_author_posts_url( $id ) . '">' . get_the_author() . '</a></p>';
}
