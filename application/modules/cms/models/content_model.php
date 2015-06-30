<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Content_model extends CI_Model 
{
    public function __construct() 
    { 
        parent::__construct();
        
        $this->load->dbforge();
        $this->load->helper('date');
        $this->initialize();
    }
    
    private function initialize()
    {
		/*
		|--------------------------------------------------------------------------
		| Version 1.0
		|--------------------------------------------------------------------------
	    */
	    
	    // content table.
	    if(!$this->db->table_exists('content'))
	    {
		    $this->dbforge->add_field('content_id		int				NOT NULL	AUTO_INCREMENT');
		    $this->dbforge->add_field('content_key 		varchar(50)		NOT NULL');
		    $this->dbforge->add_field('name 			varchar(150)	NOT NULL');
		    $this->dbforge->add_field('`group` 			varchar(80)		NULL 		default null');
		    $this->dbforge->add_field('description 		varchar(250)	NULL 		default null');
		    $this->dbforge->add_field('content_type 	varchar(15)		NOT NULL');
		    $this->dbforge->add_field('date_created 	datetime		NOT NULL');
		    $this->dbforge->add_field('last_modified 	datetime		NOT NULL');
		    $this->dbforge->add_field('status 			varchar(15)		NOT NULL');
		    $this->dbforge->add_key('content_id', TRUE);
			$this->dbforge->create_table('content', TRUE);
		}
		
		// content_label table.
	    if(!$this->db->table_exists('content_label'))
	    {
			$this->dbforge->add_field('content_label_id	int				NOT NULL	AUTO_INCREMENT');
			$this->dbforge->add_field('content_id		int				NOT NULL');
			$this->dbforge->add_field('culture			varchar(5)		NOT NULL 	default \'en-us\'');
			$this->dbforge->add_field('revision			int				NOT NULL');
			$this->dbforge->add_field('label			varchar(80)		NOT NULL');
		    $this->dbforge->add_field('date_created 	datetime		NOT NULL');
		    $this->dbforge->add_field('last_modified 	datetime		NOT NULL');
		    $this->dbforge->add_field('date_publish 	datetime		NULL 		default null');
			$this->dbforge->add_field('status			varchar(15)		NOT NULL');
			$this->dbforge->add_key('content_label_id', TRUE);
			$this->dbforge->create_table('content_label', TRUE);
		}
		
		// content_html table.
	    if(!$this->db->table_exists('content_html'))
	    {
			$this->dbforge->add_field('content_html_id	int				NOT NULL	AUTO_INCREMENT');
			$this->dbforge->add_field('content_id		int				NOT NULL');
			$this->dbforge->add_field('culture			varchar(5)		NOT NULL 	default \'en-us\'');
			$this->dbforge->add_field('revision			int				NOT NULL');
			$this->dbforge->add_field('title			varchar(80)		NOT NULL');
			$this->dbforge->add_field('html				varchar(20000)	NOT NULL');
		    $this->dbforge->add_field('date_created 	datetime		NOT NULL');
		    $this->dbforge->add_field('last_modified 	datetime		NOT NULL');
		    $this->dbforge->add_field('date_publish 	datetime		NULL 		default null');
			$this->dbforge->add_field('status			varchar(15)		NOT NULL');
			$this->dbforge->add_key('content_html_id', TRUE);
			$this->dbforge->create_table('content_html', TRUE);
		}

		// content_list table.
	    if(!$this->db->table_exists('content_list'))
	    {
			$this->dbforge->add_field('content_list_id	int				NOT NULL	AUTO_INCREMENT');
			$this->dbforge->add_field('content_id		int				NOT NULL');
			$this->dbforge->add_field('culture			varchar(5)		NOT NULL 	default \'en-us\'');
			$this->dbforge->add_field('revision			int				NOT NULL');
			$this->dbforge->add_field('title			varchar(80)		NOT NULL');
			$this->dbforge->add_field('headers			varchar(1000)	NOT NULL');
			$this->dbforge->add_field('max_items		int				NOT NULL');
		    $this->dbforge->add_field('date_created 	datetime		NOT NULL');
		    $this->dbforge->add_field('last_modified 	datetime		NOT NULL');
		    $this->dbforge->add_field('date_publish 	datetime		NULL 		default null');
			$this->dbforge->add_field('status			varchar(15)		NOT NULL');
			$this->dbforge->add_key('content_list_id', TRUE);
			$this->dbforge->create_table('content_list', TRUE);
		}
		
		// content_list_item table.
	    if(!$this->db->table_exists('content_list_item'))
	    {
			$this->dbforge->add_field('content_list_item_id	int			NOT NULL	AUTO_INCREMENT');
			$this->dbforge->add_field('content_id		int				NOT NULL');
			$this->dbforge->add_field('culture			varchar(5)		NOT NULL');
			$this->dbforge->add_field('data				varchar(5000)	NOT NULL');
			$this->dbforge->add_field('order_no			int				NOT NULL 	default 0');
		    $this->dbforge->add_field('date_created 	datetime		NOT NULL');
		    $this->dbforge->add_field('last_modified 	datetime		NOT NULL');
		    $this->dbforge->add_field('date_publish 	datetime		NULL 		default null');
			$this->dbforge->add_field('status			varchar(15)		NOT NULL');
			$this->dbforge->add_key('content_list_item_id', TRUE);
			$this->dbforge->create_table('content_list_item', TRUE);
		}
    }

    public function get_total_contents()
    {
		$this->db->from('content');
		return $this->db->count_all_results();
    }
    
	public function get_list($culture, $keyword = NULL, 
		$skip = 0, $take = 50, $order_by = 'title asc')
	{
		if($keyword)
		{
			$this->db->where('title like', '%' . $keyword . '%');
			$this->db->or_where('group like', '%' . $keyword . '%');
			$this->db->or_where('description like', '%' . $keyword . '%');
			$this->db->or_where('content_type like', '%' . $keyword . '%');
		}

		$result = $this->db->order_by($order_by)->
				select('a.content_id, a.title, a.group, a.description, 
						a.content_type, a.last_modified,
						b.culture, b.status', FALSE)->
				select(
					"CASE ".
    				"	WHEN a.content_type = 'html' THEN b.title ".
    				"	WHEN a.content_type = 'label' THEN c.label ".
    				"	WHEN a.content_type = 'list' THEN d.title ".
  					"END AS preview", FALSE)->

				join('content_html b', 'a.content_id = b.content_id', 'left')->
				join('content_label c', 'a.content_id = c.content_id', 'left')->
				join('content_list d', 'a.content_id = d.content_id', 'left')->
				get('content a', $take, $skip)->result();

		$this->db->flush_cache();

		if($keyword)
		{
			$this->db->where('title like', '%' . $keyword . '%');
			$this->db->or_where('group like', '%' . $keyword . '%');
			$this->db->or_where('description like', '%' . $keyword . '%');
			$this->db->or_where('content_type like', '%' . $keyword . '%');
		}

		$total = $this->db->from('content')->count_all_results();

		return array(

			'items' => $result,
			'total' => $total,
			'from' => count($result) > 0 ? $skip + 1 : 0,
			'to' => $skip + count($result)
		);
	}
    
    public function get_top_revision($content_key, $culture)
    {
	    $content = $this->db->get_where('content', array('content_key' => $content_key))->row();
	    if(!$content)
	    	throw new Exception('content with the given content_key does not exists');
	    
	    // Get the latest content revision.
	    $this->db->select_max('revision', 'latest_revision');
	    $query = $this->db->get_where('content_' . $content->content_type, 
	    	array('content_id' => $content->content_id, 'culture' => $culture));
	    	
	    $top_rev = $query->row()->latest_revision;
	    	
	    if(!$top_rev)
	    {
		    throw new Exception('content with the given content_key does not have details data');
	    }
	    
	    return $top_rev;
    }
 
    public function add_content($content)
    {
	    if(!$content)
	    	throw new Exception('content parameter cannot be null');
	    
	    if(!array_key_exists('title', $content))
	    	throw new Exception('title must be specified');

	    if(!array_key_exists('content_key', $content))
	    	throw new Exception('content_key must be specified');

	    if(!array_key_exists('content_type', $content))
	    	throw new Exception('content_type must be specified');
	    	
	    $this->db->flush_cache();
	    	
	    if(isset($content['content_html']))
	    {
	    	$content_html = $content['content_html'];
	    	unset($content['content_html']);
	    }	    	

	    if(isset($content['content_list']))
	    {
		    $content_list = $content['content_list'];
		    unset($content['content_list']);
		}

	    if(isset($content['content_label']))
	    {
		    $content_list = $content['content_label'];
		    unset($content['content_label']);
		}
		
	    $this->db->trans_start();
	    
	    $content['date_created'] = date('Y-m-d H:i:s', now());
	    $content['last_modified'] = date('Y-m-d H:i:s', now());
	    $content['status'] = 'active';
	    
	    $this->db->insert('content', $content);
	    $content_id = $this->db->insert_id();
	    
	    switch($content['content_type'])
	    {
		    case 'label': 
		    	$content_details = $this->add_label_content($content_id, $content_label); 
		    	$content['content_label'] = $content_details;
		    	break;
		    case 'html': 
		    	$content_details = $this->add_html_content($content_id, $content_html); 
		    	$content['content_html'] = $content_details;
		    	break;
		    case 'list': 
		    	$content_details = $this->add_list_content($content_id, $content_list); 
		    	$content['content_list'] = $content_details;
		    	break;

		    default: throw new Exception('Unsupported content_type'); break;
	    }
	    
	    $this->db->trans_complete();

	    $content['content_id'] = $content_id;

	    return $content;
    }
    
    public function update_content($content)
    {
	    if(!$content)
	    	throw new Exception('content parameter cannot be null');

	    if(!array_key_exists('content_id', $content))
	    	throw new Exception('content_id must be specified');

	    if(!array_key_exists('title', $content))
	    	throw new Exception('title must be specified');
	    	
	    $this->db->flush_cache();
	    	
	    if(isset($content['content_html']))
	    {
	    	$content_html = $content['content_html'];
	    	unset($content['content_html']);
	    }	    	

	    if(isset($content['content_list']))
	    {
		    $content_list = $content['content_list'];
		    unset($content['content_list']);
		}

	    if(isset($content['content_label']))
	    {
		    $content_list = $content['content_label'];
		    unset($content['content_label']);
		}
	    	
	    $content_id = $content['content_id'];
	    	
	    // Check if content exists.
		$query = $this->db->get_where('content', array('content_id' => $content_id));
		if($query->num_rows() == 0)
			throw new Exception('content with the given content_id: ' . $content_id . ' does not exists');
			
		$existing_content = $query->row();
		$existing_content = json_decode(json_encode($existing_content), true);
		
		// Update content.
	    $this->db->trans_start();
	    	
	    switch($existing_content['content_type'])
	    {
		    case 'label': 
		    	$content_details = $this->update_label_content($content_id, $content_label); 
		    	$content['content_label'] = $content_details;
		    	break;
		    case 'html': 
		    	$content_details = $this->update_html_content($content_id, $content_html); 
		    	$content['content_html'] = $content_details;
		    	break;
		    case 'list': 
		    	$content_details = $this->update_list_content($content_id, $content_list); 
		    	$content['content_list'] = $content_details;
		    	break;

		    default: throw new Exception('Unsupported content_type'); break;
	    }
	    
	    $this->db->set('last_modified', date('Y-m-d H:i:s', now()));
	    
	    if(array_key_exists('name', $content))
	    	$this->db->set('name', $content['name']);
	    
	    if(array_key_exists('description', $content))
		    $this->db->set('description', $content['description']);
	    
		$this->db->where('content_id', $content_id);
		$this->db->update('content');
	    
	    $this->db->trans_complete();

	    return $content;
    }
    
    private function add_label_content($content_id, $content_label)
    {
	    if(!$content_label)
	    	throw new Exception('content_label must be specified');
	    
	    if(!array_key_exists('label', $content_label))
	    	throw new Exception('content_label::label must be specified');
	    	
	    $this->db->flush_cache();

	    $content_label['content_id'] = $content_id;
	    $content_label['revision'] = 1;
	    $content_label['date_created'] = date('Y-m-d H:i:s', now());
	    $content_label['last_modified'] = date('Y-m-d H:i:s', now());
	    $content_label['date_publish'] = null;
	    $content_label['status'] = 'draft';
	    
	    $this->db->insert('content_label', $content_label);
	    $content_label['content_label_id'] = $this->db->insert_id();

	    return $content_label;
    }
    
    private function update_label_content($content_id, $content_label)
    {
	    if(!$content_label)
	    	throw new Exception('content_label must be specified');
	    
	    if(!array_key_exists('label', $content_label))
	    	throw new Exception('content_label::label must be specified');
	    	
	    if(!array_key_exists('culture', $content_label))
	    	throw new Exception('content_label::culture must be specified');
	    	
	    $this->db->flush_cache();
	    
	    // Get the latest content revision.
	    $this->db->select_max('revision', 'latest_revision');
	    $query = $this->db->get_where('content_label', 
	    	array('content_id' => $content_id, 'culture' => $content_html['culture']));
	    	
	    if(!$query->row()->latest_revision)
	    {
		    // New culture entry.
		    add_label_content($content_id, $content_html);
		}
	    else
	    {
		    $latest_revision = $query->row()->latest_revision;
		    
		    $query = $this->db->get_where('content_label',
		    	array('content_id' => $content_id, 'culture' => $culture, 'revision' => $latest_revision));
		    	
		    $existing_content_label = $query->row();
		    
			// If the content_label with the given content_id and culture already published, do not allow update.
			if($existing_content_label->status == 'published')
				throw new Exception('content is already published, please create new revision');
				
			$existing_content_label['last_modified'] = date('Y-m-d H:i:s', now());
			$existing_content_label['label'] = $content_label['label'];
			
			$content_label_id = $existing_content_label['content_label_id'];
			
			$this->db->where('content_label_id', $content_label_id);
			$this->db->update('content_label', $existing_content_label);
		}

		return $existing_content_label;
    }
    
    private function add_html_content($content_id, $content_html)
    {
	    if(!$content_html)
	    	throw new Exception('content_html must be specified');

	    if(!array_key_exists('title', $content_html))
	    	throw new Exception('content_title::title must be specified');
	    
	    if(!array_key_exists('html', $content_html))
	    	throw new Exception('content_html::html must be specified');
	    	
	    $this->db->flush_cache();

	    $content_html['content_id'] = $content_id;
	    $content_html['revision'] = 1;
	    $content_html['date_created'] = date('Y-m-d H:i:s', now());
	    $content_html['last_modified'] = date('Y-m-d H:i:s', now());
	    $content_html['date_publish'] = null;
	    $content_html['status'] = 'draft';
	    
	    $this->db->insert('content_html', $content_html);
	    $content_html['content_html_id'] = $this->db->insert_id();

	    return $content_html;
    }
    
    private function update_html_content($content_id, $content_html)
    {
	    if(!$content_html)
	    	throw new Exception('content_html must be specified');
	    
	    if(!array_key_exists('html', $content_html))
	    	throw new Exception('content_html::html must be specified');
	    	
	    if(!array_key_exists('culture', $content_html))
	    	throw new Exception('content_html::culture must be specified');
	    	
		$this->db->flush_cache();
	    	
	    // Get the latest content revision.
	    $this->db->select_max('revision', 'latest_revision');
	    $query = $this->db->get_where('content_html', 
	    	array('content_id' => $content_id, 'culture' => $content_html['culture']));
	    	
	    if(!$query->row()->latest_revision)
	    {
		    // New culture entry.
		    $this->add_html_content($content_id, $content_html);
	    }
	    else
	    {
		    $latest_revision = $query->row()->latest_revision;
		    
		    $query = $this->db->get_where('content_html',
		    	array(
		    		'content_id' => $content_id, 
		    		'culture' => $content_html['culture'], 
		    		'revision' => $latest_revision));
		    	
		    $existing_content_html = $query->row();
		    $existing_content_html = json_decode(json_encode($existing_content_html), true);
		    
			// If the content_html with the given content_id and culture already published, just skip.
			if($existing_content_html['status'] == 'published')
				throw new Exception('content is already published, please create new revision');
				
			$existing_content_html['last_modified'] = date('Y-m-d H:i:s', now());
			$existing_content_html['html'] = $content_html['html'];
			
			if(array_key_exists('title', $content_html))
				$existing_content_html['title'] = $content_html['title'];
				
			$content_html_id = $existing_content_html['content_html_id'];
			
			$this->db->where('content_html_id', $content_html_id);
			$this->db->update('content_html', $existing_content_html);
		}

		return $existing_content_html;	
    }
    
    private function add_list_content($content_id, $content_list)
    {
	    if(!$content_list)
	    	throw new Exception('content_list must be specified');
	    
	    if(!array_key_exists('title', $content_list))
	    	throw new Exception('content_list::title must be specified');
	    
	    if(!array_key_exists('headers', $content_list))
	    	throw new Exception('content_list::headers must be specified');
	    	
	    $this->db->flush_cache();

	    $content_list['content_id'] = $content_id;
	    $content_list['revision'] = 1;
	    $content_list['date_created'] = date('Y-m-d H:i:s', now());
	    $content_list['last_modified'] = date('Y-m-d H:i:s', now());
	    $content_list['date_publish'] = null;
	    $content_list['status'] = 'draft';
	    
	    $this->db->insert('content_list', $content_list);
	    $content_list_id = $this->db->insert_id();
	    
	    // Add all items.
	    if(array_key_exists('content_list_items', $content_list))
	    {
		    $content_list_items = $content_list['content_list_items'];
		    foreach($content_list_items as $content_list_item)
		    {
			    $content_list_item['content_id'] = $content['content_id'];
			    $content_list_item['content_list_id'] = $content_list_id;
			    $content_list['date_created'] = date('Y-m-d H:i:s', now());
			    $content_list['last_modified'] = date('Y-m-d H:i:s', now());
			    $content_list['date_publish'] = null;
			    $content_list['status'] = 'draft';
			    
			    $this->db->insert('content_list_item', $content_list_item);
		    }
	    }

	    $content_list['content_list_id'] = $content_list_id;

	    return $content_list;
    }
    
    private function update_list_content($content_id, $content_list)
    {
	    if(!$content_list)
	    	throw new Exception('content_list must be specified');
	    	
	    if(!array_key_exists('culture', $content_list))
	    	throw new Exception('content_html::culture must be specified');
	    	
	    $this->db->flush_cache();
	    
	    // Get the latest content revision.
	    $this->db->select_max('revision', 'latest_revision');
	    $query = $this->db->get_where('content_list', 
	    	array('content_id' => $content_id, 'culture' => $content_html['culture']));
	    	
	    if(!$query->row()->latest_revision)
	    {
		    // New culture entry.
		    add_list_content($content_id, $content_html);
	    }
	    else
	    {
		    $latest_revision = $query->row()->latest_revision;
		    
		    $query = $this->db->get_where('content_list',
		    	array('content_id' => $content_id, 'culture' => $culture, 'revision' => $latest_revision));
		    	
		    $existing_content_list = $query->row();
		    
			// If the content_list with the given content_id and culture already published, do not allow update.
			if($existing_content_list->status == 'published')
				throw new Exception('content is already published, please create new revision');
				
			$existing_content_list['last_modified'] = date('Y-m-d H:i:s', now());
			
			if(!array_key_exists('title', $content_list))
				$existing_content_list['title'] = $content_list['title'];
	
			if(!array_key_exists('headers', $content_list))
				$existing_content_list['headers'] = $content_list['headers'];
	
			if(!array_key_exists('max_items', $content_list))
				$existing_content_list['max_items'] = $content_list['max_items'];
				
			$content_list_id = $existing_content_list['content_list_id'];
			
			$this->db->where('content_list_id', $content_list_id);
			$this->db->update('content_list', $existing_content_list);
		}

		return $existing_content_list;
    }
    
    public function add_list_item($content_list_item)
    {
	    if(!$content_list_item)
	    	throw new Exception('content_list_item parameter cannot be null');

	    if(!array_key_exists('content_id', $content_list_item))
	    	throw new Exception('content_id must be specified');

	    if(!array_key_exists('culture', $content_list_item))
	    	throw new Exception('culture must be specified');
	    	
	    $this->db->flush_cache();
	    	
	    $content_id = $content_list_item['content_id'];
	    $culture = $content_list_item['culture'];
	    
	    // Check if content exists.
	    $query = $this->db->get_where('content', array('content_id' => $content_id));
	    	
	    if($query->num_rows() == 0)
		    throw new Exception('content with the given content_id does not exists');
		    
		// Check if content list with the given culture exists.
		$query = $this->db->get_where('content_list', 
			array('content_id' => $content_id, 'culture' => $culture));
			
		if($query->num_rows() == 0)
			throw new Exception('content_list with the given culture does not exists');

	    $content_list_item['date_created'] = date('Y-m-d H:i:s', now());
	    $content_list_item['last_modified'] = date('Y-m-d H:i:s', now());
	    $content_list_item['date_publish'] = null;
	    $content_list_item['status'] = 'draft';

		$this->db->insert('content_list_item', $content_list_item);
    }
    
    public function publish($content_key, $culture)
    {
	    $this->db->flush_cache();
	    
	    $content = $this->db->get_where('content', array('content_key' => $content_key))->row();
	    
	    if(!$content)
	    	throw new Exception('content with the given content_key does not exists');
	    	
	    $revision = $this->get_top_revision($content_key, $culture);
	    
	    $content_table = 'content_' . $content->content_type;
	    $content_details = $this->db->get_where($content_table, array(
			'content_id' => $content->content_id,
			'culture' => $culture,
			'revision' => $revision
	    ))->row();
	    
	    if(!$content_details)
	    	throw new Exception('content with the given content_key and culture does not exists');
	    
	    $this->db->set('status', 'published');
	    $this->db->set('date_publish', date('Y-m-d H:i:s', now()));
	    $this->db->where($content_table . '_id', $content_details->{$content_table . '_id'});
	    $this->db->update($content_table);
    }
    
    public function create_new_revision($content_key, $culture)
    {
	    $this->db->flush_cache();
	    
	    $content = $this->db->get_where('content', array('content_key' => $content_key))->row();
	    
	    if(!$content)
	    	throw new Exception('content with the given content_key does not exists');
	    	
	    $revision = $this->get_top_revision($content_key, $culture);
	    
	    $content_table = 'content_' . $content->content_type;
	    $content_details = $this->db->get_where($content_table, array(
			'content_id' => $content->content_id,
			'culture' => $culture,
			'revision' => $revision
	    ))->row();
	    
	    if(!$content_details)
	    	throw new Exception('content with the given content_key and culture does not exists');
	    
	    unset($content_details->{$content_table . '_id'});
	    $content_details->revision = $content_details->revision + 1;
	    $content_details->date_created = date('Y-m-d H:i:s', now());
	    $content_details->last_modified = date('Y-m-d H:i:s', now());
	    $content_details->date_publish = null;
	    $content_details->status = 'draft';
	    
	    $this->db->insert($content_table, $content_details);
    }
    
    public function delete_revision($content_key, $culture, $revision)
    {
	    $this->db->flush_cache();
	    
	    $content = $this->db->get_where('content', array('content_key' => $content_key))->row();
	    
	    if(!$content)
	    	throw new Exception('content with the given content_key does not exists');
	    	
	    $content_table = 'content_' . $content->content_type;
	    $content_details = $this->db->get_where($content_table, array(
			'content_id' => $content->content_id,
			'culture' => $culture,
			'revision' => $revision
	    ))->row();
	    
	    if(!$content_details)
	    	throw new Exception('content with the given content_key, culture and revision does not exists');
	    
	    $this->db->where($content_table . '_id', $content_details->{$content_table . '_id'});
	    $this->db->delete($content_table);
    }
}