<?php
/*
Template Name: Detailed HomePage
*/

get_header(); ?>

<div class="col-ms col-md-8 col-lg-9" id="main">
<article class="post notitle" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="post-content">
        <?php
          the_content(
                sprintf(
                    __( 'Continue reading %s', 'cherrysky' ),
                    the_title( '<span class="screen-reader-text">', '</span>', false )
                )
          );
          wp_link_pages();

          $cur_page = get_query_var( 'page', 1 );
          $page_size = get_option('posts_per_page');
          $offset = ($cur_page-1)*$page_size;

          $frontpage_id = get_option( 'page_on_front' );

          global $wpdb;
          $sql = "SELECT *
        	FROM $wpdb->posts AS a
        	WHERE
                post_type = 'page'
                AND ID <> $frontpage_id
                AND ID NOT in
                (
                    SELECT post_parent
                    FROM $wpdb->posts
                    WHERE post_type = 'page'
                        AND post_parent <> 0
                )
                AND 0 <> post_parent
                AND 0 <> (
                  SELECT post_parent
                  FROM $wpdb->posts
                  WHERE post_type = 'page'
                      AND ID=a.post_parent
                )
                AND post_status = 'publish'
                ORDER BY post_modified DESC
                LIMIT $page_size
                OFFSET $offset;";

            $query=$wpdb->get_results($sql);

            if(count($query)>0){
                foreach($query as $page){
                    $post=get_post($page->ID);
                    $current=$page;
                    $parent = $post->post_parent;
            	      $list=array();
            	      while($parent!=0){
                        $list[]=$parent;
              	        $parent=get_post($parent)->post_parent;
                    }
                    $id_list=array_reverse($list);
                    ?>
                       <div class="page-card">
                         <div class="location">
                           <?php
					             if (is_array($id_list) || is_object($id_list)) { 
                           foreach($id_list as $id){
              	               $title=get_the_title($id);
              	               $url=get_permalink($id);
                           ?>
              	               <a href="<?php echo $url;?>">
                                 <i class="fas fa-folder-open"></i>
                                 <?php echo $title;
                                     if($id!=$page){
                                 ?>
                                      <span> &raquo; </span>
                                <?php
                                     }
                                ?>
        		                    </a>&nbsp;
                           <?php
            	             }}
                           ?>
                        </div>

                     <h2 id="<?php echo $page->post_title; ?>" class="nonumber noindex">
                         <i class="far fa-file-alt"></i>
						         <a href="<?php echo get_permalink($page->ID);?>">
                         <?php echo $page->post_title;?>
                       </a>
                     </h2>
                     <p><?php echo cherrysky_get_content($page);?></p>
							  <?php $tags = get_the_tags($page->ID); ?>
                     <div class="post_tags">
						        <?php
                       foreach ( $tags as $tag ) {
	                       $tag_link = get_tag_link( $tag->term_id );
						         ?>
			                  <a href='<?php echo $tag_link;?>' title='<?php echo $tag->name;?>' class='<?php echo $tag->slug;?>'>
	                        <?php echo $tag->name; ?>
						           </a>
						       <?php
                       }
					          ?>
                     </div>
                     <div class="page-info">
                       <?php
                       $create=strtotime($page->post_date);
                       $modified=strtotime($page->post_modified);
                       ?>
                       <div class="modeified-date <?php if($modified+7*24*60*60 > time()) echo "hot";?>">
                         <i class="far fa-calendar-check"></i>
                         <?php
                          echo sprintf(
                           __( 'Update: %s', 'cherrysky' ),
                          date('Y.m.d', $modified)
                        );
                        ?>
                      </div>
                       <div class="create-date">
                          <i class="far fa-calendar-plus"></i>
                          <?php
                          echo sprintf(
                           __( 'Publish: %s', 'cherrysky' ),
                          date('Y.m.d', $create )
                        );
                        ?>
                      </div>
                         <div style="clear:both;"></div>
                     </div>
                </div>
                <?php
              }// end page
            }// end page set
            ?>
            <?php // paginate
                $sql1="SELECT COUNT(*)
                FROM $wpdb->posts AS a
                WHERE
                      post_type = 'page'
                      AND ID <> $frontpage_id
                      AND ID NOT in
                      (
                          SELECT post_parent
                          FROM $wpdb->posts
                          WHERE post_type = 'page'
                              AND post_parent <> 0
                      )
                      AND 0 <> post_parent
                      AND 0 <> (
                        SELECT post_parent
                        FROM $wpdb->posts
                        WHERE post_type = 'page'
                            AND ID=a.post_parent
                      )
                      AND post_status = 'publish';";
                $max_num_pages = $wpdb->get_var($sql1);
                $max_num_pages = (int)ceil((float)$max_num_pages/(float)$page_size);
                $pages = paginate_links( [
                    'base'         => site_url().'/?page=%#%',
                    'format'       => '?page=%#%',
                    'current'      => $cur_page,
                    'total'        => $max_num_pages,
                    'type'         => 'array',
                    'show_all'     => false,
                    'end_size'     => 3,
                    'mid_size'     => 1,
                    'prev_next'    => true,
                    'prev_text'    => __( '« Prev' ),
                    'next_text'    => __( 'Next »' ),
                    'add_args'     => false,
                    'add_fragment' => ''
                  ]
                );

                if ( is_array( $pages ) ) {
                  $pagination = '<div class="pagination"><ul class="pagination">';
                  foreach ( $pages as $page ) {
                    $pagination .= '<li class="page-item"> ' . str_replace( 'page-numbers', 'page-link', $page ) . '</li>';
                  }
                  $pagination .= '</ul></div>';
                  echo $pagination;
                }
            ?>
    </div>
</article>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
