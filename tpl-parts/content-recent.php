<article class="post" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php cherrysky_post_thumbnail(); ?>
    <header<?php if ( is_sticky() ) : ?> class="sticky-post"<?php endif; ?>>
        <?php if ( is_sticky() ) : ?><span class="sticky"></span><?php endif; ?>
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
    <div class="post-content">
        <?php
          the_content(
                sprintf(
                    __( 'Continue reading %s', 'cherrysky' ),
                    the_title( '<span class="screen-reader-text">', '</span>', false )
                )
          );
          wp_link_pages();

          $posts = 20;

          global $wpdb;
          $sql = "SELECT *
        	FROM $wpdb->posts
        	WHERE
                post_type = 'page' AND ID NOT in
                (
                    SELECT ID
                    FROM $wpdb->posts
                    WHERE
                        post_type = 'page' AND ID in
                        (
                            SELECT post_parent
                            FROM $wpdb->posts
                            WHERE post_type = 'page'
                        )
                ) AND post_status = 'publish'
             	ORDER BY post_modified DESC
             	LIMIT $posts;";

            $query=$wpdb->get_results($sql);
            $frontpage_id = get_option( 'page_on_front' );

            $return_string = $content?'<h3>'.$content.'</h3>':'';
            $return_string .= '<ul>';
            if(count($query)>0){
                foreach($query as $page){
                    if($frontpage_id==$page->ID) continue;
                    $post=get_post($page->ID);
                    $current=$page;
                    $parent = $post->post_parent;
            	    $list=array($page);
            	    while($parent!=0){
                        $list[]=$parent;
              	        $parent=get_post($parent)->post_parent;
                   }
                   if(count($list)<=2) continue;
                   $id_list=array_reverse($list);
                   if(count($id_list)>0){
                       $return_string .= '<li>';
                       $create=strtotime($page->post_date);
                       $modified=strtotime($page->post_modified);
                       if( $modified> $create+10800 ){
                           $return_string.="<span style=\"color:#228B22\"> [";
                           $return_string.=sprintf(
                             __( 'Update: %s', 'cherrysky' ),
                            date('Y.m.d', $modified)
                          );
                          $return_string.="]</span>&nbsp;";
                       }else{
                           $return_string.="<span style=\"color:#FF6347\"> [";
                           $return_string.=sprintf(
                             __( 'Publish: %s', 'cherrysky' ),
                            date('Y.m.d', $create )
                          );
                           $return_string.="]</span>&nbsp;";
                       }
                       foreach($id_list as $id){
              	           $title=get_the_title($id);
              	           $url=get_permalink($id);
              	           $return_string.="<a href=\"$url\">$title";
                           if($id==$page){

                           }else{
                             $return_string.="<span> &raquo; </span>";
                           }
        		               $return_string.="</a>&nbsp;";
            	       }
           	       $return_string.='</li>';
                   }
                }
            }

           $return_string .= '</ul>';
           echo $return_string;
        ?>
    </div>
</article>
