<?php
/**
 * Plugin Name: Hubspot API URL Downloader
 * Description: Call a Hubspot API URL
 * Version:     1.0
 * Author:      SatelliteWP
 */

// [hubspot_api_url("https://api.hubapi.com/cms/v3/blogs/posts?limit=1000&state=PUBLISHED&tagId__in=123,456","pat-na1-xxxxxxx-xxxx-xxxx-xxxx-xxxxx")]

/**
 * Called function from the WP All Import UI that returns an URL with the data
 * 
 * @param string $url URL
 * @param string $api_key Hubspot application API key
 * 
 * @return string URL
 */
function hubspot_api_url( $url, $api_key ){

	$ch = curl_init();

	curl_setopt( $ch, CURLOPT_URL, $url );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "GET" );

	$headers = array();
	$headers[] = "authorization: Bearer $api_key";
	curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
	
	$content = curl_exec( $ch );
	if ( curl_errno( $ch ) ) {
		return null;
	}
	curl_close( $ch );

	$uploads = wp_upload_dir();
	$filename = $uploads['basedir'] . '/' . 'hubspot_results.json';

	if ( file_exists( $filename ) ) {
		@unlink( $filename );
	}

	$data = json_decode( $content, true );

	$result = '';
	if ( $data !== false && isset( $data['results'] ) ) {
		$result = $data['results'];
	}

	file_put_contents( $filename, json_encode( $result ) );

	return str_replace( $uploads['basedir'], $uploads['baseurl'], $filename );

}

/**
 * Set feed type depending on URL
 * 
 * @param string $type Feed type (csv, xml, ...)
 * @param string $url  URL
 * 
 * @return string Type (csv, xml, json)
 */
function swp_set_feed_type( $type, $url ){

	$start_str = 'https://api.hubapi.com/';
	$len = strlen( $start_str );
	$is_hs_url = ( substr($url, 0, $len ) === $start_str );

    if ( $is_hs_url ){
        $type = 'json';
    }

    return $type;

}

add_filter( 'wp_all_import_feed_type', 'swp_set_feed_type', 10, 2 );
