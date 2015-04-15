<?php
$campaign_title = get_post_meta( $donation->ID, '_' . 'campaign_title', true );

switch ( $donation->post_status ) :
	case 'publish' :
		printf( __( 'Donation validated successfully. To view your donation <a href="%s">click here</a>.', 'wpdonations' ), get_permalink( $donation->ID ) );
	break;
	case 'pending_payment' :
		print( __( 'Donation submitted successfully. Your donation will be taken into account as soon as we receive the payment gateway validation (it can take several minutes).', 'wpdonations' ) );
		echo 'title= ' . $campaign_title;
	break;
	case 'pending_off_payment' :
		print( __( 'Donation submitted successfully. Your donation will be taken into account once payment is received.<br /><br />You chose an offline payment method so please download, complete and return the Standing Order form below to set up your payment.', 'wpdonations' ) );
		echo 'title= ' . $campaign_title;
		if ( get_option( 'wpdonations_offline_payment_text' ) ) {
			print( '<p>' . get_option( 'wpdonations_offline_payment_text' ) . '</p>' ); 
		}
	break;
endswitch;

do_action( 'wpdonations_donation_submitted_content_' . str_replace( '-', '_', sanitize_title( $donation->post_status ) ), $donation );
