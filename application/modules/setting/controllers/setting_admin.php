<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_admin extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->lang->load('setting/general');
	}

	function general()
	{
		if($this->input->server("AWS-ACCESS-KEY-ID") && $this->input->server("AWS-SECRET-ACCESS-KEY"))
		{
			$access_key = $this->input->server("AWS-ACCESS-KEY-ID");
			$access_key = "********************".substr($access_key, count($access_key) - 5);
			
			$secret = $this->input->server("AWS-SECRET-ACCESS-KEY");
			$secret = "********************".substr($secret, count($secret) - 5);
		}
		else
		{
			$access_key = null;
			$secret = null;
		}
		
		$this->data = array(
			"aws_access_key_id"	=> $access_key,
			"aws_secret_access_key" => $secret
		);
		
		$this->load->view("setting", $this->data);
	}
}