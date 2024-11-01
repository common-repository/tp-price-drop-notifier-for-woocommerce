<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       tplugins.com
 * @since      1.0.0
 *
 * @package    Tp_Price_Drop_Notifier_For_Woocommerce
 * @subpackage Tp_Price_Drop_Notifier_For_Woocommerce/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Tp_Price_Drop_Notifier_For_Woocommerce
 * @subpackage Tp_Price_Drop_Notifier_For_Woocommerce/admin
 * @author     TP Plugins <pluginstp@gmail.com>
 */
class Tp_Price_Drop_Notifier_For_Woocommerce_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name.'-icons', plugin_dir_url( __FILE__ ) . 'icons/css/fontello.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'minicolors', plugin_dir_url( __FILE__ ) . 'css/jquery.minicolors.css', array(), $this->version, 'all' );
		//wp_enqueue_style( 'datatables.min', plugin_dir_url( __FILE__ ) . 'css/datatables.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/tp-price-drop-notifier-for-woocommerce-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( 'minicolors', plugin_dir_url( __FILE__ ) . 'js/jquery.minicolors.min.js', array( 'jquery' ), $this->version, false );
		//wp_enqueue_script( 'datatables.min', plugin_dir_url( __FILE__ ) . 'js/datatables.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/tp-price-drop-notifier-for-woocommerce-admin.js', array( 'jquery','jquery-ui-core','jquery-ui-tabs' ), $this->version, false );

	}

	public function settings_link( $links ) {
		$settings_link = '<a href="admin.php?page=tppdn_plugin_settings_page">Settings</a>';
		$pro_link = '<a href="'.esc_url(TPPDN_PLUGIN_HOME.'product/'.TPPDN_PLUGIN_SLUG).'" class="tpc_get_pro" target="_blank">Go Premium!</a>';
		array_push( $links, $settings_link, $pro_link );
		return $links;
	} //function settings_link( $links )

	public function get_pro_link( $links, $file ) {

		if ( TPPDN_PLUGIN_BASENAME == $file ) {
	
			$row_meta = array(
				'docs' => '<a href="' . esc_url( 'https://tplugins.com/demos/ex2/shop/' ) . '" target="_blank" aria-label="' . esc_attr__( 'Live Demo', 'wtppcs' ) . '" class="tpc_live_demo">&#128073; ' . esc_html__( 'Live Demo', 'wtppcs' ) . '</a>'
			);
	
			return array_merge( $links, $row_meta );
		}
		
		return (array) $links;
	} //function get_pro_link( $links, $file )

	public function send_email_to_client($name,$email,$new_price,$old_price,$product_id,$product_name,$type) {
		$body = '';
		$add_bcc = false;

		$email_subject = get_option('tppdn_email_subject');

		$email_subject = str_replace("{cname}",$name,$email_subject);
		$email_subject = str_replace("{pname}",$product_name,$email_subject);
		$email_subject = str_replace("{pprice}",$new_price,$email_subject);

		$body = $this->get_email_template($product_id,$product_name,$name,$new_price,$old_price,$type);

		$to      = $email;

		$subject = $email_subject;

		$headers[] = 'Content-Type: text/html; charset=UTF-8';
		
		if(wp_mail( $to, $subject, $body, $headers )){
			//$order->add_order_note( 'מייל לאיסוף נשלח בהצלחה' );
			return true;
		}
		else{
			//$order->add_order_note( 'מייל לאיסוף לא נשלח בהצלחה' );
			return false;
		}

	}

	public function get_email_template($product_id,$product_name,$name,$new_price,$old_price,$type) {
		
		$store_name = get_bloginfo('name');
		//$product_id = 12;
		//$product       = wc_get_product($product_id);
		//$product_name  = $product->get_name();
		//$product_price = wc_price($product->get_price());
		$product_price = wc_price($new_price);
		$product_link  = get_permalink($product_id);

		$email_body = get_option('tppdn_email_body');

		$email_link_txt    = get_option('tppdn_email_link_txt');
		$email_direction   = get_option('tppdn_email_direction');
		$email_background  = get_option('tppdn_email_background');

		$email_text_align = ($email_direction == 'ltr') ? 'left' : 'right';

		$css_price = '<span style="font-weight: bold;color: green;font-size: 20px;">'.$product_price.'</span>';
		$css_plink = '<a href="'.$product_link.'" style="color: '.$email_background.';">'.$product_name.'</a>';

		$email_body = str_replace("{cname}",$name,$email_body);
		$email_body = str_replace("{pname}",$product_name,$email_body);
		$email_body = str_replace("{plink}",$css_plink,$email_body);
		$email_body = str_replace("{pprice}",$css_price,$email_body);

		$body = '';

		$body .= '<div style="max-width: 460px;margin: 0 auto;direction: '.$email_direction.';text-align: '.$email_text_align.';">';
			$body .= '<div style="font-size: 20px;background: '.$email_background.';text-align: center;color: #fff;margin: 0 0 20px 0;padding: 10px;">'.$store_name.'</div>';
			$body .= '<div style="line-height: 25px;">';
				$body .= $email_body;
				$body .= '<div style="text-align: center;margin: 20px 0 0 0;display: inline-block;width: 100%;"><a href="'.$product_link.'" style="background: '.$email_background.';color: #fff;text-decoration: none;border-radius: 20px;padding: 5px 15px;">'.$email_link_txt.'</a></div>';
			$body .= '</div>';
		$body .= '</div>';

		return $body;

	}

	public function handler_update_product($post_id, $post, $update){
		if ($post->post_status != 'publish' || $post->post_type != 'product') {
			return;
		}
	
		if (!$product = wc_get_product( $post )) {
			return;
		}

		// WP Globals
		global $table_prefix, $wpdb;

		// Customer Table
		$tppdnTable = $table_prefix.'tppdn_products';

		$product_id    = $post_id;
		$product_price = $product->get_price();
		$is_in_stock   = $product->is_in_stock();
		$is_on_sale    = $product->is_on_sale();

		$sale_from = '';
		$sale_to   = '';

		if($product->get_sale_price()){

			$product_price = $product->get_sale_price();
			$date_from     = $product->get_date_on_sale_from();
			$date_to       = $product->get_date_on_sale_to();
			
			if( ! ( empty($date_from) && empty($date_to) ) ) {			
				$sale_from = date_i18n( 'Y-m-d', $product->get_date_on_sale_from()->getTimestamp() );
				$sale_to   = date_i18n( 'Y-m-d', $product->get_date_on_sale_to()->getTimestamp() );
			}
		}

		$query  = 'SELECT * FROM '.$tppdnTable.' WHERE product_id = "'.$product_id.'" AND (status = 1 OR status = 2) AND is_sent = 0';
		$results = $wpdb->get_results( $query, ARRAY_A );

		if($results) {
			foreach ($results as $result) {

				$dbid         = $result['id'];
				$name         = $result['client_name'];
				$type         = $result['type'];
				$email        = $result['client_email'];
				$variation_id = $result['variation_id'];
				$new_price    = $product_price;
				$old_price    = $result['product_price'];
				$update_time  = date('H:i:s');

				if($product->get_type() == 'variable' && $variation_id){
					$product_variation = new WC_Product_Variation($variation_id);
					$product_price = $product_variation->get_price();
					$is_in_stock   = $product_variation->is_in_stock();
				}

				if($type == 'stock' && $is_in_stock){
					$data = array(
						'status'            => 2, //Need to send email
						'is_in_stock'       => 1,
						'is_on_sale'        => $is_on_sale,
						'sale_from'         => $sale_from,
						'sale_to'           => $sale_to,
						'update_time'       => $update_time
					);
					$where = array('id' => $dbid);
					$wpdb->update( $tppdnTable, $data, $where);
				}
				else{
					if($product_price < $result['product_price']){

						//if($this->send_email_to_client($name,$email,$new_price,$old_price,$product_id)){
							$data = array(
								'status'            => 2, //Need to send email
								'product_new_price' => $product_price,
								'is_on_sale'        => $is_on_sale,
								'sale_from'         => $sale_from,
								'sale_to'           => $sale_to,
								'update_time'       => $update_time
							);
							$where = array('id' => $dbid);
							$wpdb->update( $tppdnTable, $data, $where);
						//}
					}
				}

			}
		}

		//error_log( print_r($product_price, TRUE) );

	}

	//----------------------------------------------------------------------

	// A. Define a cron job interval if it doesn't exist
	//add_filter( 'cron_schedules', 'check_every_3_hours' );
	public function check_every_3_hours( $schedules ) {
		$schedules['every_three_hours'] = array(
			'interval' => 10800,
			'display'  => __( 'Every 3 hours' ),
		);
		return $schedules;
	}
	
	// B. Schedule an event unless already scheduled
	//add_action( 'wp', 'custom_cron_job' );
	public function custom_cron_job() {
		if ( ! wp_next_scheduled( 'woocommerce_send_email_digest' ) ) {
			wp_schedule_event( time(), 'every_three_hours', 'woocommerce_send_email_digest' );
		}
	}
	
	// C. Trigger email when hook runs
	//add_action( 'woocommerce_send_email_digest', 'generate_email_digest' );
	
	// D. Generate email content and send email if there are completed orders
	public function generate_email_digest() { 

		// WP Globals
		global $table_prefix, $wpdb;

		// Customer Table
		$tppdnTable = $table_prefix.'tppdn_products';

		$query  = 'SELECT * FROM '.$tppdnTable.' WHERE status = 2 AND is_sent = 0';
		$results = $wpdb->get_results( $query, ARRAY_A );

		if($results) {
			foreach ($results as $result) {
				
				$dbid        = $result['id'];
				$name        = $result['client_name'];
				$type        = $result['type'];
				$email       = $result['client_email'];
				$type        = $result['type'];
				$variation_id = $result['variation_id'];
				$old_price    = $result['product_price'];
				$product_id   = $result['product_id'];
				$product_name = $result['product_name'];
				$update_time  = date('H:i:s');

				$product       = wc_get_product($product_id);
				$product_price = $product->get_price();
				$new_price     = $product_price;
				$is_in_stock   = $product->is_in_stock();

				if($product->get_type() == 'variable' && $variation_id){
					$product_variation = new WC_Product_Variation($variation_id);
					$new_price     = $product_variation->get_price();
					$is_in_stock   = $product_variation->is_in_stock();
				}

				if($type == 'stock' && $is_in_stock){
					if($this->send_email_to_client($name,$email,$new_price,$old_price,$product_id,$product_name,$type)){
						$data = array(
							'status'      => 3, //Email sent successfully
							'is_sent'     => 1,
							'update_time' => $update_time
						);
						$where = array('id' => $dbid);
						$wpdb->update( $tppdnTable, $data, $where);
					}
				}
				else{
					if($new_price < $old_price){
						if($this->send_email_to_client($name,$email,$new_price,$old_price,$product_id,$product_name,$type)){
							$data = array(
								'status'      => 3, //Email sent successfully
								'is_sent'     => 1,
								'update_time' => $update_time
							);
							$where = array('id' => $dbid);
							$wpdb->update( $tppdnTable, $data, $where);
						}
					}
				}

			}
		}
	}

	//----------------------------------------------------------------------

	public function get_products_by_user_id() {
		// WP Globals
		global $table_prefix, $wpdb;

		// Customer Table
		$tppdnTable = $table_prefix.'tppdn_products';

		$user_id = get_current_user_id();

		$query = 'SELECT * FROM '.$tppdnTable.' WHERE user_id = '.$user_id;

		$results = $wpdb->get_results($query,ARRAY_A);

		return $results;

	}

}
