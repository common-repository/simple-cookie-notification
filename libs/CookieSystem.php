<?php

namespace BeforeAfter\Cookies;


class CookieSystem {

	protected static $_instance = null;

	public function start()
	{

	}

	public function __construct()
	{
		$this->init();

		add_action( 'admin_init', array(
			$this,
			'register_ba_integrations_settings',
		) );
		add_action( 'admin_menu', array(
			$this,
			'ba_cookies_add_menu_page',
		) );


	}


	public static function instance()
	{
		if( is_null( self::$_instance ) ){
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function init()
	{

		/**
		 * Check if cookie is NOT set
		 */
		if( !$this->check_cookies() ){

			add_action( 'wp_footer', array(
				$this,
				'show_message',
			) );

		}

	}

	public function show_message()
	{
		$cookieLink = get_option( 'ba_cookie_link' );
		$privacyLink = get_option( 'ba_privacy_link' );
		$cookieText = get_option( 'ba_cookie_text' ) ? get_option( 'ba_cookie_text' ) : __( 'Read more', 'b4after_cookies' );
		$privacyText = get_option( 'ba_privacy_text' ) ? get_option( 'ba_privacy_text' ) : __( 'Read more', 'b4after_cookies' );
		$interactionClass = get_option( 'ba_set_cookie_on_interaction' ) ? 'interactionClass' : '';


		$html = '';
		$html .= '<div class="ba_cookie_bar '.$interactionClass.'">';
		$html .= '<img src="'.BA_COOKIES_URL.'/assets/cancel.svg" class="close_notification">';
		$html .= '<div><p>'.get_option( 'ba_admin_bar_text', __( 'Website is using cookies', 'b4after_cookies' ) ).'</p></div>';

		$html .= '<div>';

		$html .= $cookieLink ? '<a href="'.esc_url( $cookieLink ).'" rel="nofollow">'.$cookieText.'</a>' : '';
		$html .= $privacyLink ? '<a href="'.esc_url( $privacyLink ).'" rel="nofollow">'.$privacyText.'</a>' : '';
		$html .= '<button class="" style="background-color: '.get_option( 'ba_button_color', '#2C92D0' ).'" >'.get_option( 'ba_button_text', __( 'Ok, i got it', 'b4after_cookies' ) ).'</button>';
		$html .= '</div></div>';

		echo $html;
	}

	/**
	 * @return bool
	 */
	public function check_cookies()
	{

		if( isset( $_COOKIE[ 'cookie_info' ] ) ){
			return true;
		}
		else{
			return false;
		}
	}

	/**
	 *
	 */
	function ba_cookies_add_menu_page()
	{


		add_menu_page( __( 'Cookie notification', 'b4after_cookies' ), __( 'Cookie notification', 'b4after_cookies' ), 'edit_pages', 'ba_cookies_functions.php', [
			$this,
			'ba_cookies_aftersetup',
		], 'dashicons-admin-comments', 99 );

	}


	/**
	 *
	 */
	public function register_ba_integrations_settings()
	{
		//register our settings

		register_setting( 'simple-cookie-notification', 'ba_admin_bar_text' );
		register_setting( 'simple-cookie-notification', 'ba_cookie_text' );
		register_setting( 'simple-cookie-notification', 'ba_cookie_link' );
		register_setting( 'simple-cookie-notification', 'ba_privacy_text' );
		register_setting( 'simple-cookie-notification', 'ba_privacy_link' );
		register_setting( 'simple-cookie-notification', 'ba_button_color' );
		register_setting( 'simple-cookie-notification', 'ba_button_text' );
		register_setting( 'simple-cookie-notification', 'ba_set_cookie_on_interaction' );

		register_setting( 'simple-cookie-notification', 'ba_json' );


	}

	/**
	 * Gets export json
	 *
	 * @return mixed|string|void
	 */
	public function getExport()
	{

		$ba_json_exporter = get_option( 'ba_json' );


		return json_decode( $ba_json_exporter, true );
	}

	/**
	 * Runs import
	 */
	function import()
	{
		$export = $this->getExport();
		global $new_whitelist_options;

		$ba_cookies_options = $new_whitelist_options[ 'simple-cookie-notification' ];

		$importArr = [];

		/**
		 * Get each option
		 */
		foreach( $ba_cookies_options as $option ){

			if( empty( get_option( $option ) ) ){
				$importArr[ $option ] = $option;

				update_option( $option, $export[ $option ] );

				$importArrrr[ $option ] = $export[ $option ];
			}

		}


	}

	/**
	 * Renders fields
	 */
	public function ba_cookies_aftersetup()
	{
		echo '<h1>'.__( 'GDPR Simple Notification', 'b4after_cookies' ).'</h1>';

		$this->import();


		$ba_cookie_link = esc_attr( get_option( 'ba_cookie_link' ) );
		$ba_cookie_text = get_option( 'ba_cookie_text' );


		$ba_privacy_link = esc_attr( get_option( 'ba_privacy_link' ) );
		$ba_privacy_text = esc_attr( get_option( 'ba_privacy_text' ) );

		$ba_button_color = esc_attr( get_option( 'ba_button_color' ) );
		$ba_button_text = esc_attr( get_option( 'ba_button_text' ) );

		$ba_admin_bar_text = esc_attr( get_option( 'ba_admin_bar_text' ) );

		$ba_json_exporter = get_option( 'ba_json' );

		$ba_cookie_on_interaction = get_option( 'ba_set_cookie_on_interaction' );


		/**
		 * Import datas
		 */


		?>
		<form class="ba_cookie_info" method="post" action="options.php">
        <?php settings_fields( 'simple-cookie-notification' ); ?>
			<?php do_settings_sections( 'simple-cookie-notification' ); ?>
			<div class="form_main">
					<div class="column-3-4">
					<h3><?php _e( 'Configure cookie bar', 'b4after_cookies' ) ?></h3>
					<div class="form_group">
			            <div class="form_row">
			                <div class="form_cell">
				                <?php _e( 'Cookie info link', 'b4after_cookies' ) ?>
			                </div>
			                <div class="form_cell">
				                <?php
								//								$PageSelect = new PageSelect();
								//								echo $PageSelect->render( 'ba_cookie_link' );
								?>
				                <input type="text" name="ba_cookie_link" value="<?php echo $ba_cookie_link ?>">

			                </div>
			            </div>
						<!---->
						<div class="form_row">
			                <div class="form_cell">
								<?php _e( 'Cookie text', 'b4after_cookies' ) ?>
			                </div>
			                <div class="form_cell">
				                <input type="text" name="ba_cookie_text" value="<?php echo $ba_cookie_text ?>">
			                </div>
			            </div>
		            </div>
					<div class="form_group">
						<!---->
			            <div class="form_row">
			                <div class="form_cell">
			                    <?php _e( 'Privacy link', 'b4after_cookies' ) ?>
			                </div>
			                <div class="form_cell">
				                <?php

								//								$PageSelect = new PageSelect();
								//								echo $PageSelect->render( 'ba_privacy_link' );

								?>
				                <input type="text" name="ba_privacy_link" value="<?php echo $ba_privacy_link ?>">

			                </div>
			            </div>
						<!---->
						<div class="form_row">
			                <div class="form_cell">
				                <?php _e( 'Privacy text', 'b4after_cookies' ) ?>
			                </div>
			                <div class="form_cell">
				                <input type="text" name="ba_privacy_text" value="<?php echo $ba_privacy_text ?>">
			                </div>
			            </div>
					</div>
						<!---->
				<div class="form_group">
					<div class="form_row">
		                <div class="form_cell">
			                <?php _e( 'Button color', 'b4after_cookies' ) ?>
		                </div>
						<?php
						
//						print_r($ba_button_color);
						
						?>
		                <div class="form_cell">
			                <input type="color" name="ba_button_color" value="<?php echo $ba_button_color ?>">
		                </div>
		            </div>
					<!---->
					<div class="form_row">
		                <div class="form_cell">
			                <?php _e( 'Button text', 'b4after_cookies' ) ?>
		                </div>
		                <div class="form_cell">
			                <input type="text" name="ba_button_text" value="<?php echo $ba_button_text ?>">
		                </div>
		            </div>
				</div>
						<!---->
				<div class="form_group">
				<div class="form_row">
	                <div class="form_cell">
		                <?php _e( 'Cookie notification', 'b4after_cookies' ) ?>
	                </div>
	                <div class="form_cell">
		                <textarea name="ba_admin_bar_text" id="" cols="30" rows="10"><?php echo $ba_admin_bar_text ?></textarea>
	                </div>
	            </div>
	            </div>
						<!---->
				<div class="form_group">
					<div class="form_row">
		                <div class="form_cell">
			                <?php _e( 'Import', 'b4after_cookies' ) ?>
		                </div>
		                <div class="form_cell">
			                <input type="text" name="ba_json" value='<?php echo $ba_json_exporter ?>'>
		                </div>
					</div>
					<!---->
					<div class="form_row">
		                <div class="form_cell">
			                <?php _e( 'Export', 'b4after_cookies' ) ?>
		                </div>
		                <div class="form_cell">
			                <button class="button button-primary" id="ba_cookie_info_export"><?php _e( 'Export fields', 'b4after_cookies' ) ?></button>
			                <div id="json_export"></div>
		                </div>
					</div>
				</div>
            </div>
			<div class="column-1-4">
				<h3><?php _e( 'Settings', 'b4after_cookies' ) ?></h3>
				<div class="form_group">
					<div class="form_row small">
		                <div class="form_cell">
			                <?php _e( 'Add cookie on interaction?', 'b4after_cookies' ) ?><br/>
			                <small><?php _e( 'Adds cookie whenever internal link is clicked', 'b4after_cookies' ) ?></small>
		                </div>
		                <div class="form_cell">
			                <?php
							//							echo $ba_cookie_on_interaction;
							?>
			                <input type="checkbox" name="ba_set_cookie_on_interaction" <?php checked( $ba_cookie_on_interaction, '1', true ) ?>value="1" />
		                </div>
					</div>
				</div>


			</div>
			</div>
			<?php submit_button(); ?>
    </form>

		<?php
	}

}

//function run_cookies(){
//	$cookies = CookieSystem::instance();
//}
//
//add_action( 'plugins_loaded', 'run_cookies' );
//add_action( 'init', 'run_cookies' );
