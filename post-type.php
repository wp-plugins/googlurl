<?php
/*
    Post Type Class

	Copyright 2014 zourbuth.com  (email : zourbuth@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


/**
 * Exit if accessed directly
 * @since 2.0.0
 */
if ( ! defined( 'ABSPATH' ) )
	exit;

class Googl_Type {
	
	// http://goo.gl/fbsS
	// https://developers.google.com/url-shortener/
	// http://goo.gl/#analytics/goo.gl/fbsS/all_time
	// https://www.googleapis.com/urlshortener/v1/url?shortUrl=http://goo.gl/fbsS&projection=full
	
	var $textdomain, $post_type, $countries;
	
	function __construct() {
		$this->post_type = 'googl';
		$this->textdomain = GOOGLULR_TEXTDOMAIN;
		$this->countries = array( 'AF' => 'Afghanistan', 'AX' => 'Åland Islands', 'AL' => 'Albania', 'DZ' => 'Algeria', 'AS' => 'American Samoa', 'AD' => 'Andorra', 'AO' => 'Angola', 'AI' => 'Anguilla', 'AQ' => 'Antarctica', 'AG' => 'Antigua And Barbuda', 'AR' => 'Argentina', 'AM' => 'Armenia', 'AW' => 'Aruba', 'AU' => 'Australia', 'AT' => 'Austria', 'AZ' => 'Azerbaijan', 'BS' => 'Bahamas', 'BH' => 'Bahrain', 'BD' => 'Bangladesh', 'BB' => 'Barbados', 'BY' => 'Belarus', 'BE' => 'Belgium', 'BZ' => 'Belize', 'BJ' => 'Benin', 'BM' => 'Bermuda', 'BT' => 'Bhutan', 'BO' => 'Bolivia, Plurinational State Of', 'BQ' => 'Bonaire, Sint Eustatius And Saba', 'BA' => 'Bosnia And Herzegovina', 'BW' => 'Botswana', 'BV' => 'Bouvet Island', 'BR' => 'Brazil', 'IO' => 'British Indian Ocean Territory', 'BN' => 'Brunei Darussalam', 'BG' => 'Bulgaria', 'BF' => 'Burkina Faso', 'BI' => 'Burundi', 'KH' => 'Cambodia', 'CM' => 'Cameroon', 'CA' => 'Canada', 'CV' => 'Cape Verde', 'KY' => 'Cayman Islands', 'CF' => 'Central African Republic', 'TD' => 'Chad', 'CL' => 'Chile', 'CN' => 'China', 'CX' => 'Christmas Island', 'CC' => 'Cocos (keeling) Islands', 'CO' => 'Colombia', 'KM' => 'Comoros', 'CG' => 'Congo', 'CD' => 'Congo, The Democratic Republic Of The', 'CK' => 'Cook Islands', 'CR' => 'Costa Rica', 'CI' => 'Côte D\'ivoire', 'HR' => 'Croatia', 'CU' => 'Cuba', 'CW' => 'Curaçao', 'CY' => 'Cyprus', 'CZ' => 'Czech Republic', 'DK' => 'Denmark', 'DJ' => 'Djibouti', 'DM' => 'Dominica', 'DO' => 'Dominican Republic', 'EC' => 'Ecuador', 'EG' => 'Egypt', 'SV' => 'El Salvador', 'GQ' => 'Equatorial Guinea', 'ER' => 'Eritrea', 'EE' => 'Estonia', 'ET' => 'Ethiopia', 'FK' => 'Falkland Islands (malvinas)', 'FO' => 'Faroe Islands', 'FJ' => 'Fiji', 'FI' => 'Finland', 'FR' => 'France', 'GF' => 'French Guiana', 'PF' => 'French Polynesia', 'TF' => 'French Southern Territories', 'GA' => 'Gabon', 'GM' => 'Gambia', 'GE' => 'Georgia', 'DE' => 'Germany', 'GH' => 'Ghana', 'GI' => 'Gibraltar', 'GR' => 'Greece', 'GL' => 'Greenland', 'GD' => 'Grenada', 'GP' => 'Guadeloupe', 'GU' => 'Guam', 'GT' => 'Guatemala', 'GG' => 'Guernsey', 'GN' => 'Guinea', 'GW' => 'Guinea-bissau', 'GY' => 'Guyana', 'HT' => 'Haiti', 'HM' => 'Heard Island And Mcdonald Islands', 'VA' => 'Holy See (vatican City State)', 'HN' => 'Honduras', 'HK' => 'Hong Kong', 'HU' => 'Hungary', 'IS' => 'Iceland', 'IN' => 'India', 'ID' => 'Indonesia', 'IR' => 'Iran, Islamic Republic Of', 'IQ' => 'Iraq', 'IE' => 'Ireland', 'IM' => 'Isle Of Man', 'IL' => 'Israel', 'IT' => 'Italy', 'JM' => 'Jamaica', 'JP' => 'Japan', 'JE' => 'Jersey', 'JO' => 'Jordan', 'KZ' => 'Kazakhstan', 'KE' => 'Kenya', 'KI' => 'Kiribati', 'KP' => 'Korea, Democratic People\'s Republic Of', 'KR' => 'Korea, Republic Of', 'KW' => 'Kuwait', 'KG' => 'Kyrgyzstan', 'LA' => 'Lao People\'s Democratic Republic', 'LV' => 'Latvia', 'LB' => 'Lebanon', 'LS' => 'Lesotho', 'LR' => 'Liberia', 'LY' => 'Libya', 'LI' => 'Liechtenstein', 'LT' => 'Lithuania', 'LU' => 'Luxembourg', 'MO' => 'Macao', 'MK' => 'Macedonia, The Former Yugoslav Republic Of', 'MG' => 'Madagascar', 'MW' => 'Malawi', 'MY' => 'Malaysia', 'MV' => 'Maldives', 'ML' => 'Mali', 'MT' => 'Malta', 'MH' => 'Marshall Islands', 'MQ' => 'Martinique', 'MR' => 'Mauritania', 'MU' => 'Mauritius', 'YT' => 'Mayotte', 'MX' => 'Mexico', 'FM' => 'Micronesia, Federated States Of', 'MD' => 'Moldova, Republic Of', 'MC' => 'Monaco', 'MN' => 'Mongolia', 'ME' => 'Montenegro', 'MS' => 'Montserrat', 'MA' => 'Morocco', 'MZ' => 'Mozambique', 'MM' => 'Myanmar', 'NA' => 'Namibia', 'NR' => 'Nauru', 'NP' => 'Nepal', 'NL' => 'Netherlands', 'NC' => 'New Caledonia', 'NZ' => 'New Zealand', 'NI' => 'Nicaragua', 'NE' => 'Niger', 'NG' => 'Nigeria', 'NU' => 'Niue', 'NF' => 'Norfolk Island', 'MP' => 'Northern Mariana Islands', 'NO' => 'Norway', 'OM' => 'Oman', 'PK' => 'Pakistan', 'PW' => 'Palau', 'PS' => 'Palestinian Territory, Occupied', 'PA' => 'Panama', 'PG' => 'Papua New Guinea', 'PY' => 'Paraguay', 'PE' => 'Peru', 'PH' => 'Philippines', 'PN' => 'Pitcairn', 'PL' => 'Poland', 'PT' => 'Portugal', 'PR' => 'Puerto Rico', 'QA' => 'Qatar', 'RE' => 'Réunion', 'RO' => 'Romania', 'RU' => 'Russian Federation', 'RW' => 'Rwanda', 'BL' => 'Saint Barthélemy', 'SH' => 'Saint Helena, Ascension And Tristan Da Cunha', 'KN' => 'Saint Kitts And Nevis', 'LC' => 'Saint Lucia', 'MF' => 'Saint Martin (french Part)', 'PM' => 'Saint Pierre And Miquelon', 'VC' => 'Saint Vincent And The Grenadines', 'WS' => 'Samoa', 'SM' => 'San Marino', 'ST' => 'Sao Tome And Principe', 'SA' => 'Saudi Arabia', 'SN' => 'Senegal', 'RS' => 'Serbia', 'SC' => 'Seychelles', 'SL' => 'Sierra Leone', 'SG' => 'Singapore', 'SX' => 'Sint Maarten (dutch Part)', 'SK' => 'Slovakia', 'SI' => 'Slovenia', 'SB' => 'Solomon Islands', 'SO' => 'Somalia', 'ZA' => 'South Africa', 'GS' => 'South Georgia And The South Sandwich Islands', 'SS' => 'South Sudan', 'ES' => 'Spain', 'LK' => 'Sri Lanka', 'SD' => 'Sudan', 'SR' => 'Suriname', 'SJ' => 'Svalbard And Jan Mayen', 'SZ' => 'Swaziland', 'SE' => 'Sweden', 'CH' => 'Switzerland', 'SY' => 'Syrian Arab Republic', 'TW' => 'Taiwan, Province Of China', 'TJ' => 'Tajikistan', 'TZ' => 'Tanzania, United Republic Of', 'TH' => 'Thailand', 'TL' => 'Timor-leste', 'TG' => 'Togo', 'TK' => 'Tokelau', 'TO' => 'Tonga', 'TT' => 'Trinidad And Tobago', 'TN' => 'Tunisia', 'TR' => 'Turkey', 'TM' => 'Turkmenistan', 'TC' => 'Turks And Caicos Islands', 'TV' => 'Tuvalu', 'UG' => 'Uganda', 'UA' => 'Ukraine', 'AE' => 'United Arab Emirates', 'GB' => 'United Kingdom', 'US' => 'United States', 'UM' => 'United States Minor Outlying Islands', 'UY' => 'Uruguay', 'UZ' => 'Uzbekistan', 'VU' => 'Vanuatu', 'VE' => 'Venezuela, Bolivarian Republic Of', 'VN' => 'Viet Nam', 'VG' => 'Virgin Islands, British', 'VI' => 'Virgin Islands, U.s.', 'WF' => 'Wallis And Futuna', 'EH' => 'Western Sahara', 'YE' => 'Yemen', 'ZM' => 'Zambia', 'ZW' => 'Zimbabwe' );
		
		add_action( 'init', array( &$this, 'codex_googl_init' ) );
		add_action( 'add_meta_boxes', array( &$this, 'add_meta_boxes' ) );
		add_action( 'edit_form_after_title', array( &$this, 'edit_form_after_title' ) );
		add_action( 'admin_print_styles', array( &$this, 'admin_print_styles' ) );
		add_action( 'admin_print_styles', array( &$this, 'inline_edit_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		
		add_filter( 'get_shortlink', array( &$this, 'get_shortlink' ), 10, 4 );
		add_filter( 'post_type_link', array( &$this, 'post_type_link' ), 10, 4 );
		add_filter( 'manage_edit-'. $this->post_type . '_columns', array( &$this, 'post_columns' ) );
		add_action( 'manage_posts_custom_column', array( &$this, 'link_column' ) );			
		add_action( 'manage_posts_custom_column', array( &$this, 'clicks_column' ) );			
		add_filter( 'wp_insert_post_data', array( &$this, 'insert_post_data' ), 10, 2 );
		add_filter( 'post_row_actions', array( &$this, 'post_row_actions' ), 10, 2 );		
	}
	

	function enter_title_here( $title, $post ) {
		if( $this->post_type == $post->post_type )
			$title = __( 'Enter URL here', $this->textdomain );
		
		return $title;
	}	
	
	
	function post_row_actions( $actions, $post ) {
		if( $this->post_type == $post->post_type && $post->post_content ) {
			$content = unserialize( $post->post_content );
			$actions['edit'] = '<a href="' . get_edit_post_link( $post->ID, true ) . '" title="' . esc_attr( __( 'Edit this item', $this->textdomain ) ) . '">' . __( 'Analytic', $this->textdomain ) . '</a>';
			$actions['view'] = '<a target="_blank" href="' . get_permalink( $post->ID ) . '" title="' . esc_attr( sprintf( __( 'Visit &#8220;%s&#8221;' ), $content->longUrl ) ) . '" rel="permalink">' . __( 'Visit Link', $this->textdomain ) . '</a>';
		}
		return $actions;
	}
	
	
	function post_type_link( $post_link, $post, $leavename, $sample ) {
		if( ! in_array( $post->post_status, array( 'publish', 'future', 'private' ) ) )
			return $post_link;

		if( $this->post_type == $post->post_type ) {
			$content = unserialize( $post->post_content );
			$post_link = isset( $content->longUrl ) ? $content->longUrl : $post_link;
		}
		
		return $post_link;
	}	
	

	function get_shortlink( $shortlink, $id, $context, $allow_slugs ) {
		$post = get_post( $id );
		
		if ( ! $post || $this->post_type != $post->post_type || empty( $post->post_content ) )
			return $shortlink;

		$data = unserialize( $post->post_content );
		return $data->id;
	}

	
	/**
	 * Modify the post content before saving to database
	 * @doc http://codex.wordpress.org/Plugin_API/Filter_Reference/wp_insert_post_data
	 */		
	function insert_post_data( $data, $postarr  ) {
		if( $this->post_type != $data['post_type'] )
			return $data;
	
		// Verify this came from the our screen with proper authorization, because save_post can be triggered at other times
		if ( isset( $_POST['googl_nonce'] ) && ! wp_verify_nonce( $_POST['googl_nonce'], 'googl_nonce' ) )
			return $data;
				
		if ( empty( $data['post_content'] ) ) {
			if ( isset( $_POST['long_url'] ) && ! empty( $_POST['long_url'] ) )
				$long_url = esc_url( $_POST['long_url'] );
		} else {			
			$post = get_post( $data['ID'] );	// get unmodified post_content
			$googl = unserialize( $post->post_content );
			$long_url = $googl->longUrl;
		}
		
		if( ! isset( $long_url ) )
			return $data;
		
		if( $res = googl_urlshortener( $long_url ) )
			$data['post_content'] = serialize( $res );
			
		return $data;
	}
	
	
	function edit_form_after_title( $post ) {
		if( $this->post_type != $post->post_type )
			return;
		
		if( empty( $post->post_content ) )
			echo '<p><input placeholder="Enter long URL here" type="url" id="long-url" value="" size="30" name="long_url" /></p>';			
	
		echo '<input type="hidden" name="googl_nonce" value="' . wp_create_nonce( 'googl_nonce' ) . '" />';
	}
	
	
	function post_columns( $columns ) {
		$columns['url'] = __('Links', $this->textdomain);
		$columns['clicks'] = __('Clicks', $this->textdomain);
		return $columns;
	}
		
		
	function link_column( $column ) {
		if ( 'url' != $column )	// bail early
			return;
		
		global $post;
		$data = unserialize( $post->post_content );
		echo '<span class="shorturl">'. ( isset( $data->id ) ? $data->id : '-' ) .'</span>';
		echo '<span class="longurl">'. ( isset( $data->longUrl ) ? $data->longUrl : '-' ) .'</span>';
	}
	
	
	function clicks_column( $column ) {
		if ( 'clicks' != $column )
			return;
		
		global $post;
		$data = unserialize( $post->post_content );	
		echo isset( $data->analytics->allTime->shortUrlClicks ) ? $data->analytics->allTime->shortUrlClicks : '';
	}
	
		
	function add_meta_boxes() {
		global $post;
		
		//remove_meta_box( 'submitdiv', $this->post_type, 'normal' );
		remove_meta_box( 'slugdiv', $this->post_type, 'normal' );
		
		if( ! $post->post_content )
			return;
		
		add_meta_box( 'clicks', __( 'Clicks', $this->textdomain ), array( &$this, 'meta_box_callback_clicks' ), $this->post_type );		
		add_meta_box( 'referrers', __( 'Referrers', $this->textdomain ), array( &$this, 'meta_box_callback_referrers' ), $this->post_type );		
		add_meta_box( 'browsers', __( 'Browsers', $this->textdomain ), array( &$this, 'meta_box_callback_browsers' ), $this->post_type );		
		add_meta_box( 'countries', __( 'Countries', $this->textdomain ), array( &$this, 'meta_box_callback_countries' ), $this->post_type );		
		add_meta_box( 'platforms', __( 'Platforms', $this->textdomain ), array( &$this, 'meta_box_callback_platforms' ), $this->post_type );		
		
		add_meta_box( 'shortener', __( 'Googl', $this->textdomain ), array( &$this, 'meta_box_callback_shortener' ), $this->post_type, 'side' );
	}
	

	function meta_box_callback_clicks( $post ) {
		$data = unserialize( $post->post_content );
		$clicks = array();
		unset( $data->analytics->twoHours );
		foreach( $data->analytics as $key => $c ) {
			echo '<div class="click-period">';
				echo '<span class="click-label">'. $key .'</span>';
				echo '<span class="click-total">'. number_format( $c->shortUrlClicks , 0, '.', ',') .'</span>';
			echo '</div>';
		}			
	}	
	
	
	function meta_box_callback_browsers( $post ) {
		$data = unserialize( $post->post_content );
		$period = 'allTime';
		$clicks = array();
		$clicks[] = "['Browsers', 'Count']";
		foreach( $data->analytics->$period->browsers as $browsers )
			$clicks[] = "['" . $browsers->id . "', " . $browsers->count . "]";
		?>
		<script type="text/javascript">
		google.load("visualization", "1", {packages:["corechart"]});
		google.setOnLoadCallback(drawChart);
		function drawChart() {
			var data = google.visualization.arrayToDataTable([
				<?php echo implode( ',', $clicks ); ?>
			]);

			var options = {
				hAxis: {textStyle: {color: '#999999', fontSize: 10 }},
				vAxis: {textStyle: {color: '#999999', fontSize: 10 }},
				colors:['#A4BBCD','#009900'],
				chartArea: {left:110,top:10,width:"100%",height:"90%"},
				legend: {position: 'none'}
			};

			var chart = new google.visualization.BarChart(document.getElementById('chart_browsers'));
			chart.draw(data, options);
		}
		</script>

		<div id="chart_browsers" style="width: 100%; height: 225px;"></div>
		<?php
	}
	
	
	function meta_box_callback_platforms( $post ) {
		$data = unserialize( $post->post_content );
		$period = 'allTime';
		$clicks = array();
		$clicks[] = "['Platforms', 'Count']";
		foreach( $data->analytics->$period->platforms as $platforms )
			$clicks[] = "['" . $platforms->id . "', " . $platforms->count . "]";
		?>
		<script type="text/javascript">
		google.load("visualization", "1", {packages:["corechart"]});
		google.setOnLoadCallback(drawChart);
		function drawChart() {
			var data = google.visualization.arrayToDataTable([
				<?php echo implode( ',', $clicks ); ?>
			]);

			var options = {
				hAxis: {textStyle: {color: '#999999', fontSize: 10 }},
				vAxis: {textStyle: {color: '#999999', fontSize: 10 }},
				colors:['#A4BBCD','#009900'],
				chartArea: {left:110,top:10,width:"100%",height:"90%"},
				legend: {position: 'none'}
			};

			var chart = new google.visualization.BarChart(document.getElementById('chart_platforms'));
			chart.draw(data, options);
		}
		</script>

		<div id="chart_platforms" style="width: 100%; height: 225px;"></div>
		<?php
	}	
	
	
	function meta_box_callback_countries( $post ) {
		$data = unserialize( $post->post_content );
		$period = 'allTime';
		$clicks = array();
		$clicks[] = "['Countries', 'Count']";
		foreach( $data->analytics->$period->countries as $countries )
			$clicks[] = "['" . $this->countries[$countries->id] . "', " . $countries->count . "]";
		?>
		<script type='text/javascript'>
		google.load('visualization', '1', {'packages': ['geochart']});
		google.setOnLoadCallback(drawRegionsMap);

		function drawRegionsMap() {
			var data = google.visualization.arrayToDataTable([
				<?php echo implode( ',', $clicks ); ?>
			]);

			var options = {};

			var chart = new google.visualization.GeoChart(document.getElementById('chart_countries'));
			chart.draw(data, options);
		};
		</script>


		<div id="chart_countries" style="width: 100%; height: 225px;"></div>
		<?php
	}	
	
	
	function meta_box_callback_referrers( $post ) {
		$period = 'allTime';
		$data = unserialize( $post->post_content );
		if( ! isset( $data->analytics->$period->referrers ) && ! is_array( $data->analytics->$period->referrers ) )
			return;

		$clicks = array();
		$clicks[] = "['Referrers', 'Count']";
		foreach( $data->analytics->$period->referrers as $referrers )
			$clicks[] = "['" . $referrers->id . "', " . $referrers->count . "]";
		?>
		<script type="text/javascript">
		google.load("visualization", "1", {packages:["corechart"]});
		google.setOnLoadCallback(drawChart);
		function drawChart() {
			var data = google.visualization.arrayToDataTable([
				<?php echo implode( ',', $clicks ); ?>
			]);

			var options = {
				title: 'My Daily Activities',
				pieHole: 0.75,
				legend: {textStyle:{fontSize: 10}},
				chartArea: {left:110,top:10,width:"100%",height:"90%"}
			};

			var chart = new google.visualization.PieChart(document.getElementById('chart_referrers'));
			chart.draw(data, options);
		}
		</script>
		<div id="chart_referrers" style="width: 100%; height: 290px;"></div>
		<?php
	}	

	
	function meta_box_callback_shortener( $post ) {	
		$data = unserialize( $post->post_content );
		$format = get_option( 'date_format' ) .' '. get_option( 'time_format' ); ?>
		<label for="short-url"><small><?php _e('Short URL', $this->textdomain); ?></small></label>
		<input id="short-url" type="text" value="<?php echo $data->id; ?>" readonly="readonly" />
		<p class="longurl"><?php echo $data->longUrl; ?></p>
		<p><?php printf( __( 'Created: %s',$this->textdomain ), mysql2date( $format, $data->created ) ); ?></p>
		<?php
	}	
		

	/**
	 * Register a googl post type.
	 * @doc http://codex.wordpress.org/Function_Reference/register_post_type
	 */	
	function codex_googl_init() {
		$labels = array(
			'name'               => _x( 'Googl', 'post type general name', $this->textdomain ),
			'singular_name'      => _x( 'Googl', 'post type singular name', $this->textdomain ),
			'menu_name'          => _x( 'Googl', 'admin menu', $this->textdomain ),
			'name_admin_bar'     => _x( 'Googl', 'add new on admin bar', $this->textdomain ),
			'add_new'            => _x( 'Add New', 'googl', $this->textdomain ),
			'add_new_item'       => __( 'Add New Googl', $this->textdomain ),
			'new_item'           => __( 'New Googl', $this->textdomain ),
			'edit_item'          => __( 'Edit Googl', $this->textdomain ),
			'view_item'          => __( 'Visit Link', $this->textdomain ),
			'all_items'          => __( 'All Googl', $this->textdomain ),
			'search_items'       => __( 'Search Googl', $this->textdomain ),
			'parent_item_colon'  => __( 'Parent Googl:', $this->textdomain ),
			'not_found'          => __( 'No googl found.', $this->textdomain ),
			'not_found_in_trash' => __( 'No googl found in Trash.', $this->textdomain ),
		);

		$args = array(
			'labels'             	=> $labels,
			'public'             	=> true,
			'exclude_from_search' 	=> true,
			'publicly_queryable' 	=> false,
			'show_ui'            	=> true,
			'show_in_menu'       	=> true,
			'query_var'          	=> true,
			'rewrite'            	=> false,
			'capability_type'    	=> 'post',
			'has_archive'        	=> false,
			'hierarchical'       	=> false,
			'menu_position'      	=> null,
			'supports'				=> array( 'title' )
		);

		register_post_type( $this->post_type, $args );
	}	
	
	function admin_print_styles() {
		global $typenow, $hook_suffix;
		if( ! in_array( $hook_suffix, array( 'post-new.php', 'post.php' ) ) )
			return;
			
		if( $this->post_type != $typenow )
			return;
		?>
		<style type="text/css">
			#long-url {
				background-color: #FFFFFF;
				line-height: 100%;
				margin: 0;
				outline: 0 none;
				padding: 3px 8px;
				width: 100%;
			}
			.longurl {
				color: #009933;
				font-size: 14px;
				font-weight: bold;
			}
			#short-url {
				background-color: #F5F5F5;
				border: 1px solid #EBEBEB;
				color: #0074A2;
				font-size: 21px;
				font-weight: bold;
				height: 40px;
				width: 100%;
			}
			.click-period {
				display: inline-block;
				text-align: center;
				width: 25%;
			}
			.click-label {
				color: #777777;
			}
			.click-total {
				display: block;
				font-size: 30px;
				font-weight: bold;
				line-height: 30px;
			}			
		</style><?php
	}
	
	
	function inline_edit_styles() {
		global $hook_suffix, $typenow;
		
		if( 'edit.php' != $hook_suffix || $typenow != $this->post_type )
			return;
			
		?>
		<style type="text/css">
		.shorturl {
			display: block;
			font-size: 14px;
		}
		.longurl {
			color: #999999;
		}
		</style><?php
	}
	
	function admin_enqueue_scripts( $hook ) {
		global $post, $hook_suffix;
		
		if( 'post.php' != $hook || $this->post_type != $post->post_type )
			return;
		
		wp_enqueue_script( 'google-jsapi', 'https://www.google.com/jsapi' );
	}	
}

if( is_admin() ) new Googl_Type();
?>