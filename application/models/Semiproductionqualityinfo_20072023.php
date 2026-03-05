<?php
class Semiproductionqualityinfo extends CI_Model{
    public function Productionpackqualityform(){

        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_quality_subcategory`.`idtbl_quality_subcategory`, `tbl_quality_subcategory`.`qualitysubcategory`, `tbl_quality_subcategory`.`inputtype` FROM `tbl_quality_subcategory` LEFT JOIN `tbl_quality_category` ON `tbl_quality_category`.`idtbl_quality_category`=`tbl_quality_subcategory`.`tbl_quality_category_idtbl_quality_category` WHERE `tbl_quality_subcategory`.`status`=? AND `tbl_quality_category`.`idtbl_quality_category`=?";
        $respond=$this->db->query($sql, array(1, 2));

        $sqlmaterial="SELECT `tbl_material_info`.`materialinfocode`, `tbl_material_info`.`idtbl_material_info`, `tbl_material_code`.`materialname`
        FROM `tbl_material_info`
        LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code`
        LEFT JOIN `tbl_semi_production_detail` ON `tbl_semi_production_detail`.`tbl_material_info_idtbl_material_info`=`tbl_material_info`.`idtbl_material_info`
        WHERE `tbl_semi_production_detail`.`status`=? AND `tbl_semi_production_detail`.`tbl_semi_production_idtbl_semi_production`=? 
        AND `tbl_material_info`.`idtbl_material_info` NOT IN (SELECT `tbl_material_info_idtbl_material_info` FROM `tbl_quality_info` WHERE `status`=? AND `tbl_semi_production_idtbl_semi_production`=?)";
        $respondmaterial=$this->db->query($sqlmaterial, array(1, $recordID, 1, $recordID));

        $html='';
        $html='
        <div class="form-row">
        <div class="col">
            <label class="small font-weight-bold text-dark">Material</label>
            <select name="materialinfo" id="materialinfo" class="form-control form-control-sm">
                <option value="">Select</option>';
                foreach($respondmaterial->result() AS $rowmateriallist){
                    $html.='<option value="'.$rowmateriallist->idtbl_material_info.'">'.$rowmateriallist->materialname.' - '.$rowmateriallist->materialinfocode.'</option>';
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
                        <input type="text" name="qualityform[]" class="form-control form-control-sm">
                        <input type="hidden" name="qualityformhide[]" value="'.$rowqualitylist->idtbl_quality_subcategory.'">
                    </div>
                </div>
                ';
            }
            else if($rowqualitylist->inputtype==2){
                $html.='
                <label class="small font-weight-bold text-dark">'.$rowqualitylist->qualitysubcategory.'</label><br>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="passfail1" name="qualityform[]" class="custom-control-input" value="1">
                    <label class="custom-control-label" for="passfail1">Pass</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="passfail2" name="qualityform[]" class="custom-control-input" value="0" checked>
                    <label class="custom-control-label" for="passfail2">Fail</label>
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
                        <textarea name="qualityform[]" class="form-control form-control-sm"></textarea>
                    </div>
                </div>
                <input type="hidden" name="qualityformhide[]" value="'.$rowqualitylist->idtbl_quality_subcategory.'">
                ';
            }
        }
        echo $html;
    }

    public function Productionpackqualityinsertupdate(){
        $fieldlist=$this->input->post('qualityform');
        $hideproductionmaterial=$this->input->post('hideproductionmaterial');
        $qualityformhide=$this->input->post('qualityformhide');
        $materialinfo=$this->input->post('materialinfo');
        $hideproductionmaterial=$this->input->post('hideproductionmaterial');
        $qualitycategoryID=2;

        $userID=$_SESSION['userid'];
        $updatedatetime=date('Y-m-d H:i:s');

        $i=0;
        foreach($qualityformhide as $subcategorylist){
            $descorstatus=$fieldlist[$i];
            $subcategoryID=$subcategorylist;

            $data = array(
                'descstatus'=> $descorstatus, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime,
                'tbl_material_info_idtbl_material_info'=> $materialinfo,
                'tbl_semi_production_idtbl_semi_production'=> $hideproductionmaterial,  
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

        $sql="SELECT `tbl_semi_production_detail`.`qty`,  `tbl_semi_production`.`idtbl_semi_production`, `tbl_semi_production_detail`.`unitprice`, `tbl_semi_production_detail`.`total`, `tbl_material_info`.`materialinfocode`, `tbl_material_info`.`idtbl_material_info`, `tbl_material_code`.`materialname`, `tbl_unit`.`unitcode` FROM `tbl_semi_production_detail` LEFT JOIN `tbl_semi_production` ON `tbl_semi_production`.`idtbl_semi_production`=`tbl_semi_production_detail`.`tbl_semi_production_idtbl_semi_production` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_semi_production_detail`.`tbl_material_info_idtbl_material_info` LEFT JOIN `tbl_unit` ON `tbl_unit`.`idtbl_unit`=`tbl_material_info`.`tbl_unit_idtbl_unit` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` WHERE `tbl_semi_production_detail`.`status`=? AND `tbl_semi_production_detail`.`tbl_semi_production_idtbl_semi_production`=?";
        $respond=$this->db->query($sql, array(1, $recordID)); 

        $sqlother="SELECT SUM(`costunit`) AS `sumcost` FROM `tbl_semi_other_cost` WHERE `status`=? AND `tbl_semi_production_idtbl_semi_production`=?";
        $respondother=$this->db->query($sqlother, array(1, $recordID)); 
        
        $html='
        <table class="table table-striped table-bordered table-sm small">
            <thead>
                <tr>
                    <th>Material Code</th>
                    <th>Material Name</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
        ';
        foreach($respond->result() AS $rowcotlist){
            $html.='
                <tr>
                    <td>'.$rowcotlist->materialinfocode.'</td>
                    <td>'.$rowcotlist->materialname.'</td>
                    
                    <td class="text-right">
                    <a href="' . base_url() . 'Semiproductionquality/Semiproductionqualitycheckreport/' . $rowcotlist->idtbl_semi_production . '/' . $rowcotlist->idtbl_material_info .'"
                    class="btn btn-warning btn-sm float-right ml-1" target="_blank"><i class="fas fa-file"></i></a>                
                        <button type="button" id="' . $rowcotlist->idtbl_semi_production . '"
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
        WHERE `tbl_quality_info`.`tbl_semi_production_idtbl_semi_production`=? AND `tbl_quality_info`.`status`=?";

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

        $updatesql="SELECT `tbl_quality_info`.`tbl_semi_production_idtbl_semi_production`, `tbl_material_info`.`idtbl_material_info`,`tbl_material_info`.`materialinfocode`, `tbl_quality_info`.`descstatus`, `tbl_quality_subcategory`.`idtbl_quality_subcategory`, `tbl_quality_subcategory`.`qualitysubcategory`, `tbl_quality_subcategory`.`inputtype` FROM `tbl_quality_subcategory`
        LEFT JOIN `tbl_quality_info` ON `tbl_quality_subcategory`.`idtbl_quality_subcategory`=`tbl_quality_info`.`tbl_quality_subcategory_idtbl_quality_subcategory`
    LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_quality_info`.`tbl_material_info_idtbl_material_info`     
       LEFT JOIN `tbl_quality_category` ON `tbl_quality_category`.`idtbl_quality_category`=`tbl_quality_subcategory`.`tbl_quality_category_idtbl_quality_category` WHERE `tbl_quality_subcategory`.`status`=? AND `tbl_quality_category`.`idtbl_quality_category`=? AND `tbl_quality_info`.`tbl_semi_production_idtbl_semi_production`=? AND `tbl_quality_info`.`status`=?";
        $updaterespond=$this->db->query($updatesql, array(1, 2, $recordID, 1));

        $updatesql="SELECT `tbl_material_info`.`idtbl_material_info`,`tbl_material_info`.`materialinfocode`, `tbl_quality_info`.`descstatus`, `tbl_quality_subcategory`.`idtbl_quality_subcategory`, `tbl_quality_subcategory`.`qualitysubcategory`, `tbl_quality_subcategory`.`inputtype` FROM `tbl_quality_subcategory`
        LEFT JOIN `tbl_quality_info` ON `tbl_quality_subcategory`.`idtbl_quality_subcategory`=`tbl_quality_info`.`tbl_quality_subcategory_idtbl_quality_subcategory`
    LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_quality_info`.`tbl_material_info_idtbl_material_info`     
       LEFT JOIN `tbl_quality_category` ON `tbl_quality_category`.`idtbl_quality_category`=`tbl_quality_subcategory`.`tbl_quality_category_idtbl_quality_category` WHERE `tbl_quality_subcategory`.`status`=? AND `tbl_quality_category`.`idtbl_quality_category`=? AND `tbl_quality_info`.`tbl_semi_production_idtbl_semi_production`=? AND `tbl_quality_info`.`status`=?";
        $updaterespond=$this->db->query($updatesql, array(1, 2, $recordID, 1));


        $r=1;
        $html='';

        foreach($updaterespond->result() as $rowupdatequalitylist){
            if($rowupdatequalitylist->inputtype==1){
                $html.='
                <div class="form-row">
                <div class="col">
                    <label class="small font-weight-bold text-dark d-none">Material</label>
                    <input type="text" name="hidematerialinfo" id="hidematerialinfo" class="form-control form-control-sm d-none" value="'.$rowupdatequalitylist->idtbl_material_info.'">
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
        $editqualitycategoryID=2;

        $userID=$_SESSION['userid'];
        $updatedatetime=date('Y-m-d H:i:s');

        // $this->db->where('tbl_grn_idtbl_grn', $editedgrnid);
        // $this->db->delete('tbl_quality_info');

        $data = array( 
            'status'=> 3,

        );
        $this->db->where('tbl_semi_production_idtbl_semi_production', $editedproductionid);
        $respond = $this->db->update('tbl_quality_info', $data);

        $i=0;
        foreach($editqualityformhide as $editsubcategorylist){
            $editdescorstatus=$this->input->post('editqualityform'.$editsubcategorylist);
            $editsubcategoryID=$editsubcategorylist;

            $data = array(
                'descstatus'=> $editdescorstatus, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime,
                'tbl_material_info_idtbl_material_info'=> $editmaterialinfo, 
                'tbl_semi_production_idtbl_semi_production'=> $editedproductionid,
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