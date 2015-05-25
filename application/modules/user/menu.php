<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$module_menu_items = array(

	array(
		'icon' => 'users',
		'path' => 'admin/user',
		'name' => lang('user_menu'),
		'link' => base_url('admin/user'),
		'order' => '300',
		'visible' => TRUE
	)
);