<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
require_once FCPATH . '/vendor/eventviva/php-image-resize/src/ImageResize.php';
use \Eventviva\ImageResize;

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
 * Zimpler Admin File REST Controller Class
 *
 * @package		Zimpler
 * @subpackage	Admin Module
 * @category	Libraries
 * @author		Chonnarong Hanyawongse
 * @link		http://zimpler.com/user_guide/admin/rest/file.html
 */

class File extends REST_Controller {

    function __construct()
    {
        parent::__construct();

        $this->load->model('setting/setting_model');
        $this->load->library('s3_provider');
        $this->load->library('user/ion_auth');

		if(!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			show_404();
		}
    }
    
    function list_get()
    {
        $path = $this->get('path');
        $file_manager = $this->setting_model->get('file_manager');

        if($file_manager === 's3')
        {
    	    $result = $this->s3_provider->list_files($path);
    		$this->response($result);
        }
    }

    function upload_post()
    {
        $this->load->library('upload');
        $this->load->helper('file');

        $upload_path = './' . $this->config->item('upload_path');

        if(!file_exists($upload_path))
            mkdir($upload_path);

        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = '*';
        $config['max_size'] = '10000';
        $config['max_width']  = '1280';
        $config['max_height']  = '768';

        $this->upload->initialize($config);

        $path = $this->post('path');

        if (!$this->upload->do_upload('file'))
        {
            $error = array('error' => $this->upload->display_errors());
            $this->response($error);
        }
        else
        {
            $data = $this->upload->data();

            $result = null;

            $file_manager = $this->setting_model->get('file_manager');
            if($file_manager === 's3')
            {
                $result = $this->s3_provider->store_file($path, (object)$data);
                unlink($upload_path . '/' . $data['file_name']);
            }

            $this->response($result);
        }
    }

    function index_delete()
    {
        $this->load->helper('file');

        $upload_path = './' . $this->config->item('upload_path');
        $file_name = $this->delete('file');
        $temp_path = $upload_path . $file_name;

        $path = $this->delete('path');

        if(file_exists($temp_path))
        {
            delete_files($temp_path);
        }

        $file_manager = $this->setting_model->get('file_manager');

        if($file_manager === 's3')
        {
            $this->s3_provider->delete_file($path, $file_name);
        }
    }

    function folder_post()
    {
        $path = $this->post('path');
        $folder_name = $this->post('folderName');

        $file_manager = $this->setting_model->get('file_manager');

        $result = null;

        if($file_manager === 's3')
        {
            $result = $this->s3_provider->add_folder($path, $folder_name);
        }

        $this->response($result);
    }

    function folder_delete()
    {
        $path = $this->delete('path');

        $file_manager = $this->setting_model->get('file_manager');

        if($file_manager === 's3')
        {
            $this->s3_provider->delete_folder($path);
        }
    }
}