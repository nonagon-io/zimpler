<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Zimpler
 *
 * An open source CMS for PHP 5.4 or newer
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
 * Zimpler CMS Administration Controller Class
 *
 * @package		Zimpler
 * @subpackage	CMS Module
 * @category	Libraries
 * @author		Chonnarong Hanyawongse
 * @link		http://zimpler.com/user_guide/cms/controllers/cms_admin.html
 */

class File_admin extends Partial_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$this->data = array();
		$this->data["item_selectable"] = FALSE;
		$this->data["item_deletable"] = TRUE;

		$this->load->view("file_manager", $this->data);
	}
}