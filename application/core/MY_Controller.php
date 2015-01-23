<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends MX_Controller {
	
	protected $data;

    function __construct()
    {
        parent::__construct();
        
        $this->data = array(
	        'lang_code' => 'en',
	        'meta_language' => 'en',
	        'meta_keywords' => '',
	        'meta_description' => '',
	        'title' => 'Siam Travel Mate'
        );
    }
}