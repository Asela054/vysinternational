<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Materialdetail extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Materialdetailinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['materialname']=$this->Materialdetailinfo->Getmaterialname();
        $result['materialcategory']=$this->Materialdetailinfo->Getmaterialcategory();
        $result['brand']=$this->Materialdetailinfo->Getbrand();
        $result['form']=$this->Materialdetailinfo->Getform();
        $result['grade']=$this->Materialdetailinfo->Getgrade();
        $result['size']=$this->Materialdetailinfo->Getsize();
        $result['side']=$this->Materialdetailinfo->Getside();
        $result['unittype']=$this->Materialdetailinfo->Getunittype();
        $result['unit']=$this->Materialdetailinfo->Getunit();
		$this->load->view('materialdetail', $result);
	}
    public function Materialdetailinsertupdate(){
		$this->load->model('Materialdetailinfo');
        $result=$this->Materialdetailinfo->Materialdetailinsertupdate();
	}
    public function Materialdetailstatus($x, $y){
		$this->load->model('Materialdetailinfo');
        $result=$this->Materialdetailinfo->Materialdetailstatus($x, $y);
	}
    public function Materialdetailedit(){
		$this->load->model('Materialdetailinfo');
        $result=$this->Materialdetailinfo->Materialdetailedit();
	}
    public function Materialdetailupload(){
		$this->load->model('Materialdetailinfo');
        $result=$this->Materialdetailinfo->Materialdetailupload();
	}
    public function Materialdetailcheck(){
		$this->load->model('Materialdetailinfo');
        $result=$this->Materialdetailinfo->Materialdetailcheck();
	}
    public function Getlabelinforaccomaterial(){
		$this->load->model('Materialdetailinfo');
        $result=$this->Materialdetailinfo->Getlabelinforaccomaterial();
	}
    public function Getgrninfoaccogrnid(){
		$this->load->model('Materialdetailinfo');
        $result=$this->Materialdetailinfo->Getgrninfoaccogrnid();
	}
    public function Createlabel($mname, $mcode, $grnno, $pono, $mfdate, $expdate, $batchno){
		$this->load->library('Fpdf_gen');
		
		$pdf=new RPDF('L','mm',array(50,30));
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',12);
		// $pdf->TextWithRotation(50,65,'Hello',45,-45);
		$pdf->SetFontSize(12);
		$pdf->TextWithDirection(3,5,'MATERIAL LABEL','R');
		$pdf->SetFont('Arial','',5);
		$pdf->TextWithDirection(3,8,'Name       : '.str_replace('%20', ' ', $mname),'R');
		$pdf->TextWithDirection(3,11,'Code        : '.$mcode,'R');
		$pdf->TextWithDirection(3,14,'GRN No   : '.$grnno,'R');
		$pdf->TextWithDirection(3,17,'PO No      : '.$pono,'R');
        $pdf->TextWithDirection(3,20,'MF Date   : '.$mfdate,'R');
		$pdf->TextWithDirection(3,23,'EXP Date : '.$expdate,'R');
		$pdf->TextWithDirection(3,26,'Batch No  : '.$batchno,'R');
		// $pdf->TextWithDirection(110,50,'world!','D');
		$pdf->Output();
	}
}