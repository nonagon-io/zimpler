<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Content extends CI_Model 
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
	    
	    // content table.
	    
	    $this->dbforge->add_field("content_id		int				NOT NULL");
	    $this->dbforge->add_field("content_key 		varchar(30)		NOT NULL");
	    $this->dbforge->add_field("title 			varchar(150)	NOT NULL");
	    $this->dbforge->add_field("description 		varchar(250)	NULL");
	    $this->dbforge->add_field("content_type 	varchar(15)		NOT NULL");
	    $this->dbforge->add_field("date_created 	datetime		NOT NULL");
	    $this->dbforge->add_field("last_modified 	datetime		NOT NULL");
	    $this->dbforge->add_field("status		 	varchar(15)		NOT NULL");
	    $this->dbforge->add_key("content_id");
		$this->dbforge->create_table("content", TRUE);
		
		// content_label table.
		
		$this->dbforge->add_field("content_label_id	int				NOT NULL");
		$this->dbforge->add_field("content_id		int				NOT NULL");
		$this->dbforge->add_field("culture			varchar(5)		NOT NULL default 'en-us'");
		$this->dbforge->add_field("revision			int				NOT NULL");
		$this->dbforge->add_field("label			varchar(80)		NOT NULL");
	    $this->dbforge->add_field("date_created 	datetime		NOT NULL");
	    $this->dbforge->add_field("last_modified 	datetime		NOT NULL");
	    $this->dbforge->add_field("date_publish 	datetime		NULL");
		$this->dbforge->add_field("status			varchar(15)		NOT NULL");
		$this->dbforge->add_key("content_label_id");
		$this->dbforge->create_table("content_label", TRUE);
		
		// content_html table.
		
		$this->dbforge->add_field("content_html_id	int				NOT NULL");
		$this->dbforge->add_field("content_id		int				NOT NULL");
		$this->dbforge->add_field("culture			varchar(5)		NOT NULL default 'en-us'");
		$this->dbforge->add_field("revision			int				NOT NULL");
		$this->dbforge->add_field("title			varchar(80)		NOT NULL");
		$this->dbforge->add_field("html				varchar(50000)	NOT NULL");
	    $this->dbforge->add_field("date_created 	datetime		NOT NULL");
	    $this->dbforge->add_field("last_modified 	datetime		NOT NULL");
	    $this->dbforge->add_field("date_publish 	datetime		NULL");
		$this->dbforge->add_field("status			varchar(15)		NOT NULL");
		$this->dbforge->add_key("content_html_id");
		$this->dbforge->create_table("content_html", TRUE);

		// content_list table.
		
		$this->dbforge->add_field("content_list_id	int				NOT NULL");
		$this->dbforge->add_field("content_id		int				NOT NULL");
		$this->dbforge->add_field("culture			varchar(5)		NOT NULL default 'en-us'");
		$this->dbforge->add_field("revision			int				NOT NULL");
		$this->dbforge->add_field("title			varchar(80)		NOT NULL");
		$this->dbforge->add_field("headers			varchar(1000)	NOT NULL");
		$this->dbforge->add_field("max_items		int				NOT NULL");
	    $this->dbforge->add_field("date_created 	datetime		NOT NULL");
	    $this->dbforge->add_field("last_modified 	datetime		NOT NULL");
	    $this->dbforge->add_field("date_publish 	datetime		NULL");
		$this->dbforge->add_field("status			varchar(15)		NOT NULL");
		$this->dbforge->add_key("content_list_id");
		$this->dbforge->create_table("content_list", TRUE);
		
		// content_list_item table.
		
		$this->dbforge->add_field("content_list_item_id	int			NOT NULL");
		$this->dbforge->add_field("content_id		int				NOT NULL");
		$this->dbforge->add_field("culture			varchar(5)		NOT NULL");
		$this->dbforge->add_field("data				varchar(5000)	NOT NULL");
		$this->dbforge->add_field("order_no			int				NOT NULL default 0");
	    $this->dbforge->add_field("date_created 	datetime		NOT NULL");
	    $this->dbforge->add_field("last_modified 	datetime		NOT NULL");
	    $this->dbforge->add_field("date_publish 	datetime		NULL");
		$this->dbforge->add_field("status			varchar(15)		NOT NULL");
		$this->dbforge->add_key("content_list_item_id");
		$this->dbforge->create_table("content_list_item", TRUE);
    }
    
    public function get($key)
    {
	
    }
 
    public function add_content($content)
    {
	    if(!array_key_exists("title", $content))
	    	throw new Exception("title must be specified");

	    if(!array_key_exists("content_type", $content))
	    	throw new Exception("content_type must be specified");
	    	
	    $this->db->trans_start();
	    	
	    $content["date_created"] = now();
	    $content["last_modified"] = now();
	    $content["status"] = "inactive";
	    
	    $this->db->insert("content", $content);
	    $content_id = $this->db->insert_id();
	    
	    $content["content_id"] = $content_id;
	    	
	    switch($content["content_type"])
	    {
		    case "label": add_label_content($content); break;
		    case "html": add_html_content($content); break;
		    case "list": add_list_content($content); break;
		    default: throw new Exception("Unsupported content_type"); break;
	    }
	    
	    $this->db->trans_complete();
    }
    
    public function update_content($content)
    {
	    if(!array_key_exists("content_id", $content))
	    	throw new Exception("content_id must be specified");

	    if(!array_key_exists("title", $content))
	    	throw new Exception("title must be specified");
	    	
	    $content_id = $content["content_id"];
	    	
	    // Check if content exists.
		$query = $this->db->get_where("content", array("content_id" => $content_id));
		if($query->num_rows() == 0)
			throw new Exception("content with given content_id does not exists");
			
		$existing_content = $query->row();
		
		// Update content.
	    $this->db->trans_start();
	    	
	    switch($existing_content["content_type"])
	    {
		    case "label": update_label_content($content); break;
		    case "html": update_html_content($content); break;
		    case "list": update_list_content($content); break;
		    default: throw new Exception("Unsupported content_type"); break;
	    }
	    
	    $existing_content["last_modified"] = now();
	    $existing_content["title"] = $content["title"];
	    
	    if(!array_key_exists("description", $content))
		    $existing_content["description"] = $content["description"];
	    
		$this->db->where("content_id", $content_id);
		$this->db->update("content", $existing_content);
	    
	    $this->db->trans_complete();
    }
    
    private function add_label_content($content)
    {
	    if(!array_key_exists("content_label", $content))
	    	throw new Exception("content_label must be specified");

	    $content_label = $content["content_label"];
	    
	    if(!array_key_exists("label", $content_label))
	    	throw new Exception("content_label::label must be specified");

	    $content_label["content_id"] = $content["content_id";
	    $content_label["revision"] = 1;
	    $content_label["date_created"] = now();
	    $content_label["last_modified"] = now();
	    $content_label["date_publish"] = null;
	    $content_label["status"] = "inactive";
	    
	    $this->db->insert("content_label", $content_label);
    }
    
    private function update_label_content($content)
    {
	    if(!array_key_exists("content_label", $content))
	    	throw new Exception("content_label must be specified");
	    
	    $content_id = $content["content_id"];
	    $content_label = $content["content_label"];
	    
	    if(!array_key_exists("label", $content_label))
	    	throw new Exception("content_label::label must be specified");
	    	
	    if(!array_key_exists("culture", $content_label))
	    	throw new Exception("content_label::culture must be specified");
	    
	    // Get the latest content revision.
	    $this->db->select_max("revision", "latest_revision");
	    $query = $this->db->get_where("content_label", 
	    	array("content_id" => $content_id, "culture" => $culture));
	    	
	    if($query->row_num() == 0)
	    	throw new Exception("content_label with given content_id does not exists");
	    	
	    $latest_revision = $query->row()->latest_revision;
	    
	    $query = $this->db->get_where("content_label",
	    	array("content_id" => $content_id, "culture" => $culture, "revision" => $latest_revision));
	    	
	    $existing_content_label = $query->row();
	    
		// If the content_label with given content_id and culture already active, do not allow update.
		if($existing_content_label->status == "active")
			throw new Exception("content is already active, please create new revision");
			
		$existing_content_label["last_modified"] = now();
		$existing_content_label["label"] = $content_label["label"];
		
		$content_label_id = $existing_content_label["content_label_id"];
		
		$this->db->where("content_label_id", $content_label_id);
		$this->db->update("content_label", $existing_content_label);
    }
    
    private function add_html_content($content)
    {
	    if(!array_key_exists("content_html", $content))
	    	throw new Exception("content_html must be specified");

	    $content_html = $content["content_html"];

	    if(!array_key_exists("title", $content_html))
	    	throw new Exception("content_title::title must be specified");
	    
	    if(!array_key_exists("html", $content_html))
	    	throw new Exception("content_html::html must be specified");

	    $content_html["content_id"] = $content["content_id";
	    $content_html["revision"] = 1;
	    $content_html["date_created"] = now();
	    $content_html["last_modified"] = now();
	    $content_html["date_publish"] = null;
	    $content_html["status"] = "inactive";
	    
	    $this->db->insert("content_html", $content_html);
    }
    
    private function update_html_content($content)
    {
	    if(!array_key_exists("content_html", $content))
	    	throw new Exception("content_html must be specified");
	    
	    $content_id = $content["content_id"];
	    $content_html = $content["content_html"];
	    
	    if(!array_key_exists("html", $content_html))
	    	throw new Exception("content_html::html must be specified");
	    	
	    if(!array_key_exists("culture", $content_html))
	    	throw new Exception("content_html::culture must be specified");
	    
	    // Get the latest content revision.
	    $this->db->select_max("revision", "latest_revision");
	    $query = $this->db->get_where("content_html", 
	    	array("content_id" => $content_id, "culture" => $culture));
	    	
	    if($query->row_num() == 0)
	    	throw new Exception("content_html with given content_id does not exists");
	    	
	    $latest_revision = $query->row()->latest_revision;
	    
	    $query = $this->db->get_where("content_html",
	    	array("content_id" => $content_id, "culture" => $culture, "revision" => $latest_revision));
	    	
	    $existing_content_html = $query->row();
	    
		// If the content_html with given content_id and culture already active, do not allow update.
		if($existing_content_html->status == "active")
			throw new Exception("content is already active, please create new revision");
			
		$existing_content_html["last_modified"] = now();
		$existing_content_html["html"] = $content_html["html"];
		
		if(!array_key_exists("title", $content_html))
			$existing_content_html["title"] = $content_html["title"];
			
		$content_html_id = $existing_content_html["content_html_id"];
		
		$this->db->where("content_html_id", $content_html_id);
		$this->db->update("content_html", $existing_content_html);
    }
    
    private function add_list_content($content)
    {
	    if(!array_key_exists("content_list", $content))
	    	throw new Exception("content_list must be specified");

	    $content_list = $content["content_list"];
	    
	    if(!array_key_exists("title", $content_list))
	    	throw new Exception("content_list::title must be specified");
	    
	    if(!array_key_exists("headers", $content_list))
	    	throw new Exception("content_list::headers must be specified");

	    $content_list["content_id"] = $content["content_id";
	    $content_list["revision"] = 1;
	    $content_list["date_created"] = now();
	    $content_list["last_modified"] = now();
	    $content_list["date_publish"] = null;
	    $content_list["status"] = "inactive";
	    
	    $this->db->insert("content_list", $content_list);
	    $content_list_id = $this->db->insert_id();
	    
	    // Add all items.
	    if(array_key_exists("content_list_items", $content_list))
	    {
		    $content_list_items = $content_list["content_list_items"];
		    foreach($content_list_items as $content_list_item)
		    {
			    $content_list_item["content_id"] = $content["content_id"];
			    $content_list_item["content_list_id"] = $content_list_id;
			    $content_list["date_created"] = now();
			    $content_list["last_modified"] = now();
			    $content_list["date_publish"] = null;
			    $content_list["status"] = "inactive";
			    
			    $this->db->insert("content_list_item", $content_list_item);
		    }
	    }
    }
    
    private function update_list_content($content)
    {
	    if(!array_key_exists("content_list", $content))
	    	throw new Exception("content_list must be specified");
	    
	    $content_id = $content["content_id"];
	    $content_list = $content["content_list"];
	    	
	    if(!array_key_exists("culture", $content_list))
	    	throw new Exception("content_html::culture must be specified");
	    
	    // Get the latest content revision.
	    $this->db->select_max("revision", "latest_revision");
	    $query = $this->db->get_where("content_list", 
	    	array("content_id" => $content_id, "culture" => $culture));
	    	
	    if($query->row_num() == 0)
	    	throw new Exception("content_list with given content_id does not exists");
	    	
	    $latest_revision = $query->row()->latest_revision;
	    
	    $query = $this->db->get_where("content_list",
	    	array("content_id" => $content_id, "culture" => $culture, "revision" => $latest_revision));
	    	
	    $existing_content_list = $query->row();
	    
		// If the content_list with given content_id and culture already active, do not allow update.
		if($existing_content_list->status == "active")
			throw new Exception("content is already active, please create new revision");
			
		$existing_content_list["last_modified"] = now();
		
		if(!array_key_exists("title", $content_list))
			$existing_content_list["title"] = $content_list["title"];

		if(!array_key_exists("headers", $content_list))
			$existing_content_list["headers"] = $content_list["headers"];

		if(!array_key_exists("max_items", $content_list))
			$existing_content_list["max_items"] = $content_list["max_items"];
			
		$content_list_id = $existing_content_list["content_list_id"];
		
		$this->db->where("content_list_id", $content_list_id);
		$this->db->update("content_list", $existing_content_list);
    }
    
    public function add_list_item($content_list_item)
    {
	    if(!array_key_exists("content_id", $content_list_item))
	    	throw new Exception("content_id must be specified");

	    if(!array_key_exists("culture", $content_list_item))
	    	throw new Exception("culture must be specified");
	    	
	    $content_id = $content_list_item["content_id"];
	    $culture = $content_list_item["culture"];
	    
	    // Check if content exists.
	    $query = $this->db->get_where("content", array("content_id" => $content_id));
	    	
	    if($query->num_rows() == 0)
		    throw new Exception("content with given content_id does not exists");
		    
		// Check if content list with given culture exists.
		$query = $this->db->get_where("content_list", 
			array("content_id" => $content_id, "culture" => $culture));
			
		if($query->num_rows() == 0)
			throw new Exception("content_list with given culture does not exists");

	    $content_list_item["date_created"] = now();
	    $content_list_item["last_modified"] = now();
	    $content_list_item["date_publish"] = null;
	    $content_list_item["status"] = "inactive";

		$this->db->insert("content_list_item", $content_list_item);
    }
}