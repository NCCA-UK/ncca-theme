<?php
/**
 * @package WordPress
 * @subpackage U-Design
 */
/**
 * Template Name: Get Involved Page
 */
if ( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header();

$content_position = ( $udesign_options['pages_sidebar'] == 'left' ) ? 'grid_16 push_8' : 'grid_16';
if ( $udesign_options['remove_default_page_sidebar'] == 'yes' ) $content_position = 'grid_24';
?>

<div id="content-container" class="container_24">
    <div id="main-content" class="<?php echo $content_position; ?>">
	<div class="main-content-padding">
<?php       udesign_main_content_top( is_front_page() ); ?>
<?php	    if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
<?php               udesign_entry_before(); ?>
		    <div class="entry">
<?php                   udesign_entry_top(); ?>
<?php 
			echo '<style>.widget h3, .textwidget p { text-align: center; } </style>';

			if( is_singular( 'event' ) && has_post_thumbnail() ) {
				echo '<p style="text-align: center;">' . get_the_post_thumbnail() . '</p><div class="clear" style="padding-top: 20px;"></div>';
			}
?>
<?php			the_content(__('<p class="serif">Read the rest of this page &raquo;</p>', 'udesign')); ?>
<?php                   udesign_entry_bottom(); ?>
		    </div>
<?php               udesign_entry_after(); ?>
		</div>
<?php		( $udesign_options['show_comments_on_pages'] == 'yes' ) ? comments_template() : '';
	    endwhile; endif; ?>
	    <div class="clear"></div>
<?php       udesign_main_content_bottom(); ?>
	</div><!-- end main-content-padding -->
    </div><!-- end main-content -->

<?php	if( !$udesign_options['remove_default_page_sidebar'] == 'yes' && sidebar_exist('get-involved') ) { get_sidebar('Get-Involved'); } ?>
</div><!-- end content-container -->

<div class="clear"></div>

<?php

get_footer();
