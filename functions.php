<?php 
/**
 * @package WordPress
 * @subpackage NCCA
 */
if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Enqueue scripts
 */
function ncca_load_scripts() {
	if( is_page( 'donate' ) ) {
		wp_enqueue_script(
			'ncca_theme',
			get_stylesheet_directory_uri() . '/scripts/theme-mods.js',
			array( 'jquery' ),
			false,
			true
		);
	}
}
add_action('wp_enqueue_scripts', 'ncca_load_scripts');


/**
 * Add support for Google Fonts
 */
function ncca_load_fonts() {
	echo "<link href='http://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>";
	echo "<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,400,300,600,700,800' rel='stylesheet' type='text/css'>";
}
add_action( 'wp_head', 'ncca_load_fonts' );


/**
 * Add support for post type thumbnails
 */
function ncca_theme_setup() {
	add_theme_support( 'post-thumbnails', array( 'post', 'page', 'appeal', 'journey', 'in-memory', 'wishes' ) );
}
add_action( 'after_setup_theme', 'ncca_theme_setup' );


/**
 * Add featured image to RSS feed
 */
function ncca_featured_rss( $content ) {
	global $post;
	if( has_post_thumbnail( $post->ID ) ) {
		$content = '<div>' . get_the_post_thumbnail( $post->ID, 'medium' ) . '</div>' . $content;
	}
	return $content;
}
add_filter( 'the_excerpt_rss', 'ncca_featured_rss' );
add_filter( 'the_content_feed', 'ncca_featured_rss' );


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
 * Style the login page
 */
function ncca_login_style() {
    echo '
		<style type="text/css">
			body.login
			{
			  background:#9c6c9d
			}
			
			body.login #login h1 a
			{
			  background:url(/wp-content/uploads/2014/05/logo-resp-h150.gif) no-repeat 0 100%;
			  width:225px;
			  height:157px
			}
		</style>';
}
add_action( 'login_enqueue_scripts', 'ncca_login_style' );


/**
 * Hide admin bar for non-admins or managers
 */
if( current_user_can( 'subscriber' ) || current_user_can( 'contributor' ) || current_user_can( 'customer' ) ) {
	add_filter( 'show_admin_bar', '__return_false' );
}


/**
 * Remove U-Design sidebars
 */
function ncca_remove_sidebars(){
	unregister_sidebar( 'sidebar-17' );
	unregister_sidebar( 'sidebar-18' );
	unregister_sidebar( 'sidebar-19' );
	unregister_sidebar( 'sidebar-20' );
	unregister_sidebar( 'sidebar-21' );
	unregister_sidebar( 'sidebar-22' );
	unregister_sidebar( 'sidebar-23' );
}
add_action( 'widgets_init', 'ncca_remove_sidebars', 11 );


/**
 * Register sidebars for Children, Get Involved and Events pages
 */
function ncca_register_sidebars() {
	register_sidebar( array(
		'name'          => __( 'Children Sidebar', 'ncca_udesign' ),
		'id'            => 'children',
		'description'   => 'Sidebar for the Appeal, Journey, In Memory and Wishes pages',
		'class'         => 'children-sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widgettitle">',
		'after_title'   => '</h3>'
		)
	);
	register_sidebar( array(
		'name'          => __( 'Alfie\'s Wishes Sidebar', 'ncca_udesign' ),
		'id'            => 'alfies-wishes',
		'description'   => 'Sidebar for the Alfie\'s Wishes page',
		'class'         => 'alfies-wishes-sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widgettitle">',
		'after_title'   => '</h3>'
		)
	);
	register_sidebar( array(
		'name'          => __( 'Get Involved Sidebar', 'ncca_udesign' ),
		'id'            => 'get-involved',
		'description'   => 'Sidebar for Get Involved pages',
		'class'         => 'get-involved-sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widgettitle">',
		'after_title'   => '</h3>'
		)
	);
	register_sidebar( array(
		'name'          => __( 'Events Sidebar', 'ncca_udesign' ),
		'id'            => 'events',
		'description'   => 'Sidebar for Events pages',
		'class'         => 'events-sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widgettitle">',
		'after_title'   => '</h3>'
		)
	);
}
add_action( 'widgets_init', 'ncca_register_sidebars' );


/**
 * Fixed nav bar
 */
function ncca_header_menu() {
	echo '
		<div class="fixed-nav-bar">
			<div class="wrapper">
				<div class="shop">
					<p><a class="shop-button" href="/shop/"><img src="/wp-content/themes/ncca/images/shopping-cart-32.png" /> Online shop</a></p>
				</div>
				<div class="cta">
					<p><a class="donate-button" href="/donate/">Donate Now</a></p>
				</div>
				<div class="search">
				<img src="/wp-content/themes/ncca/images/search-6-32.png" />
				<form role="search" method="get" id="searchform" action="' . $_SERVER['PHP_SELF'] . '" _lpchecked="1">
					<div><label style="display:none" class="screen-reader-text" for="s">Search for:</label>
						<input type="text" value="" name="s" id="s" placeholder="Search">
						<input type="submit" id="searchsubmit" value="">
					</div>
				</form>
				</div>
			</div>
		</div>';
}
//add_action( 'udesign_body_top', 'ncca_header_menu' );


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
