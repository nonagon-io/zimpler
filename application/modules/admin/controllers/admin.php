<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Zimpler
 *
 * An open source CMS for PHP 5.1.6 or newer
 *
 * @package		Zimpler
 * @author		Chonnarong Hanyawongse
 * @copyright	Copyright (c) 2008 - 2015, Nonagon, Ltd.
 * @license		http://zimpler.com/user_guide/license.html
 * @link		http://zimpler.com
 * @since		Version 0.1
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Zimpler Admin Controller Class
 *
 * @package		Zimpler
 * @subpackage	Admin Module
 * @category	Libraries
 * @author		Chonnarong Hanyawongse
 * @link		http://zimpler.com/user_guide/admin/admin_controllers.html
 */

class Admin extends Admin_Controller {

    function __construct()
    {
	    $this->load->library('user/ion_auth');
	    
        parent::__construct();
        
        $user = $this->ion_auth->user()->row();
        
        $this->data['current_user'] = $user->id;
        
        $display_name = $user->first_name . ' ' . $user->last_name;
        if(!trim($display_name)) $display_name = $user->username;
        
        $this->data['current_display_name'] = $display_name;
    }

	protected function authenticate()
	{
		return $this->ion_auth->is_admin();
	}

	public function index()
	{
		$this->data['sub_content'] = $this->load->view('subs/home', $this->data, TRUE);
		$this->load->templated_view('admin_base', 'main', $this->data);
	}
}