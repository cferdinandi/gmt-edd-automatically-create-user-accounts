<?php


	/**
	 * Add settings section
	 * @param array $sections The current sections
	 */
	function gmt_edd_user_accounts_settings_section( $sections ) {
		$sections['gmt_edd_user_accounts'] = __( 'Automatic  User Accounts', 'gmt_edd' );
		return $sections;
	}
	add_filter( 'edd_settings_sections_extensions', 'gmt_edd_user_accounts_settings_section' );



	/**
	 * Add settings
	 * @param  array $settings The existing settings
	 */
	function gmt_edd_user_accounts_settings( $settings ) {

		$empty_cart_settings = array(
			array(
				'id'    => 'gmt_edd_user_accounts_settings',
				'name'  => '<strong>' . __( 'Create User Account Settings', 'gmt_edd' ) . '</strong>',
				'desc'  => __( 'Configure Automatic User Account Settings', 'gmt_edd' ),
				'type'  => 'header',
			),
			array(
				'id'      => 'gmt_edd_user_account_url',
				'name'    => __( 'Site URL', 'gmt_edd_create_user' ),
				'desc'    => __( 'The URL of site where you should create the user account.', 'gmt_edd' ),
				'type'    => 'text',
				'std'     => __( '', 'gmt_edd' ),
			),
			array(
				'id'      => 'gmt_edd_user_account_username',
				'name'    => __( 'Username', 'gmt_edd_create_user' ),
				'desc'    => __( 'WP REST API Username', 'gmt_edd' ),
				'type'    => 'text',
				'std'     => __( '', 'gmt_edd' ),
			),
			array(
				'id'      => 'gmt_edd_user_account_password',
				'name'    => __( 'Password', 'gmt_edd_create_user' ),
				'desc'    => __( 'WP REST API Password', 'gmt_edd' ),
				'type'    => 'password',
				'std'     => __( '', 'gmt_edd' ),
			),
			array(
				'id'      => 'gmt_edd_user_account_already_exists',
				'name'    => __( 'User Account Already Exists', 'gmt_edd_create_user' ),
				'desc'    => __( 'Message to display when a user account already exists.', 'gmt_edd' ),
				'type'    => 'textarea',
				'std'     => __( '', 'gmt_edd' ),
			),
			array(
				'id'      => 'gmt_edd_user_account_created',
				'name'    => __( 'User Account Created', 'gmt_edd_create_user' ),
				'desc'    => __( 'Message to display when a user account is created.', 'gmt_edd' ),
				'type'    => 'textarea',
				'std'     => __( '', 'gmt_edd' ),
			),
		);
		if ( version_compare( EDD_VERSION, 2.5, '>=' ) ) {
			$empty_cart_settings = array( 'gmt_edd_user_accounts' => $empty_cart_settings );
		}
		return array_merge( $settings, $empty_cart_settings );
	}
	add_filter( 'edd_settings_extensions', 'gmt_edd_user_accounts_settings', 999, 1 );