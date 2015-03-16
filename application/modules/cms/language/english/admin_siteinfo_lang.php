<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$lang['cms_save_success_message'] = 'The setting has been saved.';;

$lang['cms_admin_siteinfo_site_title'] = 'Site Title';

$lang['cms_admin_siteinfo_site_title_main_label'] = 'Main Title';
$lang['cms_admin_siteinfo_site_title_main_placeholder'] = 'Main Title';
$lang['cms_admin_siteinfo_site_title_main_desc'] = 
	'The main title of the site. It will appears together with sub-title on the home page and will appears along ' .
	'with the page title on other pages. Main title may be overridden by any pages. Recommend specifying site name ' .
	'or something short.';
	
$lang['cms_admin_siteinfo_site_title_sub_label'] = 'Sub Title';
$lang['cms_admin_siteinfo_site_title_sub_placeholder'] = 'Sub Title (Optional)';
$lang['cms_admin_siteinfo_site_title_sub_desc'] = 
	'The sub title of the site will be only displayed on the home page together with the main title. ' .
	'It can be a business slogan, the site description or blank. Recommend specifying some kind of short description.';
	
$lang['cms_admin_siteinfo_title_style_main_and_page'] = 'Starts with Main Title';
$lang['cms_admin_siteinfo_title_style_page_and_main'] = 'Starts with Page Title';

$lang['cms_admin_siteinfo_site_title_separator_label'] = 'Separator';
$lang['cms_admin_siteinfo_site_title_separator_placeholder'] = 'Symbol (Optional)';

$lang['cms_admin_siteinfo_site_title_style_desc'] = 
	'Choose how the site title will be display together with the page title. See the example of how title ' .
	'will be rendered below.';

$lang['cms_admin_siteinfo_copyright'] = 'Copyright ';
$lang['cms_admin_siteinfo_copyright_author_label'] = 'Author Name';
$lang['cms_admin_siteinfo_copyright_author_placeholder'] = 'Author Name (Optional)';
$lang['cms_admin_siteinfo_copyright_author_desc'] =
	'The site author. If specified, it will be rendered as meta tag on every pages. It may be overridden by any pages ' .
	'if certain page has it own author specified. ' .
	'The meta would look like: <code>&lt;meta name="author" content="&lt;author-name&gt;" /&gt;</code>';

$lang['cms_admin_siteinfo_copyright_text_label'] = 'Copyright Text';
$lang['cms_admin_siteinfo_copyright_text_placeholder'] = 'Copyright Text (Optional)';
$lang['cms_admin_siteinfo_copyright_text_desc'] =
	'The site copyright text. If specified, it will be rendered as meta tag on every pages. ' .
	'It may be overridden by any pages if certain page has it own copyright text specified. ' .
	'The meta would look like: <code>&lt;meta name="copyright" content="&lt;copyright-text&gt;" /&gt;</code>';

$lang['cms_admin_siteinfo_seo'] = 'Search Engine Optimization (SEO)';
$lang['cms_admin_siteinfo_seo_description_label'] = 'Description';
$lang['cms_admin_siteinfo_seo_description_placeholder'] = 'Description (Optional)';
$lang['cms_admin_siteinfo_seo_description_desc'] =
	'The main description of the site. If specified, it will be rendered as default meta tag if page ' .
	'specific description not set. ' .
	'Recommend to specify the brief description that explains about the site. Do not repeat use of the keywords, ' .
	'make sure it is readable and make sure it is not very long.';