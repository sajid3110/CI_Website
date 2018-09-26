<?php

class Users extends CI_Model
{

     public function get($data = array())
     {
        $res = [];
        $this->db->select();
        $this->db->from("users");
        $this->db->where($data);
        $query = $this->db->get();
        if($query){
            $res = $query->result();
        }        
        return $res;
     }

     public function update_password($username,$password){
        $res = 0;
        $this->db->where('username', $username);
        $res = $this->db->update('users', array("password" => $password));
        return $res;
     }
}

?>