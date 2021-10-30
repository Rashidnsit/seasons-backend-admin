<?php defined('BASEPATH') OR exit('No direct script access allowed');
class DashboardController extends CI_Controller
{
	public function __construct()
    {
		parent::__construct();
  		$this->load->helper('url');
  	 	$this->load->model('admin_model');
        $this->load->library('session');
        if($this->session->userdata('aid')=="")
		{
			redirect(base_url('admin/login'));
		}
    }

	public function index() 
	{
		$data['page'] = 'index';
		$this->load->view('admin/template', $data);
	}
}
