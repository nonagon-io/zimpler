<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
require_once FCPATH . '/vendor/athari/yalinqo/YaLinqo/Linq.php';
use \YaLinqo\Enumerable;

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
 * Zimpler CMS Content REST Controller Class
 *
 * @package		Zimpler
 * @subpackage	CMS Module
 * @category	Libraries
 * @author		Chonnarong Hanyawongse
 * @link		http://zimpler.com/user_guide/cms/rest/content.html
 */

class Content extends REST_Controller {

    function __construct()
    {
        parent::__construct();
        
        $this->load->model('content_model');
        $this->load->library('user/ion_auth');

		if(!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			show_404();
		}
    }
    
    function index_get()
    {
	    $top_rev = $this->content_model->get_top_revision();
	    
	    $result = array(
		    'rev' => $top_rev,
		    'status' => $this->content_model->get_status($top_rev)
		);
		
		$this->response($result);
    }

    function index_delete()
    {
    	$result = $this->content_model->delete_top_revision();

	    $result = array(
		    'rev' => $result->revision,
		    'status' => $result->status
		);

    	$this->response($result);
    }
    
    function publish_post()
    {
	    $result = $this->content_model->publish();
	    $this->response($result);
    }
    
    function index_post()
    {
		$title = $this->post('title');
		$key = $this->post('key');
		$type = $this->post('type');
		$group = $this->post('group');
		$description = $this->post('description');
		$culture = $this->post('culture');
		
		$content = array(
			
			'title' => $title,
			'content_key' => $key,
			'content_type' => $type,
			'group' => $group,
			'description' => $description
		);

		if($type == 'html')
		{
			$publicTitle = $this->post("publicTitle");
			$html = $this->post("html");

			$content['content_html'] = array(

				'title' => $publicTitle,
				'html' => $html,
				'culture' => $culture
			);
		}
		else if($type == 'label')
		{
			$label = $this->post("label");

			$content['content_label'] = array(

				'label' => $label,
				'culture' => $culture
			);
		}
		else if($type == 'list')
		{
			$content['content_list'] = array(

				'culture' => $culture
			);
		}

		$result = $this->content_model->add_content($content);

		$content = array(
				
			'id' => $result['content_id'],
			'key' => $result['content_key'],
			'title' => $result['title'],
			'group' => $result['group'],
			'type' => $result['content_type'],
			'description' => $result['description']
		);

		if($content['type'] == 'html')
		{
			$content['culture'] = $result['content_html']['culture'];
			$content['publicTitle'] = $result['content_html']['title'];
			$content['html'] = $result['content_html']['html'];
			$content['status'] = $result['content_html']['status'];
		}
		else if($content['type'] == 'label')
		{
			$content['culture'] = $result['content_label']['culture'];
			$content['label'] = $result['content_label']['label'];
			$content['status'] = $result['content_label']['status'];
		}
		else if($content['type'] == 'list')
		{
			$content['culture'] = $result['content_list']['culture'];
			$content['list'] = $result['content_list']['list'];
			$content['status'] = $result['content_list']['status'];
		}

		$this->response(array(

			'content' => $content
		));
    }

    function index_put()
    {
    	$id = $this->put('id');
		$title = $this->put('title');
		$key = $this->put('key');
		$type = $this->put('type');
		$group = $this->put('group');
		$description = $this->put('description');
		$culture = $this->put('culture');
		
		$content = array(
			
			'content_id' => $id,
			'title' => $title,
			'content_key' => $key,
			'content_type' => $type,
			'group' => $group,
			'description' => $description
		);

		if($type == 'html')
		{
			$publicTitle = $this->post("publicTitle");
			$html = $this->post("html");

			$content['content_html'] = array(

				'title' => $publicTitle,
				'html' => $html,
				'culture' => $culture
			);
		}
		else if($type == 'label')
		{
			$label = $this->post("label");

			$content['content_label'] = array(

				'label' => $label,
				'culture' => $culture
			);
		}
		else if($type == 'list')
		{
			$content['content_list'] = array(

				'culture' => $culture
			);
		}

		$result = $this->content_model->update_content($content);

		$content = array(
				
			'id' => $result['content_id'],
			'key' => $result['content_key'],
			'title' => $result['title'],
			'group' => $result['group'],
			'type' => $result['content_type'],
			'description' => $result['description']
		);

		if($content['type'] == 'html')
		{
			$content['culture'] = $result['content_html']['culture'];
			$content['publicTitle'] = $result['content_html']['title'];
			$content['html'] = $result['content_html']['html'];
			$content['status'] = $result['content_html']['status'];
		}
		else if($content['type'] == 'label')
		{
			$content['culture'] = $result['content_label']['culture'];
			$content['label'] = $result['content_label']['label'];
			$content['status'] = $result['content_label']['status'];
		}
		else if($content['type'] == 'list')
		{
			$content['culture'] = $result['content_list']['culture'];
			$content['list'] = $result['content_list']['list'];
			$content['status'] = $result['content_list']['status'];
		}

		$this->response(array(

			'content' => $content
		));
    }
    
    function list_get()
    {
	    $culture = $this->get('culture');
		$skip = $this->get('skip');
		$take = $this->get('take');
		$keyword = $this->get('keyword');

	    $result = $this->content_model->get_list($culture, $keyword, $skip, $take);

	    $content_items = from($result['items'])->select(function($content_item) {
		    
		    return Content::get_front_content_item($content_item);
		    
	    })->toArray();

	    $result->items = $content_items;
	    $this->response($result);
    }
    
    function item_get()
    {
	    $id = $this->get('id');
	    $culture = $this->get('culture');
	    
	    $nav_item = $this->content_model->get_item($id, $culture);
	    
	    $this->response(Navigation::get_front_nav_item($nav_item));
    }
    
    function item_post()
    {
	    $target = $this->post('target');
	    $targetKey = $this->post('targetKey');
	    $parent = $this->post('parent');
	    
	    switch($target)
	    {
		    case 'normal': 
		    	$target = '_self';
		    	break;
		    	
		    case 'new':
		    	if($targetKey) $target = $targetKey;
		    	else $target = '_blank';
		    	break;
	    }
	    
	    $nav_item = array(
		    
		    'parent_id' => $this->post('parent'),
		    'title' => $this->post('key'),
		    'url' => $this->post('url'),
		    'target' => $target,
		    'label' => array(
			    
				'culture' => $this->post('culture'),
				'text' => $this->post('publicTitle')
		    )
		);
		
		$nav_item = $this->content_model->add_item($nav_item);
		$nav_item = Navigation::get_front_nav_item($nav_item);
	    
	    $this->response($nav_item);
    }
    
    function item_put()
    {
	    $id = $this->put('id');
	    $target = $this->put('target');
	    $targetKey = $this->put('targetKey');
	    
	    switch($target)
	    {
		    case 'normal': 
		    	$target = '_self';
		    	break;
		    	
		    case 'new':
		    	if($targetKey) $target = $targetKey;
		    	else $target = '_blank';
		    	break;
	    }
	    
	    $nav_item = array(
		    
		    'nav_item_id' => $id,
		    'parent_id' => $this->post('parent'),
		    'title' => $this->put('key'),
		    'url' => $this->put('url'),
		    'target' => $target,
		    'label' => array(
			    
				'culture' => $this->put('culture'),
				'text' => $this->put('publicTitle')
		    )
		);
		
		$nav_item = $this->content_model->update_item($nav_item);
		$nav_item = Navigation::get_front_nav_item($nav_item);
	    
	    $this->response($nav_item);
    }

    function item_delete($nav_item_id)
    {
    	$nav_item = $this->content_model->delete_item($nav_item_id);
    	$nav_item = array('id' => $nav_item->nav_item_id);

    	$this->response($nav_item);
    }
    
    function tree_post()
    {
	    $tree = json_decode($this->post("tree"));
	    $this->content_model->update_tree($tree);
    }
    
    function publish_put($content_key, $culture)
    {
		$this->content_model->publish($content_key, $culture);
    }
    
    function revision_post($content_key, $culture)
    {
	    $this->content_model->create_new_revision($content_key, $culture);
    }
    
    function revision_delete($content_key, $culture, $revision)
    {
	    $this->content_model->delete_revision($content_key, $culture, $revision);
    }
    
    public static function get_front_content_item($content_item)
    {
	    $content_item = json_decode(json_encode($content_item), FALSE);

	    $obj = new StdClass();
	    $obj->id = $content_item->content_id;
	    $obj->culture = $content_item->culture;
	    $obj->preview = $content_item->preview;
	    $obj->group = $content_item->group;
	    $obj->type = $content_item->content_type;
	    $obj->description = $content_item->description;
	    $obj->modified = $content_item->last_modified;
	    $obj->status = $content_item->status;
	    
	    return $obj;
    }
}