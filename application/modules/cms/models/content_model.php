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
		    $this->dbforge->add_field('title 			varchar(150)	NOT NULL');
		    $this->dbforge->add_field('`group` 			varchar(80)		NULL 		default null');
		    $this->dbforge->add_field('description 		varchar(250)	NULL 		default null');
		    $this->dbforge->add_field('content_type 	varchar(15)		NOT NULL');
		    $this->dbforge->add_field('author			int 			NOT NULL');
		    $this->dbforge->add_field('date_created 	datetime		NOT NULL');
		    $this->dbforge->add_field('last_modified 	datetime		NOT NULL');
		    $this->dbforge->add_field('status 			varchar(15)		NOT NULL');
		    $this->dbforge->add_key('content_id', TRUE);
			$this->dbforge->create_table('content', TRUE);
		}

		// content_track table.
		if(!$this->db->table_exists('content_track'))
		{
			$this->dbforge->add_field('content_id 		int 			NOT NULL');
			$this->dbforge->add_field('revision 		int 			NOT NULL');
			$this->dbforge->add_field('created_by 		int 			NOT NULL');
			$this->dbforge->add_field('last_modified_by	int 			NOT NULL');
			$this->dbforge->add_field('published_by		int 			NULL 		default null');
			$this->dbforge->add_field('approved_by		int 			NULL 		default null');
			$this->dbforge->add_field('rejected_by		int 			NULL 		default null');
			$this->dbforge->add_field('commit_note		text 			NULL 		default null');
			$this->dbforge->add_key('content_id', TRUE);
			$this->dbforge->add_key('revision', TRUE);
			$this->dbforge->create_table('content_track', TRUE);
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

    public function validate_key($key, $content_id = NULL)
    {
    	$this->db->where('content_key', $key);

    	if($content_id)
    		$this->db->where('content_id <>', $content_id);

    	$content = $this->db->get('content')->row();

    	return $content == NULL;
    }

    private function build_list_query($culture, $keyword, $order_by, $skip = NULL, $take = NULL)
    {
    	$this->db->flush_cache();

		if($keyword)
		{
			$this->db->where('a.title like', '%' . $this->db->escape_like_str($keyword) . '%');
			$this->db->or_where('b.title like', '%' . $this->db->escape_like_str($keyword) . '%');
			$this->db->or_where('b.html like', '%' . $this->db->escape_like_str($keyword) . '%');
			$this->db->or_where('c.label like', '%' . $this->db->escape_like_str($keyword) . '%');
			$this->db->or_where('d.title like', '%' . $this->db->escape_like_str($keyword) . '%');
			$this->db->or_where('group like', '%' . $this->db->escape_like_str($keyword) . '%');
			$this->db->or_where('description like', '%' . $this->db->escape_like_str($keyword) . '%');
			$this->db->or_where('content_type like', '%' . $this->db->escape_like_str($keyword) . '%');
		}

		$this->db->order_by($order_by);

		$query = $this->db
			->select('a.content_id, a.content_key, a.title, a.group, a.description, 
					a.content_type, a.last_modified', FALSE)

			->select(
				"CASE ".
				"	WHEN a.content_type = 'html' THEN b.title ".
				"	WHEN a.content_type = 'label' THEN c.label ".
				"	WHEN a.content_type = 'list' THEN d.title ".
				"END AS public_title", FALSE)

			->select(
				"CASE ".
				"	WHEN a.content_type = 'html' THEN b.culture ".
				"	WHEN a.content_type = 'label' THEN c.culture ".
				"	WHEN a.content_type = 'list' THEN d.culture ".
				"END AS culture", FALSE)

			->select(
				"CASE ".
				"	WHEN a.content_type = 'html' THEN b.status ".
				"	WHEN a.content_type = 'label' THEN c.status ".
				"	WHEN a.content_type = 'list' THEN d.status ".
				"END AS rev_status", FALSE)

			->select(
				"CASE ".
				"	WHEN a.content_type = 'html' THEN b.revision ".
				"	WHEN a.content_type = 'label' THEN c.revision ".
				"	WHEN a.content_type = 'list' THEN d.revision ".
				"END AS revision", FALSE)

			->from('content a')

			->join('(select content_id, culture, max(revision) as maxrev ' .
				   'from content_html where culture = ' . 
				   	$this->db->escape($culture) . ' group by content_id, culture) as mb',
				   'mb.content_id = a.content_id', 'left')

			->join('content_html b', 
				   'b.content_id = mb.content_id and ' .
				   'b.culture = mb.culture and ' .
				   'b.revision = mb.maxrev', 'left')

			->join('(select content_id, culture, max(revision) as maxrev ' .
				   'from content_label where culture = ' . 
				    $this->db->escape($culture) . ' group by content_id, culture) as mc',
				   'mc.content_id = a.content_id', 'left')

			->join('content_label c', 
				   'c.content_id = mc.content_id and ' .
				   'c.culture = mc.culture and ' .
				   'c.revision = mc.maxrev', 'left')

			->join('(select content_id, culture, max(revision) as maxrev ' .
				   'from content_list where culture = ' . 
				    $this->db->escape($culture) . ' group by content_id, culture) as md',
				   'md.content_id = a.content_id', 'left')

			->join('content_list d', 
				   'd.content_id = md.content_id and ' .
				   'd.culture = md.culture and ' .
				   'd.revision = md.maxrev', 'left');

		if($skip != NULL && $take != NULL)
			$query = $query->limit($take, $skip);

		return $query;
    }

    public function get_rank($content_id, $culture, $keyword = NULL, $order_by = 'a.last_modified desc')
    {
    	$query = $this->build_list_query($culture, $keyword, $order_by, NULL, NULL);
    	
    	$result = $query->get()->result();
    	$rank = 0;

    	foreach($result as $item)
    	{
    		if($item->content_id == $content_id)
    			break;

    		$rank++;
    	}

    	return $rank;
    }
    
	public function get_list($culture, $keyword = NULL, $order_by = 'a.last_modified desc',
		$skip = 0, $take = 50)
	{
		$query = $this->build_list_query($culture, $keyword, $order_by, $skip, $take);
		$result = $query->get()->result();

		$query = $this->build_list_query($culture, $keyword, $order_by);
		$total = $query->count_all_results();

		return array(

			'items' => $result,
			'total' => $total,
			'from' => count($result) > 0 ? $skip + 1 : 0,
			'to' => $skip + count($result)
		);
	}
    
    public function get_top_revision($content_key, $culture, $status = NULL)
    {
	    $content = $this->db->get_where('content', array('content_key' => $content_key))->row();
	    if(!$content)
	    	throw new Exception('content with the given content_key does not exists');
	    
	    // Get the latest content revision.
	    $this->db->select_max('revision', 'latest_revision');

	    $where_cause = array('content_id' => $content->content_id, 'culture' => $culture);

	    if($status)
	    {
	    	$where_cause['status'] = $status;
	    }

	    $query = $this->db->get_where('content_' . $content->content_type, $where_cause);
	    	
	    $top_rev = $query->row()->latest_revision;
	    	
	    if(!$top_rev)
	    {
		    return 0;
	    }
	    
	    return $top_rev;
    }

    public function get($content_key, $culture, $revision = NULL)
    {
    	$content = $this->db->where('content_key', $content_key)->get('content')->row();

    	if(!$content)
    		return NULL;

    	if($revision === NULL)
    		$revision = $this->get_top_revision($content_key, $culture, 'published');

    	$content_details = $this->db
    		->where('content_id', $content->content_id)
    		->where('culture', $culture)
    		->where('revision', $revision)
    		->get('content_' . $content->content_type)->row();

    	$content->{'content_' . $content->content_type} = $content_details;

    	return $content;
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
	    	
		if(!$this->validate_key($content['content_key']))
			throw new Exception('content_key is already exists');

	    $this->db->flush_cache();
	    	
	    if(isset($content['content_html']))
	    {
	    	$content_html = $content['content_html'];
	    	unset($content['content_html']);
	    }	    	

	    if(isset($content['content_label']))
	    {
		    $content_label = $content['content_label'];
		    unset($content['content_label']);
		}

	    if(isset($content['content_list']))
	    {
		    $content_list = $content['content_list'];
		    unset($content['content_list']);
		}

		if(!$content['group'])
			$content['group'] = NULL;

		if(!$content['description'])
			$content['description'] = NULL;
		
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

		if(!$this->validate_key($content['content_key'], $content['content_id']))
			throw new Exception('content_key is already exists');

	    $this->db->flush_cache();
	    	
	    if(isset($content['content_html']))
	    {
	    	$content_html = $content['content_html'];
	    	unset($content['content_html']);
	    }	    	

	    if(isset($content['content_label']))
	    {
		    $content_label = $content['content_label'];
		    unset($content['content_label']);
		}

	    if(isset($content['content_list']))
	    {
		    $content_list = $content['content_list'];
		    unset($content['content_list']);
		}
	    	
	    $content_id = $content['content_id'];
	    	
	    // Check if content exists.
		$query = $this->db->get_where('content', array('content_id' => $content_id));
		if($query->num_rows() == 0)
			throw new Exception('content with the given content_id: ' . $content_id . ' does not exists');
			
		$existing_content = $query->row();
		$existing_content = json_decode(json_encode($existing_content), true);

		if(!$content['group'])
			$content['group'] = NULL;

		if(!$content['description'])
			$content['description'] = NULL;

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

	    $last_modified = date('Y-m-d H:i:s', now());
	    
	    $this->db->set('last_modified', $last_modified);
	    $this->db->set('title', $content['title']);
	    $this->db->set('content_key', $content['content_key']);
	    $this->db->set('content_type', $content['content_type']);

	    if(array_key_exists('group', $content))
	    	$this->db->set('group', $content['group']);
	    
	    if(array_key_exists('name', $content))
	    	$this->db->set('name', $content['name']);
	    
	    if(array_key_exists('description', $content))
		    $this->db->set('description', $content['description']);
	    
		$this->db->where('content_id', $content_id);
		$this->db->update('content');
	    
	    $this->db->trans_complete();

	    $content['last_modified'] = $last_modified;

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
	    	array('content_id' => $content_id, 'culture' => $content_label['culture']));
	    	
	    if(!$query->row()->latest_revision)
	    {
		    // New culture entry.
		    return $this->add_label_content($content_id, $content_label);
		}
	    else
	    {
		    $latest_revision = $query->row()->latest_revision;
		    
		    $query = $this->db->get_where('content_label',
		    	array('content_id' => $content_id, 
		    		'culture' => $content_label['culture'], 
		    		'revision' => $latest_revision));
		    	
		    $existing_content_label = $query->row();
		    $existing_content_label = json_decode(json_encode($existing_content_label), true);
		    
			// If the content_label with the given content_id and culture already published, do not allow update.
			if($existing_content_label['status'] == 'published')
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

	    if(!$content_html['title'])
	    	$content_html['title'] = NULL;

	    if(!$content_html['html'])
	    	$content_html['html'] = NULL;

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

	    if(!$content_html['title'])
	    	$content_html['title'] = NULL;

	    if(!$content_html['html'])
	    	$content_html['html'] = NULL;

	    // Get the latest content revision.
	    $this->db->select_max('revision', 'latest_revision');
	    $query = $this->db->get_where('content_html', 
	    	array('content_id' => $content_id, 'culture' => $content_html['culture']));
	    	
	    if(!$query->row()->latest_revision)
	    {
		    // New culture entry.
		    return $this->add_html_content($content_id, $content_html);
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
				return $existing_content_html;
				
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

    public function delete_content($content_id)
    {
    	$this->db->flush_cache();

    	$content = $this->db->get_where('content', array('content_id' => $content_id))->row();

	    if(!$content)
	    	throw new Exception('content with the given content_id does not exists');

    	$this->db->from('content');
    	$this->db->where('content_id', $content_id);
    	$this->db->delete();

    	$this->db->from('content_' . $content->content_type);
    	$this->db->where('content_id', $content_id);
    	$this->db->delete();
    }
}