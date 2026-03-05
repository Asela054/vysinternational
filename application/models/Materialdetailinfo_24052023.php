<?php
class Materialdetailinfo extends CI_Model{
    public function Getmaterialcategory(){
        $this->db->select('`idtbl_material_category`, `categoryname`, `categorycode`');
        $this->db->from('tbl_material_category');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getmaterialname(){
        $this->db->select('`idtbl_material_code`, `materialname`, `materialcode`');
        $this->db->from('tbl_material_code');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getbrand(){
        $this->db->select('`idtbl_brand`, `brandname`, `brandcode`');
        $this->db->from('tbl_brand');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getform(){
        $this->db->select('`idtbl_form`, `formname`, `formcode`');
        $this->db->from('tbl_form');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getgrade(){
        $this->db->select('`idtbl_grade`, `gradename`, `gradecode`');
        $this->db->from('tbl_grade');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getsize(){
        $this->db->select('`idtbl_size`, `sizename`, `sizecode`');
        $this->db->from('tbl_size');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getside(){
        $this->db->select('`idtbl_side`, `sidename`, `sidecode`');
        $this->db->from('tbl_side');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getunittype(){
        $this->db->select('`idtbl_unit_type`, `unittypename`, `unittypecode`');
        $this->db->from('tbl_unit_type');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getunit(){
        $this->db->select('`idtbl_unit`, `unitname`, `unitcode`');
        $this->db->from('tbl_unit');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Materialdetailinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $materialcode='';

        $materialname=$this->input->post('materialname');
        $materialmaincode = $this->Materialdetailinfo->Getmaterialcode($materialname);
        $materialcode.=$materialmaincode;
        $materialcategory=$this->input->post('materialcategory');
        $materialcategorycode = $this->Materialdetailinfo->Getmaterialcategorycode($materialcategory);
        $materialcode.='-'.$materialcategorycode;

        if(!empty($this->input->post('brand'))){
            $brand=$this->input->post('brand');
            $brandcode = $this->Materialdetailinfo->Getbrandcode($brand);
            $materialcode.='-'.$brandcode;
        }else{$brand=0;}
        if(!empty($this->input->post('form'))){
            $form=$this->input->post('form');
            $formcode = $this->Materialdetailinfo->Getformcode($form);
            $materialcode.='-'.$formcode;
        }else{$form=0;}
        if(!empty($this->input->post('grade'))){
            $grade=$this->input->post('grade');
            $gradecode = $this->Materialdetailinfo->Getgradecode($grade);
            $materialcode.='-'.$gradecode;
        }else{$grade=0;}
        if(!empty($this->input->post('size'))){
            $size=$this->input->post('size');
            $sizecode = $this->Materialdetailinfo->Getsizecode($size);
            $materialcode.='-'.$sizecode;
        }else{$size=0;}
        if(!empty($this->input->post('side'))){
            $side=$this->input->post('side');
            $sidecode = $this->Materialdetailinfo->Getsidecode($side);
            $materialcode.='-'.$sidecode;
        }else{$side=0;}
        if(!empty($this->input->post('unittype'))){
            $unittype=$this->input->post('unittype');
            $unittypecode = $this->Materialdetailinfo->Getunittypecode($unittype);
            $materialcode.='-'.$unittypecode;
        }else{$unittype=0;}
        $unit=$this->input->post('unit');
        $reorder=$this->input->post('reorder');
        $comment=$this->input->post('comment');  
        $semistatus = $this->input->post('semistatus'); 
        

        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $updatedatetime=date('Y-m-d H:i:s');  

        if($recordOption==1){
            $data = array(
                'materialinfocode'=> $materialcode, 
                'reorderlevel'=> $reorder, 
                'comment'=> $comment, 
                'colour'=> '', 
                'semistatus'=> $semistatus, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID, 
                'tbl_material_code_idtbl_material_code'=> $materialname, 
                'tbl_material_category_idtbl_material_category'=> $materialcategory, 
                'tbl_brand_idtbl_brand'=> $brand, 
                'tbl_unit_idtbl_unit'=> $unit, 
                'tbl_form_idtbl_form'=> $form, 
                'tbl_grade_idtbl_grade'=> $grade, 
                'tbl_size_idtbl_size'=> $size, 
                'tbl_side_idtbl_side'=> $side, 
                'tbl_unit_type_idtbl_unit_type'=> $unittype
            );

            $this->db->insert('tbl_material_info', $data);

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
                redirect('Materialdetail');                
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
                redirect('Materialdetail');
            }
        }
        else{
            $data = array(
                'materialinfocode'=> $materialcode, 
                'reorderlevel'=> $reorder, 
                'comment'=> $comment, 
                'colour'=> '', 
                'semistatus'=> $semistatus, 
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime, 
                'tbl_material_code_idtbl_material_code'=> $materialname, 
                'tbl_material_category_idtbl_material_category'=> $materialcategory, 
                'tbl_brand_idtbl_brand'=> $brand, 
                'tbl_unit_idtbl_unit'=> $unit, 
                'tbl_form_idtbl_form'=> $form, 
                'tbl_grade_idtbl_grade'=> $grade, 
                'tbl_size_idtbl_size'=> $size, 
                'tbl_side_idtbl_side'=> $side, 
                'tbl_unit_type_idtbl_unit_type'=> $unittype
            );

            $this->db->where('idtbl_material_info', $recordID);
            $this->db->update('tbl_material_info', $data);

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
                redirect('Materialdetail');                
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
                redirect('Materialdetail');
            }
        }
    }
    public function Materialdetailstatus($x, $y){
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

            $this->db->where('idtbl_material_info', $recordID);
            $this->db->update('tbl_material_info', $data);

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
                redirect('Materialdetail');                
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
                redirect('Materialdetail');
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_material_info', $recordID);
            $this->db->update('tbl_material_info', $data);

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
                redirect('Materialdetail');                
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
                redirect('Materialdetail');
            }
        }
        else if($type==3){
            $data = array(
                'status' => '3',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_material_info', $recordID);
            $this->db->update('tbl_material_info', $data);

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
                redirect('Materialdetail');                
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
                redirect('Materialdetail');
            }
        }
    }
    public function Materialdetailedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_material_info');
        $this->db->where('idtbl_material_info', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_material_info;
        $obj->reorderlevel=$respond->row(0)->reorderlevel;
        $obj->comment=$respond->row(0)->comment;
        $obj->semistatus=$respond->row(0)->semistatus;
        $obj->materialcode=$respond->row(0)->tbl_material_code_idtbl_material_code;
        $obj->materialcategory=$respond->row(0)->tbl_material_category_idtbl_material_category ;
        $obj->brand=$respond->row(0)->tbl_brand_idtbl_brand;
        $obj->unit=$respond->row(0)->tbl_unit_idtbl_unit;
        $obj->form=$respond->row(0)->tbl_form_idtbl_form;
        $obj->grade=$respond->row(0)->tbl_grade_idtbl_grade;
        $obj->size=$respond->row(0)->tbl_size_idtbl_size;
        $obj->side=$respond->row(0)->tbl_side_idtbl_side;
        $obj->ubittype=$respond->row(0)->tbl_unit_type_idtbl_unit_type;

        echo json_encode($obj);
    }
    public function Materialdetailcheck(){
        $recordID=$this->input->post('recordID');

        $this->db->select('COUNT(*) as `count`');
        $this->db->from('tbl_brand');
        $this->db->where('tbl_material_category_idtbl_material_category', $recordID);
        $this->db->where('status', 1);

        $respondbrand=$this->db->get();

        $this->db->select('COUNT(*) as `count`');
        $this->db->from('tbl_form');
        $this->db->where('tbl_material_category_idtbl_material_category', $recordID);
        $this->db->where('status', 1);

        $respondform=$this->db->get();

        $this->db->select('COUNT(*) as `count`');
        $this->db->from('tbl_grade');
        $this->db->where('tbl_material_category_idtbl_material_category', $recordID);
        $this->db->where('status', 1);

        $respondgrade=$this->db->get();

        $this->db->select('COUNT(*) as `count`');
        $this->db->from('tbl_side');
        $this->db->where('tbl_material_category_idtbl_material_category', $recordID);
        $this->db->where('status', 1);

        $respondside=$this->db->get();

        $this->db->select('COUNT(*) as `count`');
        $this->db->from('tbl_size');
        $this->db->where('tbl_material_category_idtbl_material_category', $recordID);
        $this->db->where('status', 1);

        $respondsize=$this->db->get();

        $this->db->select('COUNT(*) as `count`');
        $this->db->from('tbl_unit_type');
        $this->db->where('tbl_material_category_idtbl_material_category', $recordID);
        $this->db->where('status', 1);

        $respondunittype=$this->db->get();

        $obj=new stdClass();
        if($respondbrand->row(0)->count>0){$obj->brandstatus='1';}else{$obj->brandstatus='0';}
        if($respondform->row(0)->count>0){$obj->formstatus='1';}else{$obj->formstatus='0';}
        if($respondgrade->row(0)->count>0){$obj->gradestatus='1';}else{$obj->gradestatus='0';}
        if($respondsize->row(0)->count>0){$obj->sizestatus='1';}else{$obj->sizestatus='0';}
        if($respondside->row(0)->count>0){$obj->sidestatus='1';}else{$obj->sidestatus='0';}
        if($respondunittype->row(0)->count>0){$obj->unittypestatus='1';}else{$obj->unittypestatus='0';}

        echo json_encode($obj);   
    }
    public function Getbrandcode($brand){
        $this->db->select('brandcode');
        $this->db->from('tbl_brand');
        $this->db->where('idtbl_brand', $brand);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->brandcode;
    }
    public function Getformcode($form){
        $this->db->select('formcode');
        $this->db->from('tbl_form');
        $this->db->where('idtbl_form', $form);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->formcode;
    }
    public function Getgradecode($grade){
        $this->db->select('gradecode');
        $this->db->from('tbl_grade');
        $this->db->where('idtbl_grade', $grade);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->gradecode;
    }
    public function Getsidecode($side){
        $this->db->select('sidecode');
        $this->db->from('tbl_side');
        $this->db->where('idtbl_side', $side);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->sidecode;
    }
    public function Getsizecode($size){
        $this->db->select('sizecode');
        $this->db->from('tbl_size');
        $this->db->where('idtbl_size', $size);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->sizecode;
    }
    public function Getunittypecode($unittype){
        $this->db->select('unittypecode');
        $this->db->from('tbl_unit_type');
        $this->db->where('idtbl_unit_type', $unittype);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->unittypecode;
    }
    public function Getmaterialcode($materialname){
        $this->db->select('materialcode');
        $this->db->from('tbl_material_code');
        $this->db->where('idtbl_material_code', $materialname);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->materialcode;
    }
    public function Getmaterialcategorycode($materialcategory){
        $this->db->select('categorycode');
        $this->db->from('tbl_material_category');
        $this->db->where('idtbl_material_category', $materialcategory);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->categorycode;
    }
    public function Materialdetailupload(){
        $this->db->trans_begin();
        $i=0;

        $userID=$_SESSION['userid'];

		$filename=$_FILES['csvfile']['tmp_name'];
        $updatedatetime=date('Y-m-d h:i:s');

        $file = fopen($filename, 'r');
        while (($line = fgetcsv($file)) !== FALSE) {
            if($i>0 && $line[0]!=''){
                $materialcode='';
                $materialname=$line[0];
                $materialmaincode = $this->Materialdetailinfo->Getmaterialcodeacconame($materialname);
                $materialmainid = $this->Materialdetailinfo->Getmaterialidacconame($materialname);
                $materialcode.=$materialmaincode;

                $materialcategorycode=$line[3];
                $materialcategoryid = $this->Materialdetailinfo->Getmaterialcategoryid($materialcategorycode);
                $materialcode.='-'.$materialcategorycode;

                $brandcode=$line[4];
                if(!empty($brandcode)){
                    $brand = $this->Materialdetailinfo->Getbrandid($brandcode);
                    $materialcode.='-'.$brandcode;
                }else{$brand=0;}

                $formcode=$line[6];
                if(!empty($formcode)){
                    $form = $this->Materialdetailinfo->Getformid($formcode);
                    $materialcode.='-'.$formcode;
                }else{$form=0;}
                
                $gradecode=$line[7];
                if(!empty($gradecode)){
                    $grade = $this->Materialdetailinfo->Getgradeid($gradecode);
                    $materialcode.='-'.$gradecode;
                }else{$grade=0;}

                $sizecode=$line[8];
                if(!empty($sizecode)){
                    $size = $this->Materialdetailinfo->Getsizeid($sizecode);
                    $materialcode.='-'.$sizecode;
                }else{$size=0;}

                $sidecode=$line[9];
                if(!empty($sidecode)){
                    $side = $this->Materialdetailinfo->Getsideid($sidecode);
                    $materialcode.='-'.$sidecode;
                }else{$side=0;}

                $unittypecode=$line[10];
                if(!empty($unittypecode)){
                    $unittype = $this->Materialdetailinfo->Getunittypeid($unittypecode);
                    $materialcode.='-'.$unittypecode;
                }else{$unittype=0;}    

                $unitcode=$line[5];
                if(!empty($unitcode)){
                    $unit = $this->Materialdetailinfo->Getunitid($unitcode);
                }else{$unit=0;}
                
                $reorder=$line[1];
                $comment=$line[2];

                $data = array(
                    'materialinfocode'=> $materialcode, 
                    'reorderlevel'=> $reorder, 
                    'comment'=> $comment, 
                    'colour'=> '', 
                    'status'=> '1', 
                    'insertdatetime'=> $updatedatetime, 
                    'tbl_user_idtbl_user'=> $userID, 
                    'tbl_material_code_idtbl_material_code'=> $materialmainid, 
                    'tbl_material_category_idtbl_material_category'=> $materialcategoryid, 
                    'tbl_brand_idtbl_brand'=> $brand, 
                    'tbl_unit_idtbl_unit'=> $unit, 
                    'tbl_form_idtbl_form'=> $form, 
                    'tbl_grade_idtbl_grade'=> $grade, 
                    'tbl_size_idtbl_size'=> $size, 
                    'tbl_side_idtbl_side'=> $side, 
                    'tbl_unit_type_idtbl_unit_type'=> $unittype
                );
    
                $this->db->insert('tbl_material_info', $data);
            }
            $i++;
        }
        fclose($file);

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
            redirect('Materialdetail');                
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
            redirect('Materialdetail');
        }
    }
    public function Getmaterialcodeacconame($materialname){
        $this->db->select('materialcode');
        $this->db->from('tbl_material_code');
        $this->db->where('materialname', $materialname);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->materialcode;
    }
    public function Getmaterialidacconame($materialname){
        $this->db->select('idtbl_material_code');
        $this->db->from('tbl_material_code');
        $this->db->where('materialname', $materialname);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->idtbl_material_code;
    }
    public function Getmaterialcategoryid($materialcategorycode){
        $this->db->select('idtbl_material_category');
        $this->db->from('tbl_material_category');
        $this->db->where('categorycode', $materialcategorycode);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->idtbl_material_category;
    }
    public function Getbrandid($brand){
        $this->db->select('idtbl_brand');
        $this->db->from('tbl_brand');
        $this->db->where('brandcode', $brand);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->idtbl_brand;
    }
    public function Getformid($form){
        $this->db->select('idtbl_form');
        $this->db->from('tbl_form');
        $this->db->where('formcode', $form);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->idtbl_form;
    }
    public function Getgradeid($grade){
        $this->db->select('idtbl_grade');
        $this->db->from('tbl_grade');
        $this->db->where('gradecode', $grade);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->idtbl_grade;
    }
    public function Getsideid($side){
        $this->db->select('idtbl_side');
        $this->db->from('tbl_side');
        $this->db->where('sidecode', $side);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->idtbl_side;
    }
    public function Getsizeid($size){
        $this->db->select('idtbl_size');
        $this->db->from('tbl_size');
        $this->db->where('sizecode', $size);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->idtbl_size;
    }
    public function Getunittypeid($unittype){
        $this->db->select('idtbl_unit_type');
        $this->db->from('tbl_unit_type');
        $this->db->where('unittypecode', $unittype);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->idtbl_unit_type;
    }
    public function Getunitid($unitcode){
        $this->db->select('idtbl_unit');
        $this->db->from('tbl_unit');
        $this->db->where('unitcode', $unitcode);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->idtbl_unit;
    }
}