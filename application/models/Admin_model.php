<?php
class Admin_model extends CI_model
{



	public function login_user($email, $pass)
	{

		$this->db->select('*');
		$this->db->from('admin');
		$this->db->where('email', $email);
		$this->db->where('password', $pass);

		if ($query = $this->db->get()) {
			return $query->row_array();
		} else {
			return false;
		}
	}

	public function get_admin($id)
	{
		$query = $this->db->get_where('admin', array('id' => $id));
		return $query->row_array();
	}

	public function password_check($password, $id)
	{
		$this->db->select('*');
		$this->db->from('admin');
		$this->db->where('password', $password);
		$this->db->where('id', $id);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function get_users()
	{
		$this->db->select('user.*');
		$this->db->from('user');
		$this->db->order_by("id", "desc");

		$query = $this->db->get();
		return $query->result();
	}

	public function get_user_by_id($id)
	{
		$query = $this->db->get_where('user', array('id' => $id));
		return $query->row();
	}

	public function update_user_by_id($cat_id, $data)
	{
		$res = $this->db->update('user', $data, ['id' => $cat_id]);
		if ($res == 1)
			return true;
		else
			return false;
	}

	public function get_vendor()
	{
		$this->db->select('vendor.*');
		$this->db->from('vendor');
		$this->db->order_by("id", "desc");

		$query = $this->db->get();
		return $query->result();
	}

	public function add_vendor($data)
	{
		$this->load->helper('url');

		return $this->db->insert('vendor', $data);
	}

	public function get_vendor_by_id($id)
	{
		$this->db->select('*');
		$this->db->from('vendor');
		$this->db->where("id", $id);
		$query = $this->db->get();
		if ($query) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function update_vendor_by_id($cat_id, $data)
	{
		$res = $this->db->update('vendor', $data, ['id' => $cat_id]);
		if ($res == 1)
			return true;
		else
			return false;
	}

	public function get_category()
	{
		$this->db->select('categories.*');
		$this->db->from('categories');

		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_all_category()
	{
		$this->db->select('categories.*');
		$this->db->from('categories');

		$query = $this->db->get();
		return $query->result();
	}

	public function add_category($data)
	{
		$this->load->helper('url');

		return $this->db->insert('categories', $data);
	}

	public function get_category_by_id($id)
	{
		$this->db->select('*');
		$this->db->from('categories');
		$this->db->where("id", $id);
		$query = $this->db->get();
		if ($query) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function update_category_by_id($cat_id, $data)
	{
		$res = $this->db->update('categories', $data, ['id' => $cat_id]);
		if ($res == 1)
			return true;
		else
			return false;
	}

	public function get_all_sub_category()
	{
		$this->db->select('sub_categories.*');
		$this->db->from('sub_categories');

		$query = $this->db->get();
		return $query->result();
	}

	public function add_sub_category($data)
	{
		$this->load->helper('url');

		return $this->db->insert('sub_categories', $data);
	}

	public function get_sub_category_by_id($id)
	{
		$this->db->select('*');
		$this->db->from('sub_categories');
		$this->db->where("id", $id);
		$query = $this->db->get();
		if ($query) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function update_sub_category_by_id($cat_id, $data)
	{
		$res = $this->db->update('sub_categories', $data, ['id' => $cat_id]);
		if ($res == 1)
			return true;
		else
			return false;
	}

	public function get_restaurants()
	{
		$this->db->select('restaurants.*');
		$this->db->from('restaurants');
		$this->db->order_by("res_id", "desc");

		$query = $this->db->get();
		return $query->result_array();
	}

	public function add_restaurants($data)
	{
		$this->load->helper('url');

		return $this->db->insert('restaurants', $data);
	}

	public function get_restaurants_by_id($id)
	{
		$this->db->select('*');
		$this->db->from('restaurants');
		$this->db->where("res_id", $id);
		$query = $this->db->get();
		if ($query) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function update_restaurants_by_id($cat_id, $data)
	{
		$res = $this->db->update('restaurants', $data, ['res_id' => $cat_id]);
		if ($res == 1)
			return true;
		else
			return false;
	}

	public function get_like($id)
	{
		$this->db->select('likes.*,user.*');
		$this->db->from('likes');
		$this->db->join('user', 'user.id = likes.user_id');
		$this->db->where('res_id', $id);

		$query = $this->db->get();
		return $query->result();
	}

	public function get_review($id)
	{
		$this->db->select('reviews.*');
		$this->db->from('reviews');
		$this->db->where('rev_res', $id);


		$query = $this->db->get();
		return $query->result();
	}

	public function get_allreview()
	{
		$this->db->select('reviews.*');
		$this->db->from('reviews');
		$this->db->order_by("reviews.rev_id", "desc");
		$this->db->limit(10);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_new_users()
	{
		$this->db->select('user.*');
		$this->db->from('user');
		$this->db->order_by("id", "desc");
		$this->db->limit(10);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_all_banners()
	{
		$this->db->select('banners.*');
		$this->db->from('banners');

		$query = $this->db->get();
		return $query->result();
	}

	public function add_banners($data)
	{
		$this->load->helper('url');

		return $this->db->insert('banners', $data);
	}

	public function get_banners_by_id($id)
	{
		$this->db->select('*');
		$this->db->from('banners');
		$this->db->where("id", $id);
		$query = $this->db->get();
		if ($query) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function update_banners_by_id($cat_id, $data)
	{
		$res = $this->db->update('banners', $data, ['id' => $cat_id]);
		if ($res == 1)
			return true;
		else
			return false;
	}

	public function get_booking()
	{
		$this->db->select('booking.*');
		$this->db->from('booking');
		$this->db->order_by("id", "desc");

		$query = $this->db->get();
		return $query->result();
	}

	public function get_type()
	{
		$this->db->select('type.*');
		$this->db->from('type');
		
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_all_type()
	{
		$this->db->select('type.*');
		$this->db->from('type');
		$this->db->order_by("id", "desc");
		$query = $this->db->get();
		return $query->result();
	}

	public function add_type($data)
	{
		$this->load->helper('url');

		return $this->db->insert('type', $data);
	}

	public function get_type_by_id($id)
	{
		$this->db->select('*');
		$this->db->from('type');
		$this->db->where("id", $id);
		$query = $this->db->get();
		if ($query) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function update_type_by_id($cat_id, $data)
	{
		$res = $this->db->update('type', $data, ['id' => $cat_id]);
		if ($res == 1)
			return true;
		else
			return false;
	}

	public function get_all_product_category()
	{
		$this->db->select('product_category.*');
		$this->db->from('product_category');
		$this->db->order_by("id", "desc");
		$query = $this->db->get();
		return $query->result();
	}

	public function add_product_category($data)
	{
		$this->load->helper('url');

		return $this->db->insert('product_category', $data);
	}

	public function get_product_category_by_id($id)
	{
		$this->db->select('*');
		$this->db->from('product_category');
		$this->db->where("id", $id);
		$query = $this->db->get();
		if ($query) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function update_product_category_by_id($cat_id, $data)
	{
		$res = $this->db->update('product_category', $data, ['id' => $cat_id]);
		if ($res == 1)
			return true;
		else
			return false;
	}

	public function get_all_product()
	{
		$this->db->select('products.*');
		$this->db->from('products');
		$this->db->order_by('product_id', "desc");
		$query = $this->db->get();
		return $query->result();
	}

	public function add_product($data)
	{
		$this->load->helper('url');

		return $this->db->insert('products', $data);
	}

	public function get_products_by_id($id)
	{
		$this->db->select('*');
		$this->db->from('products');
		$this->db->where("product_id", $id);
		$query = $this->db->get();
		if ($query) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function update_product_by_id($id, $data)
	{
		$res = $this->db->update('products', $data, ['product_id' => $id]);
		if ($res == 1)
			return true;
		else
			return false;
	}

	public function get_all_testimonial_category()
	{
		$this->db->select('testimonial_category.*');
		$this->db->from('testimonial_category');
		$this->db->order_by("id", "desc");
		$query = $this->db->get();
		return $query->result();
	}

	public function add_testimonial_category($data)
	{
		$this->load->helper('url');

		return $this->db->insert('testimonial_category', $data);
	}

	public function get_testimonial_category_by_id($id)
	{
		$this->db->select('*');
		$this->db->from('testimonial_category');
		$this->db->where("id", $id);
		$query = $this->db->get();
		if ($query) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function update_testimonial_category_by_id($cat_id, $data)
	{
		$res = $this->db->update('testimonial_category', $data, ['id' => $cat_id]);
		if ($res == 1)
			return true;
		else
			return false;
	}

	public function get_all_testimonial()
	{
		$this->db->select('testimonial.*');
		$this->db->from('testimonial');
		$this->db->order_by("id", "desc");
		$query = $this->db->get();
		return $query->result();
	}

	public function add_testimonial($data)
	{
		$this->load->helper('url');

		return $this->db->insert('testimonial', $data);
	}

	public function get_testimonial_by_id($id)
	{
		$this->db->select('*');
		$this->db->from('testimonial');
		$this->db->where("id", $id);
		$query = $this->db->get();
		if ($query) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function update_testimonial_by_id($cat_id, $data)
	{
		$res = $this->db->update('testimonial', $data, ['id' => $cat_id]);
		if ($res == 1)
			return true;
		else
			return false;
	}

	public function get_all_orders()
	{
		$this->db->select('orders.*');
		$this->db->from('orders');
        $this->db->order_by("order_id", "desc");
		$query = $this->db->get();
		return $query->result();
	}

	public function get_order_by_id($id) {
        return $this->db->get_where('orders', array('order_id' => $id), 1)->row();
    }
    
    public function updateSettings($data) 
	{
		$this->db->where("id", 1)->update("general_setting", $data);
	}



	public function get_total_products()
	{
		return $this->db->get('products')->num_rows();
	}

	public function get_total_users()
	{
		return $this->db->get('user')->num_rows();
	}

	public function get_total_restaurants()
	{
		return $this->db->get('restaurants')->num_rows();
	}

	public function get_total_reviews()
	{
		return $this->db->get('reviews')->num_rows();
	}

	public function get_total_category()
	{
		return $this->db->get('categories')->num_rows();
	}

	public function get_total_Subscriptions()
	{
		return $this->db->get_where('user', array('isGold' => '1'))->num_rows();
	}

	public function get_vip_restaurants()
	{
		$this->db->select('restaurants.*');
		$this->db->from('restaurants');
		$this->db->where('status', 1);

		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_restaurant_by_id($res_id)
	{
		return $this->db->get_where('restaurants', array('res_id' => $res_id), 1)->row();
	}


	public function get_coupon($id)
	{
		$query = $this->db->get_where('coupon', array('id' => $id));
		return $query->row_array();
	}

	public function set_coupon($id)
	{
		$this->load->helper('url');

		$data = array(
			'coupon' => $this->input->post('coupon'),
			'per' => $this->input->post('per')
		);

		$this->db->where('id', $id);
		return $this->db->update('coupon', $data);
	}

	public function update_coupon($id, $sid)
	{
		$this->load->helper('url');

		$data = array(
			'status' => $sid
		);

		$this->db->where('id', $id);
		return $this->db->update('coupon', $data);
	}

	public function delete_coupon($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete('coupon');
	}

	public function set_user($id, $res_image)
	{
		$this->load->helper('url');

		if ($res_image == "") {
			$data = array(
				'email' => $this->input->post('email'),
				'name' => $this->input->post('name')
			);
		} else {
			$data = array(
				'email' => $this->input->post('email'),
				'name' => $this->input->post('name'),
				'img' => $res_image
			);
		}
		$this->db->where('id', $id);
		return $this->db->update('admin', $data);
	}

	public function delete_user($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete('user');
	}


	public function delete_subscription($id)
	{
		$this->db->where('sid', $id);
		return $this->db->delete('subscription');
	}

	public function get_subscriptions()
	{
		$this->db->select('user.*');
		$this->db->from('user');
		$this->db->where('pstatus', '1');

		$query = $this->db->get();
		return $query->result_array();
	}

	function tuser()
	{
		$this->db->select('*');
		$this->db->from('user');
		$id = $this->db->get()->num_rows();
		return $id;
	}



	function tsub()
	{
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('pstatus', '1');
		$id = $this->db->get()->num_rows();
		return $id;
	}

	public function state()
	{
		$this->db->select('state.*');
		$this->db->from('state');

		$query = $this->db->get();
		return $query->result_array();
	}

	public function email_check($email)
	{

		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('email', $email);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return false;
		} else {
			return true;
		}
	}

	public function register_user($user)
	{


		return $this->db->insert('user', $user);
	}
	public function get_profile($id)
	{
		$this->db->select('*');
		$this->db->from('admin');
		$this->db->where('id', $id);

		$query = $this->db->get();
		return $query->row_array();
	}

	public function set_profile($id, $img_name)
	{
		$this->load->helper('url');

		$data = array(
			'name' => $this->input->post('name'),
			'email' => $this->input->post('email'),
			'img' => $img_name
		);

		$this->db->where('id', $id);
		return $this->db->update('admin', $data);
	}

	public function change_pass($npassword, $id)
	{
		$this->load->helper('url');

		$data = array(
			'password' => $npassword
		);

		$this->db->where('id', $id);
		return $this->db->update('admin', $data);
	}

	public function delete_category($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete('categories');
	}

	public function delete_vendor($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete('vendor');
	}

	public function get_cat_details($cat_id)
	{
		return $this->db->get_where('categories', array('id' => $cat_id))->row();
	}
}
