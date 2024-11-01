<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       tplugins.com
 * @since      1.0.0
 *
 * @package    Tp_Price_Drop_Notifier_For_Woocommerce
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// WP Globals
global $table_prefix, $wpdb;

// Customer Table
$customerTable = $table_prefix.'tppdn_products';

$wpdb->query( "DROP TABLE IF EXISTS ".$customerTable."" );

delete_option( 'tppdn_form_type' );
delete_option( 'tppdn_add_newsletter' );
delete_option( 'tppdn_add_newsletter_label' );
delete_option( 'tppdn_validation_message' );
delete_option( 'tppdn_price_lower_than' );
delete_option( 'tppdn_show_on_archive' );
delete_option( 'tppdn_loading_type' );
delete_option( 'tppdn_label_btn_title' );
delete_option( 'tppdn_label_your_name' );
delete_option( 'tppdn_label_your_email' );
delete_option( 'tppdn_label_price_lower_than' );
delete_option( 'tppdn_label_form_send' );
delete_option( 'tppdn_email_subject' );
delete_option( 'tppdn_email_body' );
delete_option( 'tppdn_email_link_txt' );
delete_option( 'tppdn_email_add_bcc' );
delete_option( 'tppdn_email_direction' );
delete_option( 'tppdn_track_price_icon' );
delete_option( 'tppdn_back_to_stock_icon' );
delete_option( 'tppdn_email_show_pimage' );
delete_option( 'tppdn_back_to_stock' );
delete_option( 'tppdn_label_btn_back_to_stock_title' );
delete_option( 'tppdn_email_body_back_to_stock' );
delete_option( 'tppdn_email_subject_back_to_stock' );
delete_option( 'tppdn_label_btn_title_shop' );
delete_option( 'tppdn_submit_background' );
delete_option( 'tppdn_submit_color' );
delete_option( 'tppdn_form_background' );
delete_option( 'tppdn_form_color' );
delete_option( 'tppdn_label_name_icon' );
delete_option( 'tppdn_label_email_icon' );
delete_option( 'tppdn_label_price_icon' );
delete_option( 'tppdn_label_my_account_table_in_stock_yes' );
delete_option( 'tppdn_label_my_account_table_in_stock_no' );
delete_option( 'tppdn_email_background' );