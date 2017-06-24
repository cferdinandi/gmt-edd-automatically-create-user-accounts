<?php


	/**
	 * Create a new user when a product is purchased
	 * @param  integer $payment_id The payment ID
	 */
	function gmt_edd_create_user_account_on_complete_purchase( $payment_id ) {

		// Get payment data
		$payment = edd_get_payment_meta( $payment_id );

		// See if user account should be created
		$create_account = 'off';
		foreach( $payment['downloads'] as $download ) {
			$disable = get_post_meta( $download['id'], 'gmt_edd_disable_user_account', true );
			if (empty($disable) || $disable === 'off') {
				$create_account = 'on';
				break;
			}
		}

		// If no account should be created, bail
		if ( $create_account === 'off' ) {
			EDD()->session->set( 'gmt_edd_user_created', 100 );
			return;
		}

		// Get credentials
		$email = sanitize_email( $payment['email'] );
		$credentials = array(
			'url' => edd_get_option( 'gmt_edd_user_account_url', false ),
			'username' => edd_get_option( 'gmt_edd_user_account_username', false ),
			'password' => edd_get_option( 'gmt_edd_user_account_password', false ),
		);
		if ( empty($credentials['url']) || empty($credentials['username']) || empty($credentials['password']) ) return;

		// Create user account
		$create_user = wp_remote_request(
			rtrim( $credentials['url'], '/' ) . '/wp-json/gmt-edd-create-user/v1/users/' . $email,
			array(
				'method'    => 'POST',
				'headers'   => array(
					'Authorization' => 'Basic ' . base64_encode( $credentials['username'] . ':' . $credentials['password'] ),
				),
			)
		);
		$create_user_response = (array) json_decode( wp_remote_retrieve_body($create_user) );

		// If API request is successful
		if ( is_array($create_user_response) && array_key_exists('code', $create_user_response) ) {

			// If user already exists
			if (intval($create_user_response['code']) === 200) {
				EDD()->session->set( 'gmt_edd_user_created', 200 );
			}

			// If new user was created
			else if (intval($create_user_response['code']) === 201) {
				EDD()->session->set( 'gmt_edd_user_created', 201 );
			}

			// Otherwise, throw an error
			else {
				EDD()->session->set( 'gmt_edd_user_created', 400 );
			}

			// Emit action hook
			do_action( 'gmt_edd_create_user_account_after', $email );

		}

		// Otherwise, throw an error
		else {
			EDD()->session->set( 'gmt_edd_user_created', 401 );
		}


	}
	add_action( 'edd_complete_purchase', 'gmt_edd_create_user_account_on_complete_purchase' );



	/**
	 * Adds the content snippet shortcode
	 * @param  array $atts The shortcode args
	 * @return string      The content snippet
	 */
	function gmt_edd_create_user_shortcode() {

		// Don't run if cart is empty
		if ( empty( EDD()->session->get( 'edd_purchase' ) ) ) return;

		// Get user account status
		$user = EDD()->session->get( 'gmt_edd_user_created' );
		if (empty($user) || $user === 400) return;

		// Get message
		if ($user === 200) return wpautop( edd_get_option( 'gmt_edd_user_account_already_exists', false ), false );
		if ($user === 201) return wpautop( edd_get_option( 'gmt_edd_user_account_created', false ), false );

	}
	add_shortcode( 'gmt_edd_user', 'gmt_edd_create_user_shortcode' );