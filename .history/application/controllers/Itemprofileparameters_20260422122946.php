<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class itemprofileparametersitemprofileparameters extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('itemprofileparametersitemprofileparametersinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['category']=$this->itemprofileparametersitemprofileparametersinfo->Getcategory();
		$this->load->view('itemprofileparametersitemprofileparameters', $result);
	}
    public function itemprofileparametersitemprofileparametersinsertupdate(){
		$this->load->model('itemprofileparametersitemprofileparametersinfo');
        $result=$this->itemprofileparametersitemprofileparametersinfo->itemprofileparametersitemprofileparametersinsertupdate();
	}
    public function itemprofileparametersitemprofileparametersstatus($x, $y){
		$this->load->model('itemprofileparametersitemprofileparametersinfo');
        $result=$this->itemprofileparametersitemprofileparametersinfo->itemprofileparametersitemprofileparametersstatus($x, $y);
	}
    public function itemprofileparametersitemprofileparametersedit(){
		$this->load->model('itemprofileparametersitemprofileparametersinfo');
        $result=$this->itemprofileparametersitemprofileparametersinfo->itemprofileparametersitemprofileparametersedit();
	}
}