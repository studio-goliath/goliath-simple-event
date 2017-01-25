<?php
/**
 * Register CPT event
 *
 * And event meta
 */


add_action( 'init', 'goliath_event_init' );

function goliath_event_init() {
    register_post_type( 'event', array(
        'labels'            => array(
            'name'                => __( 'Event', 'goliath_simple_event' ),
            'singular_name'       => __( 'Event', 'goliath_simple_event' ),
            'all_items'           => __( 'all events', 'goliath_simple_event' ),
            'new_item'            => __( 'New event', 'goliath_simple_event' ),
            'add_new'             => __( 'Add new', 'goliath_simple_event' ),
            'add_new_item'        => __( 'Add new event', 'goliath_simple_event' ),
            'edit_item'           => __( 'Edit event', 'goliath_simple_event' ),
            'view_item'           => __( 'View event', 'goliath_simple_event' ),
            'search_items'        => __( 'Search event', 'goliath_simple_event' ),
            'not_found'           => __( 'No events', 'goliath_simple_event' ),
            'not_found_in_trash'  => __( 'No events in trash', 'goliath_simple_event' ),
            'menu_name'           => __( 'Event', 'goliath_simple_event' ),
        ),
        'public'            => true,
        'hierarchical'      => false,
        'show_ui'           => true,
        'show_in_nav_menus' => true,
        'supports'          => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'has_archive'       => _x( 'event', 'slug', 'goliath_simple_event' ),
        'rewrite'           => true,
        'query_var'         => true,
        'menu_icon'         => 'dashicons-calendar-alt',
        'show_in_rest'      => true,
    ) );

}




add_action('add_meta_boxes_event', 'goliath_event_date_metabox' );

function goliath_event_date_metabox( $post ){

    add_meta_box( 'goliath_event_date_metabox', __( 'Event date', 'goliath_simple_event' ), 'goliath_event_date_metabox_callback', 'event', 'side' );

}


function goliath_event_date_metabox_callback( $post ){


    $event_start_date = get_post_meta( $post->ID, 'goliath_event_start_date', true);


    wp_nonce_field( 'goliath_event_start_date_action', 'goliath_event_start_date_name' );
    ?>
    <label for="goliath_event_start_date"><?php _e('Start date', 'goliath_simple_event' ) ?></label>
    <input id="goliath_event_start_date" type="date" value="<?php echo $event_start_date ?>" name="goliath_event_start_date"/>
    <?php
}



add_action( 'save_post_event', 'goliath_save_event' );


function goliath_save_event( $post_id ){

    if( isset( $_POST['goliath_event_start_date_name'] ) ){

        $user_can = current_user_can( 'edit_post', $post_id );
        $verify_nonce = wp_verify_nonce( $_POST['goliath_event_start_date_name'], 'goliath_event_start_date_action' );

        if( $user_can && $verify_nonce ){

            if( isset( $_POST['goliath_event_start_date'] ) ){

                $event_start_date = sanitize_text_field( $_POST['goliath_event_start_date'] );

                if( $event_start_date > 0 ){

                    update_post_meta( $post_id, 'goliath_event_start_date', $event_start_date );

                }
            }

        }

    }
}