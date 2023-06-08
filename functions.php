<?php
defined( 'ABSPATH' ) || exit;

$HEBA_THEME_VERSION = \HEBA_CORE\HEBA_CORE::get_theme_info('Version');

/**
 * Load Composer
 */
require __DIR__ . '/vendor/autoload.php';

/**
 * Initiate Update Checker
 */
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
	'https://github.com/jsdizajner/heba-medizin',
	__FILE__,
	'heba-medizin'
);

//Set the branch that contains the stable release.
$myUpdateChecker->setBranch('main');

/**
 * Enqueue child scripts
 */
if ( ! function_exists( 'heba_enqueue_scripts' ) ) {
	function heba_enqueue_scripts($HEBA_THEME_VERSION) {
		wp_enqueue_style( 'heba-style', get_stylesheet_directory_uri() . '/style.css', '[]', $HEBA_THEME_VERSION);
	}
}
add_action( 'wp_enqueue_scripts', 'heba_enqueue_scripts', 15 );

/**
 * @snippet       File Attachment @ WooCommerce Emails
 */

add_filter('woocommerce_email_attachments', 'bbloomer_attach_pdf_to_emails', 10, 4);
function bbloomer_attach_pdf_to_emails($attachments, $email_id, $order, $email)
{
	$email_ids = array('customer_completed_order');
	if (in_array($email_id, $email_ids)) {
		$upload_dir = wp_upload_dir();
		$attachments[] = $upload_dir['basedir'] . "/2020/09/odstupenie-od-zmluvy.docx";
	}
	return $attachments;
}


/**
 * @snippet Load ADC Title before WooCommerce Title
 */
//add_filter( 'the_title', 'load_adc_title_first', 10, 2 );
function load_adc_title_first( $title, $id = null ) {
	$post = get_post($id);
	if ($post->post_type == 'product' and get_post_meta($id,'_importer_supplier', true) == 'Medart' ) {
		return \HEBA_CORE\HEBA_CORE::get_adc_product_name($id);
	}
	return $title;
}

/**
 * Create a payment Link
 */

add_action('woocommerce_email_after_order_table', 'display_payment_link', 20, 4);
function display_payment_link($order, $sent_to_admin, $plain_text, $email)
{
	if ($email->id == 'customer_invoice' || $email->id == 'new_order' || $email->id == 'customer_on_hold_order') {
		$params = [$order->id, $order->payment_method];
		$params[] = sha1(implode($params) . $order->order_key);
		$link = add_query_arg('mk-payment-link', implode(',', $params), home_url());
		if ($order->payment_method == 'tb_tatrapay' || $order->payment_method == 'tb_cardpay') {
			print_r('
                <table style="font-family:arial,helvetica,sans-serif;margin-bottom:20px;margin-top:20px" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
                <tbody>
                    <tr>
                    <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;" align="left">

                    <div align="center">
                    <span style="display:block;padding:10px 20px;line-height:120%;line-height: 16.8px;">V prípade, že ste objednávku nezaplatili, kliknite na tlačítko nižšie: <br></span>
                    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-spacing: 0; border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;font-family:arial,helvetica,sans-serif;"><tr><td style="font-family:arial,helvetica,sans-serif;" align="center"><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="#" style="height:36px; v-text-anchor:middle; width:162px;" arcsize="11%" stroke="f" fillcolor="#4bcfad"><w:anchorlock/><center style="color:#FFFFFF;font-family:arial,helvetica,sans-serif;"><![endif]-->
                        <a href="' . esc_attr($link) . '" target="_blank" style="box-sizing: border-box;display: inline-block;font-family:arial,helvetica,sans-serif;text-decoration: none;-webkit-text-size-adjust: none;text-align: center;color: #FFFFFF; background-color: #4bcfad; border-radius: 4px; -webkit-border-radius: 4px; -moz-border-radius: 4px; width:auto; max-width:100%; overflow-wrap: break-word; word-break: break-word; word-wrap:break-word; mso-border-alt: none;">
                        <span style="display:block;padding:10px 20px;line-height:120%;"><span style="font-size: 14px; line-height: 16.8px;">Odkaz na platbu</span></span>
                        </a>
                    <!--[if mso]></center></v:roundrect></td></tr></table><![endif]-->
                    </div>

                    </td>
                    </tr>
                </tbody>
                </table>
            ');
		}
	}
}



/**
 * @snippet       Sort Products By Stock Status - WooCommerce Shop
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 5
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 *
 * @docs https://www.businessbloomer.com/woocommerce-show-in-stock-products-first-shop/
 */

 add_filter( 'woocommerce_get_catalog_ordering_args', 'bbloomer_first_sort_by_stock_amount', 9999 );

 function bbloomer_first_sort_by_stock_amount( $args ) {
	$args['orderby'] = 'meta_value';
	$args['meta_key'] = '_stock_status';
	return $args;
 }

 add_action('wp_enqueue_scripts', function () {wp_enqueue_script('wc-add-to-cart-variation');});

