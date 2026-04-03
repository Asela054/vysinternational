<?php
class Productionwastageinfo extends CI_MODEL{

    public function Getgrnnumber(){
        $this->db->select('idtbl_grn');
        $this->db->from('tbl_grn');
        $this->db->where('approvestatus',1);
        $this->db->where('status',1);

        return $respond = $this->db->get();
    }
    public function getBatchByGRN(){

        $grnID = $this->input->post('grn_id');

        $this->db->select('batchno');
        $this->db->from('tbl_grn');
        $this->db->where('idtbl_grn', $grnID);

        $query = $this->db->get();
        $result = $query->row();
        if($result){
            return $result->batchno;
        }else{
            return '';
        }
    }

        public function getFruitType(){
        $this->db->select('`idtbl_fruit_type`, `type`');
        $this->db->from('tbl_fruit_type');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function getProductList(){
        $search = $this->input->post('search');

        $this->db->select('idtbl_product, prodcutname');
        $this->db->from('tbl_product');

        if(!empty($search)){
            $this->db->like('prodcutname', $search);
        }
        $this->db->limit(5); 
        $result = $this->db->get()->result();

        $data = array();

        foreach($result as $row){
            $data[] = array(
                "id" => $row->idtbl_product,
                "text" => $row->prodcutname
            );
        }
        return $data;
    }   

    public function wastageInsertUpdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $companyid=$_SESSION['companyid'];
        $branchid=$_SESSION['branchid'];

        $tableData=$this->input->post('tableData');
        $productionDate=$this->input->post('productionDate');
        $grn=$this->input->post('grn');
        $batchno=$this->input->post('batchno');
        $remark=$this->input->post('remark');

        $updatedatetime=date('Y-m-d H:i:s');


        $data = array(
            'production_date'=> $productionDate,
            'grn_id'=> $grn,
            'batch_no'=> $batchno, 
            'status'=> '1', 
            'insertdatetime'=> $updatedatetime, 
            'check_status' =>'0',
            'remark'=> $remark,
            'tbl_user_idtbl_user'=> $userID
 
        );

        $this->db->insert('tbl_production_wastage', $data);

        $id=$this->db->insert_id();

        foreach($tableData as $rowtabledata){

            $producedQty=$rowtabledata['col_3'];
            $raw=$rowtabledata['col_4'];
            $cutting=$rowtabledata['col_5'];
            $packing=$rowtabledata['col_6'];
            $productID=$rowtabledata['col_7'];
            $fruitTypeID=$rowtabledata['col_8'];

            $dataone = array(
                'tbl_production_wastage_id'=> $id, 
                'tbl_product_id'=> $productID, 
                'produced_qty'=> $producedQty, 
                'tbl_fruit_type_id' => $fruitTypeID,
                'raw'=> $raw,
                'cutting' => $cutting,
                'packing'=> $packing

            );

            $this->db->insert('tbl_production_wastage_details', $dataone);
            //     if(!$this->db->insert('tbl_production_wastage_details', $dataone)){
            //     print_r($this->db->error());
            //     exit;
            // }
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

    public function getWastageDetails(){
        
        $id = $this->input->post('id');

        $this->db->select('pwd.produced_qty, pwd.raw, pwd.cutting, pwd.packing, p.prodcutname, ft.type AS fruittype, u.name AS username, pw.check_status');
        $this->db->from('tbl_production_wastage AS pw');
        $this->db->join('tbl_production_wastage_details AS pwd', 'pwd.tbl_production_wastage_id = pw.idtbl_production_wastage');
        $this->db->join('tbl_product AS p', 'p.idtbl_product = pwd.tbl_product_id','left');
        $this->db->join('tbl_fruit_type AS ft', 'ft.idtbl_fruit_type = pwd.tbl_fruit_type_id','left');
        $this->db->join('tbl_user AS u', 'u.idtbl_user = pw.checked_by','left');
        $this->db->where('pw.idtbl_production_wastage', $id);

        $result = $this->db->get()->row();

         if(!$result){
            echo "No data found";
            return;
        }

        $html = '
        <div class="scrollbar pb-3" id="style-3">
        <table class="table table-striped table-bordered table-sm">
            <tr>
                <th>Fruit Type</th>
                <th>Raw</th>
                <th>Cutting</th>
                <th>Packing</th>
                <th>Product</th>
                <th>Produced Qty</th>
            </tr>
            <tr>
                <td>'.$result-> fruittype.'</td>
                <td>'.$result->raw.'</td>
                <td>'.$result->cutting.'</td>
                <td>'.$result->packing.'</td>
                <td>'.$result->prodcutname.'</td>
                <td>'.$result->produced_qty.'</td>
            </tr>

        </table>
        </div>';

        if($result->check_status == 1){
            $html .= '<p class="text-primary text-right font-weight-bold">Checked By: '.$result->username.'</p>';
            $showButton = false;
        } else {
            $showButton = true; 
        }

        return [
            'status' => 'success',
            'html' => $html,
            'showButton' => $showButton
        ];

    }

    public function markAsChecked(){
        $id = $this->input->post('id');
        $userID=$_SESSION['userid'];

        $this->db->where('idtbl_production_wastage', $id);

        $update = $this->db->update('tbl_production_wastage', [
            'check_status' => 1,
            'checked_by'=> $userID
        ]);

        if($update){
            echo "success";
        } else {
            echo "error";
        }
    }

}