<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Itemprofileparameters extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Itemprofileparameters');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['category']=$this->Itemprofileparameters->Getcategory();
		$this->load->view('qualitysubcategory', $result);
	}
    public function Qualitysubcategoryinsertupdate(){
		$this->load->model('Itemprofileparameters');
        $result=$this->Itemprofileparameters->Qualitysubcategoryinsertupdate();
	}
    public function Qualitysubcategorystatus($x, $y){
		$this->load->model('Itemprofileparameters');
        $result=$this->Itemprofileparameters->Qualitysubcategorystatus($x, $y);
	}
    public function Qualitysubcategoryedit(){
		$this->load->model('Itemprofileparameters');
        $result=$this->Itemprofileparameters->Qualitysubcategoryedit();
	}
}