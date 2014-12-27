<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Content extends CI_Model 
{
    public function __construct() 
    { 
        parent::__construct();
        
        $this->load->dbforge();
        $this->initialize();
    }
    
    private function initialize()
    {
	    
    }
    
    public function get($key)
    {
	    
    }
}