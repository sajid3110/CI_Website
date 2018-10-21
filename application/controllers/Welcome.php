<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$this->load->helper('url');
		$this->load->view('index');
	}

	public function home_page(){
		$this->load->view('homepage.html');
	}

	public function photocategory_page(){
		$this->load->view('photoCategory.html');
	}

	public function photoalbum_page(){
		$this->load->view('photoAlbum.html');
	}

	public function photodetail_page(){
		$this->load->view('photoDetail.html');
	}

	public function videocategory_page(){
		$this->load->view('videoCategory.html');
	}

	public function videoalbum_page(){
		$this->load->view('videoAlbum.html');
	}

	public function videodetail_page(){
		$this->load->view('videoDetail.html');
	}

	public function rental_page(){
		$this->load->view('rental.html');
	}

	public function faq_page(){
		$this->load->view('faq.html');
	}
	public function aboutus_page(){
		$this->load->view('aboutus.html');
	}

	public function homepage_data(){
		$this->load->model("testimonials");
		$resp = new stdClass();
		$data = $this->testimonials->get(array("status" => '1'));
		$resp->testimonial_data = $data;
		echo json_encode($resp);
	}

	public function photocategory_data(){
		$this->load->model("categories");
		$resp = new stdClass();
		$data = $this->categories->get_pic_page_data();
		$resp->photocategory_data = $data;
		echo json_encode($resp);
	}

	public function photoalbum_data(){
		$this->load->model("albums");
		$resp = new stdClass();
		$data = json_decode($this->input->get('data'));

		$data = $this->albums->get_picalbum_page_data($data->category_id);
		$resp->photoalbum_data = $data;
		echo json_encode($resp);
	}

	public function photodetail_data(){
		$this->load->model("albums");
		$resp = new stdClass();
		$data = json_decode($this->input->get('data'));

		$data = $this->albums->get_picdetail_page_data($data->album_id);
		$resp->photodetail_data = $data;
		echo json_encode($resp);
	}

	public function videocategory_data(){
		$this->load->model("categories");
		$resp = new stdClass();
		$data = $this->categories->get_video_page_data();
		$resp->videocategory_data = $data;
		echo json_encode($resp);
	}

	public function videoalbum_data(){
		$this->load->model("albums");
		$resp = new stdClass();
		$data = json_decode($this->input->get('data'));

		$data = $this->albums->get_videoalbum_page_data($data->category_id);
		$resp->videoalbum_data = $data;
		echo json_encode($resp);
	}

	public function videodetail_data(){
		$this->load->model("albums");
		$resp = new stdClass();
		$data = json_decode($this->input->get('data'));

		$data = $this->albums->get_videodetail_page_data($data->album_id);
		$resp->videodetail_data = $data;
		echo json_encode($resp);
	}

	public function rental_data(){
		$this->load->model("rentals");
		$resp = new stdClass();

		$data = $this->rentals->get();
		$resp->rental_data = $data;
		echo json_encode($resp);
	}
}
