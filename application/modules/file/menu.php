<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$module_menu_items = array(

	array(
		'icon' => 'folder-open',
		'path' => 'admin/file',
		'name' => lang('file_menu'),
		'link' => base_url('admin/file'),
		'order' => '900',
		'visible' => TRUE
	)
);