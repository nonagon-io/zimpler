<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$module_setting_panels = array(

	array(
		'view' => 'cms/cms_settings',
		'load' => function($ci) {

			$ci->load->model('cms/settings_model');
			return $ci->settings_model->load_settings();
		},
		'save' => function($ci) {

			$ci->load->model('cms/settings_model');
			return $ci->settings_model->save_settings($ci->input);
		}
	)
);