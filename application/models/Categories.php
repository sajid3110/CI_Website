<?php

class Categories extends CI_Model
{

     public function get($data = array())
     {
        $res = [];
        $this->db->select();
        $this->db->from("category");
        if(count($data) > 0){
            $this->db->where($data);
        }
        $this->db->where_not_in("category_id", array("1"));
        $query = $this->db->get();
        if($query){
            $res = $query->result();
        }        
        return $res;
     }

     public function get_pic_page_data()
     {
        $res = [];
        $this->db->select("category.*, p.path");
        $this->db->from("category");
        $this->db->join("picture", "picture.category_id = category.category_id", "right outer");
        $this->db->join("picture p", "p.picture_id = category.thumbnail", "left outer");
        $this->db->where("category.category_id !=", "1");
        $this->db->group_by("category.category_id");
        $query = $this->db->get();
        if($query){
            $res = $query->result();
        }        
        return $res;
     }

     public function get_video_page_data()
     {
        $res = [];
        $this->db->select("category.*, p.path");
        $this->db->from("category");
        $this->db->join("video", "video.category_id = category.category_id", "right outer");
        $this->db->join("picture p", "p.picture_id = category.thumbnail", "left outer");
        $this->db->where("category.category_id !=", "1");
        $this->db->group_by("category.category_id");
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

        $query = $this->db->query("SELECT count(*) as total FROM `category` where category_id != 1 and name like '%" . $search . "%'");
         if($query){
             $res->total = $query->result();
         }
         $query = $this->db->query("SELECT * FROM `category` where category_id != 1 and name like '%" . $search . "%' order by category_id desc LIMIT " . $start . "," . $itemsPerPage);
         if($query){
             $res->data = $query->result();
         }
         return $res;
     }

     public function insert($data){
        $res = 0;
        $res = $this->db->insert('category',$data);
        return $res;
     }

     public function update($id,$data){
        $res = 0;
        $this->db->where('category_id', $id);
        $res = $this->db->update('category', $data);
        return $res;
     }

     public function delete($id){
        $res = 0;        
        if($id != 1){
            $this->db->where("category_id", $id);
            $this->db->update("picture", array("category_id" => 1));

            $this->db->where("category_id", $id);
            $this->db->update("video", array("category_id" => 1));

            $this->db->where("category_id", $id);
            $this->db->update("album", array("category_id" => 1));

            $this->db->where('category_id', $id);
            $res = $this->db->delete('category');
        }
        return $res;
     }

}

?>