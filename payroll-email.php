<?php
/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action('admin_menu', 'bizpress_payroll_email');
 
function bizpress_payroll_email(){
    add_menu_page(
        'Bizpress Payroll Email',
        'Payroll Email',
        'edit_posts',
        'bizink-payroll',
        'bizpress_payroll_email_page',
        'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGlkPSJmNjU0YmNiZS03MzYwLTQxZGUtOWM3ZC1lYjE3ODcwYmRjOGYiIGRhdGEtbmFtZT0iTGF5ZXIgMSIgdmlld0JveD0iMTc5Ljc3IDE1MC4xOSAyOTcuNDEgMjM0LjQ1Ij48ZGVmcz48c3R5bGU+LmE2OTM0ZWRiLWVkZGItNDlhYi1iNjljLTg0NDllMzkzODBlZXtmaWxsOiMzMzNiNjE7fS5lYzBhYzQ1OS05ZDU5LTQ2ZDItODU5NC05ZGY1ZDcwM2Q2MDV7ZmlsbDojZjdhODAwO308L3N0eWxlPjwvZGVmcz48cGF0aCBjbGFzcz0iYTY5MzRlZGItZWRkYi00OWFiLWI2OWMtODQ0OWUzOTM4MGVlIiBkPSJNMjM5LjI1LDIzMy42MmM0Ny43LTI4Ljc3LDEwNywzLjY0LDEwOC42NSw1Ny44My42OCwyMS44Mi0xLjUsNDIuOTMtMTUuMTYsNjAuODEtMTkuMzgsMjUuMzktNDUuNTQsMzUuNTQtNzcsMzAtNy41MS0xLjMyLTE0LjM1LTYuNDctMjIuODctMTAuNTEtOC4yMywxMS42NC0yMS4yMywxNS4yNS0zNy42NywxMS40MXYtOS4zOHEwLTg5LjkzLDAtMTc5Ljg1YzAtMTAuMDYtLjEtMTkuNTItMTIuMzQtMjMuNTMtMS44My0uNi0xLjkyLTYuNDQtMy4wOS0xMC45LDE4Ljc4LDAsMzYtLjE1LDUzLjE4LjA4LDUuNTUuMDgsNi4yOSw0LjQsNi4yOCw4LjkzcS0uMDYsMjcuNDgsMCw1NC45NVptMCw3MC40YzAsMTYuMzYtLjE0LDMyLjcyLjEzLDQ5LjA4LjA1LDMuMDcuODksNi43OSwyLjc1LDkuMDgsMTEuODksMTQuNTksMzEuNDMsMTMuODYsNDIuMjItMS40Nyw4Ljc2LTEyLjQ0LDExLjUtMjYuODIsMTIuMzYtNDEuNjIsMS4wOC0xOC42Ny40MS0zNy4xOC04LjgzLTU0LjE1LTktMTYuNDUtMjYuNDctMjMuODktNDIuNzctMTktNC40OSwxLjM1LTYsMy40OC02LDguMThDMjM5LjQyLDI3MC43NSwyMzkuMjUsMjg3LjM5LDIzOS4yNSwzMDRaIi8+PHBhdGggY2xhc3M9ImVjMGFjNDU5LTlkNTktNDZkMi04NTk0LTlkZjVkNzAzZDYwNSIgZD0iTTQxNy4xOCwyMTcuNDRhNjUuNzksNjUuNzksMCwwLDAsMjMuNjctNC4zNGMxMC42LTQsMTkuOTMtMTAuMTIsMjguNjItMTcuMzMsNS43Ni00Ljc4LDguMDctMTAuODUsNy42Ni0xOC4xMmEyMC4wOSwyMC4wOSwwLDAsMC00LjQ0LTEyQTIyLjA2LDIyLjA2LDAsMCwwLDQ0MiwxNjIuMzFhODQuMjcsODQuMjcsMCwwLDEtMTQuMzIsOS4yLDIxLjU2LDIxLjU2LDAsMCwxLTEzLjQzLDIuMjUsNDAuNjYsNDAuNjYsMCwwLDEtMTQuODEtNS4yNGMtNS4zNi0zLjMxLTEwLjczLTYuNjItMTYuMjQtOS42OGE2NS43OSw2NS43OSwwLDAsMC0zMC40OS04LjYxLDQ4LjYyLDQ4LjYyLDAsMCwwLTE5LjczLDRjLTguODEsMy41Ny0xNi43LDguNzUtMjQuNTYsMTRhMjYuMDcsMjYuMDcsMCwwLDAtNy41OCw3LjM2Yy0zLjI2LDQuOTMtNC43NCwxMC4zLTMuNjcsMTYuMmEyMC4xNSwyMC4xNSwwLDAsMCw3LjU0LDEyLjEyYzcuMTIsNS44NSwxNy41OCw3LjgzLDI2LjE3LDEuNjNhMTE4LjE0LDExOC4xNCwwLDAsMSwxOC44NS0xMS4wNyw2LjU0LDYuNTQsMCwwLDEsMy4wNi0uNjcsMTcuNTEsMTcuNTEsMCwwLDEsNy44NCwyLjM2YzUuMjIsMy4wNywxMC4zNyw2LjI3LDE1LjYsOS4zMkE4OS4yNyw4OS4yNywwLDAsMCw0MTcuMTgsMjE3LjQ0WiIvPjxwYXRoIGNsYXNzPSJlYzBhYzQ1OS05ZDU5LTQ2ZDItODU5NC05ZGY1ZDcwM2Q2MDUiIGQ9Ik00MTcuMTgsMjE3LjQ0YTg5LjI3LDg5LjI3LDAsMCwxLTQxLTEyYy01LjIzLTMuMDUtMTAuMzgtNi4yNS0xNS42LTkuMzJhMTcuNTEsMTcuNTEsMCwwLDAtNy44NC0yLjM2LDYuNTQsNi41NCwwLDAsMC0zLjA2LjY3LDExOC4xNCwxMTguMTQsMCwwLDAtMTguODUsMTEuMDdjLTguNTksNi4yLTE5LDQuMjItMjYuMTctMS42M2EyMC4xNSwyMC4xNSwwLDAsMS03LjU0LTEyLjEyYy0xLjA3LTUuOS40MS0xMS4yNywzLjY3LTE2LjJhMjYuMDcsMjYuMDcsMCwwLDEsNy41OC03LjM2YzcuODYtNS4yMiwxNS43NS0xMC40LDI0LjU2LTE0YTQ4LjYyLDQ4LjYyLDAsMCwxLDE5LjczLTQsNjUuNzksNjUuNzksMCwwLDEsMzAuNDksOC42MWM1LjUxLDMuMDYsMTAuODgsNi4zNywxNi4yNCw5LjY4YTQwLjY2LDQwLjY2LDAsMCwwLDE0LjgxLDUuMjQsMjEuNTYsMjEuNTYsMCwwLDAsMTMuNDMtMi4yNSw4NC4yNyw4NC4yNywwLDAsMCwxNC4zMi05LjIsMjIuMDYsMjIuMDYsMCwwLDEsMzAuNzMsMy4zOCwyMC4wOSwyMC4wOSwwLDAsMSw0LjQ0LDEyYy40MSw3LjI3LTEuOSwxMy4zNC03LjY2LDE4LjEyLTguNjksNy4yMS0xOCwxMy4zMS0yOC42MiwxNy4zM0E2NS43OSw2NS43OSwwLDAsMSw0MTcuMTgsMjE3LjQ0WiIvPjwvc3ZnPg==',
        7
    );
}
 
function bizpress_payroll_email_page(){
    echo "<h2 class=\"cx-heading\">Bizpress Payroll Email</h1>";
    $data = bizpress_get_payroll_content();
    if( is_wp_error( $data )){
        $error_message = $data->get_error_message();
        echo "Something went wrong: $error_message";
    }
    else if(empty($data->status) == false && $data->status > 299){
        echo $data->message;
    }
    else{
        display_posts_table($data);
    }
}

function bizpress_get_payroll_content(){
    if(function_exists('bizink_get_master_site_url')){
        $base_url = bizink_get_master_site_url();
    }
    else{
        $base_url = 'https://bizinkcontent.com/';
    }
    if(function_exists('bizink_url_authontication')){
        $args = bizink_url_authontication();
    }
    else{
        $args = array(
            'timeout' => 120,
		    'httpversion' => '1.1',
            'headers' => array(
                'Content-Type' => 'application/json',
            )
        );
    }
    $options = get_option( 'bizink-client_basic' );
    if(empty($options['user_email'])){
		$options['user_email'] = '';
	}
	if(empty($options['user_password'])){
		$options['user_password'] = '';
	}
    $url = add_query_arg( [ 
        'email'         => $options['user_email'],
        'password'      => ncrypt()->encrypt( $options['user_password'] ),
        'per_page'      => 10,
        'post_type'     => 'payroll-email',
        'luca'		    => function_exists('luca') ? true : false
    ], wp_slash( $base_url.'wp-json/wp/v2/posts' ) );
    $response = wp_remote_get( $url, $args );
    if ( is_wp_error( $response ) ) {
        return $response;
    } 
    else {
        return json_decode( wp_remote_retrieve_body( $response ) );
    }
}

function display_posts_table( $posts ) {
    echo '<table class="widefat">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Title</th>';
    //echo '<th>Content</th>';
    echo '<th>Date</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    foreach ( $posts as $post ) {
        echo '<tr>';
        print_r($post);
        echo '<td>' . $post->title->rendered . '</td>';
        //echo '<td>' . $post['content'] . '</td>';
        echo '<td>' . get_date_from_gmt($post->date_gmt,get_option('date_format')) . '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
}