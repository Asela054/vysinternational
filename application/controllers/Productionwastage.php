<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Productionwastage extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Productionwastageinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['grnnumber']=$this->Productionwastageinfo->Getgrnnumber();
		$result['fruittype']=$this->Productionwastageinfo->getFruitType();
		$this->load->view('productionwastage', $result);
	}

    public function getBatchByGRN(){

        $this->load->model('Productionwastageinfo');
        $result = $this->Productionwastageinfo->getBatchByGRN();
        echo $result;

    }

    public function getProducts(){
        

        $this->load->model('Productionwastageinfo');
        $result = $this->Productionwastageinfo->getProductList($search);

        echo json_encode($result);
    }

    public function wastageInsertUpdate(){
		$this->load->model('Productionwastageinfo');
        $result=$this->Productionwastageinfo->wastageInsertUpdate();
	}

    public function getWastageDetails(){

        $this->load->model('Productionwastageinfo');
        $result = $this->Productionwastageinfo->getWastageDetails();

        echo json_encode($result);
    
    }

    public function markAsChecked() {
        
        $this->load->model('Productionwastageinfo');

        $result = $this->Productionwastageinfo->markAsChecked($id);
        echo $result;

    }

}