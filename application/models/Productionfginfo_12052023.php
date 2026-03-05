<?php
class Productionfginfo extends CI_Model{
    public function Getlocationlist(){
        $this->db->select('`idtbl_location`, `location`');
        $this->db->from('tbl_location');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Productionfginsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $fgid=$this->input->post('fgid');
        $productid=$this->input->post('productid');
        $productcode=$this->input->post('productcode');
        $location=$this->input->post('location');
        $qty=$this->input->post('qty');

        $fgbatchno = $productcode;

        $updatedatetime=date('Y-m-d H:i:s');
        $currdate=date('Ymd');

            $data = array(
                'fgbatchno'=> $fgbatchno.$currdate, 
                'qty'=> $qty, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID,
                'tbl_product_idtbl_product'=> $productid,
                'tbl_location_idtbl_location'=> $location,
                'tbl_production_fg_idtbl_production_fg'=> $fgid,
            );

            $this->db->insert('tbl_product_stock', $data);

            $data2 = array(
                'transfgstock' => $qty,
            );
            
            $this->db->select('transfgstock AS transqty');
            $this->db->from('tbl_production_fg');
            $this->db->where('idtbl_production_fg', $fgid);

            $respond = $this->db->get();

            $previousqty = $respond->row(0)->transqty;
            
            $updateqty = $previousqty + $qty;

            $this->db->where('idtbl_production_fg', $fgid);
            $this->db->update('tbl_production_fg', array('transfgstock' => $updateqty));

            if((int)$qty === (int)$updateqty){
                $this->db->where('idtbl_production_fg', $fgid);
                $this->db->update('tbl_production_fg', array('status' => 3));
            }
            

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-save';
                $actionObj->title='';
                $actionObj->message='Record Added Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='success';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Productionfg');                
            } else {
                $this->db->trans_rollback();

                $actionObj=new stdClass();
                $actionObj->icon='fas fa-warning';
                $actionObj->title='';
                $actionObj->message='Record Error';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='danger';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Productionfg');
            }
    }
}