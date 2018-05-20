<article class="post" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php cherrysky_post_thumbnail(); ?>
    <header<?php if ( is_sticky() ) : ?> class="sticky-post"<?php endif; ?>>
        <?php if ( is_sticky() ) : ?><span class="sticky"></span><?php endif; ?>
        <?php if ( !is_front_page() ) { ?>
        <nav class="navbar navbar-light navbar-expand-md">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarToggler">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
              <li class="nav-item">
                <a class="nav-link" href="<?php echo get_site_url();?>">
                  <i class="fas fa-home"></i>
                  <?php echo __("Home", "cherrysky"); ?>
                  <span>&raquo;</span>
                  <span class="sr-only">(current)</span>
                </a>
              </li>
              <?php
                $post=get_post();
                $current = $post->ID;
                $parent = $post->post_parent;
                $list=array();
                while($parent!=0){
                  $list[]=$parent;
                  $parent=get_post($parent)->post_parent;
                }
                $id_list=array_reverse($list);
                if(count($id_list) > 0) { // not top level
                  foreach($id_list as $id){
                    $title=get_the_title($id);
                    $url=get_permalink($id);
                    ?>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo $url;?>">
                    <i class="fas fa-folder-open"></i>
                    <?php echo $title;?>
                    <span>&raquo;</span>
                  </a>
                </li>
                    <?php
                  }
                }
                ?>
            </ul>
          </div>
        </nav>
      <?php } ?>
        <?php if ( is_singular() ) : ?>
            <h1 class="post-title"><?php the_title() ?></h1>
        <?php else : ?>
            <h2 class="post-title">
                <a href="<?php the_permalink(); ?>">
                    <?php the_title() ?>
                </a>
            </h2>
        <?php endif; ?>
    </header>
    <ul class="post-meta">
        <li><?php
        echo __('Publish', 'cherrysky') . ' : ';
        the_time( get_option( 'date_format' ) );
        echo "&nbsp;&nbsp;&nbsp;&nbsp;";
        echo __('Last Update', 'cherrysky'). ' : ';
        the_modified_time( get_option( 'date_format' ) );
        ?></li>
        <li><?php echo ( get_the_tag_list(' ', ', ') ); ?></li>
        <li class="comment-count">
            <?php comments_popup_link(
                __( 'No Comments', 'cherrysky' ),
                __( '1 Comments', 'cherrysky' ),
                __( '% Comments', 'cherrysky' )
            ); ?>
        </li>
    </ul>
    <div class="post-content">
        <?php
        the_content(
                sprintf(
                    __( 'Continue reading %s', 'cherrysky' ),
                    the_title( '<span class="screen-reader-text">', '</span>', false )
                )
        );
        wp_link_pages();
        ?>
    </div>
</article>
