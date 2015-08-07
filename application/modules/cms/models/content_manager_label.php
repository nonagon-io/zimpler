<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Content_manager_label extends CI_Model 
{
    public function __construct() 
    {
        $this->load->dbforge();
        $this->load->helper('date');
        $this->initialize();
    }

    private function initialize()
    {
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
    }

    public function add_content($content_id, $content_label)
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
    
    public function update_content($content_id, $content_label)
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
}