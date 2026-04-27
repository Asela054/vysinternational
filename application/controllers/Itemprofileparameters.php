<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Itemprofileparameters extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Itemprofileparametersinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('itemprofileparameters', $result);
	}
    public function Qualitysubcategoryinsertupdate(){
		$this->load->model('Itemprofileparametersinfo');
        $result=$this->Itemprofileparametersinfo->Qualitysubcategoryinsertupdate();
	}
    public function Qualitysubcategorystatus($x, $y){
		$this->load->model('Itemprofileparametersinfo');
        $result=$this->Itemprofileparametersinfo->Qualitysubcategorystatus($x, $y);
	}
    public function Qualitysubcategoryedit(){
		$this->load->model('Itemprofileparametersinfo');
        $result=$this->Itemprofileparametersinfo->Qualitysubcategoryedit();
	}
}