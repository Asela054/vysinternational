<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class WaterBath extends CI_Controller {
    public function index(){

        $this->load->model('Commeninfo');
        $this->load->model('Waterbathinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['product']=$this->Waterbathinfo->getProductId();
		$this->load->view('waterbath', $result);

	}
	public function WaterBathInsertUpdate(){
		$this->load->model('Waterbathinfo');
		$result = $this->Waterbathinfo->WaterBathInsertUpdate();
		echo $result;
	}

	public function getBathDetails(){

        $this->load->model('Waterbathinfo');
        $result = $this->Waterbathinfo->getBathDetails($id);
        echo json_encode($result);
        
    }

	public function markAsChecked() {
        
        $this->load->model('Waterbathinfo');

        $result = $this->Waterbathinfo->markAsChecked($id);

        echo $result;
    }



}