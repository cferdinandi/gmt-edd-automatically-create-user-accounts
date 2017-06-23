<?php


	function gmt_edd_create_user_from_email( $data ) {

		// if no email, throw an error
		if (empty($data['email']) || !is_email($data['email'])) {
			return new WP_REST_Response(array(
				'code' => 400,
				'message' => __( 'Not a valid email address', 'gmt_edd_create_user' ),
			), 200);
		}

		// if user already exists
		if (email_exists($data['email'])) {
			return new WP_REST_Response(array(
				'code' => 200,
				'message' => __( 'User with that email already exists', 'gmt_edd_create_user' ),
			), 200);
		}

		// Otherwise, create user
		$email = sanitize_email($data['email']);
		$user = wp_create_user($email, wp_generate_password( 48, false ), $email);

		// Return success
		return new WP_REST_Response(array(
			'code' => 201,
			'message' => __( 'User was successfully created', 'gmt_edd_create_user' ),
		), 200);

	}


	function gmt_edd_create_user_register_routes () {
		register_rest_route('gmt-edd-create-user/v1', '/users/(?P<email>\S+)', array(
			'methods' => 'POST',
			'callback' => 'gmt_edd_create_user_from_email',
			'permission_callback' => function () {
				return current_user_can( 'create_users' );
			},
			'args' => array(
				'email' => array(
					'type' => 'string',
				),
			),
		));
	}
	add_action( 'rest_api_init', 'gmt_edd_create_user_register_routes' );