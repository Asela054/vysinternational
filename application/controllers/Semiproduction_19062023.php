<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Semiproduction extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Semibominfo');
		$this->load->model('Semiproductioninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['materialcategory']=$this->Semibominfo->Getmaterialcategory();
		$result['machine']=$this->Semiproductioninfo->Getmachinelist();
		$result['materialname']=$this->Semibominfo->Getmaterialname();
		$this->load->view('semiproduction', $result);
	}
	public function GetSemimateriallist(){
		$this->load->model('Semiproductioninfo');
        $result=$this->Semiproductioninfo->GetSemimateriallist();
	}
	public function printreport($x){
		$this->load->model('Semiproductionreportinfo');
        $result=$this->Semiproductionreportinfo->printreport($x);
	}
	public function Getprodcutioninfo(){
		$this->load->model('Semiproductioninfo');
        $result=$this->Semiproductioninfo->Getprodcutioninfo();
	}
	public function Machineinsertupdate(){
		$this->load->model('Semiproductioninfo');
        $result=$this->Semiproductioninfo->Machineinsertupdate();
	}
	public function Semiproductioninsertupdate(){
		$this->load->model('Semiproductioninfo');
        $result=$this->Semiproductioninfo->Semiproductioninsertupdate();
	}
	public function Getothercosttype(){
		$this->load->model('Semiproductioninfo');
        $result=$this->Semiproductioninfo->Getothercosttype();
	}
	public function Othercostinsertupdate(){
		$this->load->model('Semiproductioninfo');
        $result=$this->Semiproductioninfo->Othercostinsertupdate();
	}
	public function Viewalreadyothercost(){
		$this->load->model('Semiproductioninfo');
        $result=$this->Semiproductioninfo->Viewalreadyothercost();
	}
	public function Semiproductiondetails(){
		$this->load->model('Semiproductioninfo');
        $result=$this->Semiproductioninfo->Semiproductiondetails();
	}
	public function Semiproductiontransfer($x){
		$this->load->model('Semiproductioninfo');
        $result=$this->Semiproductioninfo->Semiproductiontransfer($x);
	}
	public function Getbatchnolistaccomaterial(){
		$this->load->model('Semiproductioninfo');
        $result=$this->Semiproductioninfo->Getbatchnolistaccomaterial();
	}
}