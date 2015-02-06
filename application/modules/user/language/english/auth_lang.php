<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Auth Lang - English
*
* Author: Ben Edmunds
* 		  ben.edmunds@gmail.com
*         @benedmunds
*
* Author: Daniel Davis
*         @ourmaninjapan
*
* Location: http://github.com/benedmunds/ion_auth/
*
* Created:  03.09.2013
*
* Description:  English language file for Ion Auth example views
*
*/

// Errors
$lang['error_csrf'] = 'This form post did not pass our security checks.';

// Startup
$lang['startup_heading']		= 'Welcome to Zimpler';
$lang['startup_intro']			= 'As you are the first one that start this site so we ' .
								  'are assuming that you are the system administrator. ' .
								  'Please enter information below to complete the setup process.';
								  
$lang['startup_fname_label']                       = 'First Name';
$lang['startup_fname_placeholder']                 = 'Your First Name';
$lang['startup_lname_label']                       = 'Last Name';
$lang['startup_lname_placeholder']                 = 'Your Last Name';
$lang['startup_company_label']                     = 'Organization';
$lang['startup_company_placeholder']               = 'Company or Organization Name (Optional)';
$lang['startup_email_label']                       = 'Email';
$lang['startup_email_placeholder']                 = 'Your Email';
$lang['startup_phone_label']                       = 'Phone';
$lang['startup_phone_placeholder']                 = 'Phone Number (Optional)';
$lang['startup_username_label']                    = 'Username';
$lang['startup_username_placeholder']              = 'Username';
$lang['startup_password_label']                    = 'Password';
$lang['startup_password_placeholder']              = 'Password';
$lang['startup_password_confirm_label']            = 'Confirm Password';
$lang['startup_password_confirm_placeholder']      = 'Confirm Password';
$lang['startup_submit_btn']                        = 'Get Started';

// Login
$lang['login_heading']    		= 'Sign In';
$lang['login_subheading']      	= 'Please sign in with your email/username and password below.';
$lang['login_identity_label']  	= 'Username';
$lang['login_password_label']  	= 'Password';
$lang['login_remember_label']  	= 'Remember Me';
$lang['login_submit_btn']      	= 'Sign In';
$lang['login_signup']			= 'Sign Up';
$lang['login_forgot_password'] 	= 'Forgot your password?';

// Index
$lang['index_heading']           = 'Users';
$lang['index_subheading']        = 'Below is a list of the users.';
$lang['index_fname_th']          = 'First Name';
$lang['index_lname_th']          = 'Last Name';
$lang['index_email_th']          = 'Email';
$lang['index_groups_th']         = 'Groups';
$lang['index_status_th']         = 'Status';
$lang['index_action_th']         = 'Action';
$lang['index_active_link']       = 'Active';
$lang['index_inactive_link']     = 'Inactive';
$lang['index_create_user_link']  = 'Create a new user';
$lang['index_create_group_link'] = 'Create a new group';

// Deactivate User
$lang['deactivate_heading']                  = 'Deactivate User';
$lang['deactivate_subheading']               = 'Are you sure you want to deactivate the user \'%s\'';
$lang['deactivate_confirm_y_label']          = 'Yes:';
$lang['deactivate_confirm_n_label']          = 'No:';
$lang['deactivate_submit_btn']               = 'Submit';
$lang['deactivate_validation_confirm_label'] = 'confirmation';
$lang['deactivate_validation_user_id_label'] = 'user ID';

// Create User
$lang['create_user_heading']                           = 'Create User';
$lang['create_user_subheading']                        = 'Please enter the user\'s information below.';
$lang['create_user_fname_label']                       = 'First Name';
$lang['create_user_lname_label']                       = 'Last Name';
$lang['create_user_company_label']                     = 'Organization';
$lang['create_user_email_label']                       = 'Email';
$lang['create_user_phone_label']                       = 'Phone';
$lang['create_user_password_label']                    = 'Password';
$lang['create_user_password_confirm_label']            = 'Confirm Password';
$lang['create_user_submit_btn']                        = 'Create User';
$lang['create_user_validation_fname_label']            = 'First Name';
$lang['create_user_validation_lname_label']            = 'Last Name';
$lang['create_user_validation_email_label']            = 'Email Address';
$lang['create_user_validation_username_label']         = 'Username';
$lang['create_user_validation_phone1_label']           = 'First Part of Phone';
$lang['create_user_validation_phone2_label']           = 'Second Part of Phone';
$lang['create_user_validation_phone3_label']           = 'Third Part of Phone';
$lang['create_user_validation_company_label']          = 'Organization';
$lang['create_user_validation_password_label']         = 'Password';
$lang['create_user_validation_password_confirm_label'] = 'Password Confirmation';

// Edit User
$lang['edit_user_heading']                           = 'Edit User';
$lang['edit_user_subheading']                        = 'Please enter the user\'s information below.';
$lang['edit_user_fname_label']                       = 'First Name';
$lang['edit_user_lname_label']                       = 'Last Name';
$lang['edit_user_company_label']                     = 'Organization';
$lang['edit_user_email_label']                       = 'Email';
$lang['edit_user_phone_label']                       = 'Phone';
$lang['edit_user_password_label']                    = 'Password (if changing password)';
$lang['edit_user_password_confirm_label']            = 'Confirm Password (if changing password)';
$lang['edit_user_groups_heading']                    = 'Member of groups';
$lang['edit_user_submit_btn']                        = 'Save User';
$lang['edit_user_validation_fname_label']            = 'First Name';
$lang['edit_user_validation_lname_label']            = 'Last Name';
$lang['edit_user_validation_email_label']            = 'Email Address';
$lang['edit_user_validation_phone1_label']           = 'First Part of Phone';
$lang['edit_user_validation_phone2_label']           = 'Second Part of Phone';
$lang['edit_user_validation_phone3_label']           = 'Third Part of Phone';
$lang['edit_user_validation_company_label']          = 'Organization';
$lang['edit_user_validation_groups_label']           = 'Groups';
$lang['edit_user_validation_password_label']         = 'Password';
$lang['edit_user_validation_password_confirm_label'] = 'Password Confirmation';

// Create Group
$lang['create_group_title']                  = 'Create Group';
$lang['create_group_heading']                = 'Create Group';
$lang['create_group_subheading']             = 'Please enter the group information below.';
$lang['create_group_name_label']             = 'Group Name:';
$lang['create_group_desc_label']             = 'Description:';
$lang['create_group_submit_btn']             = 'Create Group';
$lang['create_group_validation_name_label']  = 'Group Name';
$lang['create_group_validation_desc_label']  = 'Description';

// Edit Group
$lang['edit_group_title']                  = 'Edit Group';
$lang['edit_group_saved']                  = 'Group Saved';
$lang['edit_group_heading']                = 'Edit Group';
$lang['edit_group_subheading']             = 'Please enter the group information below.';
$lang['edit_group_name_label']             = 'Group Name:';
$lang['edit_group_desc_label']             = 'Description:';
$lang['edit_group_submit_btn']             = 'Save Group';
$lang['edit_group_validation_name_label']  = 'Group Name';
$lang['edit_group_validation_desc_label']  = 'Description';

// Change Password
$lang['change_password_heading']                               = 'Change Password';
$lang['change_password_old_password_label']                    = 'Old Password:';
$lang['change_password_new_password_label']                    = 'New Password (at least %s characters long):';
$lang['change_password_new_password_confirm_label']            = 'Confirm New Password:';
$lang['change_password_submit_btn']                            = 'Change';
$lang['change_password_validation_old_password_label']         = 'Old Password';
$lang['change_password_validation_new_password_label']         = 'New Password';
$lang['change_password_validation_new_password_confirm_label'] = 'Confirm New Password';

// Forgot Password
$lang['forgot_password_heading']                 = 'Forgot Password';
$lang['forgot_password_subheading']              = 'Please enter your %s so we can send you an email to reset your password.';
$lang['forgot_password_email_label']             = '%s:';
$lang['forgot_password_submit_btn']              = 'Submit';
$lang['forgot_password_validation_email_label']  = 'Email Address';
$lang['forgot_password_username_identity_label'] = 'Username';
$lang['forgot_password_email_identity_label']    = 'Email';
$lang['forgot_password_email_not_found']         = 'No record of that email address.';

// Reset Password
$lang['reset_password_heading']                               = 'Change Password';
$lang['reset_password_new_password_label']                    = 'New Password (at least %s characters long):';
$lang['reset_password_new_password_confirm_label']            = 'Confirm New Password:';
$lang['reset_password_submit_btn']                            = 'Change';
$lang['reset_password_validation_new_password_label']         = 'New Password';
$lang['reset_password_validation_new_password_confirm_label'] = 'Confirm New Password';

// Field Error
$lang['required_error_fname']			= 'First name must be specified';
$lang['required_error_lname']			= 'Last name must be specified';
$lang['required_error_email']			= 'Email must be specified';
$lang['invalid_error_email']			= 'Invalid email address format';
$lang['invalid_error_phone']			= 'Invalid phone number format';
$lang['required_error_username']		= 'Username must be specified';
$lang['required_error_password']		= 'Password must be specified';
$lang['min_error_password']				= 'Password must have at least 8 characters';
$lang['match_error_password']			= 'Confirm password does not match';