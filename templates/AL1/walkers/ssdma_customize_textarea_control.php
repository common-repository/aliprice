<?php

include_once ABSPATH . '/wp-includes/class-wp-customize-control.php';

class ssdma_customize_textarea_control extends WP_Customize_Control {
    public $type = 'textarea';
 
    public function render_content() {
        ?>
        <label>
        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
        <textarea rows="5" style="width:100%;" <?php $this->link(); ?>>
        	<?php echo esc_textarea( $this->value() ); ?>
        </textarea>
        </label>
        <?php
    }
}