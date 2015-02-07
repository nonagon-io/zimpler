<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Admin_Controller extends MY_Controller {
	
    function __construct()
    {
        parent::__construct();
        
        if(!$this->authenticate())
        	redirect(base_url('/user/login'));
    }
    
    protected function authenticate() { return FALSE; }
    
    protected function read_module_menu_items()
    {
	    $this->load->helper("file");
	    $dirs = get_dir_file_info(APPPATH.'modules', TRUE);
	    
	    $menu_items = array();
	    
	    foreach($dirs as $dir)
	    {
		    $menu = get_file_info($dir['server_path'].'/menu.php');
		    
		    if($menu)
		    {
			    $this->lang->load($dir['name'].'/menu');
			    
			    unset($module_menu_items);
			    require_once($menu['server_path']);
			    
			    if(isset($module_menu_items))
			    {
				    foreach($module_menu_items as $item)
				    array_push($menu_items, $item);
			    }
			}
	    }
	    
	    return $menu_items;
    }
}