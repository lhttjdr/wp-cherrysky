<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <link rel="shortcut icon" href="<?php echo get_site_url(); ?>/favicon.ico" />
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header id="header" class="clearfix">
    <div class="container">
            <div class="site-name">
                <p>
                <?php if ( is_front_page() && is_home() ) : ?>
                    <h1>
                        <a id="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                            <?php bloginfo( 'name' ); ?>
                        </a>
                    </h1>
                <?php else : ?>
                    <a id="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <?php bloginfo( 'name' ); ?>
                    </a>
                <?php endif; ?>
                  </p>
                  <p class="description"><?php bloginfo( 'description' ); ?></p>

            </div>
            <?php if ( has_nav_menu( 'primary' ) ) : ?>
                    <?php wp_nav_menu( array(
                        'theme_location'    => 'primary',
                        'container'         => 'nav',
                        'container_class'   => 'clearfix',
                        'container_id'      => 'nav-menu'
                    ) ); ?>
            <?php endif; ?>
    </div>
</header>
<div id="body">
    <div class="container">
        <div class="row">
