<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Salesordercost extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Salesordercostinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['costlist']=$this->Salesordercostinfo->Getcostlist();
		$this->load->view('salesordercost', $result);
	}

    public function Getsalesoredrproduct(){
		$this->load->model('Salesordercostinfo');
        $result=$this->Salesordercostinfo->Getsalesoredrproduct();
	}

    public function Getorderdetails(){
		$this->load->model('Salesordercostinfo');
        $result=$this->Salesordercostinfo->Getorderdetails();
	}

    public function Getmaterialcost(){
		$this->load->model('Salesordercostinfo');
        $result=$this->Salesordercostinfo->Getmaterialcost();
	}

    public function Costinsertupdate(){
		$this->load->model('Salesordercostinfo');
        $result=$this->Salesordercostinfo->Costinsertupdate();
	}

    public function Getallocatecostlist(){
		$this->load->model('Salesordercostinfo');
        $result=$this->Salesordercostinfo->Getallocatecostlist();
	}

    public function Getexpencetype(){
		$this->load->model('Salesordercostinfo');
        $result=$this->Salesordercostinfo->Getexpencetype();
	}
}