<?php
/**
 * Plugin Name: BizPress Payroll
 * Description: Display business content on your website that is automatically updated by the Bizink team.
 * Plugin URI: https://bizinkonline.com
 * Author: Bizink
 * Author URI: https://bizinkonline.com
 * Version: 1.2.4
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
$myUpdateChecker->setBranch('main');
$myUpdateChecker->setAuthentication('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');


/** Load The main plugin */
if(is_plugin_active("bizpress-client/bizink-client.php")){
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

function bizpress_payroll_activate(){
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'bizpress_payroll_activate' );