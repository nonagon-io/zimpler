<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$module_menu_items = array(

	array(
		'icon' => 'users',
		'path' => 'admin/user/management',
		'name' => lang('user_menu_management'),
		'link' => base_url('admin/user/management'),
		'order' => '300',
		'visible' => TRUE
	)
);