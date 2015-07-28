<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Content_manager_html extends CI_Model 
{
    public function __construct() 
    {
        $this->load->dbforge();
        $this->load->helper('date');
        $this->initialize();
    }

    private function initialize()
    {
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
    }

    public function add_content($content_id, $content_html)
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
    
    public function update_content($content_id, $content_html)
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
			$existing_content_html['title'] = $content_html['title'];
			$existing_content_html['html'] = $content_html['html'];
			
			if(array_key_exists('title', $content_html))
				$existing_content_html['title'] = $content_html['title'];
				
			$content_html_id = $existing_content_html['content_html_id'];
			
			$this->db->where('content_html_id', $content_html_id);
			$this->db->update('content_html', $existing_content_html);
		}

		return $existing_content_html;	
    }
}