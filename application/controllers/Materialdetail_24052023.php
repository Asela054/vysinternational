<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Materialdetail extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Materialdetailinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['materialname']=$this->Materialdetailinfo->Getmaterialname();
        $result['materialcategory']=$this->Materialdetailinfo->Getmaterialcategory();
        $result['brand']=$this->Materialdetailinfo->Getbrand();
        $result['form']=$this->Materialdetailinfo->Getform();
        $result['grade']=$this->Materialdetailinfo->Getgrade();
        $result['size']=$this->Materialdetailinfo->Getsize();
        $result['side']=$this->Materialdetailinfo->Getside();
        $result['unittype']=$this->Materialdetailinfo->Getunittype();
        $result['unit']=$this->Materialdetailinfo->Getunit();
		$this->load->view('materialdetail', $result);
	}
    public function Materialdetailinsertupdate(){
		$this->load->model('Materialdetailinfo');
        $result=$this->Materialdetailinfo->Materialdetailinsertupdate();
	}
    public function Materialdetailstatus($x, $y){
		$this->load->model('Materialdetailinfo');
        $result=$this->Materialdetailinfo->Materialdetailstatus($x, $y);
	}
    public function Materialdetailedit(){
		$this->load->model('Materialdetailinfo');
        $result=$this->Materialdetailinfo->Materialdetailedit();
	}
    public function Materialdetailupload(){
		$this->load->model('Materialdetailinfo');
        $result=$this->Materialdetailinfo->Materialdetailupload();
	}
    public function Materialdetailcheck(){
		$this->load->model('Materialdetailinfo');
        $result=$this->Materialdetailinfo->Materialdetailcheck();
	}
}