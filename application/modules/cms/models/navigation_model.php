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
	    
	    $nav_id = 0;
	    $nav_item_id = 0;
	    
	    // nav table.
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
			
			$nav["revision"] = 1;
		    $nav["date_created"] = date('Y-m-d H:i:s', now());
		    $nav["last_modified"] = date('Y-m-d H:i:s', now());
		    $nav["date_publish"] = null;
		    $nav["status"] = "draft";
			
			$this->db->insert("nav", $nav);
			$nav_id = $this->db->insert_id();
			
			unset($nav);
		}
		
		// nav_item table.
	    if(!$this->db->table_exists("nav_item"))
	    {
			$this->dbforge->add_field("nav_item_id		int				NOT NULL	AUTO_INCREMENT");
			$this->dbforge->add_field("nav_id			int				NOT NULL");
			$this->dbforge->add_field("parent_id		int				NOT NULL	default 0");
			$this->dbforge->add_field("title			varchar(80)		NOT NULL");
			$this->dbforge->add_field("url				varchar(255)	NOT NULL");
			$this->dbforge->add_field("`order`			int				NOT NULL");
		    $this->dbforge->add_field("date_created 	datetime		NOT NULL");
		    $this->dbforge->add_field("last_modified 	datetime		NOT NULL");
			$this->dbforge->add_field("status			varchar(15)		NOT NULL");
			$this->dbforge->add_key("nav_item_id", TRUE);
			$this->dbforge->create_table("nav_item", TRUE);
			
			$nav_item["nav_id"] = $nav_id;
			$nav_item["title"] = "Home";
			$nav_item["url"] = "/";
			$nav_item["order"] = 0;
		    $nav_item["date_created"] = date('Y-m-d H:i:s', now());
		    $nav_item["last_modified"] = date('Y-m-d H:i:s', now());
		    $nav_item["status"] = "active";
			
			$this->db->insert("nav_item", $nav_item);
			$nav_item_id = $this->db->insert_id();
			
			unset($nav_item);
		}
		
		// nav_item_label table.
	    if(!$this->db->table_exists("nav_item_label"))
	    {
			$this->dbforge->add_field("nav_item_label_id	int				NOT NULL	AUTO_INCREMENT");
			$this->dbforge->add_field("nav_item_id			int				NOT NULL");
			$this->dbforge->add_field("culture				varchar(5)		NOT NULL 	default 'en-us'");
			$this->dbforge->add_field("text					varchar(80)		NOT NULL");
			$this->dbforge->add_key("nav_item_label_id", TRUE);
			$this->dbforge->create_table("nav_item_label", TRUE);

			$nav_item_label["nav_item_id"] = $nav_item_id;
			$nav_item_label["text"] = "Home";
			
			$this->db->insert("nav_item_label", $nav_item_label);
		}		
    }
    
    public function get_flat($culture, $status = null)
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
		
		$this->db->from("nav_item");
		$this->db->join("nav_item_label", "nav_item.nav_item_id = nav_item_label.nav_item_id");
		$this->db->where("nav_id", $nav->nav_id);
		$this->db->where("culture", $culture);
		$this->db->order_by("parent_id", "asc");
		$this->db->order_by("order", "asc");
		$nav_items = $this->db->get()->result();
		
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
	    
	    if(!$nav_item)
	    	throw new Exception("nav_item parameter cannot be null");

	    if(!array_key_exists("title", $nav_item))
	    	throw new Exception("title must be specified");
	    	
	    if(!array_key_exists("url", $nav_item))
	    	throw new Exception("url must be specified");

	    if(!array_key_exists("label", $nav_item))
	    	throw new Exception("label must be specified");
	    	
	    $nav_item_label = $nav_item["label"];
	    unset($nav_item["label"]);

	    if(!array_key_exists("culture", $nav_item_label))
	    	throw new Exception("label::culture must be specified");
	    	
	    if(!array_key_exists("text", $nav_item_label))
	    	throw new Exception("label::text must be specified");
	    	
	    $nav = $this->db->get_where("nav", array(
	    	"revision" => $this->get_top_revision(),
	    	"status" => "draft"
	    ))->row();
	    
	    if(!$nav)
	    {
	    	throw new Exception(
	    		"The top revision is not in the 'draft' status");
	    }

		$nav_item["nav_id"] = $nav->nav_id;
	    $nav_item["date_created"] = date('Y-m-d H:i:s', now());
	    $nav_item["last_modified"] = date('Y-m-d H:i:s', now());
	    $nav_item["status"] = "active";
	    
	    $this->db->insert("nav_item", $nav_item);
	    $nav_item["nav_item_id"] = $this->db->insert_id();
	    
	    $nav_item_label["nav_item_id"] = $nav_item["nav_item_id"];
	    $this->db->insert("nav_item_label", $nav_item_label);
	    $nav_item_label["nav_item_label_id"] = $this->db->insert_id();
	    
	    return $nav_item;
    }
    
    public function update_item($nav_item)
    {
	    $this->db->flush_cache();
	    
	    if(!$nav_item)
	    	throw new Exception("nav_item parameter cannot be null");

	    if(!array_key_exists("nav_item_id", $nav_item))
	    	throw new Exception("nav_item_id must be specified");

	    if(array_key_exists("label", $nav_item))
	    	throw new Exception("label must be specified");
	    	
	    if(!array_key_exists("culture", $nav_item_label))
	    	throw new Exception("label::culture must be specified");
	    	
	    if(!array_key_exists("text", $nav_item_label))
	    	throw new Exception("label::text must be specified");

	    $nav_item_label = $nav_item["label"];
	    unset($nav_item["label"]);
	    	
	    // Update title if specified.
	    if(array_key_exists("title", $nav_item))
	    	$this->db->set("title", $nav_item["title"]);

	    // Update url if specified.
	    if(array_key_exists("url", $nav_item))
	    	$this->db->set("url", $nav_item["url"]);
	    	
	    // Update order if specified.
	    if(array_key_exists("order", $nav_item))
	    	$this->db->set("order", $nav_item["order"]);
	    	
	    $nav_item["last_modified"] = date('Y-m-d H:i:s', now());
	    
	    $this->db->where("nav_item_id", $nav_item["nav_item_id"]);
	    $this->db->update("nav_item");
	    
	    $existing_label = $this->db->get_where(
	    	"nav_item_label", array(
	    		"nav_item_id" => $nav_item_label["nav_item_id"],
	    		"culture" => $nav_item_label["culture"]
	    	)
	    )->row();
	    
	    if($existing_label)
	    {
			$this->db->set("text", $nav_item_label["text"]);
			$this->db->where("nav_item_label_id", $existing_label->nav_item_label_id);
			$this->db->update("nav_item_label");
		}
		else
		{
		    $this->db->insert("nav_item_label", $nav_item_label);
		}
	    	
	    return $nav_item;
    }
    
    public function publish()
    {
	    $this->db->flush_cache();
	    
	    $nav = $this->db->get_where("nav", array(
	    	"revision" => $this->get_top_revision(),
	    	"status" => "draft"
	    ))->row();

	    if(!$nav)
	    {
	    	throw new Exception("The top revision is not in the 'draft' status");
	    }
	    
	    $this->db->set("status", "published");
	    $this->db->set("date_publish", date('Y-m-d H:i:s', now()));
	    $this->db->where("nav_id", $nav->nav_id);
	    $this->db->update("nav");
    }
    
    public function create_new_revision() 
    {
	    $this->db->flush_cache();
	    
	    $revision = $this->get_top_revision($content_key, $culture);
	    $nav = $this->db->get_where("nav", array(
	    	"revision" => $revision
	    ))->row();

	    if($nav != null && $nav->status == "draft")
	    {
	    	throw new Exception("The new revision is already created");
	    }
	    
	    unset($nav);
	    
	    $nav = array();
		$nav["revision"] = $revision + 1;
	    $nav["date_created"] = date('Y-m-d H:i:s', now());
	    $nav["last_modified"] = date('Y-m-d H:i:s', now());
	    $nav["date_publish"] = null;
	    $nav["status"] = "draft";
		
		$this->db->insert("nav", $nav);
		
		$nav["nav_id"] = $this->db->insert_id();
		
		// Duplicate all nav_items.
		$query = $this->db->get_where("nav_item", array("nav_id" => $nav->nav_id));
		foreach($query->result() as $nav_item)
		{
			$nav_item->nav_id = $nav["nav_id"];
		    $nav_item->date_created = date('Y-m-d H:i:s', now());
		    $nav_item->last_modified = date('Y-m-d H:i:s', now());

			$this->db-insert("nav_item", $nav_item);
		}
		
		return $nav;
    }
    
    public function delete_top_revision()
    {
	    $this->db->flush_cache();
	    
	    $revision = $this->get_top_revision($content_key, $culture);
	    $nav = $this->db->get_where("nav", array(
	    	"revision" => $revision,
	    	"status" => "draft"
	    ))->row();

	    if(!$nav) return;
	    {
	    	throw new Exception("The top revision is not in the 'draft' status");
	    }
	    
	    $this->db->where("nav_id", $nav->nav_id);
	    $this->db->delete("nav");
	    
	    $this->db->where("nav_id", $nav->nav_id);
	    $this->db->delete("nav_item");
    }
}