<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Siteinfo_model extends CI_Model 
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
	    
	    // setting table.
	    if(!$this->db->table_exists("site_info"))
	    {
		    $this->dbforge->add_field("site_info_id		int				NOT NULL	AUTO_INCREMENT");
		    $this->dbforge->add_field("site_info_key 	varchar(50)		NOT NULL");
		    $this->dbforge->add_field("site_info_value 	varchar(255)	NOT NULL");
		    $this->dbforge->add_field("culture			varchar(5)		NOT NULL");
		    $this->dbforge->add_key("site_info_id", TRUE);
			$this->dbforge->create_table("site_info", TRUE);
		}
    }
    
    public function is_any_entry()
    {
	    $this->db->flush_cache();
	    
	    return $this->db->count_all_results("site_info") > 0;
    }
    
    public function get($site_info_key, $culture = "en-us")
    {
		$data = $this->db->get_where("site_info", 
			array("site_info_key" => $site_info_key, "culture" => $culture))->row();
		
		if(!$data) return null;
		
		return $data->site_info_value;
    }
    
    public function set($site_info_key, $site_info_value, $culture = "en-us")
    {
    	if(!$culture)
    		$culture = "en-us";

		$data = $this->db->get_where("site_info", 
			array("site_info_key" => $site_info_key, "culture" => $culture))->row();
		
		if(!$data)
		{
		    $site_info["site_info_key"] = $site_info_key;
		    $site_info["site_info_value"] = $site_info_value;
		    $site_info["culture"] = $culture;
		    
		    $this->db->insert("site_info", $site_info);
		}
		else
		{
			$this->db->set("site_info_value", $site_info_value);
			$this->db->where("site_info_key", $site_info_key);
			$this->db->where("culture", $culture);
			$this->db->update("site_info");
		}
    }
 }