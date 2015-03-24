<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

abstract class MY_Controller extends MX_Controller {
	
	protected $data;

    function __construct()
    {
        parent::__construct();
        
        $this->data = array(
	        'lang_code' => 'en',
	        'meta_language' => 'en',
	        'meta_keywords' => '',
	        'meta_description' => '',
	        'title' => $this->config->item('site_title')
        );
    }
}