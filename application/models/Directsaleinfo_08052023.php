<?php
class Directsaleinfo extends CI_Model{
    public function Getmaterial(){
        $this->db->select('`idtbl_material_info`, `idtbl_material_code`, `materialname`');
        $this->db->from('tbl_material_info');
        $this->db->join('tbl_material_code', 'tbl_material_code.idtbl_material_code = tbl_material_info.tbl_material_code_idtbl_material_code', 'left');
        $this->db->join('tbl_material_category', 'tbl_material_category.idtbl_material_category = tbl_material_info.tbl_material_category_idtbl_material_category', 'left');
        $this->db->where('tbl_material_info.status', 1);
        $this->db->where('tbl_material_info.tbl_material_category_idtbl_material_category', 1);
        $this->db->group_by('tbl_material_code.idtbl_material_code');

        return $respond=$this->db->get();
    }


    public function Getproductlist(){
        $html='';

        $hiddenmaterialID=$this->input->post('categoryID');
        // $saletype=$this->input->post('saletype');


        $sql="SELECT `tbl_product`.`idtbl_product`, `tbl_product`.`productcode`,  `tbl_product`.`barcode`, `tbl_product`.`retailprice`, `tbl_product`.`wholesaleprice` FROM `tbl_product` LEFT JOIN tbl_material_code ON tbl_material_code.idtbl_material_code=tbl_product.materialid WHERE `tbl_product`.`materialid`= $hiddenmaterialID AND `tbl_product`.`status`=1";
        $respond=$this->db->query($sql);

        if($respond->num_rows() > 0){ 
            foreach($respond->result() as $rowlist){
                $productID=$rowlist->idtbl_product;
                $sqlstockcheck="SELECT SUM(`qty`) AS sumqty FROM `tbl_product_stock` WHERE `tbl_product_idtbl_product`='$productID'"; 
                $respondstockcheck=$this->db->query($sqlstockcheck);
                

                if(!empty($respondstockcheck->row(0)->sumqty)){$stockcount=$respondstockcheck->row(0)->sumqty;}
                else{$stockcount=0;}  

                // $saleprice;
                // if($saletype==1){
                //     $saleprice=$rowlist->retailprice;
                // }else{
                //     $saleprice=$rowlist->wholesaleprice;
                // }

                $html.='

                    <tr class=';if($stockcount==0){$html.='table-danger';}else{$html.='pointer';}$html.=' id="'.$rowlist->idtbl_product.'">
                        <td>'.$rowlist->idtbl_product.'</td>
                        <td>'.$rowlist->productcode.'</td>
                        <td>'.$rowlist->barcode.'</td>
                        <td>'.$stockcount.'</td>
                        <td class="text-right">'.$rowlist->retailprice.'</td>

                    </tr>
                ';            
            }
        }else{
            $html.='

            <tr>
                <td colspan="3">No Product To Show</td>
            </tr>
            ';
        }
        echo $html;
    }

    public function Getproductlistaccobarcode(){
        $html='';

        $barcode=$this->input->post('barcode');
        // $saletype=$this->input->post('saletype');


        $sql="SELECT `tbl_product`.`idtbl_product`, `tbl_product`.`productcode`,  `tbl_product`.`barcode`, `tbl_product`.`retailprice`, `tbl_product`.`wholesaleprice` 
        FROM `tbl_product` 
        LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_product`.`materialid` 
        WHERE `tbl_product`.`barcode`= '$barcode' AND `tbl_product`.`status`=1";
        $respond=$this->db->query($sql);

        if($respond->num_rows() > 0){ 
            foreach($respond->result() as $rowlist){
                $productID=$rowlist->idtbl_product;
                $sqlstockcheck="SELECT SUM(`qty`) AS sumqty FROM `tbl_product_stock` WHERE `tbl_product_idtbl_product`='$productID'"; 
                $respondstockcheck=$this->db->query($sqlstockcheck);
                

                if(!empty($respondstockcheck->row(0)->sumqty)){$stockcount=$respondstockcheck->row(0)->sumqty;}
                else{$stockcount=0;}  

                // $saleprice;
                // if($saletype==1){
                //     $saleprice=$rowlist->retailprice;
                // }else{
                //     $saleprice=$rowlist->wholesaleprice;
                // }

                $html.='

                    <tr class=';if($stockcount==0){$html.='table-danger';}else{$html.='pointer';}$html.=' id="'.$rowlist->idtbl_product.'">
                        <td>'.$rowlist->idtbl_product.'</td>
                        <td>'.$rowlist->productcode.'</td>
                        <td>'.$rowlist->barcode.'</td>
                        <td>'.$stockcount.'</td>
                        <td class="text-right">'.$rowlist->retailprice.'</td>

                    </tr>
                ';            
            }
        }else{
            $html.='

            <tr>
                <td colspan="3">No Product To Show</td>
            </tr>
            ';
        }
        echo $html;
    }


    public function Directsaleinsertupdate(){

        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $tableData=$this->input->post('tableData');
        $tableDataPay=$this->input->post('tableDataPay');
        $total=$this->input->post('total');
        $distotal=$this->input->post('distotal');
        $nettotal=$this->input->post('nettotal');
        // $salestype=$this->input->post('saletype');
        $billtype=$this->input->post('billtype');
        $paytotal=$this->input->post('paytotal');
        $location=$this->input->post('location');
        $orderid=$this->input->post('orderid');

        $balance=$nettotal-$paytotal;

        $insertdatetime=date('Y-m-d H:i:s');
        $invdate=date('Y-m-d H:i:s');

        $data = array(
            'invdate'=> $invdate, 
            'grosstotal'=> $total, 
            'discount'=> $distotal, 
            'nettotal'=> $nettotal, 
            'invtype'=> '1', 
            'paycomplete'=> '0', 
            'status'=> '1', 
            'insertdatetime'=> $insertdatetime, 
            'tbl_user_idtbl_user'=> $userID,
            'tbl_location_idtbl_location'=> '1',
            'tbl_customer_porder_idtbl_customer_porder'=> '1'
        );

        $this->db->insert('tbl_invoice', $data);

        $invoiceID=$this->db->insert_id();

        foreach($tableData as $rowtabledata){
            $data = array(
                'qty'=> $rowtabledata['col_2'], 
                'saleprice'=> $rowtabledata['col_3'], 
                'total'=> $rowtabledata['col_5'],  
                'status'=> '1', 
                'insertdatetime'=> $insertdatetime,
                'tbl_invoice_idtbl_invoice'=> $invoiceID, 
                'tbl_product_idtbl_product'=> $rowtabledata['col_6']
            );

            $this->db->insert('tbl_invoice_detail', $data);

            $this->db->select('qty AS stockqty');
            $this->db->from('tbl_product_stock');
            $this->db->where('tbl_product_idtbl_product', $rowtabledata['col_6']);
            
            $respond2 = $this->db->get();

            $previousqty = $respond2->row(0)->stockqty;


            $finalqty=$previousqty-$rowtabledata['col_2'];

            $data2 = array(
                'qty' => $finalqty,
            );
            
            $this->db->where('tbl_product_idtbl_product', $rowtabledata['col_6']);
            $this->db->update('tbl_product_stock', array('qty' => $finalqty));
        }

        if($billtype==1){
            $data = array(
                'paydate'=> $invdate, 
                'nettotal'=> $paytotal, 
                'balance'=> $balance, 
                'status'=> '1', 
                'insertdatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
                'tbl_location_idtbl_location'=> '1',
            );
    
            $this->db->insert('tbl_invoice_payment', $data);

            $invoicepayID=$this->db->insert_id();

            foreach($tableDataPay as $rowtableDataPay){
                $dataone = array(
                    'method'=> $rowtableDataPay['col_1'], 
                    'amount'=> $rowtableDataPay['col_7'], 
                    'bank'=> $rowtableDataPay['col_3'],  
                    'branch'=> $rowtableDataPay['col_4'], 
                    'chequeno'=> $rowtableDataPay['col_5'], 
                    'chequedate'=> $rowtableDataPay['col_6'],  
                    'status'=> '1', 
                    'insertdatetime'=> $insertdatetime,
                    'tbl_user_idtbl_user'=> $userID,
                    'tbl_invoice_payment_idtbl_invoice_payment'=> $invoicepayID, 
                );
    
                $this->db->insert('tbl_invoice_payment_detail', $dataone);

                $datatwo = array(
                    'tbl_invoice_payment_idtbl_invoice_payment'=> $invoicepayID, 
                    'tbl_invoice_idtbl_invoice'=> $invoiceID, 
                );
        
                $this->db->insert('tbl_invoice_payment_has_tbl_invoice', $datatwo);
            }
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

            $obj=new stdClass();
            $obj->action=json_encode($actionObj);
            $obj->actiontype='1';
            $obj->invoiceid=$invoiceID;
            $obj->billtype=$billtype;
            // $obj->saletype=$salestype;  
            
            echo json_encode($obj);
        } else {
            $this->db->trans_rollback();

            $actionObj=new stdClass();
            $actionObj->icon='fas fa-exclamation-triangle';
            $actionObj->title='';
            $actionObj->message='Record Error';
            $actionObj->url='';
            $actionObj->target='_blank';
            $actionObj->type='danger';

            $actionJSON=json_encode($actionObj);

            $obj=new stdClass();
            $obj->action=json_encode($actionObj);
            $obj->actiontype='0';
            $obj->invoiceid='0';
            $obj->billtype=$billtype;
            // $obj->saletype=$salestype; 
            
            echo json_encode($obj);
        }

    }
}
