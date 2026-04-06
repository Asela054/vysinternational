<?php
class IncomingMaterialVehicleinfo extends CI_MODEL{
    public function Getfruittype(){

        $this->db->select('idtbl_fruit_type, type');
        $this->db->from('tbl_fruit_type');
        $this->db->where('status', 1);

        return $respond = $this->db->get();

    }
        public function Getsupplier(){
        
        $this->db->select('idtbl_supplier, suppliername');
        $this->db->from('tbl_supplier');
        $this->db->where('status', 1);

        return $respond = $this->db->get();

    }
    public function MaterialVehicleInfoInsertUpdate(){

        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $vehicleNumber=$this->input->post('v_number');
        $fruitType=$this->input->post('f_type');
        $assosiationName=$this->input->post('aname');
        $quantity=$this->input->post('qty');
        $supplier=$this->input->post('supplier');
        $faId=$this->input->post('fa_id');
        $address=$this->input->post('address');
        $date=$this->input->post('date');
        $materailStatus=$this->input->post('fstatus');

        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $updatedatetime=date('Y-m-d H:i:s');

        if($recordOption==1){
            $data = array(
                'vehicle_number'=> $vehicleNumber, 
                'assosiation_name'=> $assosiationName, 
                'tbl_fruit_type_idtbl_fruit_type'=> $fruitType,
                'qty'=> $quantity,
                'tbl_supplier_idtbl_supplier'=> $supplier,
                'assosiation_id'=> $faId,
                'address' => $address,
                'date' => $date,
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID,
                'materail_status'=>$materailStatus
            );

            $this->db->insert('tbl_raw_material_vehicle_inspection', $data);

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
                redirect('IncomingMaterialVehicle');                
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
                redirect('IncomingMaterialVehicle');
            }
        }
        else{
            $data = array(

                'assosiation_name'=> $assosiationName, 
                'tbl_fruit_type_idtbl_fruit_type'=> $fruitType,
                'qty'=> $quantity,
                'tbl_supplier_idtbl_supplier'=> $supplier,
                'assosiation_id'=> $faId,
                'address' => $address,
                'date' => $date,
                'updatedatetime'=> $updatedatetime,
                'materail_status'=>$materailStatus
            );

            $this->db->where('idtbl_raw_material_vehicle_inspection', $recordID);
            $this->db->update('tbl_raw_material_vehicle_inspection', $data);

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
                redirect('IncomingMaterialVehicle');                
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
                redirect('IncomingMaterialVehicle');
            }
        }

    }
    public function approveVehicle(){
        $id = $this->input->post('id');

		$this->db->where('idtbl_raw_material_vehicle_inspection', $id);
		$update = $this->db->update('tbl_raw_material_vehicle_inspection', [
			'approval_status' => 1
		]);

		if($update){
			return "success";
		}else{
			return "error";
		}
    }

}