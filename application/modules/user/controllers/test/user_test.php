<?php

class User_test extends Test_Controller
{
	function __construct()
	{
		parent::__construct(__FILE__);
		
		$this->load->model('user_model');
	}

	/**
	 * OPTIONAL; Anything in this function will be run before each test
	 * Good for doing cleanup: resetting sessions, renewing objects, etc.
	 */
	function _pre() {}

	/**
	 * OPTIONAL; Anything in this function will be run after each test
	 * I use it for setting $this->message = $this->My_model->getError();
	 */
	function _post() {}

	/* TESTS BELOW */

	function test_get_total_users()
	{
		$total = $this->user_model->get_total_users();
		$this->_assert_true($total >= 0);
	}

	function test_get_list()
	{
		$list = $this->user_model->get_list();
		$this->_assert_true($list);
		$this->_assert_true($list['items']);
	}
}