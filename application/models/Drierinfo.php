<?php
class Drierinfo extends CI_MODEL{
        public function getDrier()
        {
            $this->db->select('idtbl_drier, name');
            $this->db->from('tbl_drier');
            $this->db->where('status', 1);

            return $this->db->get();
        }
        public function DrierInsertupdate(){
                $this->db->trans_begin();

                $userID=$_SESSION['userid'];
                $companyid=$_SESSION['companyid'];
                $branchid=$_SESSION['branchid'];

                $drier=$this->input->post('drier');


                $recordOption=$this->input->post('recordOption');
                if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

                $updatedatetime=date('Y-m-d H:i:s');

                if($recordOption==1){
                    $data = array(
                        'name'=> $drier, 
                        'status'=> '1', 
                        'insertdatetime'=> $updatedatetime, 
                        'insert_user'=> $userID,
                    );

                    $this->db->insert('tbl_drier', $data);

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
                        redirect('Drier');                
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
                        redirect('Drier');
                    }
                }
                else{
                    $data = array(
                        'name'=> $drier,  
                        'update_user'=> $userID,
                        'updatedatetime'=> $updatedatetime,
                    );

                    $this->db->where('idtbl_drier', $recordID);
                    $this->db->update('tbl_drier', $data);

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
                        redirect('Drier');                
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
                        redirect('Drier');
                    }
                }
    }

        public function Drierstatus($x, $y){
            $this->db->trans_begin();

            $userID=$_SESSION['userid'];
            $recordID=$x;
            $type=$y;
            $updatedatetime=date('Y-m-d H:i:s');

            if($type==1){
                $data = array(
                    'status' => '1',
                    'update_user'=> $userID, 
                    'updatedatetime'=> $updatedatetime
                );

                $this->db->where('idtbl_drier', $recordID);
                $this->db->update('tbl_drier', $data);

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
                    redirect('Drier');                
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
                    redirect('Drier');
                }
            }
            else if($type==2){
                $data = array(
                    'status' => '2',
                    'update_user'=> $userID, 
                    'updatedatetime'=> $updatedatetime
                );

                $this->db->where('idtbl_drier', $recordID);
                $this->db->update('tbl_drier', $data);

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
                    redirect('Drier');                
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
                    redirect('Drier');
                }
            }
            else if($type==3){
                $data = array(
                    'status' => '3',
                    'update_user'=> $userID, 
                    'updatedatetime'=> $updatedatetime
                );

                $this->db->where('idtbl_drier', $recordID);
                $this->db->update('tbl_drier', $data);

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
                    redirect('Drier');                
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
                    redirect('Drier');
                }
            }
    }
        public function Drieredit(){
                $recordID=$this->input->post('recordID');

                $this->db->select('*');
                $this->db->from('tbl_drier');
                $this->db->where('idtbl_drier', $recordID);
                $this->db->where('status', 1);

                $respond=$this->db->get();

                $obj=new stdClass();
                $obj->id=$respond->row(0)->idtbl_drier;
                $obj->name=$respond->row(0)->name;

                echo json_encode($obj);
    }

        public function generateFullDayTimeOptions($interval = 30) {
            $startTime = strtotime('08:00');            
            $endTime   = strtotime('+1 day 08:00');     

            $options = '';

            while ($startTime <= $endTime) { 
                $value = date("H:i", $startTime);
                $label = date("h:i A", $startTime);

                $options .= "<option value=\"$value\">$label</option>\n";

                $startTime = strtotime("+$interval minutes", $startTime);
            }

            return $options;
        }

        public function Drierdailyinfoinsertupdate(){
            $userID=$_SESSION['userid'];
            $updatedatetime=date('Y-m-d H:i:s');

            $date = $this->input->post('date');
            $time = $this->input->post('time');
            $temp = $this->input->post('temp');
            $remark = $this->input->post('remark');
            $drierID = $this->input->post('drierid');

            $data = array(
                        'drier_id'=> $drierID, 
                        'date'=> $date, 
                        'time' => $time,
                        'temp'=> $temp, 
                        'status'=> '1',
                        'remark' => $remark,
                        'insertdatetime'=>$updatedatetime,
                        'user_id'=>$userID
                    );
            if($this->db->insert('tbl_drier_daily_info',$data)){
                echo "success";
            } else {
                echo "error";
            }

        }
}