<?php
/**
 * Plugin Name: BizPress Payroll
 * Description: Display business content on your website that is automatically updated by the Bizink team.
 * Plugin URI: https://bizinkonline.com
 * Author: Bizink
 * Author URI: https://bizinkonline.com
 * Version: 1.2
 * Requires PHP: 7.2
 * Requires at least: 5.6
 * Text Domain: bizink-client
 * Domain Path: /languages
 */

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Plugin Updater
require 'plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;
$myUpdateChecker = PucFactory::buildUpdateChecker('https://github.com/BizInk/bizpress-payroll',__FILE__,'bizpress-payroll');
// Set the branch that contains the stable release.
$myUpdateChecker->setBranch('main');
// Using a private repository, specify the access token 
$myUpdateChecker->setAuthentication('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');


/** Load The main plugin */
if(is_plugin_active("bizpress-client/bizink-client.php")){
	if ( is_admin() ) {
		if( ! function_exists('get_plugin_data') ){
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}
		$bizpress = get_plugin_data(WP_PLUGIN_DIR."/bizpress-client/bizink-client.php");
		$bVersion = explode('.',$bizpress['Version']);
/*		
		if(empty($bVersion[2]) == false && intval($bVersion[0]) < 2){
			// Bizpress Major Version 1
			if(empty($bVersion[2]) == false && intval($bVersion[2]) < 4){
				if(empty($bVersion[3]) == false && intval($bVersion[3]) < 5){
					add_action( 'admin_notices', 'bizpress_verson_payroll_notice' );
				}
				else if(empty($bVersion[3]) == false && intval($bVersion[3]) == 5){
					// Version 1.3.5
					require_once 'payroll.php';
				}
				else{
					// Version 1.3.6 - 1.4
					require_once 'payroll.php';
				}
			}
			else{
				// Version 1.4 - 2.0
				require_once 'payroll.php';
			}
		}
		else{
			// Version 2.0 & above
			require_once 'payroll.php';
		}
		*/
	}
	require_once 'payroll.php';
}
else{
	add_action( 'admin_notices', 'bizpress_notactive_payroll_notice' );
}

function bizpress_verson_payroll_notice(){
	$class = 'notice notice-error';
	$message = __( 'Bizpress plugin not updated. Bizpress Payroll needs the main Bizpress plugin to be updated to version 1.3.5 or later.', 'bizink-client' );
	printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
}


function bizpress_notactive_payroll_notice(){
	$class = 'notice notice-error';
	$message = __( 'Bizpress plugin not active. Bizpress Payroll needs the main Bizpress plugin to be active.', 'bizink-client' );
	printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
}