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
	        'meta_og_locale' => 'en_US',
	        'meta_og_type' => 'website',
	        'meta_og_title' => '',
	        'meta_og_description' => '',
	        'meta_og_url' => '',
	        'meta_og_image' => '',
	        'meta_og_site_name' => $this->config->item('site_title'),
	        'title' => $this->config->item('site_title')
        );
    }
}