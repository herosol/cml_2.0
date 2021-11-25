<?php 
 
 class Pages_model extends CI_Model
 {
 	
 	function __construct()
 	{
 		parent::__construct();
 		$this->load->database();
 		$this->table_name="sitecontent";
 	}
 	function savePageContent($vals,$page_slug=""){
 		$this->db->set($vals);
 		if($page_slug != ""){
 			//die("here");
 			$this->db->where("ckey",$page_slug);
 			$this->db->update($this->table_name);
 			return $page_slug;
 		}	 		
 		else{
 			$this->db->insert($this->table_name);
 			return $this->db->insert_id();
 		}
 	}
 	function saveMetaContent($vals,$page_slug=""){
 		$this->db->set($vals);
 		if($page_slug != ""){
 			//die("here");
 			$this->db->where("slug",$page_slug);
 			$this->db->update('meta_info');
 			return $page_slug;
 		}	 		
 		else{
 			$this->db->insert('meta_info');
 			return $this->db->insert_id();
 		}
 	}
 	function getPageContent($page_slug=""){
 		if($page_slug != ""){
 			$this->db->where("ckey",$page_slug);
 			return $this->db->get($this->table_name)->row();
 		}
 		else{
 			 return $this->db->get($this->table_name)->result();
 		}
 	}
 	 function getMetaContent($page_slug=""){
 		if($page_slug != ""){
 			$this->db->where("slug",$page_slug);
 			return $this->db->get('meta_info')->row();
 		}
 		else{
 			 return $this->db->get('meta_info')->result();
 		}
 	}
 	function deletePage($page_slug=""){
 		$this->where("ckey",$page_slug);
 		$this->db->delete($this->table_name);
 		return $page_slug;	
 	}
 }



?>