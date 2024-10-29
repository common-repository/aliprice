<?php
/**
 * Created by AL1.
 * User: Dmitry Nizovsky
 * Date: 19.02.15
 * Time: 14:47
 */

function ssdma_add_widgets_in_sidebar($sidebar, $widget)
{
    global $wp_widget_factory;
    $widgets = $wp_widget_factory->widgets;

    // We don't want to undo user changes, so we look for changes first.
    $active_widgets = get_option( 'sidebars_widgets' );

    foreach($widget as $item) {

        if(isset($widgets[ $item['id'] ])) {
            $this_widget                  = $widgets[ $item['id'] ];
            $count = $this_widget->number = $this_widget->number + 1;
            $active_widgets[ $sidebar ][] = $this_widget->id_base . '-' . $count;

            $value           = get_option( $this_widget->option_name );
            $value[ $count ] = $item['value'];
            update_option( $this_widget->option_name, $value );
        }
    }

    update_option( 'sidebars_widgets', $active_widgets );
}

function ssdma_remove_widgets_in_sidebar($sidebar)
{
    // We don't want to undo user changes, so we look for changes first.
    $active_widgets = get_option( 'sidebars_widgets' );

    if ( ! isset( $active_widgets[ $sidebar ] ) ) return;

    $ignore = array();
    foreach($active_widgets[ $sidebar ] as $item) {
        $current = preg_replace('/-\d+/', '', $item);
        if( !in_array($current, $ignore) ) {
            update_option( 'widget_' . $current, array() );
            $ignore[] = $current;
        }
    }
    $active_widgets[ $sidebar ] = array();

    update_option( 'sidebars_widgets', $active_widgets );
}