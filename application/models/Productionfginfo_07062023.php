<?php
class Productionfginfo extends CI_Model{
    public function locationlist(){
        $this->db->select('`idtbl_location, `location`');
        $this->db->from('tbl_location');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getproductlist(){
        $locationId = $this->input->post('locationId');

        $sql="SELECT `tbl_product`.`productcode`, `tbl_product`.`idtbl_product` FROM `tbl_product_stock` LEFT JOIN `tbl_product` ON `tbl_product`.`idtbl_product`=`tbl_product_stock`.`tbl_product_idtbl_product`  WHERE `tbl_product_stock`.`tbl_location_idtbl_location`=? AND `tbl_product_stock`.`status`=?";
        $respond=$this->db->query($sql, array($locationId, 1));

        echo json_encode($respond->result());
    }

    public function Getbatchlist(){
        $productId = $this->input->post('productId');
        $fromlocation = $this->input->post('fromlocation');
    
        $sql="SELECT `tbl_product_stock`.`idtbl_product_stock`,`tbl_product_stock`.`fgbatchno` FROM `tbl_product_stock`  WHERE `tbl_product_stock`.`tbl_product_idtbl_product`=? AND `tbl_product_stock`.`status`=? AND `tbl_product_stock`.`tbl_location_idtbl_location`=?";
        $respond=$this->db->query($sql, array($productId, 1, $fromlocation));
    
        echo json_encode($respond->result());
    }

   
    public function Stocktransferprocess() {
        $this->db->trans_begin();
    
        $userID = $_SESSION['userid'];
        $tableData = $this->input->post('tableData');
        $fromlocation = $this->input->post('fromlocation');
        $tolocation = $this->input->post('tolocation');
        $hiddenbatchid = $this->input->post('hiddenbatchid');
        $insertdatetime = date('Y-m-d H:i:s');
        $updatedatetime = date('Y-m-d H:i:s');
        $transdate = date('Y-m-d');
    
        $data = array(
            'date' => $transdate,
            'approvestatus' => '0',
            'approveuser' => '0',
            'status' => '1',
            'insertdatetime' => $insertdatetime,
            'fromlocation' => $fromlocation,
            'tolocation' => $tolocation,
            'tbl_user_idtbl_user' => $userID
        );
    
        $this->db->insert('tbl_transfer_fg', $data);
        $transID = $this->db->insert_id();
    
        foreach ($tableData as $rowtabledata) {
            $batchnos = explode(',', $rowtabledata['col_7']);
        
            $totalQty = $rowtabledata['col_8'];
        
        
            $this->db->select('`fgbatchno`, `qty`');
            $this->db->from('tbl_product_stock');
            $this->db->where('tbl_product_idtbl_product', $rowtabledata['col_6']);
            $this->db->where_in('fgbatchno', $batchnos);
            $this->db->where('status', 1);
            $this->db->order_by('qty');
        
            $respondstock = $this->db->get();
 
           
            $orderqty = $totalQty;

        foreach ($respondstock->result() as $rowstocklist) {
            if ($orderqty > 0) {
                $batchno2 = $rowstocklist->fgbatchno;
                $availableqty = $rowstocklist->qty;

                if ($availableqty >= $orderqty) {
                    $dedqty = $orderqty;
                    $availableqty -= $dedqty;
                    $orderqty = 0;
                } else {
                    $dedqty = $availableqty;
                    $orderqty -= $dedqty;
                    $availableqty = 0;
                }


            $datastockupdate = array(
                'qty' => $availableqty,
                'updateuser' => $userID,
                'updatedatetime' => $updatedatetime
            );

            $this->db->where('fgbatchno', $batchno2);
            $this->db->where('tbl_product_idtbl_product', $rowtabledata['col_6']);
            $this->db->update('tbl_product_stock', $datastockupdate);


            $datastockupdatetolocation = array(
                'fgbatchno' => $batchno2,
                'qty' => $dedqty,
                'status' => '1',
                'insertdatetime' => $insertdatetime,
                'tbl_user_idtbl_user' => $userID,
                'tbl_product_idtbl_product' => $rowtabledata['col_6'],
                'tbl_location_idtbl_location' => $tolocation,
                'tbl_production_fg_idtbl_production_fg' => '1'
            );

            $this->db->insert('tbl_product_stock', $datastockupdatetolocation);

            foreach ($batchnos as $batchno) {
                $dataone = array(
                    'batchno' => trim($batchno),
                    'qty' => $dedqty,
                    'status' => '1',
                    'insertdatetime' => $insertdatetime,
                    'tbl_transfer_fg_idtbl_transfer_fg' => $transID,
                    'tbl_product_idtbl_product' => $rowtabledata['col_6']
                );
                $this->db->insert('tbl_transfer_fg_detail', $dataone);
            }
        
                    if ($orderqty == 0) {
                        break; 
                    }
                } else {
                    break;
                }
            }
                }
        
            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                $actionObj = new stdClass();
                $actionObj->icon = 'fas fa-save';
                $actionObj->title = '';
                $actionObj->message = 'Record Added Successfully';
                $actionObj->url = '';
                $actionObj->target = '_blank';
                $actionObj->type = 'success';
        
                $actionJSON = json_encode($actionObj);
        
                $obj = new stdClass();
                $obj->status = 1;
                $obj->action = $actionJSON;
        
                echo json_encode($obj);
            } else {
                $this->db->trans_rollback();
                $actionObj = new stdClass();
                $actionObj->icon = 'fas fa-exclamation-triangle';
                $actionObj->title = '';
                $actionObj->message = 'Record Error';
                $actionObj->url = '';
                $actionObj->target = '_blank';
                $actionObj->type = 'danger';
        
                $actionJSON = json_encode($actionObj);
        
                $obj = new stdClass();
                $obj->status = 0;
                $obj->action = $actionJSON;
        
                echo json_encode($obj);
            }
        }
}