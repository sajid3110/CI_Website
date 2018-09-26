<?php

class Rentals extends CI_Model
{

     public function get($data = array())
     {
        $res = [];
        $this->db->select();
        $this->db->from("rentals");
        if(count($data) > 0){
            $this->db->where($data);
        }
        $query = $this->db->get();
        if($query){
            $res = $query->result();
        }        
        return $res;
     }

     public function get_with_limit($data)
     {
        $start = ($data->pgno - 1) * $data->itemsPerPage;
        $itemsPerPage = $data->itemsPerPage;
        $search = $data->search;

        $res = new stdClass();

        $query = $this->db->query("SELECT count(*) as total FROM `rentals` where name like '%" . $search . "%'");
         if($query){
             $res->total = $query->result();
         }
         $query = $this->db->query("SELECT rentals.* FROM `rentals` where rentals.name like '%" . $search . "%' 
                                    order by rental_id desc LIMIT " . $start . "," . $itemsPerPage);
         if($query){
             $res->data = $query->result();
         }
         return $res;
     }

     public function insert($data){
        $res = 0;
        $res = $this->db->insert('rentals',$data);
        return $res;
     }

     public function update($id,$data){
        $res = 0;
        $this->db->where('rental_id', $id);
        $res = $this->db->update('rentals', $data);
        return $res;
     }

     public function delete($id){
        $res = 0;
        $this->db->where('rental_id', $id);
        $res = $this->db->delete('rentals');
        return $res;
     }

}

?>