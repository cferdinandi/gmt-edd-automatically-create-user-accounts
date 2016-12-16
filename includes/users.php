<?php


	/**
	 * Create a new user when a product is purchased
	 * @param  integer $payment_id The payment ID
	 */
	function gmt_edd_create_user_account_on_complete_purchase( $payment_id ) {

		// Variables
		$payment = edd_get_payment_meta( $payment_id );
		$user = get_user_by( 'email', sanitize_email( $payment['email'] ) );

		// If user account already exists, bail
		if ( !empty( $user ) ) return EDD()->session->set( 'gmt_edd_user_created', false );

		// See if user account should be created
		$create_account = 'off';
		foreach( $payment['downloads'] as $download ) {
			if ( get_post_meta( $download['id'], 'gmt_edd_create_user_account', true ) === 'on' ) {
				$create_account = 'on';
				break;
			}
		}
		if ( $create_account === 'off' ) return EDD()->session->set( 'gmt_edd_user_created', false );

		// Create user
		$user_id = wp_create_user( sanitize_email( $payment['email'] ), wp_generate_password(), sanitize_email( $payment['email'] ) );

		// Store data about whether or not user was created
		EDD()->session->set( 'gmt_edd_user_created', true );

		// Emit action hook
		do_action( 'gmt_edd_create_user_account_after', $user_id, sanitize_email( $payment['email'] ) );

	}
	add_action( 'edd_complete_purchase', 'gmt_edd_create_user_account_on_complete_purchase' );



	/**
	 * Adds the content snippet shortcode
	 * @param  array $atts The shortcode args
	 * @return string      The content snippet
	 */
	function gmt_edd_create_user_shortcode( $atts, $content = null ) {

		// Don't run if cart is empty
		if ( empty( EDD()->session->get( 'edd_purchase' ) ) ) return;

		// Variables
		$user = EDD()->session->get( 'gmt_edd_user_created' );
		$message = empty( $user ) ? edd_get_option( 'gmt_edd_user_account_already_exists', false ) : edd_get_option( 'gmt_edd_user_account_created', false );

		return wpautop( $message, false );

	}
	add_shortcode( 'gmt_edd_user', 'gmt_edd_create_user_shortcode' );