<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Zimpler
 *
 * An open source CMS for PHP 5.1.6 or newer
 *
 * @package		Zimpler
 * @author		Chonnarong Hanyawongse
 * @copyright	Copyright (c) 2008 - 2015, Nonagon, Ltd.
 * @license		http://zimpler.com/user_guide/license.html
 * @link		http://zimpler.com
 * @since		Version 0.1
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Zimpler CMS Administration Controller Class
 *
 * @package		Zimpler
 * @subpackage	CMS Module
 * @category	Libraries
 * @author		Chonnarong Hanyawongse
 * @link		http://zimpler.com/user_guide/setting/setting_controllers.html
 */

class Cms_admin extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->lang->load('cms/admin_siteinfo');
		$this->load->model("cms/siteinfo_model");
	}

	function siteinfo()
	{
		$method = $this->input->server('REQUEST_METHOD');
		
		if($method == 'GET')
		{
			if(!$this->siteinfo_model->is_any_entry())
			{
				$this->siteinfo_model->set("site_title::main", "Zimpler");
				$this->siteinfo_model->set("site_title::sub", "The Micro CMS");
				$this->siteinfo_model->set("site_title::style", "smain");
				$this->siteinfo_model->set("site_title::separator", "|");
				$this->siteinfo_model->set("copyright::author", "");
				$this->siteinfo_model->set("copyright::text", "");
				$this->siteinfo_model->set("seo::description", "");
			}
			
			$this->data = array();
			$this->data["site_title_main"] = $this->siteinfo_model->get("site_title::main");
			$this->data["site_title_sub"] = $this->siteinfo_model->get("site_title::sub");
			$this->data["site_title_style"] = $this->siteinfo_model->get("site_title::style");
			$this->data["site_title_separator"] = $this->siteinfo_model->get("site_title::separator");
			$this->data["copyright_author"] = $this->siteinfo_model->get("copyright::author");
			$this->data["copyright_text"] = $this->siteinfo_model->get("copyright::text");
			$this->data["seo_description"] = $this->siteinfo_model->get("seo::description");
			
			$this->load->view("cms_siteinfo", $this->data);
		}
		
		else if($method == 'POST' || $method == 'PUT')
		{
			$this->siteinfo_model->set("site_title::main", $this->input->post("title"));
			$this->siteinfo_model->set("site_title::sub", $this->input->post("sub"));
			$this->siteinfo_model->set("site_title::style", $this->input->post("style"));
			$this->siteinfo_model->set("site_title::separator", $this->input->post("separator"));
			$this->siteinfo_model->set("copyright::author", $this->input->post("author"));
			$this->siteinfo_model->set("copyright::text", $this->input->post("copyright"));
			$this->siteinfo_model->set("seo::description", $this->input->post("description"));
		}
		
		else show_404();
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