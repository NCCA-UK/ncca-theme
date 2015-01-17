<?php 
/**
 * @package WordPress
 * @subpackage NCCA
 */
if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if( is_plugin_active( 'wpdonations/wpdonations.php' ) ) {
	locate_template( '/wpdonations/ncca-wpdonations.php', true, true );
}

if( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
	locate_template( '/woocommerce/ncca-woocommerce.php', true, true );
}

/**
 * Load scripts and styles
 */
function ncca_load_scripts() {
	
}
//add_action( 'wp_enqueue_scripts', 'ncca_load_scripts', 99 ); // set priority to 99 to ensure styles override parent theme


/**
 * Add favicon to header
 */
function ncca_add_favicon() {
	echo '
		<link rel="icon" type="image/png" href="//ncca-uk.org/favicon.png">
		<link rel="icon" type="image/x-icon" href="//ncca-uk.org/favicon.ico" />';
}
add_action( 'wp_head', 'ncca_add_favicon' );


/**
 * Header flyout menu
 */
function ncca_header_menu() {
	echo '
		<div id="flyout">
			<div id="flyout-inner">
			<form role="search" method="get" id="searchform" action="' . $_SERVER['PHP_SELF'] . '" _lpchecked="1">
				<div><label style="display:none" class="screen-reader-text" for="s">Search for:</label>
					<input type="text" value="" name="s" id="s" placeholder="Type here to search">
					<input type="submit" id="searchsubmit" value="">
				</div>
			</form>
			</div>
			<p><a id="flyout-1" href="mailto:info@ncca-uk.org" title="Email"><span class="flyout">Email</span></a></p>
			<p><a id="flyout-2" href="/shop/" title="Shop"><span class="flyout">Shop</span></a></p>
		</div>';
}
//add_action( 'udesign_top_wrapper_top', 'ncca_header_menu' );


/**
 * Trim the title
 */
function trim_title( $title ) {
	$title = get_the_title();
	$limit = "10";
	$pad = "...";
	if( strlen( $title ) <= $limit ) {
	
		return $title;
	} else {
		$title = substr( $title, 0, $limit ) . $pad;
		
		return $title;
	}
}


/**
 * Replace the default WordPress search form with a HTML5 version
 */
function html5_search_form( $form ) {
	$form = '
		<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
			<label class="assistive-text" for="s">' . __('Search for:') . '</label>
			<input type="search" placeholder="'.__("Enter term...").'" value="' . get_search_query() . '" name="s" id="s" />
			<input type="submit" id="searchsubmit" value="Search" />
		</form>';
	
	return $form;
}
//add_filter( 'get_search_form', 'html5_search_form' );


/**
 * Back to top
 */
function ncca_remove_backtotop() {
	remove_shortcode( 'divider_top' );
	remove_action( 'udesign_footer_inside', 'udesign_footer_back_to_top_link' );
	
	function ncca_add_backtotop() {
		return '<div class="divider top-of-page"></div>';
	}
	add_shortcode( 'divider_top', 'ncca_add_backtotop' );
}
add_action( 'init', 'ncca_remove_backtotop' );

function ncca_backtotop_single() {
	echo '
		<div class="top-of-page"><a href="#top" title="' . esc_html__("Back to Top", "udesign") . '"><img src="' . get_stylesheet_directory_uri() . '/images/back-to-top.gif" /></a></div>';
}
add_action( 'udesign_single_post_entry_bottom', 'ncca_backtotop_single' );
?>
