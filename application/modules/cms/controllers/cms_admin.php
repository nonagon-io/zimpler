<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Zimpler
 *
 * An open source CMS for PHP 5.4 or newer
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
 * @link		http://zimpler.com/user_guide/cms/controllers/cms_admin.html
 */

class Cms_admin extends Partial_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('cms/language_model');
		$this->load->model('setting/setting_model');

		$this->data = array();

		$lang_values = $this->setting_model->get('cms_enabled_languages');
		$enabled_languages = explode(',', $lang_values);

		sort($enabled_languages, SORT_LOCALE_STRING);

		$this->data['languages'] = $this->language_model->get_list();
		$this->data['enabled_languages'] = $enabled_languages;
	}

	function siteinfo()
	{
		$this->lang->load('cms/admin_siteinfo');
		$this->load->model('cms/siteinfo_model');
		$this->load->model('setting/setting_model');
		
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
		$this->lang->load('cms/admin_navigation');
		$this->load->model('cms/navigation_model');
		$this->load->model('cms/language_model');
		$this->load->model('setting/setting_model');

		$method = $this->input->server('REQUEST_METHOD');
		
		if($method == 'GET')
		{
			$nav = $this->navigation_model->get_hierarchy('en-us');

			$culture = $this->input->get('culture');
			if(!$culture) $culture = 'en-us';

			$this->data['culture'] = $culture;
			$this->data['nav'] = $nav;
			$this->load->view('cms_navigation', $this->data);
		}
	}

	function designs()
	{
		$method = $this->input->server('REQUEST_METHOD');
		
		if($method == 'GET')
		{
			$this->load->view('cms_design', $this->data);
		}
	}

	function pages()
	{
		$method = $this->input->server('REQUEST_METHOD');

		if($method == 'GET')
		{
			$this->data['total_pages'] = 0;

			$this->load->view('cms_page', $this->data);
		}
	}

	function contents()
	{
		$this->load->model('cms/content_model');

		$method = $this->input->server('REQUEST_METHOD');

		if($method == 'GET')
		{
			$culture = $this->input->get('culture');
			if(!$culture) $culture = 'en-us';

			$this->data['culture'] = $culture;
			$this->data['total_contents'] = $this->content_model->get_total_contents();
			$this->load->view('cms_content', $this->data);
		}
	}
}