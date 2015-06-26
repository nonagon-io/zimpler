<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings_model extends CI_Model 
{
    public function __construct() 
    { 
        parent::__construct();

        $this->load->model('cms/language_model');
        $this->load->model('setting/setting_model');

        $this->initialize();
    }

    private function initialize()
    {
    	$enabled_languages = $this->setting_model->get('cms_enabled_languages');
    	if($enabled_languages === NULL)
    	{
    		$this->setting_model->set('cms_enabled_languages', 'en-us');
    	}
    }

	public function load_settings()
	{
		$data = array();
		$data['languages'] = $this->language_model->get_list();
		$data['enabled_languages'] = 
			explode(',', $this->setting_model->get('cms_enabled_languages'));

		return $data;
	}

	public function save_settings($languages)
	{
		$codes = array();

		foreach($languages as $key => $value)
		{
			array_push($codes, $key);
		}

		$enabled_languages = implode(',', $codes);
		$this->setting_model->set('cms_enabled_languages', $enabled_languages);
	}
}