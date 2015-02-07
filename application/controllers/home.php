<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Public_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		$this->_render_page("home");
	}
	
	function _render_page($view, $data=null, $render=false)
	{
		$this->viewdata = (empty($data)) ? $this->data: $data;

		$view_html = $this->load->templated_view('public_base', $view, $this->viewdata, $render);

		if (!$render) return $view_html;
	}
}