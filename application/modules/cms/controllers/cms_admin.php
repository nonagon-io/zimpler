<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cms_admin extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->lang->load('cms/admin_siteinfo');
		$this->load->model("cms/content_model");
	}

	function siteinfo()
	{
		$this->load->view("cms_siteinfo");
	}

	function navigations()
	{
		echo "This is navigations admin";
	}

	function pages()
	{
		echo "This is pages admin";
	}

	function contents()
	{
		echo "This is contents admin";
	}
}