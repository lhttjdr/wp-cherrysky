<?php
/**
 * Display comments pagination.
 *
 * @param array $args
 */
function cherrysky_comments_pagination( $args = array() ) {
    echo get_cherrysky_comments_pagination( $args );
}

/**
 * Get comments pagination.
 *
 * @param array $args
 * @return string
 *
 * @see get_the_comments_pagination()
 */
function get_cherrysky_comments_pagination( $args = array() ) {
    $navigation = '';
    $links = paginate_comments_links( $args );
    if ( $links ) {
        $navigation = _navigation_markup( $links, 'comments-pagination', $args['screen_reader_text'] );
    }
    return $navigation;
}


function cherrysky_post_thumbnail() {
    if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
        return;
    } ?>

    <div class="post-thumbnail">
        <?php the_post_thumbnail(); ?>
    </div>

<?php }
