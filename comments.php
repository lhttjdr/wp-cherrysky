<?php if ( post_password_required() ) {
    return;
} ?>

<div id="comments">
    <?php if ( have_comments() ) : ?>
        <h3>
            <?php comments_popup_link(
                __( 'No Comments', 'cherrysky' ),
                __( '1 Comments', 'cherrysky' ),
                __( '% Comments', 'cherrysky' )
            ); ?>
        </h3>

        <?php cherrysky_comments_pagination( array(
            'prev_text'             => __( 'Previous', 'cherrysky' ),
            'next_text'             => __( 'Next', 'cherrysky' ),
            'screen_reader_text'    => ' ',
            'type'                  => 'list',
        ) ); ?>

        <ol class="comment-list">
            <?php
                wp_list_comments( array(
                    'type'      => 'comment'
                ) );
            ?>
        </ol>

        <?php cherrysky_comments_pagination( array(
            'prev_text'             => __( 'Previous', 'cherrysky' ),
            'next_text'             => __( 'Next', 'cherrysky' ),
            'screen_reader_text'    => ' ',
            'type'                  => 'list',
        ) ); ?>
    <?php endif; ?>

    <?php comment_form( array(
        'id_form'           => 'comment-form',
        'submit_button'     => '<button name="%1$s" type="submit" id="%2$s" class="%3$s">%4$s</button>'
    ) ) ?>
</div>
