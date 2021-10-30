<?php defined('BASEPATH') or exit('No direct script access allowed');
class AdminController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('admin_model');
		$this->load->model('firebase_model');
		$this->load->library('session');

		$this->load->helper('form');
		$this->load->library('form_validation');
	}

	public function login()
	{
		$this->load->view('admin/login');
	}

	public function login_admin()
	{
		$login = array(
			'email' => $this->input->post('email'),
			'password' => md5($this->input->post('password'))
		);

		$data = $this->admin_model->login_user($login['email'], $login['password']);
		if ($data) {
			$this->session->set_userdata('aid', $data['id']);
			$this->session->set_userdata('aemail', $data['email']);
			$this->session->set_userdata('aname', $data['name']);
			$this->session->set_userdata('aimg', $data['img']);

			redirect(base_url('admin/dashboard'));
		} else {
			$this->session->set_flashdata('error', 'Email Id And Password Wrong..');
			redirect(base_url('admin/login'));
		}
	}

	public function logout()
	{

		$this->session->sess_destroy();
		redirect(base_url() . 'admin/login', 'refresh');
	}

	public function admin_profile()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}
		$data['users'] = $this->admin_model->get_users();

		// $data['users'] = $this->admin_model->get_users(); 
		// $this->load->view("Admin/user.php",$data);

		$data['page'] = 'profile';
		$this->load->view('admin/template', $data);
	}

	public function admin_edit()
	{

		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		// $id = $this->uri->segment(3);
		$id = $this->session->userdata('aid');

		if (empty($id)) {
			show_404();
		}

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<span class="error" style="color:red;">', '</span>');

		$profile = $this->admin_model->get_admin($id);

		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('name', 'Name', 'required');

		if ($this->form_validation->run() === FALSE) {
			$data['page'] = 'profile';
			$this->load->view('admin/template', $data);
		} else {
			if ($_FILES['img']['name'] == "") {
				$this->admin_model->set_user($id, $res_image = "");
				$this->session->set_flashdata('success', 'successfully Updated..');
				redirect(base_url('admin/profile'));
			} else {
				$image_exts = array("tif", "jpg", "jpeg", "gif", "png");

				$configVideo['upload_path'] = './uploads/profile_pics/'; # check path is correct
				$configVideo['max_size'] = '102400';
				$configVideo['allowed_types'] = $image_exts; # add video extenstion on here
				$configVideo['overwrite'] = FALSE;
				$configVideo['remove_spaces'] = TRUE;
				$configVideo['file_name'] = uniqid();

				$this->load->library('upload', $configVideo);
				$this->upload->initialize($configVideo);

				if (!$this->upload->do_upload('img')) # form input field attribute
				{
					$this->session->set_flashdata('error', 'Image Type Error...');
					$data['page'] = 'profile';
					$this->load->view('admin/template', $data);
				} else {
					# Upload Successfull
					$upload_data = $this->upload->data();
					$res_image = $upload_data['file_name'];

					$this->admin_model->set_user($id, $res_image);
					$this->session->set_flashdata('success', 'successfully Updated..');
					redirect(base_url('admin/profile'));
				}
			}
		}
	}

	public function change_password()
	{

		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$id = $this->session->userdata('aid');

		if (empty($id)) {
			show_404();
		}

		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('npassword', 'New Password', 'required');
		$this->form_validation->set_rules('cpassword', 'Confirm Password', 'required');
		$this->form_validation->set_error_delimiters('<span class="error" style="color:red;">', '</span>');

		if ($this->form_validation->run() === FALSE) {
			$data['page'] = 'profile';
			$this->load->view('admin/template', $data);
		} else {
			$password = md5($this->input->post('password'));
			$npassword = md5($this->input->post('npassword'));
			$cpassword = md5($this->input->post('cpassword'));

			if ($npassword == $cpassword) {
				$password_check = $this->admin_model->password_check($password, $id);

				if ($password_check) {
					$this->admin_model->change_pass($npassword, $id);
					$this->session->set_flashdata('msg_success', 'Successfully Changed..');
					// redirect(base_url().'admin/profile/');
					redirect(base_url('admin/profile'));
				} else {
					$this->session->set_flashdata('msg_error', 'Old Password Wrong..');
					redirect(base_url() . 'admin/profile/');
				}
			} else {
				$this->session->set_flashdata('msg_error', 'New Password And Confirm Password Not Match..');
				redirect(base_url() . 'admin/profile/');
			}
		}
	}

	public function list_user()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$data['page'] = 'list_user';
		$this->load->view('admin/template', $data);
	}

	public function edit_user()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$id = $this->uri->segment(3);
		$data['page'] = 'edit_user';
		$data['user'] = $this->admin_model->get_user_by_id($id);
		$this->load->view('admin/template', $data);
	}

	public function update_user()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$id = $_REQUEST['id'];

		$this->form_validation->set_rules('username', 'UserName', 'required');
		$this->form_validation->set_rules('email', 'Email Id', 'required');

		$this->form_validation->set_error_delimiters('<span class="error" style="color:red;">', '</span>');
		if ($this->form_validation->run() == false) {
			//Error
		} else {
			$data = array(
				'username' => $_REQUEST['username'],
				'email' => $_REQUEST['email'],
			);

			if (!empty($_FILES['profile_pic']['name'])) {
				$config['upload_path'] = './uploads/profile_pics';
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['file_name'] = uniqid();
				$config['overwrite'] = TRUE;

				// Load and initialize upload library
				$this->load->library('upload');
				$this->upload->initialize($config);

				// Upload file to server
				if ($this->upload->do_upload('profile_pic')) {
					// Uploaded file data
					$fileData = $this->upload->data();
					$profile_pic = $fileData['file_name'];
				} else {
					$error = array('error' => $this->upload->display_errors('<div class="alert alert-danger">', '</div>'));
				}

				$data['profile_pic'] = $profile_pic;
			}

			$check = $this->admin_model->update_user_by_id($id, $data);
			if ($check) {
				$this->session->set_flashdata('success', 'User has been successfully Updated.');
				redirect('admin/user-list', $data);
			}
		}

		$data['page'] = 'edit_user';
		$data['user'] = $this->admin_model->get_user_by_id($id);
		$this->load->view('admin/template', $data);
	}

	public function trash_user()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		if (!empty($_REQUEST['id'])) {
			$id = $_REQUEST['id'];

			$this->db->where('rev_res', $id);
			$this->db->delete("reviews");

			$this->db->where('id', $id);
			$this->db->delete("user");
			$this->session->set_flashdata('del_success', 'User has been Successfully Deleted.');
			redirect('admin/user-list');
		}
	}

	public function list_vendor()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$data['page'] = 'list_vendor';
		$this->load->view('admin/template', $data);
	}

	public function create_vendor()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$data['page'] = 'add_vendor';
		$this->load->view('admin/template', $data);
	}

	public function add_vendor()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$this->form_validation->set_rules('fname', 'First Name', 'required');
		$this->form_validation->set_rules('lname', 'Last Name', 'required');
		$this->form_validation->set_rules('uname', 'User Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('cpassword', 'Confirm Password', 'required');

		$this->form_validation->set_error_delimiters('<span class="error" style="color:red;">', '</span>');
		if ($this->form_validation->run() == false) {
			//Error
		} else {
			$data = array(
				'fname' => $_REQUEST['fname'],
				'lname' => $_REQUEST['lname'],
				'uname' => $_REQUEST['uname'],
				'email' => $_REQUEST['email'],
			);

			if (!empty($_FILES['profile_image']['name'])) {
				$config['upload_path'] = './uploads/profile_pics';
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['file_name'] = uniqid();
				$config['overwrite'] = TRUE;

				// Load and initialize upload library
				$this->load->library('upload');
				$this->upload->initialize($config);

				// Upload file to server
				if ($this->upload->do_upload('profile_image')) {
					// Uploaded file data
					$fileData = $this->upload->data();
					$profile_image = $fileData['file_name'];
				} else {
					$error = array('error' => $this->upload->display_errors('<div class="alert alert-danger">', '</div>'));
				}

				$data['profile_image'] = $profile_image;
			}

			$data['password'] = md5($this->input->post('password'));
			$cpassword = md5($this->input->post('cpassword'));
			if ($data['password']  == $cpassword) {

				$check = $this->admin_model->add_vendor($data);
				if ($check) {
					$this->session->set_flashdata('add_success', 'Category has been added Successfully.');
					redirect('admin/vendor-list');
				}
			}

			$this->session->set_flashdata('error', 'Password And Confirm Password Not Match..');
			redirect('admin/add-vendor');
		}
		$data['page'] = 'add_vendor';
		$this->load->view('admin/template', $data);
	}

	public function edit_vendor()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$id = $this->uri->segment(3);
		$data['page'] = 'edit_vendor';
		$data['vendor'] = $this->admin_model->get_vendor_by_id($id);
		$this->load->view('admin/template', $data);
	}

	public function update_vendor()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$cat_id = $_REQUEST['id'];

		$this->form_validation->set_rules('fname', 'First Name', 'required');
		$this->form_validation->set_rules('lname', 'Last Name', 'required');
		$this->form_validation->set_rules('uname', 'User Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');

		$this->form_validation->set_error_delimiters('<span class="error" style="color:red;">', '</span>');
		if ($this->form_validation->run() == false) {
			//Error
		} else {
			$data = array(

				'fname' => $_REQUEST['fname'],
				'lname' => $_REQUEST['lname'],
				'uname' => $_REQUEST['uname'],
				'email' => $_REQUEST['email'],
			);

			if (!empty($_FILES['profile_image']['name'])) {
				$config['upload_path'] = './uploads/profile_pics';
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['file_name'] = uniqid();
				$config['overwrite'] = TRUE;

				// Load and initialize upload library
				$this->load->library('upload');
				$this->upload->initialize($config);

				// Upload file to server
				if ($this->upload->do_upload('profile_image')) {
					// Uploaded file data
					$fileData = $this->upload->data();
					$profile_image = $fileData['file_name'];
				} else {
					$error = array('error' => $this->upload->display_errors('<div class="alert alert-danger">', '</div>'));
				}

				$data['profile_image'] = $profile_image;
			}

			if ($this->input->post('password') != "") {
				$data['password'] = md5($this->input->post('password'));
			}

			$check = $this->admin_model->update_vendor_by_id($cat_id, $data);
			if ($check) {
				$this->session->set_flashdata('success', 'Category has been successfully Updated.');
				redirect('admin/vendor-list', $data);
			}
		}

		$data['page'] = 'edit_vendor';
		$data['vendor'] = $this->admin_model->get_vendor_by_id($cat_id);
		$this->load->view('admin/template', $data);
	}

	public function trash_vendor()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		if (!empty($_REQUEST['id'])) {
			$id = $_REQUEST['id'];

			$this->db->where('vid', $id);
			$this->db->delete("restaurants");

			$this->db->where('id', $id);
			$this->db->delete("vendor");
			$this->session->set_flashdata('del_success', 'User has been Successfully Deleted.');
			redirect('admin/vendor-list');
		}
	}

	public function list_category()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$data['page'] = 'list_category';
		$this->load->view('admin/template', $data);
	}

	public function create_category()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$data['page'] = 'add_category';
		$this->load->view('admin/template', $data);
	}

	public function add_category()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$this->form_validation->set_rules('c_name', 'Category Name', 'required|is_unique[categories.c_name]');

		$this->form_validation->set_error_delimiters('<span class="error" style="color:red;">', '</span>');
		if ($this->form_validation->run() == false) {
			//Error
		} else {
			$data = array(
				'c_name' => $_REQUEST['c_name'],
				// 'type' => $_REQUEST['type'],
			);

			if (!empty($_FILES['img']['name'])) {
				$config['upload_path'] = './uploads';
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['file_name'] = uniqid();
				$config['overwrite'] = TRUE;

				// Load and initialize upload library
				$this->load->library('upload');
				$this->upload->initialize($config);

				// Upload file to server
				if ($this->upload->do_upload('img')) {
					// Uploaded file data
					$fileData = $this->upload->data();
					$img = $fileData['file_name'];
				} else {
					$error = array('error' => $this->upload->display_errors('<div class="alert alert-danger">', '</div>'));
				}

				$data['img'] = $img;
			}

			$icon = "";
			if (!empty($_FILES['icon']['name'])) {
				$config['upload_path'] = './uploads';
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['file_name'] = uniqid();
				$config['overwrite'] = TRUE;

				// Load and initialize upload library
				$this->load->library('upload');
				$this->upload->initialize($config);

				// Upload file to server
				if ($this->upload->do_upload('icon')) {
					// Uploaded file data
					$fileData = $this->upload->data();
					$icon = $fileData['file_name'];
				} else {
					$error = array('error' => $this->upload->display_errors('<div class="alert alert-danger">', '</div>'));
				}

				$data['icon'] = $icon;
			}

			$check = $this->admin_model->add_category($data);
			if ($check) {
				$this->session->set_flashdata('add_success', 'Category has been added Successfully.');
				redirect('admin/category-list');
			}
		}
		$data['page'] = 'add_category';
		$this->load->view('admin/template', $data);
	}

	public function edit_category()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$id = $this->uri->segment(3);
		$data['page'] = 'edit_category';
		$data['category'] = $this->admin_model->get_category_by_id($id);
		$this->load->view('admin/template', $data);
	}

	public function update_category()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$cat_id = $_REQUEST['id'];

		$original_value = $this->db->query("SELECT c_name FROM categories WHERE id = " . $cat_id)->row()->c_name;
		if ($_REQUEST['c_name'] != $original_value) {
			$is_unique =  '|is_unique[categories.c_name]';
		} else {
			$is_unique =  '';
		}

		$this->form_validation->set_rules('c_name', 'Category Name', 'required|trim' . $is_unique);

		$this->form_validation->set_error_delimiters('<span class="error" style="color:red;">', '</span>');
		if ($this->form_validation->run() == false) {
			//Error
		} else {
			$data = array(
				'c_name' => $_REQUEST['c_name'],
				'type' => $_REQUEST['type'],
			);

			if (!empty($_FILES['img']['name'])) {
				$config['upload_path'] = './uploads';
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['file_name'] = uniqid();
				$config['overwrite'] = TRUE;

				// Load and initialize upload library
				$this->load->library('upload');
				$this->upload->initialize($config);

				// Upload file to server
				if ($this->upload->do_upload('img')) {
					// Uploaded file data
					$fileData = $this->upload->data();
					$img = $fileData['file_name'];
				} else {
					$error = array('error' => $this->upload->display_errors('<div class="alert alert-danger">', '</div>'));
				}

				$data['img'] = $img;
			}

			if (!empty($_FILES['icon']['name'])) {
				$config['upload_path'] = './uploads';
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['file_name'] = uniqid();
				$config['overwrite'] = TRUE;

				// Load and initialize upload library
				$this->load->library('upload');
				$this->upload->initialize($config);

				// Upload file to server
				if ($this->upload->do_upload('icon')) {
					// Uploaded file data
					$fileData = $this->upload->data();
					$icon = $fileData['file_name'];
				} else {
					$error = array('error' => $this->upload->display_errors('<div class="alert alert-danger">', '</div>'));
				}

				$data['icon'] = $icon;
			}

			$check = $this->admin_model->update_category_by_id($cat_id, $data);
			if ($check) {
				$this->session->set_flashdata('update_success', 'Category has been successfully Updated.');
				redirect('admin/category-list', $data);
			}
		}

		$data['page'] = 'edit_category';
		$data['category'] = $this->admin_model->get_category_by_id($cat_id);
		$this->load->view('admin/template', $data);
	}

	public function trash_category()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		if (!empty($_REQUEST['id'])) {
			$id = $_REQUEST['id'];

			$this->db->where('cat_id', $id);
			$this->db->delete("sub_categories");

			$this->db->where('id', $id);
			$this->db->delete("categories");
			$this->session->set_flashdata('del_success', 'Category has been Successfully Deleted.');
			redirect('admin/category-list');
		}
	}

	public function list_sub_category()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$data['page'] = 'list_sub_category';
		$this->load->view('admin/template', $data);
	}

	public function create_sub_category()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$data['page'] = 'add_sub_category';
		$this->load->view('admin/template', $data);
	}

	public function add_sub_category()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$this->form_validation->set_rules('c_name', 'Sub Category Name', 'required');
		$this->form_validation->set_rules('cat_id', 'Category Name', 'required');

		$this->form_validation->set_error_delimiters('<span class="error" style="color:red;">', '</span>');
		if ($this->form_validation->run() == false) {
			//Error
		} else {
			$data = array(
				'cat_id' => $_REQUEST['cat_id'],
				'c_name' => $_REQUEST['c_name'],
				'type' => $_REQUEST['type'],
			);

			if (!empty($_FILES['img']['name'])) {
				$config['upload_path'] = './uploads';
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['file_name'] = uniqid();
				$config['overwrite'] = TRUE;

				// Load and initialize upload library
				$this->load->library('upload');
				$this->upload->initialize($config);

				// Upload file to server
				if ($this->upload->do_upload('img')) {
					// Uploaded file data
					$fileData = $this->upload->data();
					$img = $fileData['file_name'];
				} else {
					$error = array('error' => $this->upload->display_errors('<div class="alert alert-danger">', '</div>'));
				}

				$data['img'] = $img;
			}

			if (!empty($_FILES['icon']['name'])) {
				$config['upload_path'] = './uploads';
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['file_name'] = uniqid();
				$config['overwrite'] = TRUE;

				// Load and initialize upload library
				$this->load->library('upload');
				$this->upload->initialize($config);

				// Upload file to server
				if ($this->upload->do_upload('icon')) {
					// Uploaded file data
					$fileData = $this->upload->data();
					$icon = $fileData['file_name'];
				} else {
					$error = array('error' => $this->upload->display_errors('<div class="alert alert-danger">', '</div>'));
				}

				$data['icon'] = $icon;
			}

			$check = $this->admin_model->add_sub_category($data);
			if ($check) {
				$this->session->set_flashdata('add_success', 'Category has been added Successfully.');
				redirect('admin/sub-category-list');
			}
		}
		$data['page'] = 'add_sub_category';
		$this->load->view('admin/template', $data);
	}

	public function edit_sub_category()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$id = $this->uri->segment(3);
		$data['page'] = 'edit_sub_category';
		$data['subcategory'] = $this->admin_model->get_sub_category_by_id($id);
		$this->load->view('admin/template', $data);
	}

	public function update_sub_category()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$cat_id = $_REQUEST['id'];

		$this->form_validation->set_rules('c_name', 'Sub Category Name', 'required');
		$this->form_validation->set_rules('cat_id', 'Category Name', 'required');

		$this->form_validation->set_error_delimiters('<span class="error" style="color:red;">', '</span>');
		if ($this->form_validation->run() == false) {
			//Error
		} else {
			$data = array(
				'cat_id' => $_REQUEST['cat_id'],
				'c_name' => $_REQUEST['c_name'],
				'type' => $_REQUEST['type'],

			);

			if (!empty($_FILES['img']['name'])) {
				$config['upload_path'] = './uploads';
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['file_name'] = uniqid();
				$config['overwrite'] = TRUE;

				// Load and initialize upload library
				$this->load->library('upload');
				$this->upload->initialize($config);

				// Upload file to server
				if ($this->upload->do_upload('img')) {
					// Uploaded file data
					$fileData = $this->upload->data();
					$img = $fileData['file_name'];
				} else {
					$error = array('error' => $this->upload->display_errors('<div class="alert alert-danger">', '</div>'));
				}

				$data['img'] = $img;
			}

			if (!empty($_FILES['icon']['name'])) {
				$config['upload_path'] = './uploads';
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['file_name'] = uniqid();
				$config['overwrite'] = TRUE;

				// Load and initialize upload library
				$this->load->library('upload');
				$this->upload->initialize($config);

				// Upload file to server
				if ($this->upload->do_upload('icon')) {
					// Uploaded file data
					$fileData = $this->upload->data();
					$icon = $fileData['file_name'];
				} else {
					$error = array('error' => $this->upload->display_errors('<div class="alert alert-danger">', '</div>'));
				}

				$data['icon'] = $icon;
			}

			$check = $this->admin_model->update_sub_category_by_id($cat_id, $data);
			if ($check) {
				$this->session->set_flashdata('update_success', 'Category has been successfully Updated.');
				redirect('admin/sub-category-list', $data);
			}
		}

		$data['page'] = 'edit_sub_category';
		$data['subcategory'] = $this->admin_model->get_sub_category_by_id($cat_id);
		$this->load->view('admin/template', $data);
	}

	public function trash_sub_category()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		if (!empty($_REQUEST['id'])) {
			$id = $_REQUEST['id'];

			$this->db->where('id', $id);
			$this->db->delete("sub_categories");
			$this->session->set_flashdata('del_success', 'Category has been Successfully Deleted.');
			redirect('admin/sub-category-list');
		}
	}

	public function list_likes()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$data['page'] = 'list_likes';
		$this->load->view('admin/template', $data);
	}

	public function likeview()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$data['page'] = 'likeview';
		$this->load->view('admin/template', $data);
	}

	public function list_reviews()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$data['page'] = 'list_reviews';
		$this->load->view('admin/template', $data);
	}

	public function reviews_view()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$data['page'] = 'reviews_view';
		$this->load->view('admin/template', $data);
	}

	public function trash_reviews()
	{

		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		if (!empty($_REQUEST['id'])) {
			$id = $_REQUEST['id'];
			$review_id = $_REQUEST['review_id'];

			$this->db->where('rev_id', $id);
			$this->db->delete("reviews");
			$this->session->set_flashdata('success', 'Category has been Successfully Deleted.');

			redirect('admin/reviews-view/' . $review_id);
		}
	}

	public function list_restaurants()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$data['page'] = 'list_restaurants';
		$this->load->view('admin/template', $data);
	}

	public function create_restaurants()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$data['page'] = 'add_restaurants';
		$this->load->view('admin/template', $data);
	}

	public function add_restaurants()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$this->form_validation->set_rules('cat_id', 'Category Name', 'required');

		$this->form_validation->set_error_delimiters('<span class="error" style="color:red;">', '</span>');
		if ($this->form_validation->run() == false) {
			//Error
		} else {
			$res_image = array();
			$res_video = "";
			$logo = "";

			if ($_FILES['res_image']['name']) {
				//echo "image detected";
				if (is_array($_FILES['res_image']['name'])) {
					$filesCount = count($_FILES['res_image']['name']);
					for ($i = 0; $i < $filesCount; $i++) {
						$_FILES['file']['name']     = $_FILES['res_image']['name'][$i];
						$_FILES['file']['type']     = $_FILES['res_image']['type'][$i];
						$_FILES['file']['tmp_name'] = $_FILES['res_image']['tmp_name'][$i];
						$_FILES['file']['error']     = $_FILES['res_image']['error'][$i];
						$_FILES['file']['size']     = $_FILES['res_image']['size'][$i];

						// File upload configuration
						$config['upload_path'] = './uploads';
						$config['allowed_types'] = 'gif|jpg|png|jpeg';
						$config['file_name'] = uniqid();
						$config['overwrite'] = TRUE;


						// Load and initialize upload library
						$this->load->library('upload');
						$this->upload->initialize($config);

						// Upload file to server
						if ($this->upload->do_upload('file')) {
							// Uploaded file data
							$fileData = $this->upload->data();
							array_push($res_image, $fileData['file_name']);
							//$res_image = $fileData['file_name'];

						} else {
							$error = array('error' => $this->upload->display_errors('<div class="alert alert-danger">', '</div>'));
							$this->session->set_flashdata('error', $error['error']);
						}
					}
				}
			}

			if ($_FILES['logo']['name']) {
				// File upload configuration
				$config['upload_path'] = './uploads';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['file_name'] = uniqid();
				$config['overwrite'] = TRUE;


				// Load and initialize upload library
				$this->load->library('upload');
				$this->upload->initialize($config);

				// Upload file to server
				if ($this->upload->do_upload('logo')) {
					// Uploaded file data
					$fileData = $this->upload->data();
					$logo = $fileData['file_name'];
				} else {
					$error = array('error' => $this->upload->display_errors('<div class="alert alert-danger">', '</div>'));
					$this->session->set_flashdata('error', $error['error']);
				}
			}

			// if ($_FILES['res_video']['name'] != "") {
			// 	// File upload configuration
			// 	$config['upload_path'] = './uploads';
			// 	$config['allowed_types'] = 'mp4|mkv';
			// 	$config['file_name'] = uniqid();
			// 	$config['overwrite'] = TRUE;


			// 	// Load and initialize upload library
			// 	$this->load->library('upload');
			// 	$this->upload->initialize($config);

			// 	// Upload file to server
			// 	if ($this->upload->do_upload('res_video')) {
			// 		// Uploaded file data
			// 		$fileData = $this->upload->data();
			// 		$res_video = $fileData['file_name'];
			// 	} else {
			// 		$error = array('error' => $this->upload->display_errors('<div class="alert alert-danger">', '</div>'));
			// 		$this->session->set_flashdata('error', $error['error']);
			// 	}
			// }

			// $data = array(
			// 	'res_name' => $_REQUEST['res_name'],
			// 	'cat_id' => $_REQUEST['cat_id'],
			// );

			$data['cat_id'] = $this->input->post('cat_id');
// 			$data['scat_id'] = $this->input->post('scat_id');

			$data['res_name'] = $this->input->post('res_name');
			$data['res_desc'] = $this->input->post('res_desc');

			$data['hours'] = $this->input->post('hours');
			$data['experts'] = $this->input->post('experts');

			$data['res_image'] = implode('::::', $res_image);
			// $data['res_url'] = $this->input->post('res_url');
			$data['logo'] = $logo;

			$data['res_create_date'] = time();

			$cid = $this->input->post('type');

			for ($i = 0; $i < count($cid); $i++) {
				$val[$i] = $_POST['type'][$i] . "," . $_POST['price'][$i];
			}

			$val_sea = serialize($val);

			$data['structure'] = $val_sea;

			// print_r($data);
			// die();

			$check = $this->admin_model->add_restaurants($data);
			if ($check) {
				$this->session->set_flashdata('add_success', 'Restaurants has been added Successfully.');
				redirect('admin/restaurants-list');
			}
		}
		$data['page'] = 'add_restaurants';
		$this->load->view('admin/template', $data);
	}

	public function edit_restaurants()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$id = $this->uri->segment(3);
		$data['page'] = 'edit_restaurants';
		$data['restaurant'] = $this->admin_model->get_restaurants_by_id($id);
		$this->load->view('admin/template', $data);
	}

	public function update_restaurants()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$id = $_REQUEST['id'];

		$this->form_validation->set_rules('cat_id', 'Category Name', 'required');

		$this->form_validation->set_error_delimiters('<span class="error" style="color:red;">', '</span>');
		if ($this->form_validation->run() == false) {
			//Error
		} else {

			$restaurant = $this->admin_model->get_restaurants_by_id($id);
			$data = array();

			$data['res_image'] = $restaurant->res_image;
			if ($_FILES['res_image']['name'][0] != "") {
				$res_image = array();
				//echo "image detected";
				if (is_array($_FILES['res_image']['name'])) {
					$filesCount = count($_FILES['res_image']['name']);
					for ($i = 0; $i < $filesCount; $i++) {
						$_FILES['file']['name']     = $_FILES['res_image']['name'][$i];
						$_FILES['file']['type']     = $_FILES['res_image']['type'][$i];
						$_FILES['file']['tmp_name'] = $_FILES['res_image']['tmp_name'][$i];
						$_FILES['file']['error']     = $_FILES['res_image']['error'][$i];
						$_FILES['file']['size']     = $_FILES['res_image']['size'][$i];

						// File upload configuration
						$config['upload_path'] = './uploads/';
						$config['allowed_types'] = 'gif|jpg|png|jpeg';
						$config['file_name'] = uniqid();
						$config['overwrite'] = TRUE;


						// Load and initialize upload library
						$this->load->library('upload');
						$this->upload->initialize($config);

						// Upload file to server
						if ($this->upload->do_upload('file')) {
							// Uploaded file data
							$fileData = $this->upload->data();
							array_push($res_image, $fileData['file_name']);
							// $res_image = $fileData['file_name'];

						} else {
							$error = array('error' => $this->upload->display_errors('<div class="alert alert-danger">', '</div>'));
							$this->session->set_flashdata('error', $error['error']);
						}
					}

					$data['res_image'] = implode("::::", $res_image);
				}
			}

			//print_r($res_image);
			$data['logo'] = $restaurant->logo;
			if ($_FILES['logo']['name'] != "") {
				// File upload configuration
				$config['upload_path'] = './uploads/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['file_name'] = uniqid();
				$config['overwrite'] = TRUE;


				// Load and initialize upload library
				$this->load->library('upload');
				$this->upload->initialize($config);

				// Upload file to server
				if ($this->upload->do_upload('logo')) {
					// Uploaded file data
					$fileData = $this->upload->data();
					$data['logo'] = $fileData['file_name'];
				} else {
					$error = array('error' => $this->upload->display_errors('<div class="alert alert-danger">', '</div>'));
					$this->session->set_flashdata('error', $error['error']);
				}
			}

			// $res_video = $restaurant->res_video;
			// if ($_FILES['res_video']['name'] != "") {
			// 	// File upload configuration
			// 	$config['upload_path'] = './uploads';
			// 	$config['allowed_types'] = 'mp4|mkv';
			// 	$config['file_name'] = uniqid();
			// 	$config['overwrite'] = TRUE;


			// 	// Load and initialize upload library
			// 	$this->load->library('upload');
			// 	$this->upload->initialize($config);

			// 	// Upload file to server
			// 	if ($this->upload->do_upload('res_video')) {
			// 		// Uploaded file data
			// 		$fileData = $this->upload->data();
			// 		$res_video = $fileData['file_name'];
			// 	} else {
			// 		$error = array('error' => $this->upload->display_errors('<div class="alert alert-danger">', '</div>'));
			// 		$this->session->set_flashdata('error', $error['error']);
			// 	}
			// }

			// $data = array(
			// 	'c_name' => $_REQUEST['c_name'],

			// );

			$data['cat_id'] = $this->input->post('cat_id');
// 			$data['scat_id'] = $this->input->post('scat_id');

			$data['res_name'] = $this->input->post('res_name');
			$data['res_desc'] = $this->input->post('res_desc');

			$data['hours'] = $this->input->post('hours');
			$data['experts'] = $this->input->post('experts');

			$check = $this->admin_model->update_restaurants_by_id($id, $data);
			if ($check) {
				$this->session->set_flashdata('success', 'Restaurants has been successfully Updated.');
				redirect('admin/restaurants-list', $data);
			}
		}

		$data['page'] = 'edit_restaurants';
		$data['restaurant'] = $this->admin_model->get_restaurants_by_id($id);
		$this->load->view('admin/template', $data);
	}

	public function trash_restaurants()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		if (!empty($_REQUEST['id'])) {
			$id = $_REQUEST['id'];

			$this->db->where('res_id', $id);
			$this->db->delete("restaurants");
			$this->session->set_flashdata('success', 'Restaurant has been Successfully Deleted.');
			redirect('admin/restaurants-list');
		}
	}

	public function list_banners()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$data['page'] = 'list_banners';
		$this->load->view('admin/template', $data);
	}

	public function create_banners()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$data['page'] = 'add_banners';
		$this->load->view('admin/template', $data);
	}

	public function add_banners()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$this->form_validation->set_rules('banners_name', 'Banners Name', 'required');

		$this->form_validation->set_error_delimiters('<span class="error" style="color:red;">', '</span>');
		if ($this->form_validation->run() == false) {
			//Error
		} else {
			$data = array(
				'banners_name' => $_REQUEST['banners_name'],
			);

			if (!empty($_FILES['image']['name'])) {
				$config['upload_path'] = './uploads';
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['file_name'] = uniqid();
				$config['overwrite'] = TRUE;

				// Load and initialize upload library
				$this->load->library('upload');
				$this->upload->initialize($config);

				// Upload file to server
				if ($this->upload->do_upload('image')) {
					// Uploaded file data
					$fileData = $this->upload->data();
					$image = $fileData['file_name'];
				} else {
					$error = array('error' => $this->upload->display_errors('<div class="alert alert-danger">', '</div>'));
				}

				$data['image'] = $image;
			}

			$check = $this->admin_model->add_banners($data);
			if ($check) {
				$this->session->set_flashdata('success', 'Banners has been added Successfully.');
				redirect('admin/banners-list');
			}
		}
		$data['page'] = 'add_banners';
		$this->load->view('admin/template', $data);
	}

	public function edit_banners()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$id = $this->uri->segment(3);
		$data['page'] = 'edit_banners';
		$data['banners'] = $this->admin_model->get_banners_by_id($id);
		$this->load->view('admin/template', $data);
	}

	public function update_banners()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$id = $_REQUEST['id'];

		$this->form_validation->set_rules('banners_name', 'Banners Name', 'required');

		$this->form_validation->set_error_delimiters('<span class="error" style="color:red;">', '</span>');
		if ($this->form_validation->run() == false) {
			//Error
		} else {
			$data = array(
				'banners_name' => $_REQUEST['banners_name'],

			);

			if (!empty($_FILES['image']['name'])) {
				$config['upload_path'] = './uploads';
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['file_name'] = uniqid();
				$config['overwrite'] = TRUE;

				// Load and initialize upload library
				$this->load->library('upload');
				$this->upload->initialize($config);

				// Upload file to server
				if ($this->upload->do_upload('image')) {
					// Uploaded file data
					$fileData = $this->upload->data();
					$image = $fileData['file_name'];
				} else {
					$error = array('error' => $this->upload->display_errors('<div class="alert alert-danger">', '</div>'));
				}

				$data['image'] = $image;
			}

			$check = $this->admin_model->update_banners_by_id($id, $data);
			if ($check) {
				$this->session->set_flashdata('success', 'Banners has been successfully Updated.');
				redirect('admin/banners-list', $data);
			}
		}

		$data['page'] = 'edit_banners';
		$data['banners'] = $this->admin_model->get_banners_by_id($id);
		$this->load->view('admin/template', $data);
	}

	public function trash_banners()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		if (!empty($_REQUEST['id'])) {
			$id = $_REQUEST['id'];

			$this->db->where('id', $id);
			$this->db->delete("banners");
			$this->session->set_flashdata('success', 'Banners has been Successfully Deleted.');
			redirect('admin/banners-list');
		}
	}

	public function list_type()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$data['page'] = 'list_type';
		$this->load->view('admin/template', $data);
	}

	public function create_type()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$data['page'] = 'add_type';
		$this->load->view('admin/template', $data);
	}

	public function add_type()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$this->form_validation->set_rules('c_name', 'Type Name', 'required');

		$this->form_validation->set_error_delimiters('<span class="error" style="color:red;">', '</span>');
		if ($this->form_validation->run() == false) {
			//Error
		} else {
			$data = array(
				'c_name' => $_REQUEST['c_name'],
			);

			$check = $this->admin_model->add_type($data);
			if ($check) {
				$this->session->set_flashdata('success', 'Type has been added Successfully.');
				redirect('admin/type-list');
			}
		}
		$data['page'] = 'add_type';
		$this->load->view('admin/template', $data);
	}

	public function edit_type()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$id = $this->uri->segment(3);
		$data['page'] = 'edit_type';
		$data['type'] = $this->admin_model->get_type_by_id($id);
		$this->load->view('admin/template', $data);
	}

	public function update_type()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$id = $_REQUEST['id'];

		$this->form_validation->set_rules('c_name', 'Type Name', 'required');

		$this->form_validation->set_error_delimiters('<span class="error" style="color:red;">', '</span>');
		if ($this->form_validation->run() == false) {
			//Error
		} else {
			$data = array(
				'c_name' => $_REQUEST['c_name'],

			);

			$check = $this->admin_model->update_type_by_id($id, $data);
			if ($check) {
				$this->session->set_flashdata('success', 'Type has been successfully Updated.');
				redirect('admin/type-list', $data);
			}
		}

		$data['page'] = 'edit_type';
		$data['type'] = $this->admin_model->get_type_by_id($id);
		$this->load->view('admin/template', $data);
	}

	public function trash_type()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		if (!empty($_REQUEST['id'])) {
			$id = $_REQUEST['id'];

			$this->db->where('id', $id);
			$this->db->delete("type");
			$this->session->set_flashdata('success', 'Type has been Successfully Deleted.');
			redirect('admin/type-list');
		}
	}

	public function list_booking()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$data['page'] = 'list_booking';
		$this->load->view('admin/template', $data);
	}

	public function view_booking()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$data['page'] = 'view_booking';
		$this->load->view('admin/template', $data);
	}

	public function trash_booking()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		if (!empty($_REQUEST['id'])) {
			$id = $_REQUEST['id'];

			$this->db->where('id', $id);
			$this->db->delete("booking");
			$this->session->set_flashdata('success', 'Type has been Successfully Deleted.');
			redirect('admin/booking-list');
		}
	}

	public function list_product_category()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$data['page'] = 'list_product_category';
		$this->load->view('admin/template', $data);
	}

	public function create_product_category()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$data['page'] = 'add_product_category';
		$this->load->view('admin/template', $data);
	}

	public function add_product_category()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$this->form_validation->set_rules('c_name', 'Category Name', 'required');

		$this->form_validation->set_error_delimiters('<span class="error" style="color:red;">', '</span>');
		if ($this->form_validation->run() == false) {
			//Error
		} else {
			$data = array(
				'c_name' => $_REQUEST['c_name'],
			);

			if (!empty($_FILES['image']['name'])) {
				$config['upload_path'] = './uploads';
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['file_name'] = uniqid();
				$config['overwrite'] = TRUE;

				// Load and initialize upload library
				$this->load->library('upload');
				$this->upload->initialize($config);

				// Upload file to server
				if ($this->upload->do_upload('image')) {
					// Uploaded file data
					$fileData = $this->upload->data();
					$image = $fileData['file_name'];
				} else {
					$error = array('error' => $this->upload->display_errors('<div class="alert alert-danger">', '</div>'));
				}

				$data['image'] = $image;
			}

			$check = $this->admin_model->add_product_category($data);
			if ($check) {
				$this->session->set_flashdata('add_success', 'Category has been added Successfully.');
				redirect('admin/product-category-list');
			}
		}
		$data['page'] = 'add_product_category';
		$this->load->view('admin/template', $data);
	}

	public function edit_product_category()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$id = $this->uri->segment(3);
		$data['page'] = 'edit_product_category';
		$data['product_category'] = $this->admin_model->get_product_category_by_id($id);
		$this->load->view('admin/template', $data);
	}

	public function update_product_category()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$id = $_REQUEST['id'];

		$this->form_validation->set_rules('c_name', 'Category Name', 'required');

		$this->form_validation->set_error_delimiters('<span class="error" style="color:red;">', '</span>');
		if ($this->form_validation->run() == false) {
			//Error
		} else {
			$data = array(
				'c_name' => $_REQUEST['c_name'],
			);

			if (!empty($_FILES['image']['name'])) {
				$config['upload_path'] = './uploads';
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['file_name'] = uniqid();
				$config['overwrite'] = TRUE;

				// Load and initialize upload library
				$this->load->library('upload');
				$this->upload->initialize($config);

				// Upload file to server
				if ($this->upload->do_upload('image')) {
					// Uploaded file data
					$fileData = $this->upload->data();
					$image = $fileData['file_name'];
				} else {
					$error = array('error' => $this->upload->display_errors('<div class="alert alert-danger">', '</div>'));
				}

				$data['image'] = $image;
			}

			$check = $this->admin_model->update_product_category_by_id($id, $data);
			if ($check) {
				$this->session->set_flashdata('update_success', 'Category has been successfully Updated.');
				redirect('admin/product-category-list', $data);
			}
		}

		$data['page'] = 'edit_product_category';
		$data['product_category'] = $this->admin_model->get_product_category_by_id($id);
		$this->load->view('admin/template', $data);
	}

	public function trash_product_category()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		if (!empty($_REQUEST['id'])) {
			$id = $_REQUEST['id'];

			$this->db->where('cat_id', $id);
			$this->db->delete("products");

			$this->db->where('id', $id);
			$this->db->delete("product_category");
			$this->session->set_flashdata('del_success', 'Category has been Successfully Deleted.');
			redirect('admin/product-category-list');
		}
	}

	public function list_product()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$data['page'] = 'list_product';
		$this->load->view('admin/template', $data);
	}

	public function create_product()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$data['page'] = 'add_product';
		$this->load->view('admin/template', $data);
	}

	public function add_product()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$this->form_validation->set_rules('cat_id', 'Category', 'required');
		$this->form_validation->set_rules('product_name', 'Product Name', 'required');
		$this->form_validation->set_rules('product_description', 'Description', 'required');
		$this->form_validation->set_rules('product_price', 'Price', 'required');

		$this->form_validation->set_error_delimiters('<span class="error" style="color:red;">', '</span>');
		if ($this->form_validation->run() == false) {
			//Error
		} else {
			$data = array(
				'cat_id' => $_REQUEST['cat_id'],
				'product_name' => $_REQUEST['product_name'],
				'product_description' => $_REQUEST['product_description'],
				'product_price' => $_REQUEST['product_price'],
			);

			$product_image = array();

			if ($_FILES['product_image']['name']) {
				//echo "product_image detected";
				if (is_array($_FILES['product_image']['name'])) {
					$filesCount = count($_FILES['product_image']['name']);
					for ($i = 0; $i < $filesCount; $i++) {
						$_FILES['file']['name']     = $_FILES['product_image']['name'][$i];
						$_FILES['file']['type']     = $_FILES['product_image']['type'][$i];
						$_FILES['file']['tmp_name'] = $_FILES['product_image']['tmp_name'][$i];
						$_FILES['file']['error']     = $_FILES['product_image']['error'][$i];
						$_FILES['file']['size']     = $_FILES['product_image']['size'][$i];

						// File upload configuration
						$config['upload_path'] = './uploads/product_images';
						$config['allowed_types'] = 'gif|jpg|png|jpeg';
						$config['file_name'] = uniqid();
						$config['overwrite'] = TRUE;


						// Load and initialize upload library
						$this->load->library('upload');
						$this->upload->initialize($config);

						// Upload file to server
						if ($this->upload->do_upload('file')) {
							// Uploaded file data
							$fileData = $this->upload->data();
							array_push($product_image, $fileData['file_name']);
							//$res_product_image = $fileData['file_name'];

						} else {
							$error = array('error' => $this->upload->display_errors('<div class="alert alert-danger">', '</div>'));
							$this->session->set_flashdata('error', $error['error']);
						}
					}
				}
			}
			// $data['logo'] = $logo;
			$data['product_image'] = implode('::::', $product_image);

			$check = $this->admin_model->add_product($data);
			if ($check) {
				$this->session->set_flashdata('success', 'Product has been added Successfully.');
				redirect('admin/product-list');
			}
		}
		$data['page'] = 'add_product';
		$this->load->view('admin/template', $data);
	}

	public function edit_product()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$id = $this->uri->segment(3);
		$data['page'] = 'edit_product';
		$data['product'] = $this->admin_model->get_products_by_id($id);
		$this->load->view('admin/template', $data);
	}

	public function update_product()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$id = $_REQUEST['id'];

		$this->form_validation->set_rules('cat_id', 'Category', 'required');
		$this->form_validation->set_rules('product_name', 'Product Name', 'required');
		$this->form_validation->set_rules('product_description', 'Description', 'required');
		$this->form_validation->set_rules('product_price', 'Price', 'required');

		$this->form_validation->set_error_delimiters('<span class="error" style="color:red;">', '</span>');
		if ($this->form_validation->run() == false) {
			//Error
		} else {
			$data = array(
				'cat_id' => $_REQUEST['cat_id'],
				'product_name' => $_REQUEST['product_name'],
				'product_description' => $_REQUEST['product_description'],
				'product_price' => $_REQUEST['product_price'],
			);

			$product = $this->admin_model->get_products_by_id($id);

			$data['product_image'] = $product->product_image;

			if ($_FILES['product_image']['name'][0] != "") {
				$product_image = array();
				//echo "product_image detected";
				if (is_array($_FILES['product_image']['name'])) {
					$filesCount = count($_FILES['product_image']['name']);
					for ($i = 0; $i < $filesCount; $i++) {
						$_FILES['file']['name']     = $_FILES['product_image']['name'][$i];
						$_FILES['file']['type']     = $_FILES['product_image']['type'][$i];
						$_FILES['file']['tmp_name'] = $_FILES['product_image']['tmp_name'][$i];
						$_FILES['file']['error']     = $_FILES['product_image']['error'][$i];
						$_FILES['file']['size']     = $_FILES['product_image']['size'][$i];

						// File upload configuration
						$config['upload_path'] = './uploads/product_images';
						$config['allowed_types'] = 'gif|jpg|png|jpeg';
						$config['file_name'] = uniqid();
						$config['overwrite'] = TRUE;


						// Load and initialize upload library
						$this->load->library('upload');
						$this->upload->initialize($config);

						// Upload file to server
						if ($this->upload->do_upload('file')) {
							// Uploaded file data
							$fileData = $this->upload->data();
							array_push($product_image, $fileData['file_name']);
							// $product_image = $fileData['file_name'];

						} else {
							$error = array('error' => $this->upload->display_errors('<div class="alert alert-danger">', '</div>'));
							$this->session->set_flashdata('error', $error['error']);
						}
					}

					$data['product_image'] = implode("::::", $product_image);
				}
			}

			$check = $this->admin_model->update_product_by_id($id, $data);
			if ($check) {
				$this->session->set_flashdata('update_success', 'Category has been successfully Updated.');
				redirect('admin/product-list', $data);
			}
		}

		$data['page'] = 'edit_product';
		$data['product'] = $this->admin_model->get_products_by_id($id);
		$this->load->view('admin/template', $data);
	}

	public function trash_product()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		if (!empty($_REQUEST['id'])) {
			$id = $_REQUEST['id'];

			$this->db->where('product_id', $id);
			$this->db->delete("products");

			$this->db->where('product_id', $id);
			$this->db->delete("cart_items");

			$this->session->set_flashdata('success', 'Product has been Successfully Deleted.');
			redirect('admin/product-list');
		}
	}

	public function testimonial_category_list()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$data['page'] = 'list_testimonial_category';
		$this->load->view('admin/template', $data);
	}

	public function create_testimonial_category()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$data['page'] = 'add_testimonial_category';
		$this->load->view('admin/template', $data);
	}

	public function add_testimonial_category()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$this->form_validation->set_rules('c_name', 'Type Name', 'required');

		$this->form_validation->set_error_delimiters('<span class="error" style="color:red;">', '</span>');
		if ($this->form_validation->run() == false) {
			//Error
		} else {
			$data = array(
				'c_name' => $_REQUEST['c_name'],
			);

			$check = $this->admin_model->add_testimonial_category($data);
			if ($check) {
				$this->session->set_flashdata('success', 'Added Successfully.');
				redirect('admin/testimonial-category-list');
			}
		}
		$data['page'] = 'add_testimonial_category';
		$this->load->view('admin/template', $data);
	}

	public function edit_testimonial_category()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$id = $this->uri->segment(3);
		$data['page'] = 'edit_testimonial_category';
		$data['testimonial_category'] = $this->admin_model->get_testimonial_category_by_id($id);
		$this->load->view('admin/template', $data);
	}

	public function update_testimonial_category()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$id = $_REQUEST['id'];

		$this->form_validation->set_rules('c_name', 'Type Name', 'required');

		$this->form_validation->set_error_delimiters('<span class="error" style="color:red;">', '</span>');
		if ($this->form_validation->run() == false) {
			//Error
		} else {
			$data = array(
				'c_name' => $_REQUEST['c_name'],

			);

			$check = $this->admin_model->update_testimonial_category_by_id($id, $data);
			if ($check) {
				$this->session->set_flashdata('success', 'Type has been successfully Updated.');
				redirect('admin/testimonial-category-list', $data);
			}
		}

		$data['page'] = 'add_testimonial_category';
		$data['testimonial_category'] = $this->admin_model->get_testimonial_category_by_id($id);
		$this->load->view('admin/template', $data);
	}

	public function trash_testimonial_category()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		if (!empty($_REQUEST['id'])) {
			$id = $_REQUEST['id'];

			$this->db->where('id', $id);
			$this->db->delete("testimonial_category");
			$this->session->set_flashdata('success', 'Successfully Deleted.');
			redirect('admin/testimonial-category-list');
		}
	}

	public function testimonial_list()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$data['page'] = 'list_testimonial';
		$this->load->view('admin/template', $data);
	}

	public function create_testimonial()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$data['page'] = 'add_testimonial';
		$this->load->view('admin/template', $data);
	}

	public function add_testimonial()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$this->form_validation->set_rules('cat_id', 'Type Name', 'required');
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('group_name', 'Group Name', 'required');
		$this->form_validation->set_rules('review_text', 'Review Text', 'required');

		$this->form_validation->set_error_delimiters('<span class="error" style="color:red;">', '</span>');
		if ($this->form_validation->run() == false) {
			//Error
		} else {
			$data = array(
				'cat_id' => $_REQUEST['cat_id'],
				'name' => $_REQUEST['name'],
				'group_name' => $_REQUEST['group_name'],
				'review_text' => $_REQUEST['review_text'],
			);
			$data['created_date'] = time();

			$check = $this->admin_model->add_testimonial($data);
			if ($check) {
				$this->session->set_flashdata('success', 'Added Successfully.');
				redirect('admin/testimonial-list');
			}
		}
		$data['page'] = 'add_testimonial';
		$this->load->view('admin/template', $data);
	}

	public function edit_testimonial()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$id = $this->uri->segment(3);
		$data['page'] = 'edit_testimonial';
		$data['testimonial'] = $this->admin_model->get_testimonial_by_id($id);
		$this->load->view('admin/template', $data);
	}

	public function update_testimonial()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$id = $_REQUEST['id'];

		$this->form_validation->set_rules('cat_id', 'Type Name', 'required');
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('group_name', 'Group Name', 'required');
		$this->form_validation->set_rules('review_text', 'Review Text', 'required');

		$this->form_validation->set_error_delimiters('<span class="error" style="color:red;">', '</span>');
		if ($this->form_validation->run() == false) {
			//Error
		} else {
			$data = array(
				'cat_id' => $_REQUEST['cat_id'],
				'name' => $_REQUEST['name'],
				'group_name' => $_REQUEST['group_name'],
				'review_text' => $_REQUEST['review_text'],
			);

			$check = $this->admin_model->update_testimonial_by_id($id, $data);
			if ($check) {
				$this->session->set_flashdata('success', 'Type has been successfully Updated.');
				redirect('admin/testimonial-list', $data);
			}
		}

		$data['page'] = 'add_testimonial';
		$data['testimonial'] = $this->admin_model->get_testimonial_by_id($id);
		$this->load->view('admin/template', $data);
	}

	public function trash_testimonial()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		if (!empty($_REQUEST['id'])) {
			$id = $_REQUEST['id'];

			$this->db->where('id', $id);
			$this->db->delete("testimonial");
			$this->session->set_flashdata('success', 'Successfully Deleted.');
			redirect('admin/testimonial-list');
		}
	}

	public function list_orders()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$data['page'] = 'list_orders';
		$this->load->view('admin/template', $data);
	}

	public function view_order()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$data['page'] = 'view_order';
		$this->load->view('admin/template', $data);
	}
	
	public function change_status()
	{
		$id = $this->input->post('order_id');

		$data = array();

		$data['order_status'] = $this->input->post('status');

		$this->db->where('order_id', $id);

		$this->db->update('orders', $data);

		$status = $this->input->post('status');

		if ($status == 0) {

			$title = "Processing";
			$message = "Your Order Processing";
		} elseif ($status == 1) {

			$title = "Order Dispatch";
			$message = "Your Order Dispatch";
		} elseif ($status == 2) {

			$title = "Order Deliver";
			$message = "Your Order Successfully Deliver";
		}else{
			
			$title = "Order Cancel";
			$message = "Your Order Cancel";
		}


		$order = $this->db->get_where('orders', array('order_id' => $id), 1)->row();

		$response = $this->firebase_model->send_user_notification($order->user_id, $title, $message, "Message");

		$this->firebase_model->save_user_notification($order->user_id, $title, $message, "order", $order->order_id);

		$this->session->set_flashdata('success', 'successfully Changed..');
		redirect(base_url() . 'admin/orders', 'refresh');
	}

	public function trash_orders()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		if (!empty($_REQUEST['id'])) {
			$id = $_REQUEST['id'];

			$this->db->where('order_id', $id);
			$this->db->delete("orders");
			$this->session->set_flashdata('success', 'Orders has been Successfully Deleted.');
			redirect('admin/orders');
		}
	}

    public function general_setting()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$data['general_setting'] = $this->db->get_where('general_setting', array('id' => "1"), 1)->row();
		$data['page'] = 'general_setting';
		$this->load->view('admin/template', $data);
	}

	public function update_general_setting()
	{
		if ($this->session->userdata('aid') == "") {
			redirect(base_url('admin/login'));
		}

		$n_server_key = $this->input->post("n_server_key");
		$s_secret_key = $this->input->post("s_secret_key");
		$s_public_key = $this->input->post("s_public_key");
		$r_secret_key = $this->input->post("r_secret_key");
		$r_public_key = $this->input->post("r_public_key");

		$this->admin_model->updateSettings(
			array(
				"n_server_key" => $n_server_key,
				"s_secret_key" => $s_secret_key,
				"s_public_key" => $s_public_key,
				"r_secret_key" => $r_secret_key,
				"r_public_key" => $r_public_key,
			)
		);

		$this->session->set_flashdata('success', 'successfully Changed..');
		redirect(base_url() . 'admin/general-setting');
	}
	
	public function change_booking_status()
	{

		$id = $this->input->post('id');

		$data = array();

		$data['status'] = $this->input->post('status');
		$this->db->where('id', $id);
		$this->db->update('booking', $data);

		$status = $this->input->post('status');

		if ($status == "Confirm") {

			$title = "Booking Confirm";
			$message = "Your Booking Successfully Confirm";
		} elseif ($status == "On Way") {

			$title = "Booking On Way";
			$message = "Your Booking On Way";
		} elseif ($status == "Completed") {

			$title = "Booking Completed";
			$message = "Your Booking Successfully Completed";
		}else{
			
			$title = "Booking Cancel";
			$message = "Your Booking Cancel";
		}

		$booking = $this->db->get_where('booking', array('id' => $id), 1)->row();

		$response = $this->firebase_model->send_user_notification($booking->user_id, $title, $message, "Message");

		$this->firebase_model->save_user_notification($booking->user_id, $title, $message, "booking", $booking->id);

		$this->session->set_flashdata('success', 'successfully Changed..');
		redirect(base_url() . 'admin/booking-list', 'refresh');
	}
	
	public function total_sales_get()
	{

		if ($this->input->post("year") != "") {
			$year = $this->input->post("year");
		} else {
			$year = date("Y");;
		}

		$sql = "SELECT * FROM chart_data WHERE year = '" . $year . "' ORDER BY id ASC";
		$query = $this->db->query($sql);
		$result = $query->result_array();

		$data = array();
		foreach ($result as $row) {
			$output[] = array(
				'month'   => $row["month"],
				'profit'  => floatval($row["profit"])
			);
		}

		echo json_encode($output);
	}



}
