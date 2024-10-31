<?php

class PAYPLUG_Plugin {

	public function __construct() {
		if ( is_admin() ) {
			add_action( 'admin_menu', array( __CLASS__, 'payplug_admin_menu' ) );
			add_action( 'admin_init', array( __CLASS__, 'payplug_admin_init' ) );
			add_action( 'init', array( __CLASS__, 'save_payplug_configuration' ) );
			add_action( 'admin_notices', array( __CLASS__, 'payplug_admin_notices' ) );
			add_action( 'admin_notices', array( __CLASS__, 'admin_notices' ) );
			add_action( 'admin_head', array( __CLASS__, 'payplug_admin_head' ) );
		}

		add_shortcode( 'payplug', array( __CLASS__, 'payplug_shortcode' ) );
	}

	/**
	 * @param $links
	 * @return array
	 */
	public static function _payplug_plugin_action_links( $links ) {
		$links[] = '<a href="'. get_admin_url(null, 'admin.php?page=payplug-admin-options') .'">' . __('Settings', 'payplug') . '</a>';
		return $links;
	}

	/**
	 *
	 */
	public static function payplug_admin_head() {
		add_filter( 'mce_external_plugins', array( __CLASS__, 'payplug_mce_external_plugins' ) );
		add_filter( 'mce_buttons', array( __CLASS__, 'payplug_mce_buttons' ) );
	}

	/**
	 * @param $plugin_array
	 *
	 * @return mixed
	 */
	public static function payplug_mce_external_plugins( $plugin_array ) {
		$plugin_array['shortcode_drop'] = PAYPLUG_URL . 'assets/js/button.js';

		return $plugin_array;
	}

	/**
	 * @param $buttons
	 *
	 * @return mixed
	 */
	public static function payplug_mce_buttons( $buttons ) {
		array_push( $buttons, 'payplug_shortcode_button' );

		return $buttons;
	}

	/**
	 *
	 */
	public static function payplug_admin_notices() {
		settings_errors( 'payplug-notices' );
	}

	/**
	 *
	 */
	public static function payplug_admin_menu() {
		add_menu_page(
			__( 'PayPlug', 'payplug' ),
			__( 'PayPlug', 'payplug' ),
			'manage_options',
			'payplug-admin-options',
			array( __CLASS__, 'payplug_admin' ),
			PAYPLUG_URL . 'assets/images/payplug.png',
			62
		);
		do_settings_sections( 'payplug' );
	}

	/**
	 *
	 */
	public static function payplug_admin() { ?>
		<style>
			#wc_get_started.payplug {
				padding: 10px;
				padding-left: 230px;
				background-image: url(<?php echo plugins_url( '../assets/images/payplug-logo-large.png' , __FILE__ )?>);
				background-position: 20px 40%;
				background-repeat: no-repeat;
				background-color: white;
				margin-top: 10px;
				border-radius: 5px;
				margin-bottom: 15px;
			}
			ul.payplug{
				list-style: initial;
				padding-left: 40px;
			}
		</style>
		<div id="wc_get_started" class="payplug">
			<span><?php _e( 'Integrate online payment on your website in 1 minute.', 'payplug' ); ?></span>
			<?php _e( '<b>2,5% per transaction + 0,25 €</b>.<br/>Your client doesn\'t have to account to pay.', 'payplug' ); ?>
			<p>
				<a href="http://www.payplug.fr/portal2/signup?sponsor=136" target="_blank"
				   class="button button-primary"><?php _e( 'Create free account', 'payplug' ); ?></a>
				<a href="http://www.payplug.fr/?sponsor=136" target="_blank"
				   class="button"><?php _e( 'Learn more about PayPlug', 'payplug' ); ?></a>
			</p>
		</div>
		<h2><?php _e( 'PayPlug configuration', 'payplug' ); ?></h2>
		<form action="options.php" method="post"><?php
		settings_fields( 'payplug-admin-settings' );
		do_settings_sections( 'payplug-admin-settings' );
		submit_button(); ?>
        <?php
        _e( 'Once configured, 3 ways to generate a payment button PayPlug :', 'payplug' );
        echo '
	        <ul class="payplug">
	        	<li>' . __( 'use the shortcode <br><code>[payplug price="xx.xx" title_button="Buy" class="payplug_buy_button my_class" icon="glyphicon" order_id="order_id" custom_data="custom_data" email="test@test.com" first_name="firstname" last_name="lastname" ]</code>', 'payplug' ) . '</li>
	        	<li>' . __( 'use the Payplug widget', 'payplug' ) . '</li>
	        	<li>' . __( 'for developpers, use static method <br><code>&lt;?php PAYPLUG_Plugin::payplug_generate_payment_link( price, \'Button text\', \'CSS class\' , \'Icon\', \'Order id\', \'Custom data\', \'test@test.com\', \'firstname\', \'lastname\' ); ?&gt;</code>', 'payplug' ) . '</li>
	        </ul>
        ';
        ?>

		</form><?php
	}

	/**
	 *
	 */
	public static function payplug_admin_init() {
		register_setting(
			'payplug-admin-settings',
			'payplug_options',
			''
		);
		add_settings_section(
			'payplug_id',
			'',
			'',
			'payplug-admin-settings'
		);
		add_settings_field(
			'login',
			__( 'Login PayPlug', 'payplug' ),
			array( __CLASS__, 'input_login' ),
			'payplug-admin-settings',
			'payplug_id'
		);
		add_settings_field(
			'password',
			__( 'Password PayPlug', 'payplug' ),
			array( __CLASS__, 'input_password' ),
			'payplug-admin-settings',
			'payplug_id'
		);
		add_settings_field(
			'test_mode',
			__( 'Payplug TEST mode ?', 'payplug' ),
			array( __CLASS__, 'input_test_mode' ),
			'payplug-admin-settings',
			'payplug_id'
		);
		add_settings_field(
			'ipn_url',
			__( 'IPN (Instant Payment Notification) URL', 'payplug' ),
			array( __CLASS__, 'input_ipn' ),
			'payplug-admin-settings',
			'payplug_id'
		);
		add_settings_field(
			'return_url',
			__( 'Return URL', 'payplug' ),
			array( __CLASS__, 'input_return' ),
			'payplug-admin-settings',
			'payplug_id'
		);
		add_settings_field(
			'tracker',
			__( 'Allow Usage Tracking ?', 'payplug' ),
			array( __CLASS__, 'input_tracker' ),
			'payplug-admin-settings',
			'payplug_id'
		);
	}

	/**
	 *
	 */
	public static function input_login() {
		echo self::input( 'login' );
	}

	/**
	 *
	 */
	public static function input_ipn(){
		echo home_url() . '/' . self::input( 'ipn_url', 'text', '50%' );
	}

	/**
	 *
	 */
	public static function input_return(){
		echo home_url() . '/' . self::input( 'return_url', 'text', '50%' );
	}

	/**
	 *
	 */
	public static function input_password() {
		echo self::input( 'password', 'password' );
	}

	/**
	 *
	 */
	public static function input_test_mode() {
		echo self::input( 'test_mode', 'checkbox' );
	}

	/**
	 *
	 */
	public static function input_tracker() {
		echo self::input( 'tracker', 'checkbox' );
		_e( 'Allow Plateforme WP Digital to anonymously track how this plugin is used and help us make the plugin better.', 'payplug' );
	}

	/**
	 * @param $name
	 * @param string $type
	 *
	 * @return string
	 */
	public static function input( $name, $type = 'text', $style = '90%' ) {
		$options      = get_option( 'payplug_options' );
		$option_value = isset( $options[ $name ] ) ? $options[ $name ] : '';
		// Anciennes metas pour récupération des informations
		if ( '' == $option_value ) {
			$option_value = get_option( 'payplug_' . $name );
			if ( 'test_mode' == $name ) {
				$option_value = ( 1 == $option_value ) ? 'on' : '';
			}
		}
		$value = 'value="' . esc_attr( $option_value ) . '"';
		$style = 'style="width:' . $style . '"';
		if ( 'checkbox' == $type ) {
			$value = ( 'on' == $option_value ) ? 'checked="checked"' : '';
			$style = '';
		}

		return '<input type="' . $type . '" name="payplug_options[' . $name . ']" ' . $style . ' ' . $value . '>';
	}

	/**
	 * @return bool
	 */
	public static function save_payplug_configuration() {
		// Action leaflet for the tracker
		if ( isset( $_GET['payplug_tracker_action'] ) ) {
			update_option( 'payplug_options', array( 'tracker' => ( 'tracker_allow' == $_GET['payplug_tracker_action'] ) ? 'on' : '' ) );
			wp_redirect( remove_query_arg( 'payplug_tracker_action' ) );
			exit;
		}

		if ( isset( $_POST['option_page'] ) && 'payplug-admin-settings' == $_POST['option_page'] ) {
			$login     = ( isset( $_POST['payplug_options']['login'] ) ) ? $_POST['payplug_options']['login'] : null;
			$password  = ( isset( $_POST['payplug_options']['password'] ) ) ? $_POST['payplug_options']['password'] : null;
			$test_mode = ( isset( $_POST['payplug_options']['test_mode'] ) ) ? true : false;
			$tracker   = ( isset( $_POST['payplug_options']['tracker'] ) ) ? true : false;

			require_once( ABSPATH . 'wp-admin/includes/template.php' );

			if ( is_null( $login ) || is_null( $password ) ) {
				add_settings_error(
					'payplug-notices',
					'empty_fields',
					__( 'The login and password are mandatory', 'payplug' ),
					'error'
				);

				return false;
			}

			require_once PAYPLUG_DIR . '/classes/payplug_php/lib/Payplug.php';
			try {
				$parameters = Payplug::loadParameters(
					$login,
					$password,
					$test_mode
				);
			} catch ( Exception $e ) {
				$error = __( 'Your login and/or password PayPlug are incorrect', 'payplug' );
				if ( '' != $e->getMessage() ) {
					$error = $e->getMessage();
				}

				add_settings_error(
					'payplug-notices',
					'error_payplug',
					__( 'PayPlug error', 'payplug' ) . ' : ' . $error,
					'error'
				);

				return false;
			}

			// update option Payplug of parameters
			update_option( 'payplug_parameters', json_encode( $parameters ) );

			// If tracker, send email monitoring
			if ( $tracker ) {
				$headers   = array();
				$headers[] = 'From: "Plateforme WP Digital" <pwd@plateformewpdigital.fr>';
				wp_mail(
					'pwd@plateformewpdigital.fr',
					'Nouvelle installation du plugin Payplug',
					'Voici le login du nouveau compte Payplug qui utilise le plugin WP Payplug : ' . $login,
					$headers
				);
			}

			add_settings_error(
				'payplug-notices',
				'success_payplug',
				__( 'Changes saved', 'payplug' ),
				'updated'
			);
		}
	}

	/**
	 * Generate payement link
	 * Ex:
	 *     echo PAYPLUG_Plugin::payplug_generate_payment_link( '48,87', NULL, NULL, 'my_icon' );
	 *     echo PAYPLUG_Plugin::payplug_generate_payment_link( '48,87', 'Buy with Payplug', 'my_css_class, 'my_icon' );
	 * @param  int $prix
	 * @param  string $title_button
	 * @param  string $class_button
	 * @param  string $icon
	 * @return string $orderID
	 * @return string $customData
	 */
	public static function payplug_generate_payment_link( $prix, $title_button = NULL, $class_button = NULL, $icon = NULL, $orderID = NULL, $customData = NULL, $email = NULL, $first_name = NULL, $last_name = NULL )
	{
		$atts = array(
			'price' => $prix
		);

		if( NULL != $title_button ) $atts[ 'title_button' ] = $title_button;
		if( NULL != $class_button ) $atts[ 'class' ] = $class_button;
		if( NULL != $icon ) 		$atts[ 'icon' ] = $icon;
		if( NULL != $orderID ) 		$atts[ 'order_id' ] = $orderID;
		if( NULL != $customData ) 	$atts[ 'custom_data' ] = $customData;
		if( NULL != $email ) 		$atts[ 'email' ] = $email;
		if( NULL != $first_name ) 	$atts[ 'first_name' ] = $first_name;
		if( NULL != $last_name ) 	$atts[ 'last_name' ] = $last_name;

		return self::payplug_shortcode( $atts );
	}

	/**
	 * @param $atts
	 *
	 * @return string
	 */
	public static function payplug_shortcode( $atts ) {

		require_once PAYPLUG_DIR . '/classes/payplug_php/lib/Payplug.php';

		// Retrieving settings
		$parameters = get_option( 'payplug_parameters' );
		$options    = get_option( 'payplug_options' );

		// If error
		if ( '' == $parameters || ! isset( $atts['price'] ) ) {
			return __( 'Unable to generate the shortcode PayPlug, thank you to verify the configuration PayPlug', 'payplug' );
		}

		// PayPlug settings
		Payplug::setConfig( Parameters::createFromString( $parameters ) );

		// Generate URL
		$array = array(
			'amount'   => str_replace( ',', '.', $atts['price'] ) * 100,
			'currency' => 'EUR',
			'ipnUrl'   => home_url() . ( isset( $options[ 'ipn_url' ] )    ? '/' . $options[ 'ipn_url' ] : '' ),
			'returnUrl'=> home_url() . ( isset( $options[ 'return_url' ] ) ? '/' . $options[ 'return_url' ] : '' ),
		);
		if( isset( $atts[ 'email' ] ) && !empty( $atts[ 'email' ] ) ){
			$array[ 'email' ] = $atts[ 'email' ];
		}
		if( isset( $atts[ 'first_name' ] ) && !empty( $atts[ 'first_name' ] ) ){
			$array[ 'firstName' ] = $atts[ 'first_name' ];
		}
		if( isset( $atts[ 'last_name' ] ) && !empty( $atts[ 'last_name' ] ) ){
			$array[ 'lastName' ] = $atts[ 'last_name' ];
		}
		if( isset( $atts[ 'order_id' ] ) && !empty( $atts[ 'order_id' ] ) ){
			$array[ 'order' ] = $atts[ 'order_id' ];
		}
		if( isset( $atts[ 'custom_data' ] ) && !empty( $atts[ 'custom_data' ] ) ){
			$array[ 'customData' ] = $atts[ 'custom_data' ];
		}
		$paymentUrl = PaymentUrl::generateUrl( $array );

		$title_button = ( isset( $atts['title_button'] ) ) ? $atts['title_button'] : __( 'Buy', 'payplug' );
		$class_button = ( isset( $atts['class'] ) ) ? $atts['class'] : 'payplug_buy_button';
		$icon		  = ( isset( $atts['icon'] ) ) ? '<i class="' . $atts['icon'] . '"></i>' : '';

		return '<a class="' . $class_button . '" href="' . $paymentUrl . '" target="_blank" base_url="https://www.payplug.fr">' . $icon . esc_attr($title_button) . '</a>';
	}

	/**
	 * getIpn
	 * @return array => fields : amount, customData, customer, email, firstName, idTransaction, lastName, order, origin, state, isTest
	 */
	public static function getIpn()
	{

		require_once PAYPLUG_DIR . '/classes/payplug_php/lib/Payplug.php';

		// Retrieving settings
		$parameters = get_option( 'payplug_parameters' );
		$options    = get_option( 'payplug_options' );

		// PayPlug settings
		Payplug::setConfig( Parameters::createFromString( $parameters ) );

		try {
		    $ipn = new IPN();
		    return array(
				'amount'        => $ipn->amount,
				'customData'    => $ipn->customData,
				'customer'      => $ipn->customer,
				'email'         => $ipn->email,
				'firstName'     => $ipn->firstName,
				'idTransaction' => $ipn->idTransaction,
				'lastName'      => $ipn->lastName,
				'order'         => $ipn->order,
				'origin'        => $ipn->origin,
				'state'         => $ipn->state,
				'isTest'        => $ipn->isTest,
		    );
		} catch( Exception $e ) {
		}
		return array();
	}

	/**
	 *
	 */
	public static function admin_notices() {
		$hide_notice = get_option( 'payplug_tracking_notice' );

		if ( $hide_notice ) {
			return;
		}

		if ( '' != get_option( 'payplug_options' ) ) {
			return;
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		if (
			stristr( network_site_url( '/' ), 'dev' ) !== false ||
			stristr( network_site_url( '/' ), 'localhost' ) !== false ||
			stristr( network_site_url( '/' ), ':8888' ) !== false // This is common with MAMP on OS X
		) {
			update_option( 'payplug_tracking_notice', '1' );
		} else {
			$optin_url  = add_query_arg( 'payplug_tracker_action', 'tracker_allow' );
			$optout_url = add_query_arg( 'payplug_tracker_action', 'tracker_disallow' );

			echo '<div class="updated"><p>';
			echo __( 'Allow Plateforme WP Digital to anonymously track how this plugin is used and help us make the plugin better.', 'payplug' );
			echo '&nbsp;<a href="' . esc_url( '' ) . '" class="button-secondary">' . __( 'Allow', 'payplug' ) . '</a>';
			echo '&nbsp;<a href="' . esc_url( '' ) . '" class="button-secondary">' . __( 'Do not allow', 'payplug' ) . '</a>';
			echo '</p></div>';
		}
	}

	/**
	 * @return mixed
	 */
	public static function activate() {

		// @TODO Test extension_load Curl

		if ( ! extension_loaded( 'openssl' ) ) {
			add_settings_error(
				'payplug-notices',
				'extension_openssl',
				__( 'OpenSSL must be enabled to run PayPlug', 'payplug' ),
				'error'
			);

			return false;
		}
	}
}
