<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Productionorderview extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Productionorderviewinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['machine']=$this->Productionorderviewinfo->Getmachinelist();
		$this->load->view('productionorderview', $result);
	}
    public function Getproductionorderid(){
		$this->load->model('Productionorderviewinfo');
        $result=$this->Productionorderviewinfo->Getproductionorderid();
	}
    public function Machineinsertupdate(){
		$this->load->model('Productionorderviewinfo');
        $result=$this->Productionorderviewinfo->Machineinsertupdate();
	}
    public function Checkmachineavailability(){
		$this->load->model('Productionorderviewinfo');
        $result=$this->Productionorderviewinfo->Checkmachineavailability();
	}
    public function Productiondetailaccoproduction(){
		$this->load->model('Productionorderviewinfo');
        $result=$this->Productionorderviewinfo->Productiondetailaccoproduction();
	}
    public function Getqtyinfoaccoproductiondetail(){
		$this->load->model('Productionorderviewinfo');
        $result=$this->Productionorderviewinfo->Getqtyinfoaccoproductiondetail();
	}
    public function Getrowmateriallist(){
		$this->load->model('Productionorderviewinfo');
        $result=$this->Productionorderviewinfo->Getrowmateriallist();
	}
    public function Getpackmateriallist(){
		$this->load->model('Productionorderviewinfo');
        $result=$this->Productionorderviewinfo->Getpackmateriallist();
	}
    public function Getlablemateriallist(){
		$this->load->model('Productionorderviewinfo');
        $result=$this->Productionorderviewinfo->Getlablemateriallist();
	}
    public function Getmaterialenterlayout(){
		$this->load->model('Productionorderviewinfo');
        $result=$this->Productionorderviewinfo->Getmaterialenterlayout();
	}
    public function Getmaterialstockinfoaccomaterial(){
		$this->load->model('Productionorderviewinfo');
        $result=$this->Productionorderviewinfo->Getmaterialstockinfoaccomaterial();
	}
    public function Checkissueqty(){
		$this->load->model('Productionorderviewinfo');
        $result=$this->Productionorderviewinfo->Checkissueqty();
	}
    public function Issuematerialforproduction(){
		$this->load->model('Productionorderviewinfo');
        $result=$this->Productionorderviewinfo->Issuematerialforproduction();
	}
}