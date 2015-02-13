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
 * Zimpler Setting Administration Controller Class
 *
 * @package		Zimpler
 * @subpackage	Setting Module
 * @category	Libraries
 * @author		Chonnarong Hanyawongse
 * @link		http://zimpler.com/user_guide/setting/setting_controllers.html
 */

class Setting_admin extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->lang->load('setting/general');
		$this->load->model("setting/setting_model");
	}

	function general()
	{
		$method = $this->input->server('REQUEST_METHOD');
		
		if($method == 'GET')
		{
			$access_key = $this->input->server("AWS_ACCESS_KEY_ID");
			if($access_key)
				$access_key = "********************".substr($access_key, count($access_key) - 5);
			
			$secret = $this->input->server("AWS_SECRET_ACCESS_KEY");
			if($secret)
				$secret = "********************".substr($secret, count($secret) - 5);
			
			$email_username = $this->input->server("EMAIL_USERNAME");
				
			$email_password = $this->input->server("EMAIL_PASSWORD");
			if($email_password)
				$email_password = "****************";
			
			$this->data = array(
				"aws_access_key_id"	=> $access_key,
				"aws_secret_access_key" => $secret,
				"smtp_username" => $email_username,
				"smtp_password" => $email_password
			);

			$this->data["setting_instruction"] = null;

			if(!$this->setting_model->is_any_entry())
			{
				$this->data["setting_instruction"] = lang("setting_instruction");
				
				$this->setting_model->set("content_approval", "disable");
				$this->setting_model->set("file_manager", "disable");
				$this->setting_model->set("file_manager::file::path", "/files");
				$this->setting_model->set("file_manager::db::table", "files");
				$this->setting_model->set("file_manager::s3::bucket", "");
				$this->setting_model->set("file_manager::gcloud::bucket", "");
				$this->setting_model->set("email", "disable");
				$this->setting_model->set("email::sendmail::path", "/usr/sbin/sendmail");
				$this->setting_model->set("email::smtp::server", "");
				$this->setting_model->set("email::smtp::port", "25");
				$this->setting_model->set("email::smtp::timeout", "5");
			}
			
			$this->data["approval_option"] = $this->setting_model->get("content_approval");
			$this->data["file_manager_option"] = $this->setting_model->get("file_manager");
			$this->data["file_path"] = $this->setting_model->get("file_manager::file::path");
			$this->data["db_table_name"] = $this->setting_model->get("file_manager::db::table");
			$this->data["s3_bucket"] = $this->setting_model->get("file_manager::s3::bucket");
			$this->data["gcloud_bucket"] = $this->setting_model->get("file_manager::gcloud::bucket");
			$this->data["email_option"] = $this->setting_model->get("email");
			$this->data["sendmail_path"] = $this->setting_model->get("email::sendmail::path");
			$this->data["smtp_server"] = $this->setting_model->get("email::smtp::server");
			$this->data["smtp_port"] = $this->setting_model->get("email::smtp::port");
			$this->data["smtp_timeout"] = $this->setting_model->get("email::smtp::timeout");
			
			$this->load->view("setting", $this->data);
		}
		
		else if($method == 'POST' || $method == 'PUT')
		{
			$this->setting_model->set("content_approval", $this->input->post("approvalOption"));
			
			$file_manager = $this->input->post("fileManagerOption");
			$this->setting_model->set("file_manager", $file_manager);
			
			if($file_manager == "file")
			{
				$path = $this->input->post("filePath");
				$this->setting_model->set("file_manager::file::path", $path);
			}
			else if($file_manager == "db")
			{
				$table = $this->input->post("dbTableName");
				$this->setting_model->set("file_manager::db::table_name", $table);
			}
			else if($file_manager == "s3")
			{
				$bucket = $this->input->post("S3Bucket");
				$this->setting_model->set("file_manager::s3::bucket", $bucket);
			}
			else if($file_manager == "gcloud")
			{
				$bucket = $this->input->post("GcloudBucket");
				$this->setting_model->set("file_manager::gcloud::bucket", $bucket);
			}
			
			$email = $this->input->post("emailOption");
			$this->setting_model->set("email", $email);
			
			if($email == "sendmail")
			{
				$path = $this->input->post("sendMailPath");
			}
			else if($email == "smtp")
			{
				$server = $this->input->post("smtpServer");
				$port = $this->input->post("smtpPort");
				$timeout = $this->input->post("smtpTimeout");
				
				$this->setting_model->set("email::smtp::server", $server);
				$this->setting_model->set("email::smtp::port", $port);
				$this->setting_model->set("email::smtp::timeout", $timeout);
			}
		}
		
		else show_404();
	}
}