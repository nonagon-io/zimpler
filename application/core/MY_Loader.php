<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Loader class */
require APPPATH."third_party/MX/Loader.php";

class MY_Loader extends MX_Loader {
	
	function templated_view($template_view, $content_view, $data = null, $as_string = FALSE, $content_var = "content")
	{
	    $content = $this->load->view($content_view, $data, true);
	    $data[$content_var] = &$content;
	    $this->load->view($template_view, $data, $as_string);
	}
}