<?php
/**
 * TOC Widget class.
 *
 * @since 0.1
 */
class TOC extends WP_Widget {
    /**
     * Widget setup.
     */
    function TOC() {
        /* Widget settings. */
        $widget_ops = array(
           'classname' => 'toc_widget',
           'description' => __('A TOC widget that generates table of contents using jQuery.', 'cherrysky')
        );
        /* Widget control settings. */
        $control_ops = array(
           'width' => 300,
           'height' => 350,
           'id_base' => 'toc'
        );
        /* Create the widget. */
        $this->WP_Widget(
          'toc',
           __('Table of Contents', 'cherrysky'),
           $widget_ops,
           $control_ops
         );
    }
    /**
     * How to display the widget on the screen.
     */
    function widget( $args, $instance ) {
        extract( $args );
        /* Our variables from the widget settings. */
        $title = apply_filters('widget_title', $instance['title'] );
        /* Before widget (defined by themes). */
        echo $before_widget;
        /* Display the widget title if one was input (before and after defined by themes). */
        if ( $title )
            echo $before_title . $title . $after_title;

        printf('<div class="toc"></div>');
        /* After widget (defined by themes). */
        echo $after_widget;
    }
    /**
     * Update the widget settings.
     */
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        /* Strip tags for title and name to remove HTML (important for text inputs). */
        $instance['title'] = strip_tags( $new_instance['title'] );
        return $instance;
    }
    /**
     * Displays the widget settings controls on the widget panel.
     * Make use of the get_field_id() and get_field_name() function
     * when creating your form elements. This handles the confusing stuff.
     */
    function form( $instance ) {
        /* Set up some default widget settings. */
        $defaults = array(
           'title' => __('Table of Contents', 'cherrysky')
        );
        $instance = wp_parse_args( (array) $instance, $defaults ); ?>
        <!-- Widget Title: Text Input -->
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title', 'cherrysky'); ?>:</label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
        </p>
    <?php
    }
}
?>
