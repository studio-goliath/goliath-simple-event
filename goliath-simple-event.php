<?php
/**
Plugin name: Goliath simple event
Description: Juste add a event post type
Version: 1.0
Author: Studio Goliath
Author URI: http://www.studio-goliath.com
 */


require_once ('post-types/event.php');


add_action('pre_get_posts', 'goliath_pre_get_post_for_event');

/**
 * @param $query
 */
function goliath_pre_get_post_for_event($query) {

    if ( ! is_admin() && $query->is_main_query() && is_post_type_archive( 'event' ) ){

        $today = date( 'Y-m-d' );

        $query->set('order', 'ASC' );
        $query->set('orderby', 'meta_value' );
        $query->set('meta_key', 'goliath_event_start_date' );
        $query->set('meta_query', array(
            array(
                'key'       => 'goliath_event_start_date',
                'value'     => $today,
                'type'      => 'DATE',
                'compare'   => '>=',
            )
        ) );

    }

}