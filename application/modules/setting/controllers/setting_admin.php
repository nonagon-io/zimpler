<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_admin extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->lang->load('setting/general');
	}

	function general()
	{
		$this->load->view("setting");
	}
}