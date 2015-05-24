<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$module_menu_items = array(

	array(
		'icon' => 'cogs',
		'path' => 'admin/setting/general',
		'name' => lang('setting_menu_general'),
		'link' => base_url('admin/setting/general'),
		'order' => '200',
		'visible' => TRUE
	)
);