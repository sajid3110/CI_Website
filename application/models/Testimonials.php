<?php

class Testimonials extends CI_Model
{

     public function get($data = array())
     {
        $res = [];
        $this->db->select();
        $this->db->from("testimonials");
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

        $query = $this->db->query("SELECT count(*) as total FROM `testimonials` where comment_by like '%" . $search . "%'");
         if($query){
             $res->total = $query->result();
         }
         $query = $this->db->query("SELECT testimonials.* FROM `testimonials` where testimonials.comment_by like '%" . $search . "%' 
                                    order by testimonial_id desc LIMIT " . $start . "," . $itemsPerPage);
         if($query){
             $res->data = $query->result();
         }
         return $res;
     }

     public function insert($data){
        $res = 0;
        $res = $this->db->insert('testimonials',$data);
        return $res;
     }

     public function update($id,$data){
        $res = 0;
        $this->db->where('testimonial_id', $id);
        $res = $this->db->update('testimonials', $data);
        return $res;
     }

     public function delete($id){
        $res = 0;
        $this->db->where('testimonial_id', $id);
        $res = $this->db->delete('testimonials');
        return $res;
     }

}

?>