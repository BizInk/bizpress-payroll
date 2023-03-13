<?php
/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function payroll_settings_fields( $fields, $section ) {

	//if ( 'bizink-client_basic' != $section['id'] ) return $fields;
	
	if('bizink-client_basic' == $section['id']){
		$fields['payroll_content_page'] = array(
			'id'      => 'payroll_content_page',
			'label'     => __( 'Bizink Client payroll', 'bizink-client' ),
			'type'      => 'select',
			'desc'      => __( 'Select the page to show the content. This page must contain the <code>[bizink-content]</code> shortcode.', 'bizink-client' ),
			'options'	=> cxbc_get_posts( [ 'post_type' => 'page' ] ),
			// 'chosen'	=> true,
			'required'	=> false,
		);
	}
	
	if('bizink-client_content' == $section['id']){
		$fields['payroll_label'] = array(
			'id' => 'payroll',
	        'label'	=> __( 'Bizink Client payroll', 'bizink-client' ),
	        'type' => 'divider'
		);
		$fields['payroll_title'] = array(
			'id' => 'payroll_title',
			'label'     => __( 'payroll Title', 'bizink-client' ),
			'type'      => 'text',
			'default'   => __( 'payroll Resources', 'bizink-client' ),
			'required'	=> true,
		);
		$fields['payroll_desc'] = array(
			'id'      	=> 'payroll_desc',
			'label'     => __( 'payroll Description', 'bizink-client' ),
			'type'      => 'textarea',
			'default'   => __( 'Free resources to help you use payroll.', 'bizink-client' ),
			'required'	=> true,
		);
	}

	return $fields;
}
add_filter( 'cx-settings-fields', 'payroll_settings_fields', 10, 2 );

function payroll_content( $types ) {
	$types[] = [
		'key' 	=> 'payroll_content_page',
		'type'	=> 'payroll-content'
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

add_action( 'init', 'bizink_payroll_init');
function bizink_payroll_init(){
	$post = bizink_get_payroll_page_object();
	if( is_object( $post ) && get_post_type( $post ) == "page" ){
		add_rewrite_tag('%'.$post->post_name.'%', '([^&]+)', 'bizpress=');
		add_rewrite_rule('^'.$post->post_name . '/([^/]+)/?$','index.php?pagename=' . $post->post_name . '&bizpress=$matches[1]','top');
		add_rewrite_rule("^".$post->post_name."/([a-z0-9-]+)[/]?$",'index.php?pagename='.$post->post_name.'&bizpress=$matches[1]','top');
		add_rewrite_rule("^".$post->post_name."/topic/([a-z0-9-]+)[/]?$",'index.php?pagename='.$post->post_name.'&topic=$matches[1]','top');
		add_rewrite_rule("^".$post->post_name."/type/([a-z0-9-]+)[/]?$" ,'index.php?pagename='.$post->post_name.'&type=$matches[1]','top');
		//flush_rewrite_rules();
	}
}

add_filter('query_vars', 'bizpress_payroll_qurey');
function bizpress_payroll_qurey($vars) {
    $vars[] = "bizpress";
    return $vars;
}