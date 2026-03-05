<?php
class Semiproductioninfo extends CI_Model{
    public function GetSemimateriallist(){
        $searchTerm=$this->input->post('searchTerm');

        if(!isset($searchTerm)){
            $sql="SELECT `tbl_material_info`.`idtbl_material_info`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname`, `tbl_unit`.`unitcode` FROM `tbl_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` LEFT JOIN `tbl_unit` ON `tbl_unit`.`idtbl_unit`=`tbl_material_info`.`tbl_unit_idtbl_unit` WHERE `tbl_material_info`.`status`=? AND `tbl_material_info`.`semistatus`=? LIMIT 5";
            $respond=$this->db->query($sql, array(1, 1));                       
        }
        else{            
            if(!empty($searchTerm)){
                $sql="SELECT `tbl_material_info`.`idtbl_material_info`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname`, `tbl_unit`.`unitcode` FROM `tbl_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` LEFT JOIN `tbl_unit` ON `tbl_unit`.`idtbl_unit`=`tbl_material_info`.`tbl_unit_idtbl_unit` WHERE `tbl_material_info`.`status`=? AND `tbl_material_info`.`semistatus`=? AND `tbl_material_info`.`materialinfocode` LIKE '$searchTerm%'";
                $respond=$this->db->query($sql, array(1, 1));    
            }
            else{
                $sql="SELECT `tbl_material_info`.`idtbl_material_info`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname`, `tbl_unit`.`unitcode` FROM `tbl_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` LEFT JOIN `tbl_unit` ON `tbl_unit`.`idtbl_unit`=`tbl_material_info`.`tbl_unit_idtbl_unit` WHERE `tbl_material_info`.`status`=? AND `tbl_material_info`.`semistatus`=? LIMIT 5";
                $respond=$this->db->query($sql, array(1, 1));                
            }
        }
        
        $data=array();
        
        foreach ($respond->result() as $row) {
            $data[]=array("id"=>$row->idtbl_material_info, "text"=>$row->materialname.' - '.$row->materialinfocode.'/'.$row->unitcode);
        }
        
        echo json_encode($data);
    }
    public function Getprodcutioninfo(){
        $prodate=$this->input->post('prodate');
        $semimaterial=$this->input->post('semimaterial');
        $qty=$this->input->post('qty');

        $this->db->select('tbl_semi_bom.qty, tbl_semi_bom.wastage, tbl_semi_bom.tbl_material_info_idtbl_material_info, tbl_semi_bom.idtbl_semi_bom, tbl_material_info.materialinfocode');
        $this->db->from('tbl_semi_bom');
        $this->db->join('tbl_material_info', 'tbl_material_info.idtbl_material_info = tbl_semi_bom.tbl_material_info_idtbl_material_info', 'left');
        $this->db->where('tbl_semi_bom.semimaterial', $semimaterial);
        $this->db->where('tbl_semi_bom.status', 1);

        $respond=$this->db->get();

        $statusstock=0;
        $html='';
        foreach($respond->result() as $rowmaterialbomlist){
            $materialID=$rowmaterialbomlist->tbl_material_info_idtbl_material_info;

            $this->db->select('SUM(qty) AS sumqty');
            $this->db->from('tbl_stock');
            $this->db->where('tbl_material_info_idtbl_material_info', $materialID);
            $this->db->where('status', 1);

            $respondcheck=$this->db->get();

            if($respondcheck->row(0)->sumqty<$qty){
                $statusstock=1;
            }
            
            $html.='
                <tr>
                    <td>'.$rowmaterialbomlist->idtbl_semi_bom.'</td>
                    <td>'.$rowmaterialbomlist->materialinfocode.'</td>
                    <td>'.(($rowmaterialbomlist->qty+(($rowmaterialbomlist->qty*$rowmaterialbomlist->wastage)/100))*$qty).'</td>
                </tr>
            ';
        }

        $obj=new stdClass();
        $obj->stockstatus=$statusstock;
        $obj->htmlview=$html;

        echo json_encode($obj);
    }
    public function Semiproductioninsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $prodate=$this->input->post('prodate');
        $semimaterial=$this->input->post('semimaterial');
        $qty=$this->input->post('qty');
        $updatedatetime=date('Y-m-d H:i:s');

        $this->db->select('tbl_semi_bom.qty, tbl_semi_bom.tbl_material_info_idtbl_material_info, tbl_semi_bom.idtbl_semi_bom, tbl_material_info.materialinfocode');
        $this->db->from('tbl_semi_bom');
        $this->db->join('tbl_material_info', 'tbl_material_info.idtbl_material_info = tbl_semi_bom.tbl_material_info_idtbl_material_info', 'left');
        $this->db->where('tbl_semi_bom.semimaterial', $semimaterial);
        $this->db->where('tbl_semi_bom.status', 1);

        $respond=$this->db->get();

        $data = array(
            'prodate'=>$prodate, 
            'status'=>'1', 
            'insertdatetime'=>$updatedatetime, 
            'tbl_user_idtbl_user'=>$userID,
            'tbl_material_info_idtbl_material_info'=>$semimaterial
        );
        $this->db->insert('tbl_semi_production', $data);

        $semiproID=$this->db->insert_id();

        foreach($respond->result() as $rowmaterialbomlist){
            $materialID=$rowmaterialbomlist->tbl_material_info_idtbl_material_info;
            $qtybom=$rowmaterialbomlist->qty;

            $sqlcheckunit="SELECT
                `tbl_semi_bom`.`qty` AS `rowqty`,
                AVG(`tbl_grndetail`.`costunitprice`) AS `avgrowmate`,
                `tbl_semi_bom`.`tbl_material_info_idtbl_material_info`,
                `tbl_material_info`.`tbl_unit_idtbl_unit` AS `rowunit`,
                (
                    AVG(`tbl_grndetail`.`costunitprice`) * `tbl_semi_bom`.`qty`
                ) AS `totalunitcost`
            FROM
                `tbl_semi_bom`
            LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info` = `tbl_semi_bom`.`tbl_material_info_idtbl_material_info`
            LEFT JOIN `tbl_stock` ON `tbl_stock`.`tbl_material_info_idtbl_material_info` = `tbl_semi_bom`.`tbl_material_info_idtbl_material_info`
            LEFT JOIN `tbl_grndetail` ON `tbl_grndetail`.`tbl_material_info_idtbl_material_info` = `tbl_semi_bom`.`tbl_material_info_idtbl_material_info`
            WHERE
                `tbl_semi_bom`.`status` = ? AND `tbl_semi_bom`.`tbl_material_info_idtbl_material_info` = ? AND `tbl_stock`.`qty` > ? AND `tbl_stock`.`status` = ? AND `tbl_grndetail`.`status` = ?";
            $respondcheckunit=$this->db->query($sqlcheckunit, array(1, $materialID, 0, 1, 1));

            $totalprice=$respondcheckunit->row(0)->totalunitcost*$qty;

            $data = array(
                'qty'=> $qty, 
                'unitprice'=> $respondcheckunit->row(0)->totalunitcost, 
                'total'=> $totalprice, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID, 
                'tbl_semi_production_idtbl_semi_production'=> $semiproID, 
                'semimaterial'=> $semimaterial, 
                'tbl_material_info_idtbl_material_info'=> $materialID
            );
            $this->db->insert('tbl_semi_production_detail', $data);

            $this->db->select('`batchno`, `qty`');
            $this->db->from('tbl_stock');
            $this->db->where('tbl_material_info_idtbl_material_info', $materialID);
            $this->db->where('status', 1);
            $this->db->order_by('qty', 'ASC');

            $respondstock=$this->db->get();

            $balqty=$qtybom*$qty;
            foreach($respondstock->result() as $rowstocklist){
                if($balqty>0){
                    if($rowstocklist->qty>=$balqty){
                        $dedqty=$rowstocklist->qty-$balqty;
                        $balqty=0;
                    }
                    else{
                        $dedqty=0;
                        $balqty=$balqty-$rowstocklist->qty;
                    }

                    $batchno=$rowstocklist->batchno;

                    $datastockupdate = array(
                        'qty'=> $dedqty, 
                        'updateuser'=> $userID, 
                        'updatedatetime'=> $updatedatetime
                    );

                    $this->db->where('batchno', $batchno);
                    $this->db->where('tbl_material_info_idtbl_material_info', $materialID);
                    $this->db->update('tbl_stock', $datastockupdate);
                }
                else{
                    break;
                }
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
            $obj->status=1;          
            $obj->action=$actionJSON;  
            
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
            $obj->status=0;          
            $obj->action=$actionJSON;  
            
            echo json_encode($obj);
        }
    }
    public function Getothercosttype(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `idtbl_expence_type`, `expencetype` FROM `tbl_expence_type` WHERE `status`=? AND `idtbl_expence_type` NOT IN (SELECT `tbl_expence_type_idtbl_expence_type` FROM `tbl_semi_other_cost` WHERE `status`=? AND `tbl_semi_production_idtbl_semi_production`=?)";
        $respond=$this->db->query($sql, array(1, 1, $recordID));  

        echo json_encode($respond->result());
    }
    public function Othercostinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $semiproductionID=$this->input->post('semiproductionID');
        $tableData=$this->input->post('tableData');
        $updatedatetime=date('Y-m-d H:i:s');

        foreach($tableData as $rowdatalist){
            $costtype=$rowdatalist['col_1'];
            $costtypeID=$rowdatalist['col_2'];
            $perunit=$rowdatalist['col_3'];
            $amount=$rowdatalist['col_4'];

            $this->db->select('SUM(qty) AS `sumqty`');
            $this->db->from('tbl_semi_production_detail');
            $this->db->where('tbl_semi_production_idtbl_semi_production', $semiproductionID);
            $this->db->where('status', 1);

            $respond=$this->db->get();

            if($perunit==0){
                $perunitcost=$amount/$respond->row(0)->sumqty;
            }
            else{
                $perunitcost=$amount;
            }

            $data = array(
                'costunit'=> $perunitcost, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID, 
                'tbl_semi_production_idtbl_semi_production'=> $semiproductionID, 
                'tbl_expence_type_idtbl_expence_type'=> $costtypeID
            );
            $this->db->insert('tbl_semi_other_cost', $data);
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
            $obj->status=1;          
            $obj->action=$actionJSON;  
            
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
            $obj->status=0;          
            $obj->action=$actionJSON;  
            
            echo json_encode($obj);
        }
    }
    public function Viewalreadyothercost(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_semi_other_cost`.`costunit`, `tbl_expence_type`.`expencetype` FROM `tbl_semi_other_cost` LEFT JOIN `tbl_expence_type` ON `tbl_expence_type`.`idtbl_expence_type`=`tbl_semi_other_cost`.`tbl_expence_type_idtbl_expence_type` WHERE `tbl_semi_other_cost`.`status`=? AND `tbl_semi_other_cost`.`tbl_semi_production_idtbl_semi_production`=?";
        $respond=$this->db->query($sql, array(1, $recordID)); 
        
        $html='
        <table class="table table-striped table-bordered table-sm small">
            <thead>
                <tr>
                    <th>Cost Type</th>
                    <th class="text-right">Per Unit</th>
                </tr>
            </thead>
            <tbody>
        ';
        foreach($respond->result() AS $rowcotlist){
            $html.='
                <tr>
                    <td>'.$rowcotlist->expencetype.'</td>
                    <td class="text-right">'.$rowcotlist->costunit.'</td>
                </tr>
            ';
        }
        $html.='</tbody></table>';

        echo $html;
    }
    public function Semiproductiondetails(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_semi_production_detail`.`qty`, `tbl_semi_production_detail`.`unitprice`, `tbl_semi_production_detail`.`total`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname` FROM `tbl_semi_production_detail` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_semi_production_detail`.`tbl_material_info_idtbl_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` WHERE `tbl_semi_production_detail`.`status`=? AND `tbl_semi_production_detail`.`tbl_semi_production_idtbl_semi_production`=?";
        $respond=$this->db->query($sql, array(1, $recordID)); 

        $sqlother="SELECT SUM(`costunit`) AS `sumcost` FROM `tbl_semi_other_cost` WHERE `status`=? AND `tbl_semi_production_idtbl_semi_production`=?";
        $respondother=$this->db->query($sqlother, array(1, $recordID)); 
        
        $html='
        <table class="table table-striped table-bordered table-sm small">
            <thead>
                <tr>
                    <th>Material Code</th>
                    <th>Material Name</th>
                    <th>Qty</th>
                    <th class="text-right">Unit Price</th>
                    <th class="text-right">Other Cost Per Unit</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
        ';
        foreach($respond->result() AS $rowcotlist){
            $html.='
                <tr>
                    <td>'.$rowcotlist->materialinfocode.'</td>
                    <td>'.$rowcotlist->materialname.'</td>
                    <td>'.$rowcotlist->qty.'</td>
                    <td class="text-right">'.number_format($rowcotlist->unitprice, 2).'</td>
                    <td class="text-right">'.number_format($respondother->row(0)->sumcost, 2).'</td>
                    <td class="text-right">'.number_format((($rowcotlist->unitprice+$respondother->row(0)->sumcost)*$rowcotlist->qty), 2).'</td>
                </tr>
            ';
        }
        $html.='</tbody></table>';

        echo $html;
    }
    public function Semiproductiontransfer($x){
        $this->db->trans_begin();

        $recordID=$x;
        $userID=$_SESSION['userid'];
        $updatedatetime=date('Y-m-d H:i:s');
        $today=date('Y-m-d');

        $datasemiproduction = array(
            'grnstatus'=> '1', 
            'updateuser'=> $userID, 
            'updatedatetime'=> $updatedatetime
        );

        $this->db->where('idtbl_semi_production', $recordID);
        $this->db->update('tbl_semi_production', $datasemiproduction);

        $this->db->select('qty, semimaterial');
        $this->db->from('tbl_semi_production_detail');
        $this->db->where('tbl_semi_production_idtbl_semi_production', $recordID);
        $this->db->where('status', 1);
        $this->db->limit(1); 

        $respond=$this->db->get();

        $this->db->select('SUM(`unitprice`) AS `sumunitprice`');
        $this->db->from('tbl_semi_production_detail');
        $this->db->where('tbl_semi_production_idtbl_semi_production', $recordID);
        $this->db->where('status', 1);

        $respondunit=$this->db->get();

        $sqlother="SELECT SUM(`costunit`) AS `sumcost` FROM `tbl_semi_other_cost` WHERE `status`=? AND `tbl_semi_production_idtbl_semi_production`=?";
        $respondother=$this->db->query($sqlother, array(1, $recordID)); 

        $semiproduct=$respond->row(0)->semimaterial;
        $semiqty=$respond->row(0)->qty;
        $semicostprice=$respondunit->row(0)->sumunitprice+$respondother->row(0)->sumcost;

        $semitotal=$semiqty*$semicostprice;  
        $materialcode='RM';
        $suppliercode='DIR';

        $sqlgrncount="SELECT COUNT(*) AS `count` FROM `tbl_grn`";
        $respondgrncount=$this->db->query($sqlgrncount);
    
        if($respondgrncount->row(0)->count==0){$batchno=date('dmY').'001';}
        else{
            $count='000'.($respondgrncount->row(0)->count+1);
            $count=substr($count, -3);
            $batchno=date('dmY').$count;
        }
    
        $batchnofinal = $suppliercode.$materialcode.$batchno;

        // Purchase Order Insert Start
        $dataporder = array(
            'orderdate'=> $today, 
            'duedate'=> NULL, 
            'subtotal'=> $semitotal, 
            'discount'=> '0', 
            'discountamount'=> '0', 
            'nettotal'=> $semitotal, 
            'confirmstatus'=> '1', 
            'grnconfirm'=> '1', 
            'remark'=> '', 
            'status'=> '1', 
            'insertdatetime'=> $updatedatetime, 
            'tbl_user_idtbl_user'=> $userID, 
            'tbl_location_idtbl_location'=> '1', 
            'tbl_supplier_idtbl_supplier'=> '1', 
            'tbl_order_type_idtbl_order_type'=> '1'
        );

        $this->db->insert('tbl_porder', $dataporder);

        $porderID=$this->db->insert_id();

        $dataporderdetail = array(
            'qty'=> $semiqty, 
            'unitprice'=> $semicostprice, 
            'discount'=> '0', 
            'discountamount'=> '0', 
            'comment'=> '', 
            'status'=> '1', 
            'insertdatetime'=> $updatedatetime,
            'tbl_porder_idtbl_porder'=> $porderID, 
            'tbl_material_info_idtbl_material_info'=> $semiproduct
        );

        $this->db->insert('tbl_porder_detail', $dataporderdetail);
        // Purchase Order Insert End

        // GRN Insert Start
        $datagrn = array(
            'batchno'=> $batchnofinal, 
            'grntype'=> '2', 
            'grndate'=> $today, 
            'total'=> $semitotal, 
            'invoicenum'=> '', 
            'dispatchnum'=> '', 
            'approvestatus'=> '1', 
            'qualitycheck'=> '1', 
            'transportcost'=> '0', 
            'unloadingcost'=> 0, 
            'status'=> '1', 
            'insertdatetime'=> $updatedatetime, 
            'tbl_user_idtbl_user'=> $userID, 
            'tbl_supplier_idtbl_supplier'=> '1', 
            'tbl_location_idtbl_location'=> '1', 
            'tbl_porder_idtbl_porder'=> $porderID, 
            'tbl_order_type_idtbl_order_type'=> '1'
        );

        $this->db->insert('tbl_grn', $datagrn);

        $grnID=$this->db->insert_id();

        $datagrndetail = array(
            'date'=> $today, 
            'qty'=> $semiqty, 
            'unitprice'=> $semicostprice, 
            'costunitprice'=> $semicostprice, 
            'total'=> $semitotal, 
            'comment'=> '', 
            'mfdate'=> $today, 
            'expdate'=> '', 
            'quater'=> '', 
            'actualqty'=> '', 
            'status'=> '1', 
            'insertdatetime'=> $updatedatetime, 
            'tbl_grn_idtbl_grn'=> $grnID, 
            'tbl_material_info_idtbl_material_info'=> $semiproduct
        );

        $this->db->insert('tbl_grndetail', $datagrndetail);
        // GRN Insert End

        $datastock = array(
            'batchno'=> $batchnofinal, 
            'qty'=> $semiqty, 
            'status'=> '1', 
            'insertdatetime'=> $updatedatetime, 
            'tbl_user_idtbl_user'=> $userID, 
            'tbl_material_info_idtbl_material_info'=> $semiproduct
        );

        $this->db->insert('tbl_stock', $datastock);

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
            redirect('Semiproduction');                
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
            redirect('Semiproduction');
        }
    }
}