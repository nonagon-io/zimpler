<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_admin extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->lang->load('setting/general');
	}

	function general()
	{
		$access_key = $this->input->server("AWS_ACCESS_KEY_ID");
		if($access_key)
			$access_key = "********************".substr($access_key, count($access_key) - 5);
		
		$secret = $this->input->server("AWS_SECRET_ACCESS_KEY");
		if($secret)
			$secret = "********************".substr($secret, count($secret) - 5);
		
		$email_username = $this->input->server("EMAIL_USERNAME");
			
		$email_password = $this->input->server("EMAIL_PASSWORD");
		if($email_password)
			$email_password = "****************";
		
		$this->data = array(
			"aws_access_key_id"	=> $access_key,
			"aws_secret_access_key" => $secret,
			"email_username" => $email_username,
			"email_password" => $email_password
		);
		
		$this->load->view("setting", $this->data);
	}
}