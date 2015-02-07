<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Startup extends Public_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->database();
		$this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language'));

		$this->form_validation->set_error_delimiters(
			$this->config->item('error_start_delimiter', 'ion_auth'), 
			$this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->load->model('user/user_model');
	}

	function index()
	{
		if($this->user_model->is_any_users_exists())
		{
			show_404();
			return;
		}

		$tables = $this->config->item('tables','ion_auth');
		
		$this->data['title'] = lang("startup_heading");
		
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		
		$this->form_validation->set_rules('firstName', 
			$this->lang->line('create_user_validation_fname_label'), 'required');
			
		$this->form_validation->set_rules('lastName', 
			$this->lang->line('create_user_validation_lname_label'), 'required');
			
		$this->form_validation->set_rules('email', 
			$this->lang->line('create_user_validation_email_label'), 
			'required|valid_email|is_unique['.$tables['users'].'.email]');
			
		$this->form_validation->set_rules('phone', 
			$this->lang->line('create_user_validation_phone_label'), 
			'valid_phone');

		$this->form_validation->set_rules('username', 
			$this->lang->line('create_user_validation_identity_label'), 'required');
			
		$this->form_validation->set_rules('password', 
			$this->lang->line('create_user_validation_password_label'), 'required|min_length[' . 
			$this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . 
			$this->config->item('max_password_length', 'ion_auth') . ']|matches[passwordConfirm]');
			
		$this->form_validation->set_rules('passwordConfirm', 
			$this->lang->line('create_user_validation_password_confirm_label'), 'required');

		if ($this->form_validation->run() == true)
		{
			$username = strtolower($this->input->post('username'));
			$password = $this->input->post('password');
			$email    = strtolower($this->input->post('email'));

			$additional_data = array(
				'first_name' => $this->input->post('firstName'),
				'last_name'  => $this->input->post('lastName'),
				'company'    => $this->input->post('company'),
				'phone'      => $this->input->post('phone'),
			);
		}
		
		if ($this->form_validation->run() == true && $this->ion_auth->
			register($username, $password, $email, $additional_data, 
			array(1, 2)))
		{
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			$this->session->set_flashdata('startup_message', lang("startup_success"));
			
			redirect("user/login", 'refresh');
		}
		else
		{
			$this->data['message'] = (validation_errors() ? validation_errors() : 
				($this->ion_auth->errors() ? $this->ion_auth->errors() : 
					$this->session->flashdata('message')));

			$this->data['firstName'] = $this->form_validation->set_value('firstName');
			$this->data['lastName'] = $this->form_validation->set_value('lastName');
			$this->data['email'] = $this->form_validation->set_value('email');
			$this->data['phone'] = $this->form_validation->set_value('phone');
			$this->data['company'] = $this->form_validation->set_value('company');
			$this->data['username'] = $this->form_validation->set_value('username');
			$this->data['password'] = $this->form_validation->set_value('password');
			$this->data['passwordConfirm'] = $this->form_validation->set_value('passwordConfirm');

			$this->_render_page('user/startup', $this->data);
		}
	}
	
	function _render_page($view, $data=null, $render=false)
	{
		$this->viewdata = (empty($data)) ? $this->data: $data;

		$view_html = $this->load->templated_view('public_base', $view, $this->viewdata, $render);

		if (!$render) return $view_html;
	}
}