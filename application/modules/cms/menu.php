<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$module_menu_items = array(

	array(
		'icon' => 'dot-circle-o',
		'path' => 'admin/cms/general',
		'name' => lang('cms_menu_general'),
		'link' => base_url('admin/cms/general')
	),

	array(
		'icon' => 'sitemap',
		'path' => 'admin/cms/navigations',
		'name' => lang('cms_menu_navigations'),
		'link' => base_url('admin/cms/navigations')
	),
	
	array(
		'icon' => 'files-o',
		'path' => 'admin/cms/pages',
		'name' => lang('cms_menu_pages'),
		'link' => base_url('admin/cms/pages')
	),
	
	array(
		'icon' => 'file-text',
		'path' => 'admin/cms/contents',
		'name' => lang('cms_menu_contents'),
		'link' => base_url('admin/cms/contents')
	)

);