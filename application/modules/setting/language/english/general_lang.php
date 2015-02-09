<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
$lang['setting_general_security_intro'] =
    'Due to the security concerns, Zimpler will just force you to always use environment variable '.
    'to store any secret data instead of database or configuration file.';
    
$lang['setting_general_security_env_apache'] =
	'In Apache, you can put the following lines into httpd.conf';
	
$lang['setting_general_security_env_apache_replace'] =
	'Just replace <code>&lt;%s&gt;</code> and <code>&lt;%s&gt;</code> '.
	'with the actual keys you own and restart the web server.';
	
$lang['setting_general_security_env_apache_note'] =
	'If you are using <b>alias</b>, the above code '.
	'must be put under its <code>&lt;Directory&gt;</code> block.';
	
$lang['setting_general_security_env_nginx'] =
	'If you host it on nginx, the above variables must be set as fastcgi_param as following:';
	
$lang['setting_general_security_env_nginx_more'] =
    'Please see this '.
    '<a href="http://nginx.org/en/docs/http/ngx_http_fastcgi_module.html" target="_blank">link</a> '.
    'for more details.';

$lang['setting_general_security_env_heroku_replace'] =    
    'In Heroku, you can use its UI to reveals all Config Variables. Then put '.
    '<code>%s</code> and <code>%s</code> as keys and put the appropriate values.';
    
$lang['setting_general_security_env_gae'] =
    'In Google App Engine, you can follow this '.
    '<a href="https://cloud.google.com/appengine/docs/php/config/appconfig# '.
    'PHP_app_yaml_Defining_environment_variables" target="_blank">link</a> '.
    'to configure environment variables.';

$lang['setting_content_approval_title'] = 'Content Approval';
$lang['setting_content_approval_disabled'] = 'Disable';
$lang['setting_content_approval_enabled'] = 'Enable';

$lang['setting_content_approval_disabled_desc'] = 
	'No content approval feature.';
	
$lang['setting_content_approval_enabled_desc'] = 
	'Content created by lower level users will need to be approved by content supervisor in order to publish.';

$lang['setting_file_upload_title'] = 'File Manager';
$lang['setting_file_upload_disabled'] = 'Disable File Manager';
$lang['setting_file_upload_file_system'] = 'Using File System';
$lang['setting_file_upload_database'] = 'Using Database';
$lang['setting_file_upload_s3'] = 'Using Amazon S3';

$lang['setting_file_upload_file_disabled_desc'] =
	'File upload is not allowed for anyone. All resources will need to be manually '.
	'uploaded. If hosting on PaaS such as Heroku, make sure you have all required '.
	'resources bundled with the source code.';

$lang['setting_file_upload_file_system_desc'] =
	'This option is recommended on your own host or event a share hosting. But do not use this option if hosting on PaaS '.
	'because the uploaded files usually being wiped out when a new version published. ';
	
$lang['setting_file_upload_database_desc'] =
	'This option is not recommended due to the performance penalty. '.
	'But some web-hosting or in some environment might force you to use the database. '.
	'So use this option if you really need to.';
	
$lang['setting_file_upload_s3_desc'] =
	'If hosting on PaaS, this option is recommended. However, there is a cost if your site '.
	'generates a lot of traffic to the storage. Checkout S3 pricing here: '.
	'<a href="http://aws.amazon.com/s3/pricing/" target="_blank">aws.amazon.com/s3/pricing</a>';
	
$lang['setting_file_upload_fs_root'] = 'Root Path';
$lang['setting_file_upload_fs_root_placeholder'] = 
	'Enter path which will store uploaded resources relative to your web root directory (e.g. /files)';
	
$lang['setting_file_upload_db_table'] = 'Table Name';
$lang['setting_file_upload_db_table_placeholder'] = 
	'Enter database table to store the image. Validation will fail if table already exists but incompatible.';
	
$lang['setting_aws_warning'] =
	'For security reason, AWS Access Key ID and AWS Secret Access Key must be setup '.
	'by using server environment variables as AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY. '.
	'Please follow the instruction <a href="#aws-key-instruction" data-uk-modal="">here</a>.';
	
$lang['setting_aws_success'] =
	'You have successfully setup AWS Access Key ID and AWS Secret Access Key. '.
	'If you want to change it please update server environment variables by '.
	'following the instruction <a href="#aws-key-instruction" data-uk-modal="">here</a>.';
	
$lang['setting_aws_access_key_id_placeholder'] =
	'AWS Access Key ID from your AWS account';

$lang['setting_aws_secret_access_key_placeholder'] =
	'AWS Secret Access Key from your AWS account';
	
$lang['setting_aws_bucket_placeholder'] =
	'Bucket Name (will be created if not exists)';

$lang['setting_aws_instruction_title'] =
	'Setup environment variables for AWS';
	
$lang['setting_email_title'] = 'Email Sending';
$lang['setting_email_disabled'] = 'Disable Email Sending';
$lang['setting_email_build_in'] = 'Using Build-in Email';
$lang['setting_email_send_mail'] = 'Using SendMail';
$lang['setting_email_smtp'] = 'Using SMTP';
$lang['setting_email_gae'] = 'Using GAE API';

$lang['setting_email_disabled_desc'] = 
	'No email sending feature on this site.';
	
$lang['setting_email_build_in_desc'] = 
	'Select this option to use PHP mail() function to deliver emails. '.
	'See <a href="http://php.net/manual/en/function.mail.php" target="_blank">this link</a> for more information.';

$lang['setting_email_send_mail_desc'] = 
	'Select this option to use sendmail command to deliver emails.';
	
$lang['setting_email_send_mail_path_placeholder'] =
	'Sendmail path (e.g. /usr/sbin/sendmail)';

$lang['setting_email_smtp_desc'] = 	
	'Connect to SMTP server to send email. All information about SMTP server '.
	'including the credential are required.';
	
$lang['setting_email_gae_desc'] = 
	'Only use this option if hosing on Google App Engine.';
	
$lang['setting_email_warning'] =
	'For security reason, email username and password must be setup '.
	'by using server environment variables as EMAIL_USERNAME and EMAIL_PASSWORD. '.
	'Please follow the instruction <a href="#email-key-instruction" data-uk-modal="">here</a>.';

$lang['setting_email_success'] =
	'You have successfully setup email username and password. '.
	'If you want to change it please update server environment variables by '.
	'following the instruction <a href="#email-key-instruction" data-uk-modal="">here</a>.';
	
$lang['setting_email_smtp_username_placeholder'] = 'SMTP Username';
$lang['setting_email_smtp_password_placeholder'] = 'SMTP Password';
$lang['setting_email_smtp_server_placeholder'] = 'SMTP Server domain name or ip address';
$lang['setting_email_smtp_port_placeholder'] = 'SMTP Port number (0-65535)';
$lang['setting_email_smtp_timeout_placeholder'] = 'SMTP Timeout in seconds (0-300)';

$lang['setting_email_instruction_title'] =
	'Setup environment variables for email sending';
