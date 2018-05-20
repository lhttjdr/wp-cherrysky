<?php get_header(); ?>

<div class="col-ms col-md-8 col-lg-9" id="main">
        <?php
        while ( have_posts() ) :
            the_post();
            get_template_part( 'tpl-parts/content', get_post_format() );

            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;
        endwhile;
        ?>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
