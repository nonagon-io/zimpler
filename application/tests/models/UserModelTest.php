<?php
class UserModelTest extends PHPUnit_Framework_TestCase
{
	private $CI;
	
	public function setUp() {

		$this->CI =& get_instance();
		$this->CI->load->model('user/user_model');
	}
	
	public function testListUser()
	{
		$this->assertTrue($this->CI->user_model->get_total_users() >= 0);
	}
}
?>