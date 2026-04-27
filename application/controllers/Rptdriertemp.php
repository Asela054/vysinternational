<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Rptdriertemp extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Drierinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['drierlist'] = $this->Drierinfo->getDrier();
		$this->load->view('rptdrier', $result);
	}
}