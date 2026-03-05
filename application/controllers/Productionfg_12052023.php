<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Productionfg extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Productionfginfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['location']=$this->Productionfginfo->Getlocationlist();
		$this->load->view('productionfg', $result);
	}
    public function Productionfginsertupdate(){
		$this->load->model('Productionfginfo');
        $result=$this->Productionfginfo->Productionfginsertupdate();
	}
}