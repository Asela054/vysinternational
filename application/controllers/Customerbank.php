<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Customerbank extends CI_Controller {
	public function Customerbankinsertupdate(){
		$this->load->model('Customerbankinfo');
        $result=$this->Customerbankinfo->Customerbankinsertupdate();
	}
	public function Customerbankedit(){
		$this->load->model('Customerbankinfo');
        $result=$this->Customerbankinfo->Customerbankedit();
	}
	public function Customerbankstatus($x,$y){
		$this->load->model('Customerbankinfo');
        $result=$this->Customerbankinfo->Customerbankstatus($x,$y);
	}
	
}
