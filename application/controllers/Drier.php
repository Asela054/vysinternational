<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Drier extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('drierinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['time'] = $this->drierinfo->generateFullDayTimeOptions(); 
		$this->load->view('drier', $result);
	}
    public function DrierInsertupdate(){
		$this->load->model('drierinfo');
        $result=$this->drierinfo->DrierInsertupdate();
	}
    public function Drierstatus($x, $y){
		$this->load->model('drierinfo');
        $result=$this->drierinfo->Drierstatus($x, $y);
	}
    public function Drieredit(){
		$this->load->model('drierinfo');
        $result=$this->drierinfo->Drieredit();
	}
    public function Drierdailyinfoinsertupdate()
    {
        $this->load->model('drierinfo');
        $result=$this->drierinfo->Drierdailyinfoinsertupdate();
        echo $result;
    }
}