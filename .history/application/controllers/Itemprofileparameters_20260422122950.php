<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class itemprofileparameters extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('itemprofileparametersinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['category']=$this->itemprofileparametersinfo->Getcategory();
		$this->load->view('itemprofileparameters', $result);
	}
    public function itemprofileparametersinsertupdate(){
		$this->load->model('itemprofileparametersinfo');
        $result=$this->itemprofileparametersinfo->itemprofileparametersinsertupdate();
	}
    public function itemprofileparametersstatus($x, $y){
		$this->load->model('itemprofileparametersinfo');
        $result=$this->itemprofileparametersinfo->itemprofileparametersstatus($x, $y);
	}
    public function itemprofileparametersedit(){
		$this->load->model('itemprofileparametersinfo');
        $result=$this->itemprofileparametersinfo->itemprofileparametersedit();
	}
}