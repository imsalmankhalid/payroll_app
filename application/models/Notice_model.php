<?php

class Notice_model extends CI_Model{


    	function __consturct(){
    	   parent::__construct();    	
    	}
    public function GetNotice(){
        $sql = "SELECT * FROM `notice` ORDER BY `notice`.`date` DESC;";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result; 
        }
    public function Published_Notice($data){
        $this->db->insert('notice',$data);
    }
    public function GetNoticelimit(){
        $this->db->order_by('date', 'DESC');
		$query = $this->db->get('notice');
		$result =$query->result();
        return $result;        
    }

    public function Update_Notice($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('notice', $data);
    }

    public function Delete_Notice($id) {
        $this->db->where('id', $id);
        $this->db->delete('notice');
    }  
}
?>