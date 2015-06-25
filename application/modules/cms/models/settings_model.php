<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings_model extends CI_Model 
{
    public function __construct() 
    { 
        parent::__construct();

        $this->load->model('cms/language_model');
    }

	public function load_settings()
	{
		$data = array();
		$data['languages'] = $this->language_model->get_list();

		return $data;
	}
}