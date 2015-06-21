<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
require_once FCPATH . '/vendor/autoload.php';

use \YaLinqo\Enumerable;
use \Aws\S3\S3Client;

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
 * Zimpler S3_Provider Library Class
 *
 * @package		Zimpler
 * @subpackage	Admin Module
 * @category	Libraries
 * @author		Chonnarong Hanyawongse
 * @link		http://zimpler.com/user_guide/admin/libraries/s3_provider.html
 */

class S3_Provider {

	private $bucket;
	private $client;

    function __construct()
    {
        $CI =& get_instance();

        $CI->load->model('setting/setting_model');
        $CI->load->helper('date');

        $this->bucket = $CI->setting_model->get('file_manager::s3::bucket');

        $this->client = S3Client::factory(array(
            'credentials' => array(
                'key'    => $_SERVER['AWS_ACCESS_KEY_ID'],
                'secret' => $_SERVER['AWS_SECRET_ACCESS_KEY']
            )
        ));
    }

	public function list_files($path = null)
	{
		$result = array();

		$params = array(
            'Bucket' => $this->bucket,
            'Prefix' => '',
            'Delimiter' => '/',
            'EncodingType' => 'url',
            'Marker' => ''
        );

        if($path)
        {
			$params['Prefix'] = $path;
        }

        $iterator = $this->client->getIterator('ListObjects', $params, array(
        	'return_prefixes' => TRUE
        ));

        foreach ($iterator as $object) {

        	if(!array_key_exists('Prefix', $object))
        	{
                $keys = explode('/', $object['Key']);
                $pure_key = $keys[count($keys) - 1];

                if($pure_key == '')
                    $pure_key = $object['Key'];

	        	$item = array(

	        		'name' => $pure_key,
	        		'size' => $object['Size'],
	        		'modified' => $object['LastModified'],
	        		'url' => $this->client->getObjectUrl($this->bucket, $object['Key']),
	        		'type' => 'file'
	        	);
	        }
	        else
	        {
                $prefixes = explode('/', $object['Prefix']);
                $last_prefix = $prefixes[count($prefixes) - 1];

                if($last_prefix == '')
                    $last_prefix = $object['Prefix'];

	        	$item = array(

	        		'name' => $last_prefix,
	        		'size' => NULL,
	        		'modified' => NULL,
	        		'url' => NULL,
	        		'type' => 'folder'
	        	);
	        }

	        array_push($result, $item);
        }

        return $result;
	}

    public function store_file($path = '', $file)
    {
        $this->client->putObject(array(
            'Bucket' => $this->bucket,
            'Key' => $path . $file->file_name,
            'SourceFile' => $file->full_path,
            'ACL' => 'public-read'
        ));

        $this->client->waitUntil('ObjectExists', array(
            'Bucket' => $this->bucket,
            'Key' => $path . $file->file_name
        ));

        $time = time();
        $last_modified = standard_date('DATE_ATOM', $time);

        $item = array(

            'name' => $file->file_name,
            'size' => $file->file_size * 1024,
            'modified' => $last_modified,
            'url' => $this->client->getObjectUrl($this->bucket, $path . $file->file_name),
            'type' => 'file'
        );

        return $item;
    }

    public function delete_file($path = '', $file_name)
    {
        $this->client->deleteObject(array(
            'Bucket' => $this->bucket,
            'Key' => $path . $file_name
        ));
    }

    public function delete_folder($path)
    {
        $this->client->deleteMatchingObjects($this->bucket, $path);
    }
}