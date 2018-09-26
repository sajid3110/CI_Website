<?php

class Pictures extends CI_Model
{

     public function get($data = array())
     {
        $res = [];
        $this->db->select("picture.*, category.name as category_name");
        $this->db->from("picture");
        $this->db->join("category", "picture.category_id = category.category_id");
        if(count($data) > 0){
            $this->db->where($data);
        }
        $query = $this->db->get();
        if($query){
            $res = $query->result();
        }        
        return $res;
     }

     public function get_album_picture($data = array())
     {
        $res = [];
        $this->db->select("*");
        $this->db->from("album_picture");
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

        $query = $this->db->query("SELECT count(*) as total FROM `picture` where name like '%" . $search . "%'");
         if($query){
             $res->total = $query->result();
         }
         $query = $this->db->query("SELECT picture.*, category.name as category_name FROM `picture` inner join category on
                                    picture.category_id = category.category_id where picture.name like '%" . $search . "%' 
                                    order by picture_id desc LIMIT " . $start . "," . $itemsPerPage);
         if($query){
             $res->data = $query->result();
         }
         return $res;
     }

     public function insert($data){
        $res = 0;
        $res = $this->db->insert('picture',$data);
        return $res;
     }

     public function insert_into_album($pic_id, $album_id){
        $res = 0;
        $res = $this->db->insert('album_picture',array("picture_id" => $pic_id, "album_id" => $album_id));
        return $res;
     }

     public function update($id,$data){
        $res = 0;
        $this->db->where('picture_id', $id);
        $res = $this->db->update('picture', $data);
        return $res;
     }

     public function delete($id){
        $res = 0;
        $this->db->where('picture_id', $id);
        $res = $this->db->delete('picture');
        return $res;
     }

     public function get_album($id)
     {
        $res = [];
        $this->db->select("album.*");
        $this->db->from("album");
        $this->db->join("album_picture", "album.album_id = album_picture.album_id ");
        $this->db->where("album_picture.picture_id", $id);
        $query = $this->db->get();
        if($query){
            $res = $query->result();
        }        
        return $res;
     }

     public function delete_album_picture($data){
        $res = 0;
        $this->db->where($data);
        $res = $this->db->delete('album_picture');
        return $res;
     }

}

?>