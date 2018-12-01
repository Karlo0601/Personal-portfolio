<?php
//Send Email
/**
* In this function we will handle the form inputs and send our email.
*
* @return void
*/

function send_form(){
// This is a secure process to validate if this request comes from a valid source.
	//check_ajax_referer( 'security-nonce', 'security' );
	/**
	* First we make some validations, 
	* I think you are able to put better validations and sanitizations. =)
	*/
	$send_to 		    = get_field('admin_email_address', 'options');
	$labels             = global_labels();
	$full_name 		    = $_POST['full-name'];
	$subject 			= $_POST['subject'];
	$email	    		= $_POST['email'];
	$phone_number 	    = $_POST['phone'];
	$message 		    = $_POST['message'];
	$redirect_site_url  = site_url('/thank-you/');

	/*if ( !isset( $full_name ) ) {
		echo json_encode(array('status' => 'error', 'status_data' => 'Insert your name please.', 'field' => 'full-name' ));
		//wp_die();
	}
	if ( ! filter_var( $email_adresa, FILTER_VALIDATE_EMAIL ) ) {
		echo json_encode(array('status' => 'error', 'status_data' => 'Insert your email please.', 'field' => 'email-adresa'));
		//wp_die();
	}
	if ( empty( $phone_number ) ) {
		echo json_encode(array('status' => 'error', 'status_data' => 'Insert your phone number.', 'field' => 'phone-number'));
		//wp_die();
	} */
	if ( empty( $phone_number) && !filter_var( $email, FILTER_VALIDATE_EMAIL ) && empty( $full_name ) ) {
		echo json_encode(array('status' => 'error', 'status_data' => 'One or more fields have an error. Please check and try again', 'field' => 'phone-number'));
		wp_die();
	} 
	$send_email = WP_Mail::init()
    ->to($send_to)
    ->subject($subject)
    ->template(get_template_directory() .'/page-templates/email-template.html', [
		'labels'		=> $labels, 
		'full_name'		=> $full_name,
		'subject'		=> $subject,
		'email'			=> $email,
		'phone_number'	=> $phone_number,
		'message'		=> $message,

    ])
	->send();

	if ( $send_email ) {
		echo json_encode( array(
			'status'		=> 'success',
			'status_data'	=> $labels['label_success'],
			'action'		=> 'redirect',
			'redirectPath'	=> $redirect_site_url,
		));
	} else {
		echo json_encode( array(
			'status'	=> 'error',
			'status_data'		=> $labels['label_error'],
			'action'	=> '',
		));
	}
	exit();

}
add_action('wp_ajax_send_form', 'send_form'); // This is for authenticated users
add_action('wp_ajax_nopriv_send_form', 'send_form'); // This is for unauthenticated users.
