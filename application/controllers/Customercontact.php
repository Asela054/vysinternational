<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Customercontact extends CI_Controller {   
	public function Customercontactinsertupdate(){
		$this->load->model('Customercontactinfo');
        $result=$this->Customercontactinfo->Customercontactinsertupdate();
	}
	public function Customercontactedit(){
		$this->load->model('Customercontactinfo');
        $result=$this->Customercontactinfo->Customercontactedit();
	}
	public function Customercontactstatus($x,$y){
		$this->load->model('Customercontactinfo');
        $result=$this->Customercontactinfo->Customercontactstatus($x,$y);
	}
	
}
