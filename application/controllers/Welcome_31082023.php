<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		$this->load->view('login');
	}
	public function LoginUser(){
		$this->load->model('Userinfo');
        $result=$this->Userinfo->LoginUser();
		// print_r($result);
        if($result!=false){
            $user_data=array(
                'userid'=>$result->idtbl_user,
                'name'=>$result->name,
                'type'=>$result->idtbl_user_type,
                'typename'=>$result->type,
                'loggedin'=>true
            );

			$this->session->set_userdata($user_data);
			
			redirect('Welcome/Dashboard');            
        }
        else{
            $this->session->set_flashdata('msg', 'Invalid Username or password');
            redirect();
        }
	}
	public function Logout(){
        $this->session->unset_userdata('userid');
        $this->session->unset_userdata('name');
        $this->session->unset_userdata('type');
        $this->session->unset_userdata('typename');
        $this->session->unset_userdata('loggedin');
        $this->cart->destroy();
        redirect(base_url());
    }
	public function Dashboard(){
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['xline']=$this->Commeninfo->Chartxline();
		$result['yline']=$this->Commeninfo->Chartyline();
		$result['xline2']=$this->Commeninfo->salepricechartxline();
		$result['yline2']=$this->Commeninfo->salepricechartyline();
		$result['xline3']=$this->Commeninfo->matstockchartxline();
		$result['yline3']=$this->Commeninfo->matstockchartyline();
		$this->load->view('dashboard', $result);
	}
}
