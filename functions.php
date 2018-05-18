<?php

require_once( get_template_directory() . '/inc/toc.php' );

if ( ! isset( $content_width ) ) {
    $content_width = 900;
}

if ( ! function_exists( 'cherrysky_setup' ) ) :

    /**
     * Sets up theme defaults and registers support for various WordPress features.
     */
    function cherrysky_setup() {
        load_theme_textdomain( 'cherrysky', get_template_directory() . '/languages' );

        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        // Let WordPress manage the document title.
        add_theme_support( 'title-tag' );

        // Switch default core markup for search form, comment form, and comments to output valid HTML5.
        add_theme_support( 'html5', array(
            'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
        ) );

        // Enable support for Post Thumbnails on posts and pages.
        add_theme_support( 'post-thumbnails' );
        set_post_thumbnail_size( 800, 500, true );

        // Enable support for background image
        add_theme_support( 'custom-background' );

        // Enable support for Post Formats.
        add_theme_support( 'post-formats', array(
            'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
        ) );

        // This theme styles the visual editor to resemble the theme style.
        add_editor_style( 'css/editor-style.css' );

        // Use wp_nav_menu() in one location.
        register_nav_menus( array(
            'primary' => __( 'Primary Menu', 'cherrysky' )
        ) );
    }
endif;
add_action( 'after_setup_theme', 'cherrysky_setup' );

/**
 * Register widget area.
 */
function cherrysky_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Widget Area', 'cherrysky' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Add widgets here to appear in your sidebar.', 'cherrysky' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
    register_widget('TOC');
}
add_action( 'widgets_init', 'cherrysky_widgets_init' );

/**
 * Enqueue scripts.
 */
function cherrysky_scripts() {
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
    global $post;
    $cdn=true;
    if($cdn==true){
      $dep = ['jquery'];
      wp_enqueue_script( 'bootstrap',  'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js', array(), '4.0.0', true );
      $dep[] = "bootstrap";
      if (is_page_template('page-detailed-homepage.php') || (get_post_meta($post->ID,'tjdr1235813_enable_markdown',true) && preg_match("/`{3,}/m", $post->post_content))) {
        wp_enqueue_script( 'highlight.js', 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js', array(), '9.12.0', true );
		   wp_enqueue_script( 'highlight-line-number.js', get_template_directory_uri() . '/js/highlightjs-line-numbers.js/dist/highlightjs-line-numbers.min.js', array(), '2.1.0', true );
        $dep[]="highlight.js";
        $dep[]="highlight-line-number.js";
	    }
		 if (is_page_template('page-detailed-homepage.php') || (get_post_meta($post->ID,'tjdr1235813_enable_markdown',true) && preg_match("/`{3,}haskell/m", $post->post_content))) {
        wp_enqueue_script( 'highlight.haskell.js', 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/languages/haskell.min.js', array(), '9.12.0', true );
			$dep[]="highlight.haskell.js";
		 }
		 if (is_page_template('page-detailed-homepage.php') || (get_post_meta($post->ID,'tjdr1235813_enable_markdown',true) && preg_match("/`{3,}bnf/m", $post->post_content))) {
		   wp_enqueue_script( 'highlight.bnf.js', 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/languages/bnf.min.js', array(), '9.12.0', true );
		   $dep[]="highlight.bnf.js";
		 }
		 if (is_page_template('page-detailed-homepage.php') || (get_post_meta($post->ID,'tjdr1235813_enable_markdown',true) && preg_match("/`{3,}prolog/m", $post->post_content))) {
			 wp_enqueue_script( 'highlight.prolog.js', 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/languages/prolog.min.js', array(), '9.12.0', true );
		   $dep[]="highlight.prolog.js";
	    }

      wp_enqueue_script( 'mathjax-config', get_template_directory_uri() . '/js/mathjax-config.js', array(), '1.0.0', true );
      wp_enqueue_script( 'mathjax', 'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.2/MathJax.js?config=TeX-MML-AM_CHTML',array('mathjax-config'), '2.7.2', true );
      $dep[]="mathjax";

      if(is_singular() && preg_match("/\*{3,}pseudocode\*{3,}/m", $post->post_content)){
        wp_enqueue_script( 'pseudocode.js', get_template_directory_uri() . '/js/pseudocode.js/pseudocode.js', array(), '1.1.0', true );
        $dep[]="pseudocode.js";
      }
      if(is_singular() && preg_match("/\*{3,}mermaid\*{3,}/m", $post->post_content)){
        wp_enqueue_script( 'mermaid', 'https://cdnjs.cloudflare.com/ajax/libs/mermaid/7.1.2/mermaid.min.js', array(), '7.1.2', true );
        $dep[]="mermaid";
      }
      wp_enqueue_script( 'tocbot',  'https://cdnjs.cloudflare.com/ajax/libs/tocbot/4.3.0/tocbot.min.js', array(), '4.3.0', true );
      $dep[]="tocbot";
      if(is_singular() && preg_match("/\*{3,}plotly-\{.+\}\*{3,}/m", $post->post_content)){
        wp_enqueue_script( 'plotly',  'https://cdn.plot.ly/plotly-latest.min.js', array(), '', true );
        $dep[]="plotly";
      }
      if(is_singular() && preg_match("/\*{3,}graphviz-.+-\{.+\}\*{3,}/m", $post->post_content)){
        wp_enqueue_script( 'viz',  'https://cdnjs.cloudflare.com/ajax/libs/viz.js/1.8.1/viz.js', array(), '', true );
        $dep[]="viz";
      }
      if(is_singular() && preg_match("/\*{3,}vis-\{.+\}\*{3,}/m", $post->post_content)){
        wp_enqueue_script( 'vis',  'https://cdnjs.cloudflare.com/ajax/libs/vis/4.21.0/vis.min.js', array(), '4.21.0', true );
        $dep[]="vis";
      }
		if (is_page_template('page-detailed-homepage.php') || (get_post_meta($post->ID,'tjdr1235813_enable_markdown',true) && preg_match("/\*{3,}console\s*>>(.*)<<\s*\*{3,}/m", $post->post_content))) {
			wp_enqueue_script( 'console',  get_template_directory_uri() . '/js/console/osx.js', array('jquery'), '1.0', true );
      }
      wp_enqueue_script( 'init', get_template_directory_uri() . '/js/init.js', $dep, '1.0.0', true );
    }else{
      $dep = ['jquery'];
      wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/css/bootstrap/js/bootstrap.min.js', array(), '4.0.0', true );
      $dep[] = "bootstrap";
      if (is_singular() && preg_match("/`{3,}/m", $post->post_content)) {
        wp_enqueue_script( 'highlight.js', get_template_directory_uri() . '/js/highlight/highlight.pack.js', array(), '9.12.0', true );
        wp_enqueue_script( 'highlight-line-number.js', get_template_directory_uri() . '/js/highlightjs-line-numbers.js/dist/highlightjs-line-numbers.min.js', array(), '2.1.0', true );
        $dep[]="highlight.js";
        $dep[]="highlight-line-number.js";
      }
      wp_enqueue_script( 'mathjax-config', get_template_directory_uri() . '/js/mathjax-config.js', array(), '1.0.0', true );
      wp_enqueue_script( 'mathjax', get_template_directory_uri() . '/js/MathJax/MathJax.js?config=TeX-MML-AM_CHTML', array('mathjax-config'), '2.7.3', true );
      $dep[]="mathjax";

      if(is_singular() && preg_match("/\*{3,}mermaid\*{3,}/m", $post->post_content)){
        wp_enqueue_script( 'mermaid', get_template_directory_uri() . '/js/mermaid/mermaidAPI.min.js', array(), '7.0.0', true );
        $dep[]="mermaid";
      }
      if(is_singular() && preg_match("/\*{3,}pseudocode\*{3,}/m", $post->post_content)){
       wp_enqueue_script( 'pseudocode.js', get_template_directory_uri() . '/js/pseudocode.js/pseudocode.js', array(), '1.1.0', true );
       $dep[]="pseudocode.js";
      }
      wp_enqueue_script( 'tocbot',  get_template_directory_uri() . '/js/tocbot/tocbot.min.js', array(), '4.3.0', true );
      $dep[]="tocbot";
      if(is_singular() && preg_match("/\*{3,}plotly-\{.+\}\*{3,}/m", $post->post_content)){
        wp_enqueue_script( 'plotly',  get_template_directory_uri() . '/js/plotly-latest.min.js', array(), '', true );
        $dep[]="plotly";
      }
      if(is_singular() && preg_match("/\*{3,}graphviz-.+-\{.+\}\*{3,}/m", $post->post_content)){
        wp_enqueue_script( 'viz',  get_template_directory_uri() . '/js/viz.js', array(), '', true );
        $dep[]="viz";
      }
      if(is_singular() && preg_match("/\*{3,}vis-\{.+\}\*{3,}/m", $post->post_content)){
        wp_enqueue_script( 'vis',  get_template_directory_uri() . '/js/vis/vis.min.js', array(), '5.0.0', true );
        $dep[]="vis";
      }
      wp_enqueue_script( 'init', get_template_directory_uri() . '/js/init.js', $dep, '1.0.0', true );
    }
}
add_action( 'wp_enqueue_scripts', 'cherrysky_scripts' );

/**
 * Print styles
 */
function cherrysky_styles() {
  global $post;
  $cdn=true;
  if($cdn==true){
    wp_enqueue_style( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' );
    wp_enqueue_style( 'fontawesome',  'https://use.fontawesome.com/releases/v5.0.6/css/all.css');
    if (is_page_template('page-detailed-homepage.php') || (get_post_meta($post->ID,'tjdr1235813_enable_markdown',true) && preg_match("/`{3,}/m", $post->post_content))) {
      wp_enqueue_style( 'highlight.js', 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/xcode.min.css');
      wp_enqueue_style( 'highlight-line-number.js', get_template_directory_uri() . '/css/line-number.css');
    }
    if(is_singular() && preg_match("/\*{3,}pseudocode\*{3,}/m", $post->post_content)){
      wp_enqueue_style( 'pseudocode.js', get_template_directory_uri() . '/js/pseudocode.js/pseudocode.css');
    }
    if(is_singular() && preg_match("/\*{3,}mermaid\*{3,}/m", $post->post_content)){
      wp_enqueue_style( 'mermaid', get_template_directory_uri() . '/js/mermaid/mermaid.css');
    }
    wp_enqueue_style( 'tocbot', 'https://cdnjs.cloudflare.com/ajax/libs/tocbot/4.1.1/tocbot.css');
    if(is_singular() && preg_match("/\*{3,}vis-\{.+\}\*{3,}/m", $post->post_content)){
      wp_enqueue_style( 'vis', 'https://cdnjs.cloudflare.com/ajax/libs/vis/4.21.0/vis.min.css');
    }
	 if (is_page_template('page-detailed-homepage.php') || (get_post_meta($post->ID,'tjdr1235813_enable_markdown',true) && preg_match("/\*{3,}console\s*>>(.*)<<\s*\*{3,}/m", $post->post_content))) {
		 wp_enqueue_style( 'console', get_template_directory_uri() . '/js/console/osx.css' );
	 }
    wp_enqueue_style( 'cherrysky-style', get_stylesheet_uri() );
  }else{
    wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap/css/bootstrap.min.css' );
    wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/fonts/fontawesome/css/fontawesome-all.min.css');
    if (is_singular() && preg_match("/`{3,}/m", $post->post_content)) {
      wp_enqueue_style( 'highlight.js', get_template_directory_uri() . '/js/highlight/styles/xcode.css');
      wp_enqueue_style( 'highlight-line-number.js', get_template_directory_uri() . '/css/line-number.css');
    }
    if(is_singular() && preg_match("/\*{3,}pseudocode\*{3,}/m", $post->post_content)){
      wp_enqueue_style( 'pseudocode.js', get_template_directory_uri() . '/js/pseudocode.js/pseudocode.css');
    }
    if(is_singular() && preg_match("/\*{3,}mermaid\*{3,}/m", $post->post_content)){
      wp_enqueue_style( 'mermaid', get_template_directory_uri() . '/js/mermaid/mermaid.css');
    }
    wp_enqueue_style( 'tocbot', get_template_directory_uri() . '/js/tocbot/tocbot.css');
    if(is_singular() && preg_match("/\*{3,}vis-\{.+\}\*{3,}/m", $post->post_content)){
      wp_enqueue_style( 'vis', get_template_directory_uri() . '/js/vis/vis.css');
    }
    wp_enqueue_style( 'cherrysky-style', get_stylesheet_uri() );
  }
}
add_action( 'wp_print_styles', 'cherrysky_styles' );

require get_template_directory() . '/inc/tpls.php';

add_action( 'rest_api_init', 'add_custom_endpoint' );
function add_custom_endpoint() {
  register_rest_route( 'cherrysky/v0', '/list', array(
      'methods' => 'GET',
      'callback' => 'cherrysky_get_list'
  ) );
  register_rest_route( 'cherrysky/v0', '/page', array(
      'methods' => 'GET',
      'callback' => 'cherrysky_get_page'
  ) );
}
function cherrysky_get_list(){
          $frontpage_id = get_option( 'page_on_front' );

          global $wpdb;
          $sql = "SELECT ID AS i, UNIX_TIMESTAMP(post_modified) as m
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
                ORDER BY post_modified DESC;";

            $data=$wpdb->get_results($sql);

  $response = new WP_REST_Response($data);
  $response->set_status(200);
  $domain = (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"];
  $response->header( 'Location', $domain );
  return $response;
}
function cherrysky_get_location($post){
	$parent = $post->post_parent;
   $list=array();
   while($parent!=0){
     $list[]=$parent;
     $parent=get_post($parent)->post_parent;
   }
   $id_list=array_reverse($list);
   $location=[];
   foreach($id_list as $id){
        $location[]= array(
           'title' => get_the_title($id),
           'url' => get_permalink($id)
        );
    }
	return $location;
}
function cherrysky_get_content($post){
   $content = $post->post_content;
	if(get_post_meta($post->ID,'tjdr1235813_enable_markdown',true)){
		$content=apply_filters('cherrysky_markdown',$content);
	}
   $end_pos=strpos($content, "<!--end abstract-->");
   if($end_pos){
     $content = substr($content, 0 , $end_pos);
     $begin_pos=strpos($content, "<!--begin abstract-->");
     $content = substr($content, $begin_pos + 21 );
   }else{
     $content = substr(strip_tags($content), 0 , 500);
   }
	return $content;
}
function cherrysky_get_page($request_data ) {
	$parameters = $request_data->get_params();
	if( !isset( $parameters['ID'] ) || empty($parameters['ID']) )
		return array( 'error' => 'no_parameter_given' );
	$ID=$parameters['ID'];
	$post=get_post($ID);
   $data=array(
	  'ID' => $ID,
     'title' => $post->post_title,
     'url' => get_permalink($ID),
     'date' => $post->post_date,
     'modified' => $post->post_modified,
     'content' => cherrysky_get_content($post),
     'location'=>cherrysky_get_location($post)
   );
  $response = new WP_REST_Response($data);
  $response->set_status(200);
  $domain = (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"];
  $response->header( 'Location', $domain );
  return $response;
}

// add tag support to pages
function tags_support_all() {
	register_taxonomy_for_object_type('post_tag', 'page');
}

// ensure all tags are included in queries
function tags_support_query($wp_query) {
	if ($wp_query->get('tag')) $wp_query->set('post_type', 'any');
}

// tag hooks
add_action('init', 'tags_support_all');
add_action('pre_get_posts', 'tags_support_query');

// remove emoji
/**
 * Disable the emoji's
 */
function disable_emojis() {
 remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
 remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
 remove_action( 'wp_print_styles', 'print_emoji_styles' );
 remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
 remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
 remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
 remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
 add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
 add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', 'disable_emojis' );

/**
 * Filter function used to remove the tinymce emoji plugin.
 * 
 * @param array $plugins 
 * @return array Difference betwen the two arrays
 */
function disable_emojis_tinymce( $plugins ) {
 if ( is_array( $plugins ) ) {
 return array_diff( $plugins, array( 'wpemoji' ) );
 } else {
 return array();
 }
}

/**
 * Remove emoji CDN hostname from DNS prefetching hints.
 *
 * @param array $urls URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 * @return array Difference betwen the two arrays.
 */
function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
 if ( 'dns-prefetch' == $relation_type ) {
 /** This filter is documented in wp-includes/formatting.php */
 $emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );

$urls = array_diff( $urls, array( $emoji_svg_url ) );
 }

return $urls;
}