<?php
/**
Plugin Name: Weekly Food Section Widget 
Plugin URI: http://www.familyfeatures.com/
Description: Weekly Food Section Widget
Author: culinary.net Copyright 2010
Version: 1.0
Author URI: http://www.culinary.net/
*/

// This gets called at the plugins_loaded action
function widget_ffes_feed_init() {

        // Check for the required API functions
        if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
                return;

        // This saves options and prints the widget's config form.
        function widget_ffes_feed_control() {
                $options = $newoptions = get_option('widget_ffes_feed');
                if ( $_POST['ffes-feed-submit'] ) {
                        $newoptions['title'] = strip_tags(stripslashes($_POST['ffes-feed-title']));
                }
                if ( $options != $newoptions ) {
                        $options = $newoptions;
                        update_option('widget_ffes_feed', $options);
                }
        ?>
                                <div style="text-align:right">
                                <label for="ffes-feed-title" style="line-height:35px;display:block;"><?php _e('Widget title:', 'ffes_widgets'); ?>
                                                                <input type="text" id="ffes-feed-title" name="ffes-feed-title" value="<?php echo wp_specialchars($options['title'], true); ?>" /></label>
                                <input type="hidden" name="ffes-feed-submit" id="ffes-feed-submit" value="1" />
                                </div>
        <?php
        }

        // This prints the widget
        function widget_ffes_feed($args) {
                extract($args);
                $defaults = array('count' => 10, 'username' => 'wordpress');
                $options = (array) get_option('widget_ffes_feed');

                foreach ( $defaults as $key => $value )
                        if ( !isset($options[$key]) )
                                $options[$key] = $defaults[$key];
//feed copy
$feed_text = "<script language=\"JavaScript\" type=\"text/javascript\">document.write('<scr' + 'ipt language=\"JavaScript\" type=\"text/javascript\" src=\"http://www.familyfeatures.com/wordpress/food/foodhandler.ashx' + window.location.search + '\"></scr' + 'ipt>'
);</script>";
                ?>
                <?php echo $before_widget; ?>
                        <?php echo $before_title . $options['title'] . $after_title; ?>
                       <?php echo "$feed_text"; ?>
                <?php echo $after_widget; ?>
<?php
        }

        // Tell Dynamic Sidebar about our new widget and its control
        register_sidebar_widget(array('Weekly Food Section Widget', 'ffes_widgets'), 'widget_ffes_feed');
        register_widget_control(array('Weekly Food Section Widget', 'ffes_widgets'), 'widget_ffes_feed_control');

}

// Delay plugin execution to ensure Dynamic Sidebar has a chance to load first
add_action('widgets_init', 'widget_ffes_feed_init');
?>
