<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
$lang['setting_content_approval_title'] = 'Content Approval';
$lang['setting_content_approval_disabled'] = 'Disable';
$lang['setting_content_approval_enabled'] = 'Enable';

$lang['setting_content_approval_disabled_desc'] = 
	'No content approval feature.';
	
$lang['setting_content_approval_enabled_desc'] = 
	'Content created by lower level users will need to be approved by content supervisor in order to publish.';

$lang['setting_file_upload_title'] = 'File Upload';
$lang['setting_file_upload_disabled'] = 'Disable File Upload';
$lang['setting_file_upload_file_system'] = 'Using File System';
$lang['setting_file_upload_database'] = 'Using Database';
$lang['setting_file_upload_s3'] = 'Using Amazon S3';

$lang['setting_file_upload_file_disabled_desc'] =
	'File upload is not allowed for anyone. All resources will need to be manually '.
	'uploaded. If hosting on PaaS such as Heroku, make sure you have all required '.
	'resources bundled with the source code.';

$lang['setting_file_upload_file_system_desc'] =
	'Do not use this option if hosting on PaaS '.
	'because the file system usually being wiped out when new version published, '.
	'so all uploaded data will be lost.';
	
$lang['setting_file_upload_database_desc'] =
	'This is not recommended due to the performance penalty. '.
	'But some web-hosting or in some environment might force you to use the database. '.
	'So use this option if you really need to.';
	
$lang['setting_file_upload_s3_desc'] =
	'If hosting on PaaS, this option is recommended. However, there is a cost if your site '.
	'generate a lot of traffic to the storage. Checkout S3 pricing here: '.
	'<a href="http://aws.amazon.com/s3/pricing/" target="_blank">aws.amazon.com/s3/pricing</a>';
	
$lang['setting_email_title'] = 'Email Sending';
$lang['setting_email_disabled'] = 'Disable Email Sending';
$lang['setting_email_build_in'] = 'Using Build-in Email';
$lang['setting_email_external'] = 'Using GAE Email';

$lang['setting_email_disabled_desc'] = 
	'No email sending feature on this site.';
	
$lang['setting_email_build_in_desc'] = 
	'Using Build-in Email service. Do not use this option if hosting on Google App Engine.';
	
$lang['setting_email_external_desc'] = 
	'Only use this option if hosing on Google App Engine.';
	
$lang['setting_social_title'] = 'Social Network Sharing';
$lang['setting_social_disabled'] = 'Disable Social Share';
$lang['setting_social_addthis'] = 'Using AddThis';
$lang['setting_social_sharethis'] = 'Using ShareThis';

$lang['setting_social_disabled_desc'] = 
	'No social share feature.';

$lang['setting_social_addthis_desc'] = 
	'Use AddThis social sharing buttons. Sign up here: '.
	'<a href="http://www.addthis.com" target="_blank">www.addthis.com</a>';
	
$lang['setting_social_sharethis_desc'] = 
	'Use ShareThis social sharing buttons. Sign up here: '.
	'<a href="http://www.sharethis.com" target="_blank">www.sharethis.com</a>';
