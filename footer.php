        </div>
    </div>
</div>
<footer id="footer">
    <div class="container">
        &copy; <?php echo date( 'Y' ); ?> <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>.
        Powered by: <a href="https://wordpress.org">WordPress</a>.
        <?php echo get_option( 'zh_cn_l10n_icp_num' );?>
    </div>
</footer>

<?php wp_footer(); ?>
		   <div id="page-top">
            <a id="move-page-top">▲</a>
        </div>
</body>
</html>