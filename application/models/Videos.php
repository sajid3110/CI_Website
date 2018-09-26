<?php

class Videos extends CI_Model
{

     public function get($data = array())
     {
        $res = [];
        $this->db->select("video.*, category.name as category_name");
        $this->db->from("video");
        $this->db->join("category", "video.category_id = category.category_id");
        if(count($data) > 0){
            $this->db->where($data);
        }
        $query = $this->db->get();
        if($query){
            $res = $query->result();
        }        
        return $res;
     }

     public function get_album_video($data = array())
     {
        $res = [];
        $this->db->select("*");
        $this->db->from("album_video");
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

        $query = $this->db->query("SELECT count(*) as total FROM `video` where name like '%" . $search . "%'");
         if($query){
             $res->total = $query->result();
         }
         $query = $this->db->query("SELECT video.*, category.name as category_name FROM `video` inner join category on
                                    video.category_id = category.category_id where video.name like '%" . $search . "%' 
                                    order by video_id desc LIMIT " . $start . "," . $itemsPerPage);
         if($query){
             $res->data = $query->result();
         }
         return $res;
     }

     public function insert($data){
        $res = 0;
        $res = $this->db->insert('video',$data);
        return $res;
     }

     public function insert_into_album($vid_id, $album_id){
        $res = 0;
        $res = $this->db->insert('album_video',array("video_id" => $vid_id, "album_id" => $album_id));
        return $res;
     }

     public function update($id,$data){
        $res = 0;
        $this->db->where('video_id', $id);
        $res = $this->db->update('video', $data);
        return $res;
     }

     public function delete($id){
        $res = 0;
        $this->db->where('video_id', $id);
        $res = $this->db->delete('video');
        return $res;
     }

     public function get_album($id)
     {
        $res = [];
        $this->db->select("album.*");
        $this->db->from("album");
        $this->db->join("album_video", "album.album_id = album_video.album_id ");
        $this->db->where("album_video.video_id", $id);
        $query = $this->db->get();
        if($query){
            $res = $query->result();
        }        
        return $res;
     }

     public function delete_album_video($data){
        $res = 0;
        $this->db->where($data);
        $res = $this->db->delete('album_video');
        return $res;
     }

}

?>