<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Fruittype extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Fruittypeinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('fruittype', $result);
	}
    public function Fruittypeinsertupdate(){
		$this->load->model('Fruittypeinfo');
        $result=$this->Fruittypeinfo->Fruittypeinsertupdate();
	}
    public function Fruittypestatus($x, $y){
		$this->load->model('Fruittypeinfo');
        $result=$this->Fruittypeinfo->Fruittypestatus($x, $y);
	}
    public function Fruittypeedit(){
		$this->load->model('Fruittypeinfo');
        $result=$this->Fruittypeinfo->Fruittypeedit();
	}
}