<?php

class Albums extends CI_Model
{

     public function get($data = array())
     {
        $res = [];
        $this->db->select("album.*, category.name as category_name");
        $this->db->from("album");
        $this->db->join("category", "album.category_id = category.category_id");
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

        $query = $this->db->query("SELECT count(*) as total FROM `album` where name like '%" . $search . "%'");
         if($query){
             $res->total = $query->result();
         }
         $query = $this->db->query("SELECT album.*, category.name as category_name FROM `album` inner join category on
                                    album.category_id = category.category_id where album.name like '%" . $search . "%' 
                                    order by album_id desc LIMIT " . $start . "," . $itemsPerPage);
         if($query){
             $res->data = $query->result();
         }
         return $res;
     }

     public function insert($data){
        $res = 0;
        $res = $this->db->insert('album',$data);
        return $res;
     }

     public function update($id,$data){
        $res = 0;
        $this->db->where('album_id', $id);
        $res = $this->db->update('album', $data);
        return $res;
     }

     public function delete($id){
        $res = 0;
        $this->db->where('album_id', $id);
        $res = $this->db->delete('album');
        return $res;
     }

     public function get_album_data($id)
     {
        $res = [];
        $this->db->select("picture.*");
        $this->db->from("picture");
        $this->db->join("album_picture", "picture.picture_id = album_picture.picture_id");
        $this->db->where("album_id", $id);
        $query = $this->db->get();
        if($query){
            $data = $query->result();
        } 
        $res["pictures"] = $data;  
        
        $this->db->select("master_pic");
        $this->db->from("album");
        $this->db->where("album_id", $id);
        $query = $this->db->get();
        if($query){
            $data = $query->result();
        }
        
        foreach($res['pictures'] as &$pic){
            if($pic->picture_id == $data[0]->master_pic){
                $pic->master_pic = true;
            } else {
                $pic->master_pic = false;
            }
        }        

        $this->db->select("video.*");
        $this->db->from("video");
        $this->db->join("album_video", "video.video_id = album_video.video_id");
        $this->db->where("album_id", $id);
        $query = $this->db->get();
        if($query){
            $data = $query->result();
        }
        $res["videos"] = $data;

        return $res;
     }

     public function delete_album_data($album_id, $id, $isPic = true){
        $res = 0;
        $table = ($isPic) ? 'album_picture' : 'album_video';
        $id_col = ($isPic) ? 'picture_id' : 'video_id';

        $this->db->select("master_pic");
        $this->db->from("album");
        $this->db->where("album_id", $album_id);
        $query = $this->db->get();
        if($query){
            $data = $query->result();
        }
        if($data[0]->master_pic == $id){
            $this->update($album_id, array("master_pic" => null));
        }

        $this->db->where(array('album_id' => $album_id, $id_col => $id));
        $res = $this->db->delete($table);
        return $res;
     }

     public function get_picalbum_page_data($id){
        $res = new stdClass();
        $this->db->select('show_album');
        $this->db->from('category');
        $this->db->where('category_id', $id);

        $query = $this->db->get();
        if($query){
            $a = $query->result();
        }

        if($a[0]->show_album == "1"){
            $this->db->select("album.*, picture.path, category.name as category_name");
            $this->db->from("album");
            $this->db->join("category", "album.category_id = category.category_id");
            $this->db->join("picture", "picture.picture_id = album.master_pic");
            $this->db->where("category.category_id", $id);
            
            $query = $this->db->get();
            if($query){
                $res->data = $query->result();
            }
        } else {
            $this->db->select('*');
            $this->db->from("picture");
            $this->db->join("category", "picture.category_id = category.category_id");
            $this->db->where("category.category_id", $id);

            $query = $this->db->get();
            if($query){
                $res->data = $query->result();
            }
        }
          
        $this->db->select("name,show_album");
        $this->db->from("category");
        $this->db->where("category_id", $id);  
        $query = $this->db->get();
        if($query){
            $d = $query->result();
            $res->category = $d[0]->name;
            $res->show_album = $d[0]->show_album;
        }     
        return $res;
     }

     public function get_videoalbum_page_data($id){
        $res = new stdClass();
        $this->db->select("album.*, picture.path, category.name as category_name");
        $this->db->from("album");
        $this->db->join("category", "album.category_id = category.category_id","left outer");
        $this->db->join("picture", "picture.picture_id = album.master_pic", "left outer");
        $this->db->join("album_video", "album.album_id = album_video.album_id");
        $this->db->where("category.category_id", $id);
        
        $query = $this->db->get();
        if($query){
            $res->data = $query->result();
        }  
        $this->db->select("name,show_album");
        $this->db->from("category");
        $this->db->where("category_id", $id);  
        $query = $this->db->get();
        if($query){
            $d = $query->result();
            $res->category = $d[0]->name;
            $res->show_album = $d[0]->show_album;
        }     
        return $res;
     }

     public function get_picdetail_page_data($id){
        $res = [];
        $this->db->select("picture.*, p.path as master_pic, album.name as album_name, album.comment as album_comment");
        $this->db->from("album");
        $this->db->join("album_picture", "album.album_id = album_picture.album_id");
        $this->db->join("picture", "picture.picture_id = album_picture.picture_id");
        $this->db->join("picture p", "p.picture_id = album.master_pic");
        $this->db->where("album.album_id", $id);
        
        $query = $this->db->get();
        if($query){
            $res = $query->result();
        }        
        return $res;
     }

     public function get_videodetail_page_data($id){
        $res = [];
        $this->db->select("video.*, p.path as master_pic, album.name as album_name, album.comment as album_comment, category.name as category");
        $this->db->from("album");
        $this->db->join("album_video", "album.album_id = album_video.album_id");
        $this->db->join("video", "video.video_id = album_video.video_id");
        $this->db->join("picture p", "p.picture_id = album.master_pic");
        $this->db->join("category", "category.category_id = album.category_id");
        $this->db->where("album.album_id", $id);
        
        $query = $this->db->get();
        if($query){
            $res = $query->result();
        }        
        return $res;
     }
}

?>