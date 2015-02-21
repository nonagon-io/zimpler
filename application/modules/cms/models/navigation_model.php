<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Navigation_model extends CI_Model 
{
    public function __construct() 
    { 
        parent::__construct();
        
        $this->load->dbforge();
        $this->load->helper("date");
        $this->initialize();
    }
    
    private function initialize()
    {
		/*
		|--------------------------------------------------------------------------
		| Version 1.0
		|--------------------------------------------------------------------------
	    */
	    
	    // navigation table.
	    if(!$this->db->table_exists("nav"))
	    {
		    $this->dbforge->add_field("nav_id			int				NOT NULL	AUTO_INCREMENT");
			$this->dbforge->add_field("revision			int				NOT NULL");
		    $this->dbforge->add_field("date_created 	datetime		NOT NULL");
		    $this->dbforge->add_field("last_modified 	datetime		NOT NULL");
		    $this->dbforge->add_field("date_publish 	datetime		NULL");
			$this->dbforge->add_field("status			varchar(15)		NOT NULL");
		    $this->dbforge->add_key("nav_id", TRUE);
			$this->dbforge->create_table("nav", TRUE);
		}
		
		// content_label table.
	    if(!$this->db->table_exists("nav_item"))
	    {
			$this->dbforge->add_field("nav_item_id		int				NOT NULL	AUTO_INCREMENT");
			$this->dbforge->add_field("nav_id			int				NOT NULL");
			$this->dbforge->add_field("parent_id		int				NOT NULL	default 0");
			$this->dbforge->add_field("culture			varchar(5)		NOT NULL 	default 'en-us'");
			$this->dbforge->add_field("label			varchar(80)		NOT NULL");
			$this->dbforge->add_field("url				varchar(255)	NOT NULL");
			$this->dbforge->add_field("`order`			int				NOT NULL");
		    $this->dbforge->add_field("date_created 	datetime		NOT NULL");
		    $this->dbforge->add_field("last_modified 	datetime		NOT NULL");
			$this->dbforge->add_field("status			varchar(15)		NOT NULL");
			$this->dbforge->add_key("nav_item_id", TRUE);
			$this->dbforge->create_table("nav_item", TRUE);
		}
    }
    
    public function get_flat($culture, $status = null)
    {
	    if($status)
	    	$this->db->where("status", $status);
	    
	    $this->db->select_max("latest_revision", "latest_revision");
		$max_revision = $this->db->get("nav")->row()->latest_revision;

	    if($status)
	    	$this->db->where("status", $status);
		
		$this->db->where("revision", $max_revision);
		$nav = $this->db->get("nav")->row();
		
		if(!$nav) return array();
		
		$this->db->where("nav_id", $nav->nav_id);
		$this->db->where("culture", $culture);
		$this->db->order_by("parent_id", "asc");
		$this->db->order_by("order", "asc");
		$nav_items = $this->db->get("nav_item")->result();
		
		return $nav_items;
    }
    
    public function get_hierarchy($culture, $status = null)
    {
		$nav_items = $this->get_flat($culture, $status);
		
		$tree = array();
		$lookup = array();
		
		foreach($nav_items as $item)
		{
			$lookup[$item->nav_item_id] = $item;
			
			if(isset($lookup[$item->parent_id]))
			{
				$parent = $lookup[$item->parent_id];
				
				if(!isset($parent->children))
					$parent->children = array();
					
				array_push($parent->children, $item);
			}
			else
			{
				array_push($tree, $item);
			}
		}
		
		unset($lookup);
		
		return $tree;
    }
    
    public function get($culture, $parent_id = 0, $status = null)
    {
	    if($status)
	    	$this->db->where("status", $status);
	    
	    $this->db->select_max("revision", "latest_revision");
		$max_revision = $this->db->get("nav")->row()->latest_revision;

	    if($status)
	    	$this->db->where("status", $status);
		
		$this->db->where("revision", $max_revision);
		$nav = $this->db->get("nav")->row();
		
		if(!$nav) return array();
		
		$this->db->where("nav_id", $nav->nav_id);
		$this->db->where("culture", $culture);
		$this->db->where("parent_id", $parent_id);
		$this->db->order_by("order", "asc");
		$nav_items = $this->db->get("nav_item")->result();
		
		return $nav_items;
    }
    
    public function get_top_revision()
    {
	    // Get the latest revision.
	    $this->db->select_max("revision", "latest_revision");
	    $query = $this->db->get("nav");
	    	
	    $top_rev = $query->row()->latest_revision;
	    	
	    if(!$top_rev)
		    $top_rev = 1;
	    
	    return $top_rev;
    }
    
    public function get_status($revision = null)
    {
	    if($revision == null)
	    	$revision = $this->get_top_revision();
	    	
	    $this->db->where("revision", $revision);
	    return $this->db->get("nav")->row()->status;
    }
 
    public function add_item($nav_item)
    {
	    $this->db->flush_cache();
    }
    
    public function publish() {
	    
	    $this->db->flush_cache();
    }
    
    public function create_new_revision() {
	    
	    $this->db->flush_cache();
    }
    
    public function delete_top_revision() {
	    
	    $this->db->flush_cache();
    }
}