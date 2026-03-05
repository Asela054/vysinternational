<?php
class Finishgoodbominfo extends CI_Model{
    public function Finishgoodbominsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $finishgood=$this->input->post('finishgood');
        $materialcategory=$this->input->post('materialcategory');
        $materialinfo=$this->input->post('materialinfo');
        $qty=$this->input->post('qty');

        // print_r($materialinfo);

        $updatedatetime=date('Y-m-d H:i:s');

        $i=0;
        foreach($materialcategory as $materialcate){
            $matcate=$materialcate;
            $matinfo=$materialinfo[$i];
            $qtylist=$qty[$i];

            $data = array(
                'qty'=>$qtylist, 
                'status'=>'1', 
                'insertdatetime'=>$updatedatetime, 
                'tbl_user_idtbl_user'=>$userID, 
                'tbl_product_idtbl_product'=>$finishgood, 
                'tbl_material_info_idtbl_material_info'=>$matinfo
            );
            $this->db->insert('tbl_product_bom', $data);
            $i++;
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
            redirect('Finishgoodbom');                
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
            redirect('Finishgoodbom');
        }
    }
    public function Finishgoodbomstatus($x, $y){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $recordID=$x;
        $type=$y;
        
        $updatedatetime=date('Y-m-d H:i:s');

        if($type==1){
            $data = array(
                'status' => '1',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_product_bom', $recordID);
            $this->db->update('tbl_product_bom', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-check';
                $actionObj->title='';
                $actionObj->message='Record Activate Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='success';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Finishgoodbom');                
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
                redirect('Finishgoodbom');
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_product_bom', $recordID);
            $this->db->update('tbl_product_bom', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-times';
                $actionObj->title='';
                $actionObj->message='Record Deactivate Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='warning';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Finishgoodbom');                
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
                redirect('Finishgoodbom');
            }
        }
        else if($type==3){
            $data = array(
                'status' => '3',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_product_bom', $recordID);
            $this->db->update('tbl_product_bom', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-trash-alt';
                $actionObj->title='';
                $actionObj->message='Record Remove Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='danger';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Finishgoodbom');                
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
                redirect('Finishgoodbom');
            }
        }
    }
    public function Finishgoodbomedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('tbl_product_bom.*, tbl_product.productcode, tbl_product.productname, tbl_material_info.materialinfocode , tbl_material_code.materialname');
        $this->db->from('tbl_product_bom');
        $this->db->join('tbl_product', 'tbl_product.idtbl_product = tbl_product_bom.tbl_product_idtbl_product', 'left');
        $this->db->join('tbl_material_info', 'tbl_material_info.idtbl_material_info = tbl_product_bom.tbl_material_info_idtbl_material_info', 'left');
        $this->db->join('tbl_material_code', 'tbl_material_code.idtbl_material_code = tbl_material_info.tbl_material_code_idtbl_material_code', 'left');
        $this->db->where('tbl_product_bom.idtbl_product_bom', $recordID);
        $this->db->where('tbl_product_bom.status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_product_bom;
        $obj->qty=$respond->row(0)->qty;
        $obj->finishgood=$respond->row(0)->tbl_product_idtbl_product;
        $obj->finishgoodtext=$respond->row(0)->productname.' - '.$respond->row(0)->productcode;
        $obj->materialinfo=$respond->row(0)->tbl_material_info_idtbl_material_info ;
        $obj->materialinfotext=$respond->row(0)->materialname.' - '.$respond->row(0)->materialinfocode;

        echo json_encode($obj);
    }
    public function Getfinishgoodlist(){
        $searchTerm=$this->input->post('searchTerm');

        if(!isset($searchTerm)){
            $sql="SELECT `tbl_product`.`idtbl_product`, `tbl_product`.`productcode`, `tbl_material_code`.`materialname` FROM `tbl_product` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_product`.`materialid` WHERE `tbl_product`.`status`=? AND `tbl_product`.`idtbl_product` NOT IN (SELECT `tbl_product_idtbl_product` FROM `tbl_product_bom` WHERE `status`=? GROUP BY `tbl_product_idtbl_product`) LIMIT 5";
            $respond=$this->db->query($sql, array(1, 1));                       
        }
        else{            
            if(!empty($searchTerm)){
                $sql="SELECT `tbl_product`.`idtbl_product`, `tbl_product`.`productcode`, `tbl_material_code`.`materialname` FROM `tbl_product` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_product`.`materialid` WHERE `tbl_product`.`status`=? AND `tbl_product`.`idtbl_product` NOT IN (SELECT `tbl_product_idtbl_product` FROM `tbl_product_bom` WHERE `status`=? GROUP BY `tbl_product_idtbl_product`) AND `tbl_product`.`productcode` LIKE '$searchTerm%'";
                $respond=$this->db->query($sql, array(1, 1));    
            }
            else{
                $sql="SELECT `tbl_product`.`idtbl_product`, `tbl_product`.`productcode`, `tbl_material_code`.`materialname` FROM `tbl_product` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_product`.`materialid` WHERE `tbl_product`.`status`=? AND `tbl_product`.`idtbl_product` NOT IN (SELECT `tbl_product_idtbl_product` FROM `tbl_product_bom` WHERE `status`=? GROUP BY `tbl_product_idtbl_product`) LIMIT 5";
                $respond=$this->db->query($sql, array(1, 1));                
            }
        }
        
        $data=array();
        
        foreach ($respond->result() as $row) {
            $data[]=array("id"=>$row->idtbl_product, "text"=>$row->materialname.' - '.$row->productcode);
        }
        
        echo json_encode($data);
    }
    public function Getmaterialinfolist(){
        $searchTerm=$this->input->post('searchTerm');

        if(!isset($searchTerm)){
            $sql="SELECT `tbl_material_info`.`idtbl_material_info`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname` FROM `tbl_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` WHERE `tbl_material_info`.`status`=? LIMIT 5";
            $respond=$this->db->query($sql, array(1));           
        }
        else{            
            if(!empty($searchTerm)){
                $sql="SELECT `tbl_material_info`.`idtbl_material_info`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname` FROM `tbl_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` WHERE `tbl_material_info`.`status`=? AND `tbl_material_info`.`materialinfocode` LIKE '%$searchTerm%'";
                $respond=$this->db->query($sql, array(1));
            }
            else{
                $sql="SELECT `tbl_material_info`.`idtbl_material_info`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname` FROM `tbl_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` WHERE `tbl_material_info`.`status`=? LIMIT 5";
                $respond=$this->db->query($sql, array(1));
            }
        }
        
        $data=array();
        
        foreach ($respond->result() as $row) {
            $data[]=array("id"=>$row->idtbl_material_info, "text"=>$row->materialname.' - '.$row->materialinfocode);
        }
        
        echo json_encode($data);
    }
    public function Getmaterialcategory(){
        $this->db->select('`idtbl_material_category`, `categoryname`, `categorycode`');
        $this->db->from('tbl_material_category');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getmaterialcategoryedit(){
        $this->db->select('`idtbl_material_category`, `categoryname`, `categorycode`');
        $this->db->from('tbl_material_category');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getmaterialname(){
        $this->db->select('`idtbl_material_info`, `materialname`, `materialinfocode`, `unitcode`');
        $this->db->from('tbl_material_info');
        $this->db->join('tbl_material_code', 'tbl_material_code.idtbl_material_code = tbl_material_info.tbl_material_code_idtbl_material_code', 'left');
        $this->db->join('tbl_unit', 'tbl_unit.idtbl_unit = tbl_material_info.tbl_unit_idtbl_unit', 'left');
        $this->db->where('tbl_material_info.status', 1);

        return $respond=$this->db->get();
    }
    public function Getmaterialinfo(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_material_info`.`idtbl_material_info`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname`, `tbl_unit`.`unitcode` FROM `tbl_material_info` LEFT JOIn `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` LEFT JOIN `tbl_unit` ON `tbl_unit`.`idtbl_unit`=`tbl_material_info`.`tbl_unit_idtbl_unit` WHERE `tbl_material_info`.`tbl_material_category_idtbl_material_category`=? AND `tbl_material_info`.`status`=?";
        $respond=$this->db->query($sql, array($recordID, 1));

        echo json_encode($respond->result());
    } 
    public function Getmaterialinfoedit(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_material_info`.`idtbl_material_info`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname`, `tbl_unit`.`unitcode` FROM `tbl_material_info` LEFT JOIn `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` LEFT JOIN `tbl_unit` ON `tbl_unit`.`idtbl_unit`=`tbl_material_info`.`tbl_unit_idtbl_unit` WHERE `tbl_material_info`.`tbl_material_category_idtbl_material_category`=? AND `tbl_material_info`.`status`=?";
        $respond=$this->db->query($sql, array($recordID, 1));

        echo json_encode($respond->result());
    } 
    public function Finishgoodbomdetails(){

        $recordID=$this->input->post('recordID');
        $html='';

        $sql="SELECT `tbl_product_bom`.`idtbl_product_bom`, `tbl_product_bom`.`tbl_material_info_idtbl_material_info`, `tbl_product_bom`.`qty`, `tbl_material_code`.`materialname`, `tbl_material_code`.`materialcode`, `tbl_material_category`.`categoryname`, `tbl_product`.`productcode`, `tbl_unit`.`unitcode`, `tbl_material_info`.`materialinfocode`
        FROM `tbl_product_bom` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_product_bom`.`tbl_material_info_idtbl_material_info`
                LEFT JOIN `tbl_product` ON `tbl_product`.`idtbl_product`=`tbl_product_bom`.`tbl_product_idtbl_product` LEFT JOIN `tbl_material_category` ON `tbl_material_category`.`idtbl_material_category`=`tbl_material_info`.`tbl_material_category_idtbl_material_category`
                LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code`
                LEFT JOIN `tbl_unit` ON `tbl_unit`.`idtbl_unit`=`tbl_material_info`.`tbl_unit_idtbl_unit` WHERE `tbl_product_idtbl_product`= $recordID AND `tbl_product_bom`.`status`=1
        ";

        $respond=$this->db->query($sql, array(1, $recordID));


        foreach($respond->result() as $rowlist){
            $html.='
            <tr>
            	<td>'.$rowlist->categoryname.'</td>
            	<td>'.$rowlist->materialname.'-'.$rowlist->materialinfocode.'</td>
            	<td>'.$rowlist->qty.$rowlist->unitcode.'</td>
            	<td>
            		<div class="row ml-5"><button type="button" id="'.$rowlist->idtbl_product_bom.'"
            				class="btnEditbom btn btn-primary btn-sm float-right" data-toggle="modal"
            				data-target="#exampleModal">
            				<i class="fas fa-pen"></i>
            			</button>
            			<button type="button" id="'.$rowlist->idtbl_product_bom.'"
            				class="btnDeletebom btn btn-danger btn-sm float-left ml-1" onclick="return delete_confirm()"">
            				<i class="fas fa-trash-alt"></i>
            			</button>
            		</div>
            	</td>

            </tr>
            
            ';
        }

        echo $html;
    }
    public function Finishgoodbomlist(){
        $recordID=$this->input->post('recordID');

        $this->db->select('tbl_product_bom.idtbl_product_bom, tbl_product_bom.tbl_material_info_idtbl_material_info, tbl_product_bom.qty, tbl_material_category.categoryname , tbl_material_code.materialname, tbl_material_code.materialcode');
        $this->db->from('tbl_product_bom');
        $this->db->join('tbl_material_info', 'tbl_material_info.idtbl_material_info = tbl_product_bom.tbl_material_info_idtbl_material_info', 'left');
        $this->db->join('tbl_material_category', 'tbl_material_category.idtbl_material_category = tbl_material_info.tbl_material_category_idtbl_material_category', 'left');
        $this->db->join('tbl_material_code', 'tbl_material_code.idtbl_material_code = tbl_material_info.tbl_material_code_idtbl_material_code', 'left');
        $this->db->where('tbl_product_bom.idtbl_product_bom', $recordID);
        $this->db->where('tbl_product_bom.status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_product_bom;
        $obj->materialcategory=$respond->row(0)->categoryname;
        $obj->materialinfo=$respond->row(0)->tbl_material_info_idtbl_material_info ;
        $obj->qty=$respond->row(0)->qty;


        echo json_encode($obj);
    }
    public function Finishgoodbomlistedit(){

        $userID=$_SESSION['userid'];

        $materialinfo=$this->input->post('name');
        $qty=$this->input->post('quantity');

        $recordID=$this->input->post('recordID');

        $updatedatetime=date('Y-m-d H:i:s');

        $data = array(
            'qty'=>$qty, 
            'status'=> '1', 
            'updatedatetime'=> $updatedatetime, 
            'updateuser'=> $userID,
            'tbl_material_info_idtbl_material_info'=>$materialinfo

        );

        $this->db->where('idtbl_product_bom', $recordID);
        $this->db->update('tbl_product_bom', $data);

        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            
            $actionObj=new stdClass();
            $actionObj->icon='fas fa-save';
            $actionObj->title='';
            $actionObj->message='Record Update Successfully';
            $actionObj->url='';
            $actionObj->target='_blank';
            $actionObj->type='primary';

            $actionJSON=json_encode($actionObj);
            
            $this->session->set_flashdata('msg', $actionJSON);
            redirect('Finishgoodbom');                
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
            redirect('Finishgoodbom');
        }
    }

    public function Finishgoodbomdelete(){
        $recordID=$this->input->post('recordID');

        $sql="UPDATE `tbl_product_bom` SET `status` = 3 WHERE `idtbl_product_bom`=?";

        $respond=$this->db->query($sql, array($recordID));


    }

    public function ViewallBOMdetails(){

        $html = '';

        $sql = "SELECT `tbl_product`.`idtbl_product`, `tbl_product`.`productcode`, `tbl_material_code`.`materialname` FROM `tbl_product` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_product`.`materialid` WHERE `tbl_product`.`status`=?";
        $respond = $this->db->query($sql, array(1)); 

        $bomarray = array();

        foreach ($respond->result() as $rowlist) {
            $productid = $rowlist->idtbl_product;

            $sqlbom = "SELECT `tbl_product_bom`.`qty`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname`, `tbl_unit`.`unitcode` FROM `tbl_product_bom` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_product_bom`.`tbl_material_info_idtbl_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` LEFT JOIN `tbl_unit` ON `tbl_unit`.`idtbl_unit`=`tbl_material_info`.`tbl_unit_idtbl_unit` WHERE `tbl_product_bom`.`tbl_product_idtbl_product`=? AND `tbl_product_bom`.`status`=?";
            $respondbom = $this->db->query($sqlbom, array($productid, 1)); 

            $obj = new stdClass();
            $obj->id = $rowlist->idtbl_product;
            $obj->procode = $rowlist->productcode;
            $obj->matname = $rowlist->materialname;
            $obj->result = $respondbom->result();

            array_push($bomarray, $obj);
        }
        $html.='
        <table class="table table-bordered table-striped table-sm nowrap" id="tblBOM">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Finish Good/Material Code</th>
                <th scope="col">Finish Good/Material Name</th>
                <th scope="col">Quantity</th>
                <th scope="col">Unit</th>
                </tr>
            </thead>
            <tbody>
        ';
        foreach ($bomarray as $bomitem) {
            $html .= '
                <tr class="table-secondary">
                    <td>'.$bomitem->id.'</td>
                    <td>'.$bomitem->procode.'</td>
                    <td>'.$bomitem->matname.'</td>
                    <td></td>
                    <td></td>
                </tr>';
            
            foreach ($bomitem->result as $resultitem) {
                $html .= '
                    <tr>
                        <td></td>
                        <td>'.$resultitem->materialinfocode.'</td>
                        <td>'.$resultitem->materialname.'</td>
                        <td>'.$resultitem->qty.'</td>
                        <td>'.$resultitem->unitcode.'</td>
                    </tr>';
            }
        }
        $html.='</tbody></table>';

        echo $html;

    }

}

