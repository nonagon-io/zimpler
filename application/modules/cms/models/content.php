<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Content extends CI_Model 
{
    public function __construct() 
    { 
        parent::__construct();
        
        $this->load->dbforge();
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
		$this->dbforge->create_table('content', TRUE);
		
		// content_label table.
		
		$this->dbforge->add_field("content_label_id	int				NOT NULL");
		$this->dbforge->add_field("content_id		int				NOT NULL");
		$this->dbforge->add_field("revision			int				NOT NULL");
		$this->dbforge->add_field("label			varchar(80)		NOT NULL");
		$this->dbforge->add_field("culture			varchar(5)		NOT NULL default 'en-us'");
	    $this->dbforge->add_field("date_created 	datetime		NOT NULL");
	    $this->dbforge->add_field("last_modified 	datetime		NOT NULL");
	    $this->dbforge->add_field("date_publish 	datetime		NULL");
		$this->dbforge->add_field("status			varchar(15)		NOT NULL");
		$this->dbforge->add_key("content_label_id");
		$this->dbforge->create_table('content_label', TRUE);
		
		// content_paragraph table.
		
		$this->dbforge->add_field("content_paragraph_id	int			NOT NULL");
		$this->dbforge->add_field("content_id		int				NOT NULL");
		$this->dbforge->add_field("revision			int				NOT NULL");
		$this->dbforge->add_field("title			varchar(80)		NOT NULL");
		$this->dbforge->add_field("paragraph		varchar(50000)	NOT NULL");
		$this->dbforge->add_field("culture			varchar(5)		NOT NULL default 'en-us'");
	    $this->dbforge->add_field("date_created 	datetime		NOT NULL");
	    $this->dbforge->add_field("last_modified 	datetime		NOT NULL");
	    $this->dbforge->add_field("date_publish 	datetime		NULL");
		$this->dbforge->add_field("status			varchar(15)		NOT NULL");
		$this->dbforge->add_key("content_paragraph_id");
		$this->dbforge->create_table('content_paragraph', TRUE);
		
		// content_list table.
		
		$this->dbforge->add_field("content_list_id	int				NOT NULL");
		$this->dbforge->add_field("content_id		int				NOT NULL");
		$this->dbforge->add_field("revision			int				NOT NULL");
		$this->dbforge->add_field("max_items		int				NOT NULL");
		$this->dbforge->add_field("title			varchar(80)		NOT NULL");
		$this->dbforge->add_field("culture			varchar(5)		NOT NULL default 'en-us'");
	    $this->dbforge->add_field("date_created 	datetime		NOT NULL");
	    $this->dbforge->add_field("last_modified 	datetime		NOT NULL");
	    $this->dbforge->add_field("date_publish 	datetime		NULL");
		$this->dbforge->add_field("status			varchar(15)		NOT NULL");
		$this->dbforge->add_key("content_list_id");
		$this->dbforge->create_table('content_list', TRUE);
		
		// content_list_item table.
		
		$this->dbforge->add_field("content_list_item_id	int			NOT NULL");
		$this->dbforge->add_field("content_id		int				NOT NULL");
		$this->dbforge->add_field("content_list_id	int				NOT NULL");
		$this->dbforge->add_field("data				varchar(5000)	NOT NULL");
		$this->dbforge->add_field("order_no			int				NOT NULL default 0");
		$this->dbforge->add_key("content_list_item_id");
		$this->dbforge->create_table('content_list_item', TRUE);
    }
    
    public function get($key)
    {
	    
    }
}