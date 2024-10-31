<?php

class PayPlug_Widget extends WP_Widget {

    public function __construct() {
        $widget_options = array(
            'classname'     => 'payplug_widget',
            'description'   => __('Add button payment PayPlug.', 'payplug')
        );
        parent::__construct('payplug_widget', 'PayPlug', $widget_options);
    }

    /**
     * Outputs the content of the widget
     *
     * @param $args
     * @param $instance
     * @return mixed
     */
    public function widget($args, $instance) {
        echo $args['before_widget'];

        echo PAYPLUG_Plugin::payplug_shortcode( $instance );

        echo $args['after_widget'];
    }

    /**
     * @param $new_instance
     * @param $old_instance
     * @return mixed
     */
    public function update($new_instance, $old_instance) {
        $new_instance = parent::update($new_instance, $old_instance);
        return $new_instance;
    }

    /**
     * @param $instance
     */
    public function form($instance) {
        $default = array(
            'title_button' => __('Buy', 'payplug'),
            'price'        => ''
        );

        $instance = wp_parse_args((array)$instance, $default);

        $title_button_id        = $this->get_field_id('title_button');
        $title_button_name      = $this->get_field_name('title_button');
        $price_id               = $this->get_field_id('price');
        $price_name             = $this->get_field_name('price');
        $class_id               = $this->get_field_id('class');
        $class_name             = $this->get_field_name('class');
        $icon_id                = $this->get_field_id('icon');
        $icon_name              = $this->get_field_name('icon');
        ?>
        <p>
            <span></span>
            <label for="<?php echo $title_button_id ?>">
                <?php _e('Button title', 'payplug'); ?> :
                <input id="<?php echo $title_button_id ?>" name="<?php echo $title_button_name ?>" type="text" value="<?php echo ($instance['title_button']) ? $instance['title_button'] : ''; ?>" />
            </label><br /><br />
            <label for="<?php echo $price_id ?>">
                <?php _e('Price', 'payplug'); ?> :
                <input id="<?php echo $price_id ?>" name="<?php echo $price_name ?>" type="text" value="<?php echo ($instance['price']) ? $instance['price'] : ''; ?>" />
            </label><br /><br />
            <label for="<?php echo $class_id ?>">
                <?php _e('CSS Class', 'payplug'); ?> :
                <input id="<?php echo $class_id ?>" name="<?php echo $class_name ?>" type="text" value="<?php echo ($instance['class']) ? $instance['class'] : ''; ?>" />
            </label><br /><br />
            <label for="<?php echo $icon_id ?>">
                <?php _e('Icon', 'payplug'); ?> :
                <input id="<?php echo $icon_id ?>" name="<?php echo $icon_name ?>" type="text" value="<?php echo ($instance['icon']) ? $instance['icon'] : ''; ?>" />
            </label>
        </p>
        <?php
    }

}
