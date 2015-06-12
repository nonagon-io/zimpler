<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page_model extends CI_Model 
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
	    
	    // page table.
	    if(!$this->db->table_exists('page'))
	    {
		    $this->dbforge->add_field('page_id			int				NOT NULL	AUTO_INCREMENT');
		    $this->dbforge->add_field('page_key 		varchar(150)	NOT NULL');
		    $this->dbforge->add_field('design_id		int 			NULL 		default null');
		    $this->dbforge->add_field('`group` 			varchar(80)		NULL 		default null');
		    $this->dbforge->add_field('description 		varchar(250)	NULL 		default null');
		    $this->dbforge->add_field('date_created 	datetime		NOT NULL');
		    $this->dbforge->add_field('last_modified 	datetime		NOT NULL');
		    $this->dbforge->add_field('status 			varchar(15)		NOT NULL');
		    $this->dbforge->add_key('page_id', TRUE);
			$this->dbforge->create_table('page', TRUE);
		}

	    // page_header table.
	    if(!$this->db->table_exists('page_header'))
	    {
		    $this->dbforge->add_field('page_header_id	int				NOT NULL	AUTO_INCREMENT');
		    $this->dbforge->add_field('page_id			int				NOT NULL');
		    $this->dbforge->add_field('culture			varchar(5)		NOT NULL');
		    $this->dbforge->add_field('title 			varchar(255)	NOT NULL');
		    $this->dbforge->add_key('page_header_id', TRUE);
			$this->dbforge->create_table('page_header', TRUE);
		}

	    // page_meta table.
	    if(!$this->db->table_exists('page_meta'))
	    {
		    $this->dbforge->add_field('page_meta_id		int				NOT NULL	AUTO_INCREMENT');
		    $this->dbforge->add_field('page_id			int				NOT NULL');
		    $this->dbforge->add_field('culture			varchar(5)		NOT NULL');
		    $this->dbforge->add_field('name 			varchar(30)		NOT NULL');
		    $this->dbforge->add_field('content 			varchar(255)	NOT NULL');
		    $this->dbforge->add_key('page_meta_id', TRUE);
			$this->dbforge->create_table('page_meta', TRUE);
		}

		// page_content table.
		if(!$this->db->table_exists('page_content'))
		{
		    $this->dbforge->add_field('page_content_id	int				NOT NULL	AUTO_INCREMENT');
		    $this->dbforge->add_field('page_id			int				NOT NULL');
		    $this->dbforge->add_field('content_id		int				NOT NULL');
		    $this->dbforge->add_field('css_class		varchar(30)		NULL 		default null');
		    $this->dbforge->add_field('container_key 	varchar(30)		NULL 		default null');
		    $this->dbforge->add_field('order			int				NOT NULL');
		    $this->dbforge->add_key('page_content_id', TRUE);
			$this->dbforge->create_table('page_content', TRUE);
		}
    }
}