<?php
/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
//require "payroll-email.php";
add_filter( 'display_post_states', 'bizpress_payroll_post_states', 10, 2 );
function bizpress_payroll_post_states( $post_states, $post ) {
	$payrollResourcesPageID = intval(cxbc_get_option( 'bizink-client_basic', 'payroll_content_page' ));
    if ( $payrollResourcesPageID == $post->ID ) {
        $post_states['bizpress_payrollresources'] = __('BizPress Payroll Resources','bizink-client');
    }

	$payrollGlossaryPageID = intval(cxbc_get_option( 'bizink-client_basic', 'payroll_glossary_page' ));
    if ( $payrollGlossaryPageID == $post->ID ) {
        $post_states['bizpress_payrollglossary'] = __('BizPress Payroll Glossary','bizink-client');
    }
    return $post_states;
}

function payroll_settings_fields( $fields, $section ) {
	$pageselect = false;
	if(defined('CXBPC')){
		$bizpress = get_plugin_data( CXBPC );
		$v = intval(str_replace('.','',$bizpress['Version']));
		if($v >= 151){
			$pageselect = true;
		}
	}
	
	if('bizink-client_basic' == $section['id']){
		$fields['payroll_content_page'] = array(
			'id'      => 'payroll_content_page',
			'label'     => __( 'Payroll Resources', 'bizink-client' ),
			'type'      => $pageselect ? 'pageselect':'select',
			'desc'      => __( 'Select the page to show the content. This page must contain the <code>[bizpress-content]</code> shortcode.', 'bizink-client' ),
			'options'	=> cxbc_get_posts( [ 'post_type' => 'page' ] ),
			'default_page' => [
				'post_title'   => __( 'Payroll Resources', 'bizink-client' ),
				'post_content' => "[bizpress-content]",
				'post_status'  => "publish",
				'post_type'    => "page"
			],
			'required'	=> false,
		);

		$fields['payroll_glossary_page'] = array(
			'id'      => 'payroll_glossary_page',
			'label'     => __( 'Payroll Glossary', 'bizink-client' ),
			'type'      => $pageselect ? 'pageselect':'select',
			'desc'      => __( 'Select the page to show the content. This page must contain the <code>[bizpress-content]</code> shortcode.', 'bizink-client' ),
			'options'	=> cxbc_get_posts( [ 'post_type' => 'page' ] ),
			'default_page' => [
				'post_title'   => __( 'Payroll Glossary', 'bizink-client' ),
				'post_content' => "[bizpress-content]",
				'post_status'  => "publish",
				'post_type'    => "page"
			],
			'required'	=> false,
		);
	}
	
	if('bizink-client_content' == $section['id']){
		$fields['payroll_label'] = array(
			'id' => 'payroll',
	        'label'	=> __( 'Bizpress Payroll Resources', 'bizink-client' ),
	        'type' => 'divider'
		);
		$fields['payroll_title'] = array(
			'id' => 'payroll_title',
			'label'     => __( 'Payroll Resources Title', 'bizink-client' ),
			'type'      => 'text',
			'default'   => __( 'Payroll Resources', 'bizink-client' ),
			'required'	=> true,
		);
		$fields['payroll_desc'] = array(
			'id'      	=> 'payroll_desc',
			'label'     => __( 'Payroll Resources Description', 'bizink-client' ),
			'type'      => 'textarea',
			'default'   => __( 'Free resources to help you with payroll resources.', 'bizink-client' ),
			'required'	=> false,
		);

		$fields['payroll_glossary_label'] = array(
			'id' => 'payroll_glossary',
	        'label'	=> __( 'Bizpress Payroll Glossary', 'bizink-client' ),
	        'type' => 'divider'
		);
		$fields['payroll_glossary_title'] = array(
			'id' => 'payroll_glossary_title',
			'label'     => __( 'Payroll Glossary Title', 'bizink-client' ),
			'type'      => 'text',
			'default'   => __( 'Payroll Glossary', 'bizink-client' ),
			'required'	=> true,
		);
		$fields['payroll_glossary_desc'] = array(
			'id'      	=> 'payroll_glossary_desc',
			'label'     => __( 'Payroll Glossary Description', 'bizink-client' ),
			'type'      => 'textarea',
			'default'   => __( 'Free glossary to help you with your payroll.', 'bizink-client' ),
			'required'	=> false,
		);
	}

	return $fields;
}
add_filter( 'cx-settings-fields', 'payroll_settings_fields', 10, 2 );

function payroll_content( $types ) {
	$types[] = [
		'key' 	=> 'payroll_content_page',
		'type'	=> 'payroll'
	];
	$types[] = [
		'key' 	=> 'payroll_glossary_page',
		'type'	=> 'payroll-glossary'
	];
	return $types;
}
add_filter( 'bizink-content-types', 'payroll_content' );

if( !function_exists( 'bizink_get_payroll_page_object' ) ){
	function bizink_get_payroll_page_object(){
		$post_id = cxbc_get_option( 'bizink-client_basic', 'payroll_content_page' );
		$post = get_post( $post_id );
		return $post;
	}
}

if( !function_exists( 'bizink_get_payroll_page_glossary' ) ){
	function bizink_get_payroll_page_glossary(){
		$post_id = cxbc_get_option( 'bizink-client_basic', 'payroll_glossary_page' );
		$post = get_post( $post_id );
		return $post;
	}
}

add_action( 'init', 'bizink_payroll_init');
function bizink_payroll_init(){
	$post = bizink_get_payroll_page_object();
	if( is_object( $post ) && get_post_type( $post ) == "page" ){
		add_rewrite_tag('%'.$post->post_name.'%', '([^&]+)', 'bizpress=');
		add_rewrite_rule('^'.$post->post_name . '/([^/]+)/?$','index.php?pagename=payroll-resources&bizpress=$matches[1]','top');
		add_rewrite_rule("^".$post->post_name."/([a-z0-9-]+)[/]?$",'index.php?pagename=payroll-resources&bizpress=$matches[1]','top');
		add_rewrite_rule("^".$post->post_name."/topic/([a-z0-9-]+)[/]?$",'index.php?pagename=payroll-resources&topic=$matches[1]','top');
		add_rewrite_rule("^".$post->post_name."/type/([a-z0-9-]+)[/]?$" ,'index.php?pagename=payroll-resources&type=$matches[1]','top');
		//flush_rewrite_rules();
	}

	$post = bizink_get_payroll_page_glossary();
	if( is_object( $post ) && get_post_type( $post ) == "page" ){
		add_rewrite_tag('%'.$post->post_name.'%', '([^&]+)', 'bizpress=');
		add_rewrite_rule('^'.$post->post_name . '/([^/]+)/?$','index.php?pagename=payroll-glossary&bizpress=$matches[1]','top');
		add_rewrite_rule("^".$post->post_name."/([a-z0-9-]+)[/]?$",'index.php?pagename=payroll-glossary&bizpress=$matches[1]','top');
		//flush_rewrite_rules();
	}
}

add_filter('query_vars', 'bizpress_payroll_qurey');
function bizpress_payroll_qurey($vars) {
    $vars[] = "bizpress";
    return $vars;
}

/**
 * change account term url as per selected page
 * @author jayden
 */
add_filter( 'cx_account_post_url', 'cxa_filter_payroll_glossary_post_url', 10, 2 );
function cxa_filter_payroll_glossary_post_url( $url, $post){
	if($post->type == 'payroll-glossary'){
		$page = bizink_get_payroll_page_glossary();
		if( isset( $post ) ){
			return get_permalink( $page ).$post->slug;
		}
		return $url;
	}
	return $url;
}
