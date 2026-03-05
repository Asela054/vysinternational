<?php
class Rptproductwisesalesinfo extends CI_Model{
    public function Getproduct(){
        $this->db->select('`idtbl_product`, `productcode`');
        $this->db->from('tbl_product');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
}