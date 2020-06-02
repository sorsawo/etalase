<?php
if ( post_password_required() ) {
    return;
}
?>

<?php tha_comments_before(); ?>

<div id="comments" class="entry-comments">

    <?php if ( have_comments() ): ?>
    
    <h2 class="comments-title"><?php _e( 'Comments', 'alamanda' ); ?></h2>

    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through?  ?>

    <nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
        <h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'alamanda' ); ?></h2>
        <div class="nav-links">
            <div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'alamanda' ) ); ?></div>
            <div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'alamanda' ) ); ?></div>
        </div><!-- .nav-links -->
    </nav><!-- #comment-nav-above -->

    <?php endif; // Check for comment navigation.  ?>

    <ol class="comment-list">
        <?php
        wp_list_comments( array(
            'style' => 'ol',
            'short_ping' => true,
        ) );
        ?>
    </ol><!-- .comment-list -->

    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through?  ?>

    <nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
        <h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'alamanda' ); ?></h2>
        <div class="nav-links">
            <div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'alamanda' ) ); ?></div>
            <div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'alamanda' ) ); ?></div>
        </div><!-- .nav-links -->
    </nav><!-- #comment-nav-below -->

    <?php
    endif; // Check for comment navigation.

    endif; // Check for have_comments().
    
    // If comments are closed and there are comments, let's leave a little note, shall we?
    if ( !comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
        ?>
        <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'alamanda' ); ?></p>
        <?php
    endif;

    comment_form();
    ?>

</div><!-- #comments -->

<?php tha_comments_after(); ?>
