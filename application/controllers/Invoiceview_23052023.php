<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Invoiceview extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
		$this->load->model('Invoiceviewinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('invoiceview', $result);
	}

	public function Getinvoicedetails(){
        $this->load->model('Invoiceviewinfo');
        $result=$this->Invoiceviewinfo->Getinvoicedetails();
    }

    public function printreport($x){
		$this->load->model('Invoiceviewreportinfo');
        $result=$this->Invoiceviewreportinfo->printreport($x);
	}
}