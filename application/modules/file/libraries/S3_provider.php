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

        // Ensure bucket exists.
        if(!$this->client->doesBucketExist($this->bucket))
        {
            $this->client->createBucket(array(

                'Bucket' => $this->bucket
            ));

            $this->client->waitUntil('BucketExists]', array('Bucket' => $this->bucket));
        }
    }

	public function list_files($path = null, $delimiter = '/', $resultAs = 'front')
	{
		$result = array();

		$params = array(
            'Bucket' => $this->bucket,
            'Prefix' => '',
            'EncodingType' => 'url',
            'Marker' => ''
        );

        if($path)
        {
			$params['Prefix'] = $path . '/';
        }

        if($delimiter)
        {
            $params['Delimiter'] = $delimiter;
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
                $last_prefix = $prefixes[count($prefixes) - 2];

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

            if($resultAs == 'front')
            {
                array_push($result, $item);
            }
            else
            {
                array_push($result, $object);
            }
        }

        return $result;
	}

    public function store_file($path = '', $file)
    {
        $key = $path . '/' . $file->file_name;

        $this->client->putObject(array(
            'Bucket' => $this->bucket,
            'Key' => $key,
            'SourceFile' => $file->full_path,
            'ACL' => 'public-read'
        ));

        $this->client->waitUntil('ObjectExists', array(
            'Bucket' => $this->bucket,
            'Key' => $key
        ));

        $time = time();
        $last_modified = standard_date('DATE_ATOM', $time);

        $item = array(

            'name' => $file->file_name,
            'size' => $file->file_size * 1024,
            'modified' => $last_modified,
            'url' => $this->client->getObjectUrl($this->bucket, $key),
            'type' => 'file'
        );

        return $item;
    }

    public function delete_file($path = '', $file_name)
    {
        $this->client->deleteObject(array(
            'Bucket' => $this->bucket,
            'Key' => $path . '/' . $file_name
        ));
    }

    public function add_folder($path = '', $folder_name)
    {
        $this->client->putObject(array( 
           'Bucket' => $this->bucket,
           'Key' => $path . '/' . $folder_name . '/',
           'Body' => '',
           'ACL' => 'public-read'
        ));

        $item = array(

            'name' => $folder_name,
            'size' => NULL,
            'modified' => NULL,
            'url' => NULL,
            'type' => 'folder'
        );

        return $item;
    }

    public function delete_folder($path)
    {
        $path = ltrim($path, '/');
        $this->client->deleteMatchingObjects($this->bucket, $path . '/');
    }

    public function move_file($path, $file, $target)
    {
        $sourceBucket = $this->bucket;

        if($path)
        {
            $sourceKeyname = $path . '/' . $file;
        }
        else
        {
            $sourceKeyname = $file;
        }

        $source = "{$sourceBucket}/{$sourceKeyname}";

        $this->client->copyObject(array(
            'Bucket'     => $this->bucket,
            'Key'        => $target . '/' . $file,
            'CopySource' => $source,
            'ACL' => 'public-read'
        ));

        $this->client->deleteObject(array(
            'Bucket' => $this->bucket,
            'Key' => $path . '/' . $file
        ));
    }

    public function move_folder($path, $folder, $target)
    {
        //echo($target . PHP_EOL);

        $sourceBucket = $this->bucket;

        if($path)
        {
            $sourcePrefix = $path . '/' . $folder;
        }
        else
        {
            $sourcePrefix = $folder;
        }

        $files = $this->list_files($sourcePrefix, null, 'original');
        foreach($files as $file)
        {
            $source = "{$sourceBucket}/{$file['Key']}";
            $targetKey = $target . '/' . $folder . str_replace($sourcePrefix, '', $file['Key']);

            // print_r($targetKey);
            // echo(PHP_EOL);

            $this->client->copyObject(array(
                'Bucket'     => $this->bucket,
                'Key'        => $targetKey,
                'CopySource' => $source,
                'ACL' => 'public-read'
            ));
        }

        $this->delete_folder($sourcePrefix);
    }
}