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
 * Zimpler User Administration Controller Class
 *
 * @package		Zimpler
 * @subpackage	User Module
 * @category	Libraries
 * @author		Chonnarong Hanyawongse
 * @link		http://zimpler.com/user_guide/user/controllers/user_admin.html
 */

class User_admin extends Partial_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('user/user_model');
		$this->load->library('user/ion_auth');
	}

	function index()
	{
		$this->data = array();

		$this->data['current_user_id'] = $this->ion_auth->get_user_id();
		$this->data['total_users'] = $this->user_model->get_total_users();
		$this->load->view("user_list", $this->data);
	}
}