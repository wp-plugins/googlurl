<?php

add_action( 'wp', 'googl_cron_schedule' );
add_action( 'googl_hourly_event', 'googl_update_data' );

function googl_cron_schedule() {
	if ( ! wp_next_scheduled( 'googl_hourly_event' ) )
		wp_schedule_event( time(), 'daily', 'googl_hourly_event' );
}

function googl_update_data() {
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
		if( isset( $googl->longUrl ) && $res = googl_urlshortener( $googl->longUrl ) ) {
			$post->post_content = serialize( $res );
			wp_update_post( $post );
		}
	}
}


function googl_urlshortener( $long_url ) {
	$request = wp_remote_post( 'https://www.googleapis.com/urlshortener/v1/url', array(
		'body' 		=> json_encode( array( 'longUrl' => esc_url_raw( $long_url ) ) ),
		'headers' 	=> array( 'Content-Type' => 'application/json' ),
	));			

	if ( is_wp_error( $request ) ) {
		return false;
	} else {
		$res = json_decode( wp_remote_retrieve_body( $request ) );
		
		$request = wp_remote_get( "https://www.googleapis.com/urlshortener/v1/url?shortUrl={$res->id}&projection=full" );
		
		if ( ! is_wp_error( $request ) )
			$res = json_decode( wp_remote_retrieve_body( $request ) );
		
		return $res;
	}
}