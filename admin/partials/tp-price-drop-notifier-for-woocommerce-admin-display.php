<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       tplugins.com
 * @since      1.0.0
 *
 * @package    Tp_Price_Drop_Notifier_For_Woocommerce
 * @subpackage Tp_Price_Drop_Notifier_For_Woocommerce/admin/partials
 */


add_action('admin_menu', 'tppdn_plugin_create_menu');

function tppdn_plugin_create_menu() {
 
	//create new top-level menu
	add_menu_page(TPPDN_PLUGIN_MENU_NAME, TPPDN_PLUGIN_MENU_NAME, 'manage_options', 'tppdn_plugin_settings_page', 'tppdn_plugin_settings_page' , plugins_url('/images/tp.png', __FILE__) );
    add_submenu_page( 'tppdn_plugin_settings_page', 'Settings', 'Settings', 'manage_options', 'tppdn_plugin_settings_page', 'tppdn_plugin_settings_page');
    add_submenu_page( 'tppdn_plugin_settings_page', 'Statistics', 'Statistics', 'manage_options', 'tppdn-statistics-page', 'tppdn_statistics_page');   

	//call register settings function
	add_action( 'admin_init', 'register_tppdn_plugin_settings' );
    
}

function register_tppdn_plugin_settings() {
    //register our settings
    register_setting('tppdn-plugin-settings-group','tppdn_activate_price_drop');

    register_setting('tppdn-plugin-settings-group','tppdn_form_type');
    register_setting('tppdn-plugin-settings-group','tppdn_form_display_to');
    register_setting('tppdn-plugin-settings-group','tppdn_add_newsletter');
    register_setting('tppdn-plugin-settings-group','tppdn_box_position_checkout');
    register_setting('tppdn-plugin-settings-group','tppdn_box_showon_cart');
    register_setting('tppdn-plugin-settings-group','tppdn_showon_radio_button');

    register_setting('tppdn-plugin-settings-group','tppdn_loading_type');
    register_setting('tppdn-plugin-settings-group','tppdn_track_price_icon');
    register_setting('tppdn-plugin-settings-group','tppdn_back_to_stock_icon');
    //register_setting('tppdn-plugin-settings-group','tppdn_back_to_stock');

    register_setting('tppdn-plugin-settings-group','tppdn_label_btn_title');
    register_setting('tppdn-plugin-settings-group','tppdn_add_newsletter_label');
    register_setting('tppdn-plugin-settings-group','tppdn_label_your_name');
    register_setting('tppdn-plugin-settings-group','tppdn_label_your_email');
    register_setting('tppdn-plugin-settings-group','tppdn_label_price_lower_than');
    register_setting('tppdn-plugin-settings-group','tppdn_label_form_send');
    register_setting('tppdn-plugin-settings-group','tppdn_label_btn_title_shop');
    register_setting('tppdn-plugin-settings-group','tppdn_label_btn_title_shop_stock');
    register_setting('tppdn-plugin-settings-group','tppdn_label_my_account_title');
    register_setting('tppdn-plugin-settings-group','tppdn_label_my_account_empty');
    register_setting('tppdn-plugin-settings-group','tppdn_label_my_account_menu');

    register_setting('tppdn-plugin-settings-group','tppdn_label_my_account_table_image');
    register_setting('tppdn-plugin-settings-group','tppdn_label_my_account_table_product');
    register_setting('tppdn-plugin-settings-group','tppdn_label_my_account_table_price');
    register_setting('tppdn-plugin-settings-group','tppdn_label_my_account_table_expects_price');
    register_setting('tppdn-plugin-settings-group','tppdn_label_my_account_table_new_price');
    register_setting('tppdn-plugin-settings-group','tppdn_label_my_account_table_in_stock');
    register_setting('tppdn-plugin-settings-group','tppdn_label_my_account_table_date');
    register_setting('tppdn-plugin-settings-group','tppdn_label_my_account_table_status');
    //register_setting('tppdn-plugin-settings-group','tppdn_label_my_account_table_status_yes');
    //register_setting('tppdn-plugin-settings-group','tppdn_label_my_account_table_status_no');

    register_setting('tppdn-plugin-settings-group','tppdn_email_subject');
    register_setting('tppdn-plugin-settings-group','tppdn_email_body');
    register_setting('tppdn-plugin-settings-group','tppdn_email_link_txt');
    register_setting('tppdn-plugin-settings-group','tppdn_email_background');
    register_setting('tppdn-plugin-settings-group','tppdn_email_direction');
    register_setting('tppdn-plugin-settings-group','tppdn_email_body_back_to_stock');
    register_setting('tppdn-plugin-settings-group','tppdn_email_subject_back_to_stock');

    register_setting('tppdn-plugin-settings-group','tppdn_submit_background');
    register_setting('tppdn-plugin-settings-group','tppdn_submit_color');
    register_setting('tppdn-plugin-settings-group','tppdn_form_background');
    register_setting('tppdn-plugin-settings-group','tppdn_form_color');

    register_setting('tppdn-plugin-settings-group','tppdn_validation_message');
    register_setting('tppdn-plugin-settings-group','tppdn_success_message');
    register_setting('tppdn-plugin-settings-group','tppdn_unsuccess_message');
    register_setting('tppdn-plugin-settings-group','tppdn_already_registered_message');

    register_setting('tppdn-plugin-settings-group','tppdn_label_btn_back_to_stock_title');

    register_setting('tppdn-plugin-settings-group','tppdn_label_my_account_table_in_stock_yes');
    register_setting('tppdn-plugin-settings-group','tppdn_label_my_account_table_in_stock_no');

    register_setting('tppdn-plugin-settings-group','tppdn_label_name_icon');
    register_setting('tppdn-plugin-settings-group','tppdn_label_email_icon');
    register_setting('tppdn-plugin-settings-group','tppdn_label_price_icon');
}

function tppdn_plugin_settings_page() {

    //Settings
    $activate_price_drop    = get_option('tppdn_activate_price_drop');
    $form_type              = get_option('tppdn_form_type');
    $form_display_to        = get_option('tppdn_form_display_to');
    $box_position_checkout  = get_option('tppdn_box_position_checkout');
    
    $loading_type           = get_option('tppdn_loading_type');
    $track_price_icon       = get_option('tppdn_track_price_icon');
    $back_to_stock_icon     = get_option('tppdn_back_to_stock_icon');
    //$back_to_stock          = get_option('tppdn_back_to_stock');

    $label_name_icon  = get_option('tppdn_label_name_icon');
    $label_email_icon = get_option('tppdn_label_email_icon');
    $label_price_icon = get_option('tppdn_label_price_icon');

    //Style
    $submit_background = get_option('tppdn_submit_background');
    $submit_color      = get_option('tppdn_submit_color');
    $form_background   = get_option('tppdn_form_background');
    $form_color        = get_option('tppdn_form_color');

    //Labels
    $label_btn_title        = get_option('tppdn_label_btn_title');
    $add_newsletter_label   = get_option('tppdn_add_newsletter_label');
    $label_your_name        = get_option('tppdn_label_your_name');
    $label_your_email       = get_option('tppdn_label_your_email');
    $label_price_lower_than = get_option('tppdn_label_price_lower_than');
    $label_form_send        = get_option('tppdn_label_form_send');
    $label_btn_title_shop   = get_option('tppdn_label_btn_title_shop');
    $label_btn_title_shop_stock = get_option('tppdn_label_btn_title_shop_stock');
    $label_my_account_title = get_option('tppdn_label_my_account_title');
    $label_my_account_empty = get_option('tppdn_label_my_account_empty');
    $label_my_account_menu  = get_option('tppdn_label_my_account_menu');

    //Labels My account
    $label_my_account_table_image         = get_option('tppdn_label_my_account_table_image');
    $label_my_account_table_product       = get_option('tppdn_label_my_account_table_product');
    $label_my_account_table_price         = get_option('tppdn_label_my_account_table_price');
    $label_my_account_table_expects_price = get_option('tppdn_label_my_account_table_expects_price');
    $label_my_account_table_new_price     = get_option('tppdn_label_my_account_table_new_price');
    $label_my_account_table_in_stock      = get_option('tppdn_label_my_account_table_in_stock');
    $label_my_account_table_date          = get_option('tppdn_label_my_account_table_date');
    $label_my_account_table_status        = get_option('tppdn_label_my_account_table_status');
    //$label_my_account_table_in_stock_yes  = get_option('tppdn_label_my_account_table_status_yes');
    //$label_my_account_table_in_stock_no   = get_option('tppdn_label_my_account_table_status_no');

    $label_my_account_table_in_stock_yes  = get_option('tppdn_label_my_account_table_in_stock_yes');
    $label_my_account_table_in_stock_no   = get_option('tppdn_label_my_account_table_in_stock_no');

    $validation_message         = get_option( 'tppdn_validation_message' );
	$success_message            = get_option( 'tppdn_success_message' );
	$unsuccess_message          = get_option( 'tppdn_unsuccess_message' );
	$already_registered_message = get_option( 'tppdn_already_registered_message' );

    $label_btn_back_to_stock_title = get_option('tppdn_label_btn_back_to_stock_title');

    //Email
    $email_subject     = get_option('tppdn_email_subject');
    $email_body        = get_option('tppdn_email_body');
    $email_link_txt    = get_option('tppdn_email_link_txt');
    $email_background  = get_option('tppdn_email_background');
    $email_direction   = get_option('tppdn_email_direction');

    $email_subject_back_to_stock = get_option('tppdn_email_subject_back_to_stock');
    $email_body_back_to_stock    = get_option('tppdn_email_body_back_to_stock');
    
    $activate_price_drop_check    = ($activate_price_drop) ? 'checked="checked"' : '';

    ?>
    
    <div class="wrap tppdn-wrap">

        <h1><?php echo TPPDN_PLUGIN_NAME; ?></h1>
        
        <form method="post" action="options.php">
            <?php settings_fields( 'tppdn-plugin-settings-group' ); ?>
            <?php do_settings_sections( 'tppdn-plugin-settings-group' ); ?>

            <div id="tppdn-tabs" class="tpglobal-tabs">
                <ul>
                    <li><a href="#tabs-1">Settings</a></li>
                    <li><a href="#tabs-2">Style</a></li>
                    <li><a href="#tabs-4">Labels</a></li>
                    <li><a href="#tabs-5">Email</a></li>
                    <li><a href="#tabs-3">Custom css</a></li>
                    <li><a href="#tabs-7">License</a></li>
                </ul>

                <div id="tabs-1" class="tpglobal-tabs-content">

                    <div class="tpglobal-tabs-row">

                        <div class="tpglobal-tabs-row-ins">
                            <label class="tpglobal-container">Activate price drop notifier
                                <input type="checkbox" name="tppdn_activate_price_drop" <?php echo esc_html($activate_price_drop_check); ?> value="1">
                                <span class="checkmark"></span>
                            </label>
                        </div>

                        <div class="tpglobal-tabs-row-ins" style="position: relative;">
                            <label class="tpglobal-container">Activate back to stock notifier
                                <input type="checkbox" name="tppdn_activate_back_to_stock" disabled value="0">
                                <span class="checkmark"></span>
                            </label>
                            <span class="tpglobal-desc">If product is out of stock, the form will change to Back to stock notifier.</span>
                            <div class="tpglobal_triangle_topright_box_small"><div class="tpglobal_triangle_topright_small"><span>PRO</span></div></div>
                        </div>

                    </div><!-- tpglobal-tabs-row -->

                    <div class="tpglobal-tabs-row">
                        <label>Form Type</label>
                        <?php
                            $form_type_options = array('open','toggle PRO','lightbox PRO');
                            echo tppdn_select_options('tppdn_form_type',$form_type_options,$form_type,1);
                        ?>
                    </div>

                    <div class="tpglobal-tabs-row">
                        <label>Form Dispaly To</label>
                        <?php
                            $form_display_to_options = array('both','loged in PRO','guests PRO');
                            echo tppdn_select_options('tppdn_form_display_to',$form_display_to_options,$form_display_to,1);
                        ?>
                        <ol class="tpglobal-ul-info">
                            <li><strong>both:</strong> all your customers will see the form.</li>
                            <li><strong>loged in:</strong> only loged in customers will see the form.</li>
                            <li><strong>guests:</strong> only guests customers will see the form.</li>
                        </ol>
                        <div class="tpglobal_triangle_topright_box"><div class="tpglobal_triangle_topright"><span>PRO</span></div></div>
                    </div>

                    <div class="tpglobal-tabs-row">
                        <div class="tpglobal_triangle_topright_box"><div class="tpglobal_triangle_topright"><span>PRO</span></div></div>
                        <div class="tpglobal-tabs-row-ins">
                            <label class="tpglobal-container">Add Checkbox for Newsletter
                                <input type="checkbox" name="tppdn_add_newsletter" disabled value="0">
                                <span class="checkmark"></span>
                            </label>
                            <span class="tpglobal-desc">if checked, users will be able to apply to sign up for newsletter.</span>
                            
                        </div>

                        <div class="tpglobal-tabs-row-ins">
                            <label class="tpglobal-container">Add "Price lower than" option
                                <input type="checkbox" name="tppdn_price_lower_than" disabled value="0">
                                <span class="checkmark"></span>
                            </label>
                            <!-- <span class="tpglobal-desc">TTT</span> -->
                        </div>

                        <div class="tpglobal-tabs-row-ins">
                            <label class="tpglobal-container">Show on archive / category / shop page
                                <input type="checkbox" name="tppdn_show_on_archive" disabled value="0">
                                <span class="checkmark"></span>
                            </label>
                            <span class="tpglobal-desc">Show drop price option on a shop / archive pages</span>
                        </div>

                    </div><!-- tpglobal-tabs-row -->

                    <div class="tpglobal-tabs-row">
                        <label>Loading Type</label>
                        <?php
                            $loading_type_options = array('ring','roller','ellipsis','facebook','spinner','ripple');
                            echo tppdn_select_options('tppdn_loading_type',$loading_type_options,$loading_type,222);
                        ?>
                    </div>

                    <div class="tpglobal-tabs-row">
                        <label>Track Price Icon</label>
                        <?php
                            echo tppdn_select_icon('tppdn_track_price_icon',$track_price_icon);
                        ?>
                    </div>

                    <div class="tpglobal-tabs-row">
                        <label>Back to Stock Icon</label>
                        <?php
                            echo tppdn_select_icon('tppdn_back_to_stock_icon',$back_to_stock_icon);
                        ?>
                    </div>

                    <div class="tpglobal-tabs-row">
                        <div class="tpglobal_triangle_topright_box"><div class="tpglobal_triangle_topright"><span>PRO</span></div></div>
                        <div class="tpglobal-tabs-row-ins">
                            <label>"Your Name" Icon</label>
                            <?php
                                echo tppdn_select_icon('tppdn_label_name_icon',$label_name_icon);
                            ?>
                        </div>

                        <div class="tpglobal-tabs-row-ins">
                            <label>"Your Email" Icon</label>
                            <?php
                                echo tppdn_select_icon('tppdn_label_email_icon',$label_email_icon);
                            ?>
                        </div>

                        <div class="tpglobal-tabs-row-ins">
                            <label>"Price lower than" Icon</label>
                            <?php
                                echo tppdn_select_icon('tppdn_label_price_icon',$label_price_icon);
                            ?>
                        </div>
                    </div>
                
                </div><!-- tpglobal-tabs-content -->

                <div id="tabs-2" class="tpglobal-tabs-content">

                    <div class="tpglobal-tabs-row">

                        <div class="tpglobal-tabs-row-ins">
                            <label>Form Background</label>
                            <input type="text" class="tp_colorpiker" name="tppdn_form_background" value="<?php echo esc_html($form_background); ?>" >
                        </div>

                        <div class="tpglobal-tabs-row-ins">
                            <label>Form Color</label>
                            <input type="text" class="tp_colorpiker" name="tppdn_form_color" value="<?php echo esc_html($form_color); ?>" >
                        </div>

                    </div><!-- tpglobal-tabs-row -->

                    <div class="tpglobal-tabs-row">

                        <div class="tpglobal-tabs-row-ins">
                            <label>Submit button Background</label>
                            <input type="text" class="tp_colorpiker" name="tppdn_submit_background" value="<?php echo esc_html($submit_background); ?>" >
                        </div>

                        <div class="tpglobal-tabs-row-ins">
                            <label>Submit button Color</label>
                            <input type="text" class="tp_colorpiker" name="tppdn_submit_color" value="<?php echo esc_html($submit_color); ?>" >
                        </div>

                    </div><!-- tpglobal-tabs-row -->

                </div>
                
                <div id="tabs-4" class="tpglobal-tabs-content">

                    <div class="tpglobal-tabs-row">

                        <div class="tpglobal-tabs-row-ins">
                            <label>Label "Let me know if the price goes down"</label>
                            <input type="text" name="tppdn_label_btn_title" class="tpglobal-long-label" value="<?php echo esc_html($label_btn_title); ?>" >
                        </div>

                        <div class="tpglobal-tabs-row-ins">
                            <label>Label "Would like to receive special offers and deals"</label>
                            <input type="text" name="tppdn_add_newsletter_label" class="tpglobal-long-label" value="<?php echo esc_html($add_newsletter_label); ?>" >
                        </div>

                        <div class="tpglobal-tabs-row-ins">
                            <label>Label "Your name"</label>
                            <input type="text" name="tppdn_label_your_name" class="tpglobal-long-label" value="<?php echo esc_html($label_your_name); ?>" >
                        </div>

                        <div class="tpglobal-tabs-row-ins">
                            <label>Label "Your email"</label>
                            <input type="text" name="tppdn_label_your_email" class="tpglobal-long-label" value="<?php echo esc_html($label_your_email); ?>" >
                        </div>

                        <div class="tpglobal-tabs-row-ins">
                            <label>Label "Price lower than"</label>
                            <input type="text" name="tppdn_label_price_lower_than" class="tpglobal-long-label" value="<?php echo esc_html($label_price_lower_than); ?>" >
                        </div>

                        <div class="tpglobal-tabs-row-ins">
                            <label>Label "Send"</label>
                            <input type="text" name="tppdn_label_form_send" class="tpglobal-long-label" value="<?php echo esc_html($label_form_send); ?>" >
                        </div>

                    </div><!-- tpglobal-tabs-row -->

                    
                    <div class="tpglobal-tabs-row">

                        <div class="tpglobal-tabs-row-ins">
                            <label>Label "Let me know if product back to stock"</label>
                            <input type="text" name="tppdn_label_btn_back_to_stock_title" class="tpglobal-long-label" value="<?php echo esc_html($label_btn_back_to_stock_title); ?>" >
                        </div>

                    </div><!-- tpglobal-tabs-row -->

                    
                    <div class="tpglobal-tabs-row">

                        <div class="tpglobal-tabs-row-ins">
                            <label>Label "Track price" in category / shop / archive pages</label>
                            <input type="text" name="tppdn_label_btn_title_shop" class="tpglobal-long-label" value="<?php echo esc_html($label_btn_title_shop); ?>" >
                        </div>

                        <div class="tpglobal-tabs-row-ins">
                            <label>Label "Track stock" in category / shop / archive pages</label>
                            <input type="text" name="tppdn_label_btn_title_shop_stock" class="tpglobal-long-label" value="<?php echo esc_html($label_btn_title_shop_stock); ?>" >
                        </div>

                    </div><!-- tpglobal-tabs-row -->

                    <div class="tpglobal-tabs-row">

                        <div class="tpglobal-tabs-row-ins">
                            <label>Label My Account "Your Tracking Products"</label>
                            <input type="text" name="tppdn_label_my_account_title" class="tpglobal-long-label" value="<?php echo esc_html($label_my_account_title); ?>" >
                        </div>

                        <div class="tpglobal-tabs-row-ins">
                            <label>Label My Account "Empty"</label>
                            <input type="text" name="tppdn_label_my_account_empty" class="tpglobal-long-label" value="<?php echo esc_html($label_my_account_empty); ?>" >
                        </div>

                        <div class="tpglobal-tabs-row-ins">
                            <label>Label My Account "Tracking Products"</label>
                            <input type="text" name="tppdn_label_my_account_menu" class="tpglobal-long-label" value="<?php echo esc_html($label_my_account_menu); ?>" >
                        </div>

                    </div><!-- tpglobal-tabs-row -->

                    <div class="tpglobal-tabs-row">

                        <div class="tpglobal-tabs-row-ins">
                            <label>"Please fill in the required fields"</label>
                            <input type="text" name="tppdn_validation_message" class="tpglobal-long-label" value="<?php echo esc_html($validation_message); ?>" >
                        </div>

                        <div class="tpglobal-tabs-row-ins">
                            <label>"Your request has been successfully saved"</label>
                            <input type="text" name="tppdn_success_message" class="tpglobal-long-label" value="<?php echo esc_html($success_message); ?>" >
                        </div>

                        <div class="tpglobal-tabs-row-ins">
                            <label>"Error to save your request"</label>
                            <input type="text" name="tppdn_unsuccess_message" class="tpglobal-long-label" value="<?php echo esc_html($unsuccess_message); ?>" >
                        </div>

                        <div class="tpglobal-tabs-row-ins">
                            <label>"You are already registered for this product"</label>
                            <input type="text" name="tppdn_already_registered_message" class="tpglobal-long-label" value="<?php echo esc_html($already_registered_message); ?>" >
                        </div>

                    </div><!-- tpglobal-tabs-row -->

                    <div class="tpglobal-tabs-row">
                        <h3>My Account Labels</h3>

                        <div class="tpglobal-tabs-row-ins">
                            <label>Label Table "Image"</label>
                            <input type="text" name="tppdn_label_my_account_table_image" class="tpglobal-long-label" value="<?php echo esc_html($label_my_account_table_image); ?>" >
                        </div>

                        <div class="tpglobal-tabs-row-ins">
                            <label>Label Table "Product"</label>
                            <input type="text" name="tppdn_label_my_account_table_product" class="tpglobal-long-label" value="<?php echo esc_html($label_my_account_table_product); ?>" >
                        </div>

                        <div class="tpglobal-tabs-row-ins">
                            <label>Label Table "Price"</label>
                            <input type="text" name="tppdn_label_my_account_table_price" class="tpglobal-long-label" value="<?php echo esc_html($label_my_account_table_price); ?>" >
                        </div>

                        <div class="tpglobal-tabs-row-ins">
                            <label>Label Table "Expects Price"</label>
                            <input type="text" name="tppdn_label_my_account_table_expects_price" class="tpglobal-long-label" value="<?php echo esc_html($label_my_account_table_expects_price); ?>" >
                        </div>

                        <div class="tpglobal-tabs-row-ins">
                            <label>Label Table "New Price"</label>
                            <input type="text" name="tppdn_label_my_account_table_new_price" class="tpglobal-long-label" value="<?php echo esc_html($label_my_account_table_new_price); ?>" >
                        </div>

                        <div class="tpglobal-tabs-row-ins">
                            <label>Label Table "In Stock"</label>
                            <input type="text" name="tppdn_label_my_account_table_in_stock" class="tpglobal-long-label" value="<?php echo esc_html($label_my_account_table_in_stock); ?>" >
                            <div class="tpglobal-tabs-row-group">
                                <input type="text" name="tppdn_label_my_account_table_in_stock_yes" class="tpglobal-small-label" value="<?php echo esc_html($label_my_account_table_in_stock_yes); ?>" placeholder="yes">
                                <input type="text" name="tppdn_label_my_account_table_in_stock_no" class="tpglobal-small-label" value="<?php echo esc_html($label_my_account_table_in_stock_no); ?>" placeholder="no">
                            </div>
                        </div>

                        <div class="tpglobal-tabs-row-ins">
                            <label>Label Table "Date"</label>
                            <input type="text" name="tppdn_label_my_account_table_date" class="tpglobal-long-label" value="<?php echo esc_html($label_my_account_table_date); ?>" >
                        </div>

                        <div class="tpglobal-tabs-row-ins">
                            <label>Label Table "Status"</label>
                            <input type="text" name="tppdn_label_my_account_table_status" class="tpglobal-long-label" value="<?php echo esc_html($label_my_account_table_status); ?>" >
                        </div>

                    </div><!-- tpglobal-tabs-row -->

                </div>

                <div id="tabs-3" class="tpglobal-tabs-content">
                    <div class="tpglobal-tabs-row">
                        <p>This option is for developers only! If you do not know CSS it is not recommended to change it.</p>
                        <textarea id="tppdn_custom_css" class="tppdn_custom_css" name="tppdn_custom_css_pro" disabled></textarea>
                        <div class="tpglobal_triangle_topright_box"><div class="tpglobal_triangle_topright"><span>PRO</span></div></div>
                    </div>
                </div>

                <div id="tabs-5" class="tpglobal-tabs-content">

                    <div class="tppdn_admin_settings_left">
                        <div class="tpglobal-tabs-row">
                            <!-- <h2>Email</h2> -->
                            
                            <div class="tpglobal-tabs-row-ins">
                                <label>Price Track Email Subject</label>
                                <input type="text" name="tppdn_email_subject" class="tpglobal-long-label" value="<?php echo esc_html($email_subject); ?>" >
                            </div>

                            <div class="tpglobal-tabs-row-ins">
                                <label>Price Track Email Body</label>
                                <textarea name="tppdn_email_body" class="tppdn_email_body"><?php echo esc_textarea($email_body); ?></textarea>
                                <span class="tpglobal-desc">You can use any HTML tags if you know how...</span>
                            </div>

                            <!-- ---------------------------------------------------------- -->
                            <div class="tpglobal-tabs-row-ins">
                                <label>Back to Stock Email Subject</label>
                                <input type="text" name="tppdn_email_subject_back_to_stock" class="tpglobal-long-label" value="<?php echo esc_html($email_subject_back_to_stock); ?>" >
                            </div>

                            <div class="tpglobal-tabs-row-ins">
                                <label>Back to Stock Email Body</label>
                                <textarea name="tppdn_email_body_back_to_stock" class="tppdn_email_body_back_to_stock"><?php echo esc_textarea($email_body_back_to_stock); ?></textarea>
                                <span class="tpglobal-desc">You can use any HTML tags if you know how...</span>
                            </div>
                            <!-- ---------------------------------------------------------- -->

                            <div class="tpglobal-tabs-row-ins">
                                <label>Email Button Text</label>
                                <input type="text" name="tppdn_email_link_txt" class="tpglobal-long-label" value="<?php echo esc_html($email_link_txt); ?>" >
                            </div>

                            <div class="tpglobal-tabs-row-ins" style="position: relative;">
                                <label>Add BCC to Email</label>
                                <input type="text" name="tppdn_email_add_bcc" class="tpglobal-long-label" value="" disabled >
                                <div class="tpglobal_triangle_topright_box_small"><div class="tpglobal_triangle_topright_small"><span>PRO</span></div></div>
                            </div>

                            <div class="tpglobal-tabs-row-ins">
                                <label>Email Background</label>
                                <input type="text" class="tp_colorpiker" name="tppdn_email_background" value="<?php echo esc_html($email_background); ?>" autocomplete="off">
                            </div>

                            <div class="tpglobal-tabs-row-ins" style="position: relative;">
                                <label class="tpglobal-container">Add Product Image to email
                                    <input type="checkbox" name="tppdn_email_show_pimage" value="0" disabled>
                                    <span class="checkmark"></span>
                                </label>
                                <div class="tpglobal_triangle_topright_box_small"><div class="tpglobal_triangle_topright_small"><span>PRO</span></div></div>
                            </div>

                            <div class="tpglobal-tabs-row-ins">
                                <label>Email Direction</label>
                                <?php
                                    $email_direction_options = array('ltr','rtl');
                                    echo tppdn_select_options('tppdn_email_direction',$email_direction_options,$email_direction,222);
                                ?>
                            </div>

                            <div class="tpglobal-tabs-row-ins">
                                <label>Email Dynamic Variables</label>
                                <span class="tpglobal-code">{cname}  - replace with customer name</span><br>
                                <span class="tpglobal-code">{pname}  - replace with product name</span><br>
                                <span class="tpglobal-code">{plink}  - replace with product name inside product link</span><br>
                                <span class="tpglobal-code">{pprice} - replace with product price</span><br>
                            </div>

                        </div>
                    </div>

                    <div class="tppdn_admin_settings_right">
                        <?php echo tppdn_email_preview(); ?>
                    </div>

                </div>

                <div id="tabs-7" class="tpglobal-tabs-content">
                    <div class="tppdn_admin_settings_left">
                        <h2>Free Version</h2>
                        <a href="https://www.tplugins.com/product/tp-price-drop-notifier-for-woocommerce-pro/" target="_blank">Upgrade to PRO</a>
                    </div>
                </div>

            </div><!-- tpglobal-tabs -->

            <?php submit_button(); ?>
        </form>

    </div><!-- tppdn-wrap -->
    <?php

}

function tppdn_statistics_page() {
    
    ?>
    <div class="wrap tppdn-wrap tppdn-wrap-statistics">
        <h1><?php echo TPPDN_PLUGIN_NAME; ?></h1>
        <?php
            echo 'Available in PRO version';
        ?>
    </div>
    <?php
}

function tppdn_select_options($name,$options,$selected = false,$pronum = false) {
    $i = 1;
    
    $select = '';
    $select .= '<select name="'.esc_attr($name).'">';
    foreach ($options as $option) {
        if($pronum == 222){
            $disabled = '';
        }
        else{
            $disabled = 'disabled';

            if($pronum && $pronum == $i){
                $disabled = '';
            }
        }

        if($selected && $selected == $option){
            $select .= '<option value="'.esc_attr($option).'" selected '.$disabled.'>'.esc_attr($option).'</option>';
        }
        else{
            $select .= '<option value="'.esc_attr($option).'" '.$disabled.'>'.esc_attr($option).'</option>';
        }
        $i++;
    }
    $select .= '</select>';
    return $select;
}

function tppdn_select_asso_options($name,$options,$selected = false) {
    $select = '';
    $select .= '<select name="'.$name.'">';
    foreach ($options as $option => $value) {
        if($selected && $selected == $option){
            $select .= '<option value="'.$option.'" selected>'.$value.'</option>';
        }
        else{
            $select .= '<option value="'.$option.'">'.$value.'</option>';
        }
    }
    $select .= '</select>';
    return $select;
}

function tppdn_select_button_position($tppdn_button_position) {
    $select = '';
    $i = 0;
    $all_fields = array(
        'woocommerce_shop_loop_item_title.15'        => 'After product title',   //15
        'woocommerce_shop_loop_item_title.10'        => 'Before product title',  //10
        'woocommerce_shop_loop_item_title.5'         => 'Inside product image',  //5
        'woocommerce_after_shop_loop_item.10'        => 'After product price',   //10
    );

    $priority = array(15,10,5,10);

    $select .= '<select name="tppdn_button_position" id="tppdn_button_position">';
    foreach ($all_fields as $key => $value) {
        $selected = '';
        if($tppdn_button_position == $key){
            $selected = 'selected';
        }
        
        $select .= '<option value="'.$key.'" data-priority="'.$priority[$i].'" '.$selected.'>'.$value.'</option>';

        $i++;
    }

    $select .= '</select>';

    return $select;
}

function tppdn_translate_status($status,$type = 'price') {
    switch ($status) {
        case 1:
            return ($type == 'stock') ? 'Awaiting for back to stock' : 'Awaiting for price drop';
            break;
        case 2:
            return "Need to get an notification";
            break;
        case 3:
            return "Received a notification";
            break;
        default:
            return $status;
    }
}

function tppdn_get_emails_sent() {
    // WP Globals
    global $table_prefix, $wpdb;

    $html = '';

    // Customer Table
    $tppdnTable = $table_prefix.'tppdn_products';

    $query_emails_sent = 'SELECT status,COUNT(status) as num FROM '.$tppdnTable.' GROUP BY status ORDER BY num DESC';
    $results_emails_sent = $wpdb->get_results( $query_emails_sent, ARRAY_A );

    if($results_emails_sent){
        $html .= '<div class="tppdn_most_wanted">';
            $html .= '<h3>Emails</h3>';
            foreach ($results_emails_sent as $ttt) {
                if($ttt['status'] == 1){
                    $html .= '<div class="tppdn_most_wanted_in">';
                        $html .= $ttt['num'].' Emails Waiting for price to drop.';
                    $html .= '</div>';
                }
                if($ttt['status'] == 2){
                    $html .= '<div class="tppdn_most_wanted_in">';
                        $html .= $ttt['num'].' Emails need to be send (next cron).';
                    $html .= '</div>';
                }
                if($ttt['status'] == 3){
                    $html .= '<div class="tppdn_most_wanted_in">';
                        $html .= $ttt['num'].' Emails have been sent.';
                    $html .= '</div>';
                }
            }
        $html .= '</div>';
    }

    return $html;
}

function tppdn_email_preview() {
    $store_name        = get_bloginfo('name');
    $email_subject     = get_option('tppdn_email_subject');
    $email_body        = get_option('tppdn_email_body');
    $email_link_txt    = get_option('tppdn_email_link_txt');
    $email_background  = get_option('tppdn_email_background');

    $product_link      = '#';

    $email_direction  = get_option('tppdn_email_direction');
	$email_text_align = ($email_direction == 'ltr') ? 'left' : 'right';


    $html = '<div class="tppdn_email_preview">';

        $html .= '<h2>Email Preview</h2>';

        $html .= '<div class="tppdn_email_preview_in">';

            $html .= '<h3>Email subject: </h3>';
            $html .= '<div>'.$email_subject.'</div>';

            $html .= '<h3>Email body: </h3>';
            $html .= '<div style="max-width: 460px;margin: 0;direction: '.$email_direction.';text-align: '.$email_text_align.';">';
                $html .= '<div style="font-size: 20px;background: '.$email_background.';text-align: center;color: #fff;margin: 0 0 20px 0;padding: 10px;">'.$store_name.'</div>';
                $html .= '<div style="line-height: 25px;">';
                    $html .= $email_body;
                    $html .= '<div style="text-align: center;margin: 20px 0 0 0;display: inline-block;width: 100%;"><a href="'.$product_link.'" style="background: '.$email_background.';color: #fff;text-decoration: none;border-radius: 20px;padding: 5px 15px;">'.$email_link_txt.'</a></div>';
                $html .= '</div>';
            $html .= '</div>';


        $html .= '</div>';

    $html .= '</div>';

    return $html;
}

function tppdn_select_icon($name,$selected = false) {
    $icons = array(
        'tppdnicon-none' => 'none',
        'tppdnicon-calendar' => '<i class="demo-icon tppdnicon-calendar"></i>',
        'tppdnicon-bell-2' => '<i class="demo-icon tppdnicon-bell-2"></i>',
        'tppdnicon-ok' => '<i class="demo-icon tppdnicon-ok"></i>',
        'tppdnicon-plus-squared' => '<i class="demo-icon tppdnicon-plus-squared"></i>',
        'tppdnicon-check' => '<i class="demo-icon tppdnicon-check"></i>',
        'tppdnicon-ok-1' => '<i class="demo-icon tppdnicon-ok-1"></i>',
        'tppdnicon-ok-circled2-1' => '<i class="demo-icon tppdnicon-ok-circled2-1"></i>',
        'tppdnicon-money' => '<i class="demo-icon tppdnicon-money"></i>',
        'tppdnicon-bell' => '<i class="demo-icon tppdnicon-bell"></i>',
        'tppdnicon-bell-3' => '<i class="demo-icon tppdnicon-bell-3"></i>',
        'tppdnicon-ok-circled' => '<i class="demo-icon tppdnicon-ok-circled"></i>',
        'tppdnicon-plus-squared-alt' => '<i class="demo-icon tppdnicon-plus-squared-alt"></i>',
        'tppdnicon-down-thin' => '<i class="demo-icon tppdnicon-down-thin"></i>',
        'tppdnicon-ok-2' => '<i class="demo-icon tppdnicon-ok-2"></i>',
        'tppdnicon-ok-circled-2' => '<i class="demo-icon tppdnicon-ok-circled-2"></i>',
        'tppdnicon-user' => '<i class="demo-icon tppdnicon-user"></i>',
        'tppdnicon-bell-alt' => '<i class="demo-icon tppdnicon-bell-alt"></i>',
        'tppdnicon-bell-4' => '<i class="demo-icon tppdnicon-bell-4"></i>',
        'tppdnicon-ok-circled2' => '<i class="demo-icon tppdnicon-ok-circled2"></i>',
        'tppdnicon-mail' => '<i class="demo-icon tppdnicon-mail"></i>',
        'tppdnicon-download' => '<i class="demo-icon tppdnicon-download"></i>',
        'tppdnicon-ok-circled-1' => '<i class="demo-icon tppdnicon-ok-circled-1"></i>',
        'tppdnicon-chart' => '<i class="demo-icon tppdnicon-chart"></i>',
        'tppdnicon-user-circle-o' => '<i class="demo-icon tppdnicon-user-circle-o"></i>',
        'tppdnicon-bell-1' => '<i class="demo-icon tppdnicon-bell-1"></i>',
        'tppdnicon-bell-5' => '<i class="demo-icon tppdnicon-bell-5"></i>',
        'tppdnicon-ok-squared' => '<i class="demo-icon tppdnicon-ok-squared"></i>',
        'tppdnicon-mail-alt' => '<i class="demo-icon tppdnicon-mail-alt"></i>',
        'tppdnicon-mail-1' => '<i class="demo-icon tppdnicon-mail-1"></i>',
        'tppdnicon-download-1' => '<i class="demo-icon tppdnicon-download-1"></i>',
        'tppdnicon-dollar' => '<i class="demo-icon tppdnicon-dollar"></i>',
        'tppdnicon-user-o' => '<i class="demo-icon tppdnicon-user-o"></i>',
        //'xxx' => '<i class="demo-icon xxx"></i>',
        //'xxx' => '<i class="demo-icon xxx"></i>',
    );

    $select = '<div class="tppdn_select_icon">';
        foreach ($icons as $key => $value) {

            if($selected && $selected == $key){
                $checked = 'checked';
            }
            else{
                $checked = '';
            }

            $select .= '<div class="tppdn_select_icon_row">';
                $select .= '<input type="radio" name="'.$name.'" value="'.$key.'" id="'.$name.'_'.$key.'" '.$checked.'><label for="'.$name.'_'.$key.'">'.$value.'</label>';
            $select .= '</div>';
        }
    $select .= '</div>';

    return $select;

}