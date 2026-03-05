<?php
class Productionpackingqualityinfo extends CI_Model{
    public function Productionpackqualityform(){

        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_quality_subcategory`.`idtbl_quality_subcategory`, `tbl_quality_subcategory`.`qualitysubcategory`, `tbl_quality_subcategory`.`inputtype` FROM `tbl_quality_subcategory` LEFT JOIN `tbl_quality_category` ON `tbl_quality_category`.`idtbl_quality_category`=`tbl_quality_subcategory`.`tbl_quality_category_idtbl_quality_category` WHERE `tbl_quality_subcategory`.`status`=? AND `tbl_quality_category`.`idtbl_quality_category`=?";
        $respond=$this->db->query($sql, array(1, 3));

        $sqlmaterial="SELECT `tbl_product`.`idtbl_product`, `tbl_product`.`productcode` FROM `tbl_product` LEFT JOIN `tbl_production_orderdetail` ON `tbl_product`.`idtbl_product` = `tbl_production_orderdetail`.`tbl_product_idtbl_product`LEFT JOIN `tbl_production_order` ON `tbl_production_order`.`idtbl_production_order` = `tbl_production_orderdetail`.`tbl_production_order_idtbl_production_order` WHERE `tbl_product`.`status`=? AND `tbl_production_orderdetail`.`tbl_production_order_idtbl_production_order` = ? AND `tbl_product`.`idtbl_product` NOT IN (SELECT `tbl_product_idtbl_product` FROM `tbl_quality_info` WHERE `status` = ? AND `tbl_production_order_idtbl_production_order` = ?)";
        $respondmaterial=$this->db->query($sqlmaterial, array(1, $recordID, 1, $recordID));

        $r=1;
        $html='';

        $html='
        <div class="form-row">
        <div class="col">
            <label class="small font-weight-bold text-dark">Product</label>
            <select name="materialinfo" id="materialinfo" class="form-control form-control-sm">
                <option value="">Select</option>';
                foreach($respondmaterial->result() AS $rowmateriallist){
                    $html.='<option value="'.$rowmateriallist->idtbl_product.'">'.$rowmateriallist->productcode.'</option>';
                }
            $html.='</select>
        </div>
    </div>
    ';
    foreach($respond->result() as $rowqualitylist){
        if($rowqualitylist->inputtype==1){
            $html.='
            <div class="form-row">
                <div class="col">
                    <label class="small font-weight-bold text-dark">'.$rowqualitylist->qualitysubcategory.'</label>
                    <input type="text" name="qualityform'.$rowqualitylist->idtbl_quality_subcategory.'" class="form-control form-control-sm">
                    <input type="hidden" name="qualityformhide[]" value="'.$rowqualitylist->idtbl_quality_subcategory.'">
                </div>
            </div>
            ';
        }
        else if($rowqualitylist->inputtype==2){
            $html.='
            <label class="small font-weight-bold text-dark">'.$rowqualitylist->qualitysubcategory.'</label><br>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="passfail'.$r.'" name="qualityform'.$rowqualitylist->idtbl_quality_subcategory.'" class="custom-control-input" value="1">
                <label class="custom-control-label" for="passfail'.$r.'">Pass</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="passfailsecond'.$r.'" name="qualityform'.$rowqualitylist->idtbl_quality_subcategory.'" class="custom-control-input" value="0" checked>
                <label class="custom-control-label" for="passfailsecond'.$r.'">Fail</label>
            </div>
            <input type="hidden" name="qualityformhide[]" value="'.$rowqualitylist->idtbl_quality_subcategory.'">
            ';
        }
        else if($rowqualitylist->inputtype==3){

        }
        else if($rowqualitylist->inputtype==4){
            $html.='
            <div class="form-row">
                <div class="col">
                    <label class="small font-weight-bold text-dark">'.$rowqualitylist->qualitysubcategory.'</label>
                    <textarea name="qualityform'.$rowqualitylist->idtbl_quality_subcategory.'" class="form-control form-control-sm"></textarea>
                </div>
            </div>
            <input type="hidden" name="qualityformhide[]" value="'.$rowqualitylist->idtbl_quality_subcategory.'">
            ';
        }
        if($rowqualitylist->inputtype==5){
            $html.='
            <div class="form-row">
                <div class="col">
                    <label class="small font-weight-bold text-dark">'.$rowqualitylist->qualitysubcategory.'</label>
                    <input type="datetime-local" name="qualityform'.$rowqualitylist->idtbl_quality_subcategory.'" class="form-control form-control-sm">
                    <input type="hidden" name="qualityformhide[]" value="'.$rowqualitylist->idtbl_quality_subcategory.'">
                </div>
            </div>
            ';
        }
        $r++;
    }
        echo $html;
    }

    public function Productionpackqualityinsertupdate(){
        $fieldlist=$this->input->post('qualityform');
        $hideproductionmaterial=$this->input->post('hideproductionmaterial');
        $qualityformhide=$this->input->post('qualityformhide');
        $materialinfo=$this->input->post('materialinfo');
        $hideproductionmaterial=$this->input->post('hideproductionmaterial');
        $qualitycategoryID=3;

        $userID=$_SESSION['userid'];
        $updatedatetime=date('Y-m-d H:i:s');

        $i=0;
        foreach($qualityformhide as $subcategorylist){
            $descorstatus=$this->input->post('qualityform'.$subcategorylist);
            $subcategoryID=$subcategorylist;

            $data = array(
                'descstatus'=> $descorstatus, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime,
                'tbl_product_idtbl_product'=> $materialinfo,
                'tbl_production_order_idtbl_production_order'=> $hideproductionmaterial,  
                'tbl_quality_category_idtbl_quality_category'=> $qualitycategoryID, 
                'tbl_quality_subcategory_idtbl_quality_subcategory'=> $subcategoryID,
                'tbl_user_idtbl_user'=> $userID
            );

            $this->db->insert('tbl_quality_info', $data);

            $i++;
        }

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

    public function Semiproductiondetails(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_production_order`.`idtbl_production_order`,`tbl_product`.`idtbl_product`, `tbl_product`.`productcode` FROM `tbl_product` LEFT JOIN `tbl_production_orderdetail` ON `tbl_product`.`idtbl_product` = `tbl_production_orderdetail`.`tbl_product_idtbl_product`LEFT JOIN `tbl_production_order` ON `tbl_production_order`.`idtbl_production_order` = `tbl_production_orderdetail`.`tbl_production_order_idtbl_production_order` WHERE `tbl_product`.`status`=? AND `tbl_production_orderdetail`.`tbl_production_order_idtbl_production_order` = ?";
        $respond=$this->db->query($sql, array(1, $recordID)); 

        
        $html='
        <table class="table table-striped table-bordered table-sm small">
            <thead>
                <tr>
                    <th>Product Code</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
        ';
        foreach($respond->result() AS $rowcotlist){
            $html.='
                <tr>
                    <td>'.$rowcotlist->productcode.'</td>
                    
                    <td class="text-right">
                    <a href="' . base_url() . 'Productionpackingquality/Productionpackingqualityreport/' . $rowcotlist->idtbl_production_order .'"
                    class="btn btn-warning btn-sm float-right ml-1" target="_blank"><i class="fas fa-file"></i></a>
                        <button type="button" id="' . $rowcotlist->idtbl_production_order . '"
                            class="btnViewqualityinfo btn btn-primary btn-sm float-right" data-toggle="modal"
                            data-target="#exampleModal">
                            <i class="fas fa-eye"></i>
                        </button>
                    </td>
                </tr>
            ';
        }
        $html.='</tbody></table>';

        echo $html;
    }

    public function Getqualityviewdescription(){

        $recordID=$this->input->post('recordID');
        $html='';

        $sql="SELECT IFNULL(`tblel`.`ds`, `tbl_quality_info`.`descstatus`) As descstatus,`tbl_quality_subcategory`.`qualitysubcategory` FROM `tbl_quality_info` 
        LEFT JOIN `tbl_quality_subcategory` ON `tbl_quality_subcategory`.`idtbl_quality_subcategory`=`tbl_quality_info`.`tbl_quality_subcategory_idtbl_quality_subcategory`
        LEFT JOIN(SELECT 1 AS type, 'PASS' AS ds, 2 As el UNION ALL SELECT 0 AS type, 'FAIL' AS ds, 2 As el) As tblel ON (`tbl_quality_info`.`descstatus`=`tblel`.`type` AND `tbl_quality_subcategory`.`inputtype`=`tblel`.`el`)
        WHERE `tbl_quality_info`.`tbl_production_order_idtbl_production_order`=? AND `tbl_quality_info`.`status`=?";

        $respond=$this->db->query($sql, array($recordID, 1));

        foreach($respond->result() as $rowlist){
            $html.='

            <ul>
                <li>

                    <label for="">'.$rowlist->qualitysubcategory.' : <span>&nbsp;'.$rowlist->descstatus.'</span></label>
                </li>
            </ul>

            
            ';
        }

        echo $html;
    }

    public function Editproductionqualityinfo(){
        $recordID=$this->input->post('recordID');

        $updatesql="SELECT `tbl_quality_info`.`tbl_production_order_idtbl_production_order`, `tbl_product`.`idtbl_product`,`tbl_product`.`productcode`, `tbl_quality_info`.`descstatus`, `tbl_quality_subcategory`.`idtbl_quality_subcategory`, `tbl_quality_subcategory`.`qualitysubcategory`, `tbl_quality_subcategory`.`inputtype` FROM `tbl_quality_subcategory`
        LEFT JOIN `tbl_quality_info` ON `tbl_quality_subcategory`.`idtbl_quality_subcategory`=`tbl_quality_info`.`tbl_quality_subcategory_idtbl_quality_subcategory`
    LEFT JOIN `tbl_product` ON `tbl_product`.`idtbl_product`=`tbl_quality_info`.`tbl_product_idtbl_product`     
       LEFT JOIN `tbl_quality_category` ON `tbl_quality_category`.`idtbl_quality_category`=`tbl_quality_subcategory`.`tbl_quality_category_idtbl_quality_category` WHERE `tbl_quality_subcategory`.`status`=? AND `tbl_quality_category`.`idtbl_quality_category`=? AND `tbl_quality_info`.`tbl_production_order_idtbl_production_order`=? AND `tbl_quality_info`.`status`=?";
        $updaterespond=$this->db->query($updatesql, array(1, 3, $recordID, 1));

        $updatesql="SELECT `tbl_product`.`idtbl_product`,`tbl_product`.`productcode`, `tbl_quality_info`.`descstatus`, `tbl_quality_subcategory`.`idtbl_quality_subcategory`, `tbl_quality_subcategory`.`qualitysubcategory`, `tbl_quality_subcategory`.`inputtype` FROM `tbl_quality_subcategory`
        LEFT JOIN `tbl_quality_info` ON `tbl_quality_subcategory`.`idtbl_quality_subcategory`=`tbl_quality_info`.`tbl_quality_subcategory_idtbl_quality_subcategory`
    LEFT JOIN `tbl_product` ON `tbl_product`.`idtbl_product`=`tbl_quality_info`.`tbl_product_idtbl_product`     
       LEFT JOIN `tbl_quality_category` ON `tbl_quality_category`.`idtbl_quality_category`=`tbl_quality_subcategory`.`tbl_quality_category_idtbl_quality_category` WHERE `tbl_quality_subcategory`.`status`=? AND `tbl_quality_category`.`idtbl_quality_category`=? AND `tbl_quality_info`.`tbl_production_order_idtbl_production_order`=? AND `tbl_quality_info`.`status`=?";
        $updaterespond=$this->db->query($updatesql, array(1, 3, $recordID, 1));


        $r=1;
        $html='';

        foreach($updaterespond->result() as $rowupdatequalitylist){
            if($rowupdatequalitylist->inputtype==1){
                $html.='
                <div class="form-row">
                <div class="col">
                    <label class="small font-weight-bold text-dark d-none">Material</label>
                    <input type="text" name="hidematerialinfo" id="hidematerialinfo" class="form-control form-control-sm d-none" value="'.$rowupdatequalitylist->idtbl_product.'">
                </div>
            </div>
                <div class="form-row">
                    <div class="col">
                        <label class="small font-weight-bold text-dark">'.$rowupdatequalitylist->qualitysubcategory.'</label>
                        <input type="text" name="editqualityform'.$rowupdatequalitylist->idtbl_quality_subcategory.'" value="'.$rowupdatequalitylist->descstatus.'" class="form-control form-control-sm">
                        <input type="hidden" name="editqualityformhide[]" value="'.$rowupdatequalitylist->idtbl_quality_subcategory.'">
                    </div>
                </div>
                ';
            }
            else if($rowupdatequalitylist->inputtype==2){
                $html.='
                <label class="small font-weight-bold text-dark">'.$rowupdatequalitylist->qualitysubcategory.'</label><br>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="passfail'.$r.'" name="editqualityform'.$rowupdatequalitylist->idtbl_quality_subcategory.'" class="custom-control-input" value="1">
                    <label class="custom-control-label" for="passfail'.$r.'">Pass</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="passfailsecond'.$r.'" name="editqualityform'.$rowupdatequalitylist->idtbl_quality_subcategory.'" class="custom-control-input" value="0" checked>
                    <label class="custom-control-label" for="passfailsecond'.$r.'">Fail</label>
                </div>
                <input type="hidden" name="editqualityformhide[]" value="'.$rowupdatequalitylist->idtbl_quality_subcategory.'">
                ';
            }
            else if($rowupdatequalitylist->inputtype==3){

            }
            else if($rowupdatequalitylist->inputtype==4){
                $html.='
                <div class="form-row">
                    <div class="col">
                        <label class="small font-weight-bold text-dark">'.$rowupdatequalitylist->qualitysubcategory.'</label>
                        <textarea name="editqualityform'.$rowupdatequalitylist->idtbl_quality_subcategory.'" value="'.$rowupdatequalitylist->descstatus.'" class="form-control form-control-sm"></textarea>
                    </div>
                </div>
                <input type="hidden" name="editqualityformhide[]" value="'.$rowupdatequalitylist->idtbl_quality_subcategory.'">
                ';
            }
            if($rowupdatequalitylist->inputtype==5){
                $html.='
                <div class="form-row">
                    <div class="col">
                        <label class="small font-weight-bold text-dark">'.$rowupdatequalitylist->qualitysubcategory.'</label>
                        <input type="datetime-local" name="qualityform'.$rowupdatequalitylist->idtbl_quality_subcategory.'" value="'.$rowupdatequalitylist->descstatus.'" class="form-control form-control-sm">
                        <input type="hidden" name="qualityformhide[]" value="'.$rowupdatequalitylist->idtbl_quality_subcategory.'">
                    </div>
                </div>
                ';
            }
            $r++;
        }
        echo $html;
    }

    public function Newproductioninqualitysertupdate(){
        $this->db->trans_begin();
        // $fieldlist=$this->input->post('qualityform');
        $editedproductionmaterial=$this->input->post('editedproductionmaterial');
        $editmainpassfail=$this->input->post('editmainpassfail');
        $editqualityformhide=$this->input->post('editqualityformhide');
        $editmaterialinfo=$this->input->post('hidematerialinfo');
        $editedproductionid=$this->input->post('editedproductionid');
        $editqualitycategoryID=3;

        $userID=$_SESSION['userid'];
        $updatedatetime=date('Y-m-d H:i:s');

        // $this->db->where('tbl_grn_idtbl_grn', $editedgrnid);
        // $this->db->delete('tbl_quality_info');

        $data = array( 
            'status'=> 3,

        );
        $this->db->where('tbl_production_order_idtbl_production_order', $editedproductionid);
        $respond = $this->db->update('tbl_quality_info', $data);

        $i=0;
        foreach($editqualityformhide as $editsubcategorylist){
            $editdescorstatus=$this->input->post('editqualityform'.$editsubcategorylist);
            $editsubcategoryID=$editsubcategorylist;

            $data = array(
                'descstatus'=> $editdescorstatus, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime,
                'tbl_product_idtbl_product'=> $editmaterialinfo, 
                'tbl_production_order_idtbl_production_order'=> $editedproductionid,
                'tbl_quality_category_idtbl_quality_category'=> $editqualitycategoryID, 
                'tbl_quality_subcategory_idtbl_quality_subcategory'=> $editsubcategoryID,
                'tbl_user_idtbl_user'=> $userID
            );

            $this->db->insert('tbl_quality_info', $data);

            $i++;
        }


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
}