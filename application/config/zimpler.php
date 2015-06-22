<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Site Title
|--------------------------------------------------------------------------
|
| The title of website.
|
*/

$config['site_title'] = 'Zimpler';

/*
|--------------------------------------------------------------------------
| Allow Signup
|--------------------------------------------------------------------------
|
| Allow new user signup.
|
*/
$config['allow_signup']	= 'false';

/*
|--------------------------------------------------------------------------
| Upload temporary path.
|--------------------------------------------------------------------------
|
| The temporary path the file will be uploaded into.
|
*/

$config['upload_path'] = 'uploads';


// Skip CSRF on API request.
if (isset($_SERVER["REQUEST_URI"]) &&
   (isset($_SERVER['REQUEST_METHOD']) && ($_SERVER['REQUEST_METHOD'] == 'POST') ))
{
    if (stripos($_SERVER["REQUEST_URI"],'/api/') === TRUE )
    {
        $config['csrf_protection'] = FALSE;
    }
} 