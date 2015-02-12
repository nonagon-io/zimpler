<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting_model extends CI_Model 
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
	    
	    // setting table.
	    
	    $this->dbforge->drop_table("setting");
	    $this->dbforge->add_field("setting_id		int				NOT NULL	AUTO_INCREMENT");
	    $this->dbforge->add_field("setting_key 		varchar(50)		NOT NULL");
	    $this->dbforge->add_field("setting_value 	varchar(255)	NOT NULL");
	    $this->dbforge->add_key("setting_id", TRUE);
		$this->dbforge->create_table("setting", TRUE);
    }
    
    public function is_any_entry()
    {
	    $this->db->flush_cache();
	    
	    return $this->db->count_all_results("setting") > 0;
    }
    
    public function get($setting_key)
    {
		$data = $this->db->get_where("setting", array("setting_key" => $setting_key))->row();
		
		if(!$data) return null;
		
		return $data->setting_value;
    }
    
    public function set($setting_key, $setting_value)
    {
		$data = $this->db->get_where("setting", array("setting_key" => $setting_key))->row();
		
		if(!$data)
		{
		    $setting["setting_key"] = $setting_key;
		    $setting["setting_value"] = $setting_value;
		    
		    $this->db->insert("setting", $setting);
		}
		else
		{
			$this->db->set("setting_value", $setting_value);
			$this->db->where("setting_key", $setting_key);
			$this->db->update("setting");
		}
    }
 }