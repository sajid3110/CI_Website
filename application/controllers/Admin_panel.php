<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_panel extends CI_Controller {
    public function __construct()
    {
            parent::__construct();
            $this->load->helper('url');
            $this->load->helper('cookie');
            $this->load->library('session');
            if($this->router->class == "admin_panel" 
                && $this->router->method != "login_page" 
                && $this->router->method != "login" 
                && $this->router->method != "logout"
                && $this->router->method != "index"){
                if(!$this->session->userdata('username')){
                    $resp = new stdClass();
                    $resp->loggedIn = false;
                    echo json_encode($resp);
                    die;
                }
            }
            
    }
    
    /* PAGE Render */
	public function index(){
		$this->load->helper('url');
		$this->load->view('admin_panel/index.html');
    }

    public function homepage(){
		$this->load->view('admin_panel/homepage.html');
	}
    
    public function categories_page(){
        $this->load->view('admin_panel/categoriesGrid.html');
    }

    public function pictures_page(){
        $this->load->view('admin_panel/picturesGrid.html');
    }

    public function videos_page(){
        $this->load->view('admin_panel/videosGrid.html');
    }

    public function rentals_page(){
        $this->load->view('admin_panel/rentalsGrid.html');
    }

    public function update_password_page(){
        $this->load->view('admin_panel/updatePassword.html');
    }

    public function albums_page(){
        $this->load->view('admin_panel/albumsGrid.html');
    }
    
    public function login_page(){
        $this->load->view('admin_panel/login_page.html');
    }

    public function testimonials_page(){
        $this->load->view('admin_panel/testimonialsGrid.html');
    }

    /* Login and Logout */

    public function isLoggedIn(){
        $resp = new stdClass();
        if(!$this->session->userdata('username')){
            $resp->loggedIn = false;
        } else {
            $resp->loggedIn = true;
        }
        echo json_encode($resp);
    }

    public function login(){
        $this->load->model('users');
        $data = json_decode($this->input->post('data'));
        $username = $data->username;
        $password = $data->password;
        $resp = new stdClass();
        $user = $this->users->get(array("username" => $username, "password" => md5($password)));
        if(!empty($user)){
            $cookie = array(
                'name'   => 'username',
                'value'  => $user[0]->username,
                'expire' => time()+86500,
                'domain' => base_url(),
                'path'   => '/',
                'prefix' => '',
                );
         
            // set_cookie($cookie);
            $this->session->set_userdata(array("username" => $user[0]->username));            
            $resp->success = true;
        } else {
            $resp->success = false;
        }
        echo json_encode($resp);
    }

    public function update_password(){
        $this->load->model('users');
        $resp = new stdClass();
        $data = json_decode($this->input->post('data'));

        if(empty($this->users->get(array('username' => $this->session->userdata('username'), 'password' => md5($data->oldPassword))))){
            $resp->error = "Old Password Mismatch";
            $resp->success = false;
        }
        if(!property_exists($resp, 'error')){
            $res = $this->users->update_password($this->session->userdata('username'), md5($data->newPassword));
            $resp->data = $res;
            $resp->success = ($res > 0) ? true : false;
            if($res == 0){
                $resp->error = "Update Error";
            }
        }
        echo json_encode($resp);        
    }

    public function logout(){
        $cookie = array(
            'name'   => 'username',
            'value'  => '',
            'expire' => '0',
            'domain' => base_url(),
            'prefix' => ''
            );
         
        delete_cookie($cookie);
        $this->session->unset_userdata('username');
        $resp = new stdClass();
        $resp->loggedIn = false;
        echo json_encode($resp);
        // redirect('admin_panel/login_page');
    }

    /* CRUD operations */

    //Categories
    public function get_categories(){
        $this->load->model('categories');
        $resp = new stdClass();
        $data = json_decode($this->input->get('data'));

        if($data == null){
            $resp->data = $this->categories->get();
            $resp->total = count($resp->data);
            $resp->success = true;
        } else {
            $res = $this->categories->get_with_limit($data);
            $resp->data = $res->data;
            $resp->total = $res->total[0]->total;
            $resp->success = true;

        }        
        echo json_encode($resp);
    }

	public function insert_categories(){
        $this->load->model('categories');
        $resp = new stdClass();

        $data = json_decode($this->input->post('data'));
        if(count($this->categories->get(array('name' => $data->categoryName)))){
            $resp->error = "Category already exists";
            $resp->success = false;
        }

        if(!property_exists($resp, 'error')){
            $res = $this->categories->insert(array('name' => $data->categoryName));            
            $resp->data = $res;
            $resp->success = ($res > 0) ? true : false;
            if($res == 0){
                $resp->error = "Insertion Error";
            }
        }        
        echo json_encode($resp);        
    }

    public function update_categories(){
        $this->load->model('categories');
        $resp = new stdClass();
        $data = json_decode($this->input->post('data'));
        $catData = $this->categories->get(array('name' => $data->name));
        if(count($catData) && $catData[0]->category_id != $data->category_id){
            $resp->error = "Category already exists";
            $resp->success = false;
        }
        if(!property_exists($resp, 'error')){
            $res = $this->categories->update($data->category_id, array("name" => $data->name, "show_album" => $data->show_album));
            $resp->data = $res;
            $resp->success = ($res > 0) ? true : false;
            if($res == 0){
                $resp->error = "Update Error";
            }
        }
        echo json_encode($resp);        
    }

    public function delete_categories(){
        $this->load->model('categories');
        $data = json_decode($this->input->post('data'));
        $res = $this->categories->delete($data->category_id);
        $resp = new stdClass();
		$resp->data = $res;
        $resp->success = ($res > 0) ? true : false;
        echo json_encode($resp);        
    }

    public function set_category_pic(){
        $this->load->model('categories');
        $resp = new stdClass();
        $data = json_decode($this->input->post('data'));

        $res = $this->categories->update($data->category_id, array("thumbnail" => $data->picture_id));
        $resp->data = $res;
        $resp->success = ($res > 0) ? true : false;
        if($res == 0){
            $resp->error = "Update Error";
        }
        echo json_encode($resp);
    }

    //Pictures
    public function get_pictures(){
        $this->load->model('pictures');
        $resp = new stdClass();
        $data = json_decode($this->input->get('data'));

        if($data == null){
            $resp->data = $this->pictures->get();
            $resp->total = count($resp->data);
            $resp->success = true;
        } else {
            $res = $this->pictures->get_with_limit($data);
            $resp->data = $res->data;
            $resp->total = $res->total[0]->total;
            $resp->success = true;

        }        
        echo json_encode($resp);
    }

	public function insert_pictures(){
        $this->load->model('pictures');
        $resp = new stdClass();
        $data = json_decode($this->input->post('data'));

        $target_dir = "Media" . DIRECTORY_SEPARATOR . "Pictures" . DIRECTORY_SEPARATOR;
        $path = $this->upload($target_dir, $_FILES, $resp);

            if(!property_exists($resp, 'error')){
                $arr = array(
                    "name" => basename($_FILES["file"]["name"]),
                    "path" => $path,
                    "size" => $_FILES["file"]["size"],
                    "comment" => $data->pictureComment,
                    "category_id" => property_exists($data, 'pictureCategory') ? $data->pictureCategory : 1,
                );
                $res = $this->pictures->insert($arr);            
                $resp->data = $res;
                $resp->success = ($res > 0) ? true : false;
                if($res == 0){
                    $resp->error = "Insertion Error";
                }
            }
        echo json_encode($resp);        
    }

    public function update_pictures(){
        $this->load->model('pictures');
        $resp = new stdClass();
        $data = json_decode($this->input->post('data'));
        $category_id = ($data->category_id == null) ? 1 : $data->category_id;
        $res = $this->pictures->update($data->picture_id, array("name" => $data->name, "comment" => $data->comment, "category_id" => $category_id));
        $resp->data = $res;
        $resp->success = ($res > 0) ? true : false;
        if($res == 0){
            $resp->error = "Update Error";
        }
            
        echo json_encode($resp);        
    }

    public function delete_pictures(){
        $this->load->model('pictures');
        $data = json_decode($this->input->post('data'));

        $this->pictures->delete_album_picture(array("picture_id" => $data->picture_id));
        $res = $this->pictures->delete($data->picture_id);
        $resp = new stdClass();
		$resp->data = $res;
        $resp->success = ($res > 0) ? true : false;
        echo json_encode($resp);        
    }

    //Album Picture
    public function get_album_picture(){
        $data = json_decode($this->input->get('data'));
        $resp = new stdClass();
        $this->load->model("pictures");
        $resp->data = $this->pictures->get_album($data->picture_id);
        $resp->success = true;
        echo json_encode($resp);
    }

    public function insert_album_picture(){
        $data = json_decode($this->input->get('data'));
        $resp = new stdClass();
        $this->load->model("pictures");
        if(count($this->pictures->get_album_picture(array("picture_id" => $data->picture_id, "album_id" => $data->album_id)))){
            $resp->error = "Already added to the Album";
            $resp->success = false;
        }
        
        if(!property_exists($resp, 'error')){
            $res = $this->pictures->insert_into_album($data->picture_id, $data->album_id);
            $resp->data = $res;
            $resp->success = ($res > 0) ? true : false;
            if($res == 0){
                $resp->error = "Insertion Error";
            }
        }
        echo json_encode($resp);
    }

    //Videos
    public function get_videos(){
        $this->load->model('videos');
        $resp = new stdClass();
        $data = json_decode($this->input->get('data'));

        if($data == null){
            $resp->data = $this->videos->get();
            $resp->total = count($resp->data);
            $resp->success = true;
        } else {
            $res = $this->videos->get_with_limit($data);
            $resp->data = $res->data;
            $resp->total = $res->total[0]->total;
            $resp->success = true;

        }        
        echo json_encode($resp);
    }

	public function insert_videos(){
        $this->load->model('videos');
        $resp = new stdClass();
        $data = json_decode($this->input->post('data'));

        $target_dir = "Media" . DIRECTORY_SEPARATOR . "VideoThumbnails" . DIRECTORY_SEPARATOR;
        $path = $this->upload($target_dir, $_FILES, $resp);

        if(!property_exists($resp, 'error')){
            $arr = array(
                "name" => $data->videoName,
                "link" => $data->videoLink,
                "comment" => $data->videoComment,
                "thumbnail" => $path,
                "category_id" => property_exists($data, 'videoCategory') ? $data->videoCategory : 1,
            );
            $res = $this->videos->insert($arr);            
            $resp->data = $res;
            $resp->success = ($res > 0) ? true : false;
            if($res == 0){
                $resp->error = "Insertion Error";
            }
        }

        echo json_encode($resp);        
    }

    public function update_videos(){
        $this->load->model('videos');
        $resp = new stdClass();
        $data = json_decode($this->input->post('data'));
        $category_id = ($data->category_id == null) ? 1 : $data->category_id;
        $res = $this->videos->update($data->video_id, array("name" => $data->name, "link" => $data->link, "comment" => $data->comment, "category_id" => $category_id));
        $resp->data = $res;
        $resp->success = ($res > 0) ? true : false;
        if($res == 0){
            $resp->error = "Update Error";
        }
            
        echo json_encode($resp);        
    }

    public function delete_videos(){
        $this->load->model('videos');
        $data = json_decode($this->input->post('data'));

        $this->videos->delete_album_video(array("video_id" => $data->video_id));
        $res = $this->videos->delete($data->video_id);
        $resp = new stdClass();
		$resp->data = $res;
        $resp->success = ($res > 0) ? true : false;
        echo json_encode($resp);        
    }

    //Album Video
    public function get_album_video(){
        $data = json_decode($this->input->get('data'));
        $resp = new stdClass();
        $this->load->model("videos");
        $resp->data = $this->videos->get_album($data->video_id);
        $resp->success = true;
        echo json_encode($resp);
    }

    public function insert_album_video(){
        $data = json_decode($this->input->get('data'));
        $resp = new stdClass();
        $this->load->model("videos");
        if(count($this->videos->get_album_video(array("video_id" => $data->video_id, "album_id" => $data->album_id)))){
            $resp->error = "Already added to the Album";
            $resp->success = false;
        }
        
        if(!property_exists($resp, 'error')){
            $res = $this->videos->insert_into_album($data->video_id, $data->album_id);
            $resp->data = $res;
            $resp->success = ($res > 0) ? true : false;
            if($res == 0){
                $resp->error = "Insertion Error";
            }
        }
        echo json_encode($resp);
    }

    //Album
    public function get_albums(){
        $this->load->model('albums');
        $resp = new stdClass();
        $data = json_decode($this->input->get('data'));

        if($data == null){
            $resp->data = $this->albums->get();
            $resp->total = count($resp->data);
            $resp->success = true;
        } else {
            $res = $this->albums->get_with_limit($data);
            $resp->data = $res->data;
            $resp->total = $res->total[0]->total;
            $resp->success = true;
        }        
        echo json_encode($resp);
    }

    public function insert_albums(){
        $this->load->model('albums');
        $this->load->model('pictures');
        $resp = new stdClass();
        $data = json_decode($this->input->post('data'));  
        $picArr = [];
        
        $target_dir = "Media" . DIRECTORY_SEPARATOR . "Pictures" . DIRECTORY_SEPARATOR;
        for($i = 0; $i < count($_FILES["file"]["name"]); $i++){
            
            $File["file"]["name"] = $_FILES["file"]["name"][$i];
            $File["file"]["tmp_name"] = $_FILES["file"]["tmp_name"][$i];
            $File["file"]["size"] = $_FILES["file"]["size"][$i];

            $path = $this->upload($target_dir, $File, $resp);

            $arr = array(
                "name" => basename($File["file"]["name"]),
                "path" => $path,
                "size" => $File["file"]["size"],
                "comment" => $data->albumComment,
                "category_id" => property_exists($data, 'albumCategory') ? $data->albumCategory : 1,
            );
            $this->pictures->insert($arr);
            array_push($picArr, $this->db->insert_id());
        }
        

        if(!property_exists($resp, 'error')){
            $arr = array(
                "name" => $data->albumName,
                "comment" => $data->albumComment,
                "category_id" => property_exists($data, 'albumCategory') ? $data->albumCategory : 1,
            );
            $res = $this->albums->insert($arr);
            $album_id = $this->db->insert_id();         
            $resp->data = $res;
            $resp->success = ($res > 0) ? true : false;
            if($res == 0){
                $resp->error = "Insertion Error";
            }

            foreach($picArr as $pic){
                $this->pictures->insert_into_album($pic, $album_id);
            }
        }

        echo json_encode($resp);        
    }

    public function update_albums(){
        $this->load->model('albums');
        $resp = new stdClass();
        $data = json_decode($this->input->post('data'));
        $category_id = ($data->category_id == null) ? 1 : $data->category_id;
        $res = $this->albums->update($data->album_id, array("name" => $data->name, "comment" => $data->comment, "category_id" => $category_id, "master_pic" => $data->master_pic));
        $resp->data = $res;
        $resp->success = ($res > 0) ? true : false;
        if($res == 0){
            $resp->error = "Update Error";
        }
            
        echo json_encode($resp);        
    }

    public function delete_albums(){
        $this->load->model('albums');
        $data = json_decode($this->input->post('data'));

        $res = $this->albums->delete($data->album_id);
        $resp = new stdClass();
		$resp->data = $res;
        $resp->success = ($res > 0) ? true : false;
        echo json_encode($resp);        
    }

    public function get_album_data(){
        $this->load->model('albums');
        $resp = new stdClass();
        $data = json_decode($this->input->get('data'));

        $resp->data = $this->albums->get_album_data($data->album_id);
        $resp->success = true;
        
        echo json_encode($resp);
    }

    public function delete_album_data(){
        $this->load->model('albums');
        $data = json_decode($this->input->post('data'));
        if($data->delete_pic_id != null){
            $res = $this->albums->delete_album_data($data->album_id, $data->delete_pic_id, true);
        } else {
            $res = $this->albums->delete_album_data($data->album_id, $data->delete_video_id, false);
        }
        
        $resp = new stdClass();
		$resp->data = $res;
        $resp->success = ($res > 0) ? true : false;
        echo json_encode($resp);        
    }

    //Rentals
    public function get_rentals(){
        $this->load->model('rentals');
        $resp = new stdClass();
        $data = json_decode($this->input->get('data'));

        if($data == null){
            $resp->data = $this->rentals->get();
            $resp->total = count($resp->data);
            $resp->success = true;
        } else {
            $res = $this->rentals->get_with_limit($data);
            $resp->data = $res->data;
            $resp->total = $res->total[0]->total;
            $resp->success = true;

        }        
        echo json_encode($resp);
    }

	public function insert_rentals(){
        $this->load->model('rentals');
        $resp = new stdClass();
        $data = json_decode($this->input->post('data'));

        $target_dir = "Media" . DIRECTORY_SEPARATOR . "RentalPictures" . DIRECTORY_SEPARATOR;
        $path = $this->upload($target_dir, $_FILES, $resp);

            if(!property_exists($resp, 'error')){
                $arr = array(
                    "name" => $data->rentalName,
                    "path" => $path,
                    "description" => $data->rentalDescription
                );
                $res = $this->rentals->insert($arr);            
                $resp->data = $res;
                $resp->success = ($res > 0) ? true : false;
                if($res == 0){
                    $resp->error = "Insertion Error";
                }
            }
        echo json_encode($resp);        
    }

    public function update_rentals(){
        $this->load->model('rentals');
        $resp = new stdClass();
        $data = json_decode($this->input->post('data'));
        $res = $this->rentals->update($data->rental_id, array("name" => $data->name, "description" => $data->description));
        $resp->data = $res;
        $resp->success = ($res > 0) ? true : false;
        if($res == 0){
            $resp->error = "Update Error";
        }
            
        echo json_encode($resp);        
    }

    public function delete_rentals(){
        $this->load->model('rentals');
        $data = json_decode($this->input->post('data'));

        $res = $this->rentals->delete($data->rental_id);
        $resp = new stdClass();
		$resp->data = $res;
        $resp->success = ($res > 0) ? true : false;
        echo json_encode($resp);        
    }

    //Testimonials
    public function get_testimonials(){
        $this->load->model('testimonials');
        $resp = new stdClass();
        $data = json_decode($this->input->get('data'));

        if($data == null){
            $resp->data = $this->testimonials->get();
            $resp->total = count($resp->data);
            $resp->success = true;
        } else {
            $res = $this->testimonials->get_with_limit($data);
            $resp->data = $res->data;
            $resp->total = $res->total[0]->total;
            $resp->success = true;

        }        
        echo json_encode($resp);
    }

	public function insert_testimonials(){
        $this->load->model('testimonials');
        $resp = new stdClass();
        $data = json_decode($this->input->post('data'));

        $target_dir = "Media" . DIRECTORY_SEPARATOR . "TestimonialPictures" . DIRECTORY_SEPARATOR;
        $path = $this->upload($target_dir, $_FILES, $resp);

            if(!property_exists($resp, 'error')){
                $arr = array(
                    "comment" => $data->testimonialComment,
                    "pic_path" => $path,
                    "comment_by" => $data->testimonialCommentBy,
                    "status" => $data->testimonialStatus
                );
                $res = $this->testimonials->insert($arr);            
                $resp->data = $res;
                $resp->success = ($res > 0) ? true : false;
                if($res == 0){
                    $resp->error = "Insertion Error";
                }
            }
        echo json_encode($resp);        
    }

    public function update_testimonials(){
        $this->load->model('testimonials');
        $resp = new stdClass();
        $data = json_decode($this->input->post('data'));
        $res = $this->testimonials->update($data->testimonial_id, array("comment" => $data->comment, "comment_by" => $data->comment_by, "status" => $data->status));
        $resp->data = $res;
        $resp->success = ($res > 0) ? true : false;
        if($res == 0){
            $resp->error = "Update Error";
        }
            
        echo json_encode($resp);        
    }

    public function delete_testimonials(){
        $this->load->model('testimonials');
        $data = json_decode($this->input->post('data'));

        $res = $this->testimonials->delete($data->testimonial_id);
        $resp = new stdClass();
		$resp->data = $res;
        $resp->success = ($res > 0) ? true : false;
        echo json_encode($resp);        
    }

    //private functions
    private function upload($target_dir,$File,&$resp){
            $path = "";
            $file_name = basename($File["file"]["name"]);
            $imageFileType = strtolower(pathinfo($file_name,PATHINFO_EXTENSION));
                
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) {
                $resp->error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $resp->success = false;
            }
        
            if(!property_exists($resp, 'error')){
                $newDirName = time().uniqid(rand());
                $target_file = FCPATH . $target_dir . $newDirName . DIRECTORY_SEPARATOR;
                $oldMask = umask(0);
                if(!file_exists($target_file)){
                    mkdir($target_file, 0777);
                }
                if (!move_uploaded_file($File["file"]["tmp_name"],$target_file . $File["file"]["name"])) {
                    $resp->error = "Upload Failed";
                    $resp->success = false;
                }
                umask($oldMask);
                $path = $target_dir . $newDirName . DIRECTORY_SEPARATOR . $file_name;
            }            
            return $path;
    }
}
