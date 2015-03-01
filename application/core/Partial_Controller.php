<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
abstract class Partial_Controller extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		
        if(!defined('MAIN_CONTROLLER'))
        {
        	show_404();
        	exit();
        }
	}
}