<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Product extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Productinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['material']=$this->Productinfo->Getmaterial();
		$result['form']=$this->Productinfo->Getform();
		$result['grade']=$this->Productinfo->Getgrade();
		$result['brand']=$this->Productinfo->Getbrand();
		$result['size']=$this->Productinfo->Getsize();
		$result['type']=$this->Productinfo->Gettype();
		$this->load->view('product', $result);
	}
	public function getSubCategory(){
		$postData = $this->input->post();
		$this->load->model('Productinfo');
		$data = $this->Productinfo->getSubCategory($postData);
		echo json_encode($data);
	}
    public function Productinsertupdate(){
		$this->load->model('Productinfo');
        $result=$this->Productinfo->Productinsertupdate();
	}
    public function Productstatus($x, $y){
		$this->load->model('Productinfo');
        $result=$this->Productinfo->Productstatus($x, $y);
	}
    public function Productedit(){
		$this->load->model('Productinfo');
        $result=$this->Productinfo->Productedit();
	}
	public function Finishgoodlupload(){
		$this->load->model('Productinfo');
        $result=$this->Productinfo->Finishgoodlupload();
	}
}