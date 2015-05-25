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
 * Zimpler User Model Class
 *
 * @package		Zimpler
 * @subpackage	User Module
 * @category	Libraries
 * @author		Chonnarong Hanyawongse
 * @link		http://zimpler.com/user_guide/user/user_model.html
 */

class User_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->database();
		$this->load->model("user/ion_auth_model");
	}

	public function create_first_admin($user)
	{
		$additional_data = array(
			'first_name' => $user->first_name,
			'last_name'  => $user->last_name,
			'company'    => $user->company,
			'phone'      => $user->phone,
		);
		
		$group = array(1);
		
		$this->user_model->register($user->username, $user->password, $additional_data, $group);
	}

	public function is_any_users_exists()
	{
		$tables = $this->config->item('tables', 'ion_auth');

		$this->db->from($tables["users"]);
		return $this->db->count_all_results() > 0;
	}

	public function is_user_exists($username)
	{
		$tables = $this->config->item('tables', 'ion_auth');

		$this->db->where($this->config->item('identity', 'ion_auth'), $username);
		$this->db->from($tables["users"]);

		return $this->db->count_all_results() > 0;
	}

	public function get_total_users()
	{
		$this->db->from('user');
		return $this->db->count_all_results();
	}

	public function get_list($keyword = NULL, 
		$skip = 0, $take = 50, $order_by = 'first_name asc, last_name asc')
	{
		if($keyword)
		{
			$this->db->where('first_name like', '%' . $keyword . '%');
			$this->db->or_where('last_name like', '%' . $keyword . '%');
			$this->db->or_where('email like', '%' . $keyword . '%');
		}

		$result = $this->db->order_by($order_by)->
				select('id, username, concat(first_name, \' \', last_name) as name, 
						first_name as firstName, last_name as lastName,
						email, last_login as lastLogin, 
						active as status', FALSE)->
				get('user', $take, $skip)->result();

		$this->db->flush_cache();

		if($keyword)
		{
			$this->db->where('first_name like', '%' . $keyword . '%');
			$this->db->or_where('last_name like', '%' . $keyword . '%');
			$this->db->or_where('email like', '%' . $keyword . '%');
		}

		$total = $this->db->from('user')->count_all_results();

		return array(

			'items' => $result,
			'total' => $total,
			'from' => count($result) > 0 ? $skip + 1 : 0,
			'to' => $skip + count($result)
		);
	}
}
