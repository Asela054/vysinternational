<?php
class Waterbathinfo extends CI_MODEL{

    public function getProductId(){
        
        $this->db->select('idtbl_product, prodcutname');
        $this->db->from('tbl_product');
        $this->db->where('status',1);

        return $result = $this->db->get();
    }

    public function WaterBathInsertUpdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $companyid=$_SESSION['companyid'];
        $branchid=$_SESSION['branchid'];

        $date = $this->input->post('date');
        $batchNo = $this->input->post('batchno');
        $product = $this->input->post('product');
        $qty = $this->input->post('qty');
        $exhausting_temperature = $this->input->post('e_temp');
        $cappingTemp = $this->input->post('capping_temp');
        $sterilizationTemp = $this->input->post('ster_temp');
        $steamOn = $this->input->post('steam_on');
        $steamOff = $this->input->post('steam_off');
        $rejections = $this->input->post('n_rejections');
        $remark = $this->input->post('remark');

        $updatedatetime=date('Y-m-d H:i:s');


        $data = array(
            'date'=> $date,
            'batch_no'=> $batchNo,
            'product_id'=> $product, 
            'qty'=> $qty, 
            'exhasting_temp'=> $exhausting_temperature, 
            'capping_temp'=> $cappingTemp, 
            'sterlization_temp'=> $sterilizationTemp, 
            'steam_on_time'=> $steamOn, 
            'steam_off_time'=> $steamOff, 
            'number_of_rejection'=> $rejections, 
            'status'=> '1', 
            'insertdatetime'=> $updatedatetime, 
            'insert_user'=> $userID
        );

        $this->db->insert('tbl_water_bath', $data);


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
    public function getBathDetails(){
        $id = $this->input->post('id');

        $this->db->select('b.exhasting_temp, b.capping_temp, b.sterlization_temp, b.steam_on_time, b.steam_off_time, b.number_of_rejection, b.check_status, u.name AS username');
        $this->db->from('tbl_water_bath AS b');
        $this->db->join('tbl_user AS u', 'u.idtbl_user = b.checked_by','left');
        $this->db->where('idtbl_water_bath', $id);

        $result = $this->db->get()->row();

        if(!$result){
            echo "No data found";
            return;
        }

        $html = '
        <div class="scrollbar pb-3" id="style-3">
        <table class="table table-striped table-bordered table-sm">
            <tr>
                <th>Exhausting Temperature</th>
                <th>Capping Temperature</th>
                <th>Sterlization Temperature</th>
                <th>Steam ON time</th>
                <th>Steam Off Time</th>
                <th>Number of Rejections</th>
            </tr>
            <tr>
                <td>'.$result-> exhasting_temp.'</td>
                <td>'.$result->capping_temp.'</td>
                <td>'.$result->sterlization_temp.'</td>
                <td>'.$result->steam_on_time.'</td>
                <td>'.$result->steam_off_time.'</td>
                <td>'.$result->number_of_rejection.'</td>
            </tr>

        </table>
        </div>';

        if($result->check_status == 1){
            $html .= '<p class="text-primary text-right font-weight-bold">Checked By: '.$result->username.'</p>';
            $showButton = false;
        } else {
            $showButton = true; 
        }

        return[
            'status' => 'success',
            'html' => $html,
            'showButton' => $showButton
        ];
    }

    public function markAsChecked(){
        
        $id = $this->input->post('id');
        $userID=$_SESSION['userid'];

        $this->db->where('idtbl_water_bath', $id);

        $update = $this->db->update('tbl_water_bath', [
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