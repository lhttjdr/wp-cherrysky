<?php get_header(); ?>

<div class="col-ms col-md-8 col-lg-9" id="main">
        <?php if ( have_posts() ) : ?>
            <header>
                <h1 class="archive-title">
                    <?php printf( __( 'Search Results for: %s', 'cherrysky' ), get_search_query() ); ?>
                </h1>
            </header>
            <?php
            while ( have_posts() ) :
                the_post();
                get_template_part( 'tpl-parts/content', get_post_format() );
            endwhile;

            the_posts_pagination( array(
                'prev_text'             => __( 'Previous', 'cherrysky' ),
                'next_text'             => __( 'Next', 'cherrysky' ),
                'screen_reader_text'    => ' ',
                'type'                  => 'list',
            ) );
            ?>
        <?php else : ?>
            <?php get_template_part( 'tpl-parts/content', 'none' ); ?>

        <?php endif; ?>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
