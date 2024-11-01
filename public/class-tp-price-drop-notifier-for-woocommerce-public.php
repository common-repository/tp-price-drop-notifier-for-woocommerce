<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       tplugins.com
 * @since      1.0.0
 *
 * @package    Tp_Price_Drop_Notifier_For_Woocommerce
 * @subpackage Tp_Price_Drop_Notifier_For_Woocommerce/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Tp_Price_Drop_Notifier_For_Woocommerce
 * @subpackage Tp_Price_Drop_Notifier_For_Woocommerce/public
 * @author     TP Plugins <pluginstp@gmail.com>
 */
class Tp_Price_Drop_Notifier_For_Woocommerce_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name.'-icons', plugin_dir_url( __FILE__ ) . 'icons/css/fontello.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/tp-price-drop-notifier-for-woocommerce-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/tp-price-drop-notifier-for-woocommerce-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'tppdn',
			array( 
				'ajaxurl'                => admin_url( 'admin-ajax.php' ),
				'is_mobile'              => wp_is_mobile(),
				'is_cart'                => is_cart(),
				'is_checkout'            => is_checkout(),
				'is_product'             => is_product(),
				'form_type'              => get_option('tppdn_form_type'),
				'add_newsletter'         => get_option('tppdn_add_newsletter'),
				'validation_message'     => get_option('tppdn_validation_message'),
				'success_message'        => get_option('tppdn_success_message'),
				'show_on_archive'        => get_option('tppdn_show_on_archive'),
				'activate_price_drop'    => get_option('tppdn_activate_price_drop'),
				'activate_back_to_stock' => get_option('tppdn_activate_back_to_stock')
				//'count_limit' => get_option('tpgw_note_word_count_limit')
			)
		);
	}

	public function init_price_drop_notifier() {
		global $product;
		global $woocommerce_loop;
 
		$display_none  = '';
		$track_type    = 'price';
		$product_id    = $product->get_id();
		$product_name  = $product->get_name();
		$price         = $product->get_price();
		$price_html    = $product->get_price_html();
		$is_in_stock   = $product->is_in_stock();
		//$display_price = $product->get_display_price();
		$main_class = '';

		$nonce = wp_create_nonce("save_price_drop_notifier");

		$form_type = get_option('tppdn_form_type');

		$activate_price_drop    = get_option('tppdn_activate_price_drop');

		$label_btn_title        = get_option('tppdn_label_btn_title');
		//$label_btn_title_shop   = get_option('tppdn_label_btn_title_shop');
		$label_your_name        = get_option('tppdn_label_your_name');
    	$label_your_email       = get_option('tppdn_label_your_email');
    	$label_price_lower_than = get_option('tppdn_label_price_lower_than');
		$label_form_send        = get_option('tppdn_label_form_send');

		$track_price_icon = get_option('tppdn_track_price_icon');

		$page        = 'product';
		$label_title = $label_btn_title;
		$referer     = 'product';

		if(!$activate_price_drop) {
			$main_class .= ' tppdn_display_none_'.$track_type;
		}

		if($this->form_display_to()){
		?>
			
			<div id="tppdn-box-<?php echo esc_attr($product->get_id()); ?>" class="tppdn-box <?php echo 'tppdn-form-type-'.esc_attr($form_type).''.esc_attr($main_class); ?>">

				<div class="tppdnlds-loading-mask">
					<?php echo $this->init_loading(); ?>
				</div>

				<div class="tppdn-link-but <?php echo esc_attr($display_none); ?>" data-pid="<?php echo esc_attr($product->get_id()); ?>">
					<span id="tppdn-link-but-<?php echo esc_attr($product->get_id()); ?>"><i class="demo-icon <?php echo esc_attr($track_price_icon); ?>"></i> <?php echo $label_title; ?></span>
				</div>

				<div class="tppdn-form" id="tppdn-form-<?php echo esc_attr($product->get_id()); ?>">

					<input type="hidden" id="tppdn-type-<?php echo esc_attr($product->get_id()); ?>" value="<?php echo esc_attr($track_type); ?>" >
					<input type="hidden" id="tppdn-id-<?php echo esc_attr($product->get_id()); ?>" value="<?php echo esc_attr($product_id); ?>" >
					<input type="hidden" id="tppdn-referer-<?php echo esc_attr($product->get_id()); ?>" value="<?php echo esc_attr($referer); ?>" >
					<input type="hidden" id="tppdn-nonce-<?php echo esc_attr($product->get_id()); ?>" value="<?php echo esc_attr($nonce); ?>" >

					<div class="tppdn-form-row user-box">
						<input type="text" id="tppdn-client-name-<?php echo esc_attr($product->get_id()); ?>" required="" >
						<label><?php echo esc_html($label_your_name); ?></label>
					</div>

					<div class="tppdn-form-row user-box">
						<input type="email" id="tppdn-client-email-<?php echo esc_attr($product->get_id()); ?>" required="" >
						<label><?php echo esc_html($label_your_email); ?></label>
					</div>

					<input type="hidden" id="tppdn-price-lower-than-<?php echo esc_attr($product->get_id()); ?>" value="" >
					
					<?php do_action('tppdn_before_send_button'); ?>

					<div class="tppdn-form-row user-box">
						<span class="tppdn-form-send" data-pid="<?php echo esc_attr($product->get_id()); ?>"><?php echo esc_html($label_form_send); ?></span>
					</div>

					<?php do_action('tppdn_after_send_button'); ?>

				</div>

				<div id="tppdn-required-validation-<?php echo esc_attr($product->get_id()); ?>"></div>

				<div id="pey-test-<?php echo esc_attr($product->get_id()); ?>"></div>

			</div>
			
		<?php
		}
	}

	public function save_price_drop_notifier() {

		if ( !wp_verify_nonce( $_REQUEST['nonce'], "save_price_drop_notifier")) {
			exit("No naughty business please");
		}

		// WP Globals
		global $table_prefix, $wpdb;

		// Customer Table
		$tppdnTable = $table_prefix.'tppdn_products';

		$status = 1;

		$type             = sanitize_text_field($_POST['typee']);
		//$type         = 'price'; //stock
		$product_id       = intval($_POST['product_id']);
		$variation_id     = intval($_POST['variation_id']);
		$newsletter       = sanitize_text_field($_POST['newsletter']);
		$client_name      = sanitize_text_field($_POST['client_name']);
		$client_email     = sanitize_email($_POST['client_email']);
		$price_lower_than = intval($_POST['price_lower_than']);

		$referer = sanitize_text_field($_POST['referer']);

		$today       = date('Y-m-d');
		$date_expiry = date('Y-m-d', strtotime('+10 years'));
		$time        = date('H:i:s');

		if(isset($_POST['cycle']) && !empty($_POST['cycle'])){
			$cycle = sanitize_text_field($_POST['cycle']);
			$date_expiry = date('Y-m-d', strtotime('+'.$cycle.' day'));
		}

		$product = wc_get_product($product_id);

		$product_id    = $product->get_id();
		$product_name  = $product->get_name();
		$product_price = $product->get_price();
		$product_sku   = $product->get_sku();
		//$is_in_stock   = $product->is_in_stock();
		$is_in_stock   = ($product->is_in_stock()) ? 1 : 0;
		//$wc_price      = wc_price($product->get_price());
		//$price_html    = $product->get_price_html();
		//$display_price = $product->get_display_price();

		if($product->get_type() == 'variable' && $variation_id){
			$product_variation = new WC_Product_Variation($variation_id);
			$product_price = $product_variation->get_price();
			$product_name  = $product_variation->get_name();
			$is_in_stock   = ($product_variation->is_in_stock()) ? 1 : 0;

			if($product_variation->get_sku()){
				$product_sku = $product_variation->get_sku();
			}

		}

		if(is_user_logged_in()){
			$user_id = get_current_user_id();
			$is_logged_in = 1;
		}
		else{
			$user_id = 0;
			$is_logged_in = 0;
		}

		$validation_message         = get_option( 'tppdn_validation_message' );
		$success_message            = get_option( 'tppdn_success_message' );
		$unsuccess_message          = get_option( 'tppdn_unsuccess_message' );
		$already_registered_message = get_option( 'tppdn_already_registered_message' );

		if(!$this->client_is_exist($client_email,$product_id)){

			$data = array(
				'product_id'       => $product_id,
				'variation_id'     => $variation_id,
				'product_name'     => $product_name,
				'product_price'    => $product_price,
				'product_sku'      => $product_sku,
				'price_lower_than' => $price_lower_than,
				'client_email'     => $client_email,
				'client_name'      => $client_name,
				'date'             => $today,
				'date_expiry'      => $date_expiry,
				'time'             => $time,
				'update_time'      => $time,
				'status'           => $status,
				'is_sent'          => 0,
				'is_logged_in'     => $is_logged_in,
				'user_id'          => $user_id,
				'newsletter'       => $newsletter,
				'referer'          => $referer,
				'is_in_stock'      => $is_in_stock,
				'type'             => $type,
				'session_expiry'   => time()
				//'cycle'         => $cycle,
			);

			if($wpdb->insert( $tppdnTable, $data )){
				echo '<div class="tppdn_success_registered">'.esc_html($success_message).'.</div>';
			}
			else{
				echo '<div class="tppdn_error_registered">'.esc_html($unsuccess_message).'.</div>';
			}
		}
		else{
			echo '<div class="tppdn_already_registered">'.esc_html($already_registered_message).'.</div>';
		}

		wp_die();

	}

	public function client_is_exist($client_email,$product_id) {
		// WP Globals
		global $table_prefix, $wpdb;

		// Customer Table
		$tppdnTable = $table_prefix.'tppdn_products';

		$query  = 'SELECT * FROM '.$tppdnTable.' WHERE client_email = "'.$client_email.'" AND product_id = "'.$product_id.'" AND status = 1';
		$result = $wpdb->get_row( $query, OBJECT );
		if($result){
			return true;
		}
		else{
			return false;
		}

	}

	public function init_loading() {
		$loading_type = get_option('tppdn_loading_type');
		switch ($loading_type) {
			case "roller":
			 	return '<div class="tppdnlds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>';
			  	break;
			case "ellipsis":
				return '<div class="tppdnlds-ellipsis"><div></div><div></div><div></div><div></div></div>';
			  	break;
			case "facebook":
				return '<div class="tppdnlds-facebook"><div></div><div></div><div></div></div>';
			  	break;
			case "spinner":
				return '<div class="tppdnlds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>';
				break;
			case "ripple":
				return '<div class="tppdnlds-ripple"><div></div><div></div></div>';
				break;
			default:
				return '<div class="tppdnlds-ring"><div></div><div></div><div></div><div></div></div>';
		}
	}

	public function init_custom_css() {
		
		$submit_background = get_option('tppdn_submit_background');
    	$submit_color      = get_option('tppdn_submit_color');
		$form_background   = get_option('tppdn_form_background');
    	$form_color        = get_option('tppdn_form_color');

		$submit_background = ($submit_background) ? $submit_background : 'none';
		$submit_color = ($submit_color) ? $submit_color : '#000';
		// $add_gift_wrap_btn_underline = ($add_gift_wrap_btn_underline) ? 'underline' : 'none';

		$form_background = ($form_background) ? $form_background : 'none';
		$form_color = ($form_color) ? $form_color : '#000';
		$form_padding = ($form_background) ? '10px' : '0';

		// $add_gift_wrap_border = ($add_gift_wrap_border) ? '1px solid' : 'none';

		// $add_instructions_color      = get_option('tpgw_add_instructions_color');
    	// $add_instructions_background = get_option('tpgw_add_instructions_background');

		echo '<style>';

			echo '.tppdn-form-send{
				background: '.$submit_background.';
				color: '.$submit_color.';
			}';

			echo '.tppdn-form-send:hover{
				background: '.$submit_background.';
				opacity: 0.8;
			}';

			echo '.tpcartwrapform {
				background: '.$form_background.';
				color: '.$form_color.';
			}';

			echo '.tppdn-form .user-box label{
				color: '.$form_color.';
			}';

			echo '.tppdn-form-type-open{
				background: '.$form_background.';
				color: '.$form_color.';
				padding: '.$form_padding.';
			}';
		
		echo '</style>';
	}

	public function form_display_to() {
		return true;
	}

}
