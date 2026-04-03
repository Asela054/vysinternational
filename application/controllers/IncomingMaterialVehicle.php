<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class IncomingMaterialVehicle extends CI_Controller {
    public function index(){
		$this->load->model('IncomingMaterialVehicleinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['fruittype']=$this->IncomingMaterialVehicleinfo->Getfruittype();
		$result['supplier']=$this->IncomingMaterialVehicleinfo->Getsupplier();
		$this->load->view('incomingvehicle',$result);
	}
   
	public function MaterialVehicleInfoInsertUpdate(){
		$this->load->model('IncomingMaterialVehicleinfo');
        $result=$this->IncomingMaterialVehicleinfo->MaterialVehicleInfoInsertUpdate();
	}
	public function approveVehicle(){

		$this->load->model('IncomingMaterialVehicleinfo');
        $result=$this->IncomingMaterialVehicleinfo->approveVehicle();
		echo $result;

	}

	
}
