<?php 
/**
 * @package WordPress
 * @subpackage NCCA
 */
if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Add support for post thumbnails
 */
function ncca_theme_setup() {
	add_theme_support( 'post-thumbnails', array( 'post', 'page', 'appeal', 'journey' ) );
}
add_action( 'after_setup_theme', 'ncca_theme_setup' );


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
 * Add 'terms and conditions' to the bottom of Journey Pages
 */
function ncca_add_journey_terms() {
	$query = new WP_Query( 'pagename=journeys/terms-and-conditions' );
	
	if( is_singular( 'journey' ) && $query->have_posts() ) {
		echo '<div class="divider"></div>';
		while( $query->have_posts() ) {
			$query->the_post();
				the_title();
				the_content();
		}
	}
	
	wp_reset_postdata();
}
add_action( 'udesign_single_post_entry_bottom', 'ncca_add_journey_terms', 2 );


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
