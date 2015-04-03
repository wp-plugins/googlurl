<?php

add_action( 'wp', 'googlurl_cron_schedule' );
add_action( 'googl_daily_event', 'googlurl_update_data' );
register_deactivation_hook( __FILE__, 'googlurl_remove_event' );


/**
 * Add cron schedule
 * @since 0.0.1
 */	
function googlurl_cron_schedule() {
	if ( ! wp_next_scheduled( 'googl_daily_event' ) )
		wp_schedule_event( time(), 'daily', 'googl_daily_event' );
}


 /**
 * On deactivation, remove all functions from the scheduled action hook.
 * @since 0.0.1
 */	
function googlurl_remove_event() {
	wp_clear_scheduled_hook( 'googl_daily_event' );
}


/**
 * Update it daily
 * @since 0.0.1
 */	
function googlurl_update_data() {
	$today = getdate();
	
	$args = array(
		'post_type' => 'googl',
		'date_query' => array(
			array(
				'column' => 'post_modified',
				'before'    => array(
					'year'  => $today["year"],
					'month' => $today["mon"],
					'day'   => $today["mday"],
				)
			)
		),
		'posts_per_page' => -1
	);
	
	$posts = get_posts( $args );
	
	foreach( $posts as $post ) {
		$googl = unserialize( $post->post_content );
		if( isset( $googl->longUrl ) && $res = googlurl_shortener( $googl->longUrl ) ) {
			$post->post_content = serialize( $res );
			wp_update_post( $post );
		}
	}
}


/**
 * Get plugin setting/options
 * https://www.googleapis.com/urlshortener/v1/url?key=api_key_here
 * @since 0.0.1
 */	
function googlurl_shortener( $long_url ) {
	
	if ( ! $key = googlurl_options( 'api_key' ) ) {
		$std = new stdClass();
		$std->error->message = 'Please provide API key';
		return $std;
	}
		
	
	$request = wp_remote_post( "https://www.googleapis.com/urlshortener/v1/url?key=$key", array(
		'body' 		=> json_encode( array( 'longUrl' => esc_url_raw( $long_url ) ) ),
		'headers' 	=> array( 'Content-Type' => 'application/json; charset=UTF-8' ),
	));			

	$res = json_decode( wp_remote_retrieve_body( $request ) );

	$request = wp_remote_get( "https://www.googleapis.com/urlshortener/v1/url?shortUrl={$res->id}&projection=full&key=$key" );

	return json_decode( wp_remote_retrieve_body( $request ) );
}


/**
 * Get plugin setting/options
 * @since 0.0.2
 */	
function googlurl_options( $key = null ) {
	$option = get_option( GOOGLULR_SLUG );
	
	if( $key ) {
		if( isset( $option[$key] ) )
			return $option[$key];
		else
			return false;
	} else {
		return $option;
	}
}