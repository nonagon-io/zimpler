<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends REST_Controller {

    function __construct()
    {
        parent::__construct();

        $this->load->model("user/user_model");
        $this->load->model("user/ion_auth_model");
        $this->load->library("user/ion_auth");

		if(!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			show_404();
		}
    }
    
	public function index_get()
	{
		$user_id = $this->get('id');
		if(!$user_id)
			throw new Exception('Id must be specified.');

		$user = $this->ion_auth_model->user($user_id)->row();
		
		$this->response($user);
	}
	
	public function index_post()
	{
		$username = $this->post('username');
		$password = $this->post('password');
		$first_name = $this->post('firstName');
		$last_name = $this->post('lastName');
		$email = $this->post('email');

		$additional_data = array(

			'first_name' => $first_name,
			'last_name' => $last_name
		);

		$group = array('2');

		if($this->user_model->is_user_exists($username))
		{
			$this->response(array(
				
				'status' => 'ERR_EXISTS'
			));
			
			return;
		}
		
		$user_id = $this->ion_auth->register($username, $password, $email, $additional_data, $group);

		$this->response(array(
			
			'id' => $user_id,
			'user' => array(
				'firstName' => $first_name,
				'lastName' => $last_name,
				'email' => $email
			),
			'status' => 'OK'
		));
	}
	
	public function index_put()
	{
		$id = $this->put('id');
		$first_name = $this->put('firstName');
		$last_name = $this->put('lastName');
		$email = $this->put('email');
		
		$user = array(
			
			'first_name' => $first_name,
			'last_name' => $last_name,
			'email' => $email
		);

		$result = $this->ion_auth_model->update($id, $user);
		$this->response(array(
			
			'id' => $id,
			'user' => array(
				'firstName' => $first_name,
				'lastName' => $last_name,
				'email' => $email
			),
			'status' => 'OK'
		));
	}

	public function list_get()
	{
		$skip = $this->get('skip');
		$take = $this->get('take');
		$keyword = $this->get('keyword');

		if(!$skip) $skip = 0;
		if(!$take) $take = 50;

		$result = $this->user_model->get_list($keyword, $skip, $take);

		$this->response($result);
	}
}