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
	}

	function siteinfo()
	{
		$this->lang->load('cms/admin_siteinfo');
		$this->load->model('cms/siteinfo_model');
		
		$method = $this->input->server('REQUEST_METHOD');
		
		if($method == 'GET')
		{
			$culture = $this->input->get('culture');
			if(!$culture) $culture = 'en-us';
			
			if(!$this->siteinfo_model->is_any_entry())
			{
				$this->siteinfo_model->set('site_title::main', 'Zimpler', $culture);
				$this->siteinfo_model->set('site_title::sub', 'The Micro CMS', $culture);
				$this->siteinfo_model->set('site_title::style', 'smain', $culture);
				$this->siteinfo_model->set('site_title::separator', '|', $culture);
				$this->siteinfo_model->set('copyright::author', '', $culture);
				$this->siteinfo_model->set('copyright::text', '', $culture);
				$this->siteinfo_model->set('seo::description', '', $culture);
			}
			
			$this->data = array();
			$this->data['culture'] = $culture;
			$this->data['site_title_main'] = $this->siteinfo_model->get('site_title::main', $culture);
			$this->data['site_title_sub'] = $this->siteinfo_model->get('site_title::sub', $culture);
			$this->data['site_title_style'] = $this->siteinfo_model->get('site_title::style', $culture);
			$this->data['site_title_separator'] = $this->siteinfo_model->get('site_title::separator', $culture);
			$this->data['copyright_author'] = $this->siteinfo_model->get('copyright::author', $culture);
			$this->data['copyright_text'] = $this->siteinfo_model->get('copyright::text', $culture);
			$this->data['seo_description'] = $this->siteinfo_model->get('seo::description', $culture);
			
			$this->load->view('cms_siteinfo', $this->data);
		}
		
		else if($method == 'POST' || $method == 'PUT')
		{
			$culture = $this->input->post('culture');
			
			$this->siteinfo_model->set('site_title::main', $this->input->post('title'), $culture);
			$this->siteinfo_model->set('site_title::sub', $this->input->post('sub'), $culture);
			$this->siteinfo_model->set('site_title::style', $this->input->post('style'), $culture);
			$this->siteinfo_model->set('site_title::separator', $this->input->post('separator'), $culture);
			$this->siteinfo_model->set('copyright::author', $this->input->post('author'), $culture);
			$this->siteinfo_model->set('copyright::text', $this->input->post('copyright'), $culture);
			$this->siteinfo_model->set('seo::description', $this->input->post('description'), $culture);
		}
		
		else show_404();
	}

	function navigations()
	{
		$this->lang->load('cms/admin_siteinfo');
		$this->load->model('cms/navigation_model');

		$method = $this->input->server('REQUEST_METHOD');
		
		if($method == 'GET')
		{
			$nav = $this->navigation_model->get_hierarchy('en-us');
			
			$culture = $this->input->get('culture');
			if(!$culture) $culture = 'en-us';

			$this->data = array();
			$this->data['culture'] = $culture;
			$this->data['nav'] = $nav;
			$this->load->view('cms_navigation', $this->data);
		}
	}

	function pages()
	{
		echo 'This is pages admin';
	}

	function contents()
	{
		echo 'This is contents admin';
	}
}