<?php

/**
 * Fired during plugin activation
 *
 * @link       tplugins.com
 * @since      1.0.0
 *
 * @package    Tp_Price_Drop_Notifier_For_Woocommerce
 * @subpackage Tp_Price_Drop_Notifier_For_Woocommerce/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Tp_Price_Drop_Notifier_For_Woocommerce
 * @subpackage Tp_Price_Drop_Notifier_For_Woocommerce/includes
 * @author     TP Plugins <pluginstp@gmail.com>
 */
class Tp_Price_Drop_Notifier_For_Woocommerce_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		self::init_db();

		add_option( 'tppdn_activate_price_drop', 1 );
		add_option( 'tppdn_activate_back_to_stock', 0 );
		add_option( 'tppdn_form_type', 'open' );
		add_option( 'tppdn_form_display_to', 'both' ); // both , loged in , guests
		add_option( 'tppdn_add_newsletter', 0 );
		add_option( 'tppdn_add_newsletter_label', 'Would like to receive special offers and deals' );
		add_option( 'tppdn_validation_message', 'Please fill in the required fields' );
		add_option( 'tppdn_success_message', 'Your request has been successfully saved' );
		add_option( 'tppdn_unsuccess_message', 'Error to save your request' );
		add_option( 'tppdn_already_registered_message', 'You are already registered for this product' );
		add_option( 'tppdn_price_lower_than', 0 );
		add_option( 'tppdn_show_on_archive', 0 );
		add_option( 'tppdn_loading_type', 'ring' );
		add_option( 'tppdn_label_btn_title', 'Let me know if the price goes down' );
		add_option( 'tppdn_label_your_name', 'Your name' );
		add_option( 'tppdn_label_your_email', 'Your email' );
		add_option( 'tppdn_label_price_lower_than', 'Price lower than' );
		add_option( 'tppdn_label_my_account_title', 'Your Tracking Products' );
		add_option( 'tppdn_label_my_account_empty', 'Empty' );
		add_option( 'tppdn_label_my_account_menu', 'Tracking Products' );
		add_option( 'tppdn_label_form_send', 'Send' );
		add_option( 'tppdn_email_subject', 'Product {pname} price drop' );
		add_option( 'tppdn_email_body', 'Hello {cname},<br> Price for {plink} product has dropped!<br> You can now purchase it for only {pprice}<br>' );
		add_option( 'tppdn_email_link_txt', 'Add it to your cart now' );
		add_option( 'tppdn_email_add_bcc', '' );
		add_option( 'tppdn_email_direction', 'ltr' );
		add_option( 'tppdn_track_price_icon', 'tppdnicon-bell-1' );
		add_option( 'tppdn_back_to_stock_icon', 'tppdnicon-bell-1' );
		add_option( 'tppdn_email_show_pimage', 0 );
		add_option( 'tppdn_email_background', '#96588a' );
		add_option( 'tppdn_label_btn_back_to_stock_title', 'Let me know if product back to stock' );

		add_option( 'tppdn_email_body_back_to_stock', 'Hello {cname},<br> Product {plink} is back to stock!<br> You can now purchase it for only {pprice}<br>' );
		add_option( 'tppdn_email_subject_back_to_stock', 'Product {pname} is back to stock' );
		add_option( 'tppdn_label_btn_title_shop', 'Track price' );
		add_option( 'tppdn_label_btn_title_shop_stock', 'Track stock' );

		add_option( 'tppdn_submit_background', '#a46497' );
		add_option( 'tppdn_submit_color', '#fff' );
		add_option( 'tppdn_form_background', '#fff' );
		add_option( 'tppdn_form_color', '#000' );

		add_option( 'tppdn_label_name_icon', 'tppdnicon-user' );
		add_option( 'tppdn_label_email_icon', 'tppdnicon-mail-alt' );
		add_option( 'tppdn_label_price_icon', 'tppdnicon-dollar' );

		add_option('tppdn_label_my_account_table_image', 'image');
		add_option('tppdn_label_my_account_table_product', 'product');
		add_option('tppdn_label_my_account_table_price', 'price');
		add_option('tppdn_label_my_account_table_expects_price', 'expects price');
		add_option('tppdn_label_my_account_table_new_price', 'new price');
		add_option('tppdn_label_my_account_table_in_stock', 'in stock');
		add_option('tppdn_label_my_account_table_date', 'date');
		add_option('tppdn_label_my_account_table_status', 'status');
		add_option('tppdn_label_my_account_table_status_yes', 'yes');
		add_option('tppdn_label_my_account_table_status_no', 'no');

		add_option('tppdn_label_my_account_table_in_stock_yes', 'yes');
		add_option('tppdn_label_my_account_table_in_stock_no', 'no');

		// add_option( 'tppdn_xxx', 0 );
		// add_option( 'tppdn_xxx', 0 );
		// add_option( 'tppdn_xxx', 0 );
	}

	// Initialize DB Tables
	public static function init_db() {

		// WP Globals
		global $table_prefix, $wpdb;

		// Customer Table
		$customerTable = $table_prefix.'tppdn_products';

		$charset_collate = $wpdb->get_charset_collate();

		// Create Customer Table if not exist
		if( $wpdb->get_var( "show tables like '$customerTable'" ) != $customerTable ) {

			// Query - Create Table
			$sql = "CREATE TABLE `$customerTable` (";
			$sql .= " `id` int(11) NOT NULL auto_increment, ";
			$sql .= " `product_id` varchar(500) NOT NULL, ";
			$sql .= " `variation_id` varchar(500), ";
			$sql .= " `product_name` varchar(500) NOT NULL, ";
			$sql .= " `product_price` varchar(500) NOT NULL, ";
			$sql .= " `product_new_price` varchar(500), ";
			$sql .= " `product_sku` varchar(500), ";
			$sql .= " `price_lower_than` varchar(500), ";
			$sql .= " `client_email` varchar(500) NOT NULL, ";
			$sql .= " `client_name` varchar(500) NOT NULL, ";
			$sql .= " `date` date NOT NULL, ";
			$sql .= " `date_expiry` date NOT NULL, ";
			$sql .= " `time` time NOT NULL, ";
			$sql .= " `update_time` time, ";
			$sql .= " `line1` varchar(500), ";
			$sql .= " `line2` varchar(500), ";
			$sql .= " `status` varchar(150) NOT NULL, ";
			$sql .= " `is_sent` varchar(150) NOT NULL, ";
			$sql .= " `is_logged_in` varchar(150) NOT NULL, ";
			$sql .= " `user_id` varchar(150), ";
			$sql .= " `newsletter` varchar(150), ";
			$sql .= " `cycle` varchar(500), ";
			$sql .= " `referer` varchar(150), ";
			$sql .= " `is_in_stock` varchar(150) NOT NULL, ";
			$sql .= " `is_on_sale` varchar(150), ";
			$sql .= " `sale_from` date, ";
			$sql .= " `sale_to` date, ";
			$sql .= " `type` varchar(150) NOT NULL, ";
			$sql .= " `session_expiry` BIGINT UNSIGNED NOT NULL, ";
			$sql .= " PRIMARY KEY (`id`) ";
			$sql .= ") $charset_collate;";

			// Include Upgrade Script
			require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
		
			// Create Table
			dbDelta( $sql );
		}

	}

}
