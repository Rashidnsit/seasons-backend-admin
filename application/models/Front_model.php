<?php

class Front_model extends CI_Model
{
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

   public function facebook_id_check($facebook_id)
   {
      $this->db->select('*');
      $this->db->from('user');
      $this->db->where('facebook_id', $facebook_id);
      $query = $this->db->get();

      if ($query->num_rows() > 0) {
         return false;
      } else {
         return true;
      }
   }

   public function get_restaurant_by_id($res_id)
   {
      return $this->db->get_where('restaurants', array('res_id' => $res_id), 1)->row();
   }

   public function username_check($username)
   {

      $this->db->select('*');
      $this->db->from('user');
      $this->db->where('username', $username);
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

   public function likeCheck($user_id, $res_id)
   {
      $result = $this->db->get_where('likes', array('user_id' => $user_id, 'res_id' => $res_id));
      if ($result->num_rows() > 0) {
         return false;
      } else {
         return true;
      }
   }

   public function bookCheck($user_id, $date, $slot)
   {
      $result = $this->db->get_where('booking', array('user_id' => $user_id, 'date' => $date, 'slot' => $slot));
      if ($result->num_rows() > 0) {
         return false;
      } else {
         return true;
      }
   }

   public function login_user($email, $pass)
   {

      $this->db->select('*');
      $this->db->from('user');
      $this->db->where('email', $email);
      $this->db->or_where('username', $email);
      $this->db->where('password', $pass);

      if ($query = $this->db->get()) {
         return $query->row_array();
      } else {
         return false;
      }
   }

   public function login_vendor($email, $pass)
   {

      $this->db->select('*');
      $this->db->from('vendor');
      $this->db->where('email', $email);
      //$this->db->or_where('uname',$email);
      $this->db->where('password', $pass);

      if ($query = $this->db->get()) {
         return $query->row_array();
      } else {
         return false;
      }
   }

   public function get_user($id)
   {
      $query = $this->db->get_where('user', array('id' => $id), 1);
      return $query->row();
   }

   public function get_vendor($id)
   {
      $query = $this->db->get_where('vendor', array('id' => $id), 1);
      return $query->row();
   }

   public function get_res_by_id($id)
   {
      $query = $this->db->get_where('restaurants', array('res_id' => $id), 1);
      return $query->row();
   }

   public function get_res($id)
   {
      $query = $this->db->get_where('reviews', array('rev_user' => $id));
      return $query->result();
   }

   public function get_rev_by_id_res($res_id)
   {
      $query = $this->db->get_where('reviews', array('rev_res' => $res_id));
      return $query->result();
   }

   public function get_rev_by_id_user($id)
   {
      $query = $this->db->get_where('user', array('id' => $id), 1);
      return $query->row();
   }

   public function get_res_reviews($res_id)
   {
      return $this->db->get_where('reviews', array('rev_res' => $res_id))->result();
   }

   public function password_check($password, $id)
   {

      $this->db->select('*');
      $this->db->from('user');
      $this->db->where('password', $password);
      $this->db->where('id', $id);
      $query = $this->db->get();

      if ($query->num_rows() > 0) {
         return true;
      } else {
         return false;
      }
   }

   public function change_pass($npassword, $id)
   {
      $this->load->helper('url');

      $data = array(
         'password' => $npassword
      );

      $this->db->where('id', $id);
      return $this->db->update('user', $data);
   }

   public function unlike($res_id, $user_id)
   {
      $this->db->where('res_id', $res_id);
      $this->db->where('user_id', $user_id);
      return $this->db->delete('likes');
   }

   public function get_order_by_id($id)
   {
      return $this->db->get_where('booking', array('id' => $id), 1)->row();
   }

   public function update_payment($data, $id)
   {
      $this->db->where('id', $id);
      if ($this->db->update('booking', $data)) {
         return true;
      } else {
         return false;
      }
   }

   public function get_user_by_id($id)
   {
      return $this->db->get_where('user', array('id' => $id), 1)->row();
   }

   public function get_banners()
   {
      $this->db->select('image');
      $this->db->from('banners');
      $this->db->order_by("id", "desc");
      $this->db->limit(5);
      $query = $this->db->get();
      if ($query) {
         return $query->result();
      } else {
         return false;
      }
   }

   public function get_product_by_id($product_id)
   {
      return $this->db->get_where('products', array('product_id' => $product_id), 1)->row();
   }

   public function is_new_cart_item($user_id, $product_id)
   {
      $isNew = $this->db->get_where('cart_items', array('user_id' => $user_id, 'product_id' => $product_id), 1);
      if ($isNew->num_rows() > 0) {
         return false;
      } else {
         return true;
      }
   }

   public function get_pro_reviews($product_id)
   {
      return $this->db->get_where('reviews_product', array('rev_pro' => $product_id))->result();
   }

   public function get_rev_by_pro_id($product_id)
   {
      $query = $this->db->get_where('reviews_product', array('rev_pro' => $product_id));
      return $query->result();
   }

   public function get_pro_by_id($id)
   {
      $query = $this->db->get_where('products', array('product_id' => $id), 1);
      return $query->row();
   }

   public function get_user_by_rev_id($id)
   {
      $query = $this->db->get_where('user', array('id' => $id), 1);
      return $query->row();
   }

   public function likeCheck_product($user_id, $pro_id)
   {
      $result = $this->db->get_where('likes_product', array('user_id' => $user_id, 'pro_id' => $pro_id));
      if ($result->num_rows() > 0) {
         return false;
      } else {
         return true;
      }
   }

   public function unlike_product($pro_id, $user_id)
   {
      $this->db->where('pro_id', $pro_id);
      $this->db->where('user_id', $user_id);
      return $this->db->delete('likes_product');
   }

   public function remove_cart($cart_id)
   {
      $this->db->where('cart_id', $cart_id);
      // $this->db->where('user_id', $user_id);
      return $this->db->delete('cart_items');
   }

   public function clear_cart($user_id)
   {
      $this->db->where('user_id', $user_id);
      if ($this->db->delete('cart_items')) {
         return true;
      } else {
         return false;
      }
   }

   public function get_user_cart($user_id)
   {
      return $this->db->get_where('cart_items', array('user_id' => $user_id))->result();
   }

   public function get_product_order_by_id($id)
   {
      return $this->db->get_where('orders', array('order_id' => $id), 1)->row();
   }

   public function update_product_payment($data, $id)
   {
      $this->db->where('order_id', $id);
      if ($this->db->update('orders', $data)) {
         return true;
      } else {
         return false;
      }
   }

   public function get_user_orders($user_id)
   {
      $this->db->from('orders');
      $this->db->order_by("order_id", "DESC");
      $this->db->where("user_id", $user_id);
      $query = $this->db->get();
      return  $products = $query->result();
   }

   public function get_pro_by_cat_id($cat_id)
   {
      $this->db->select('products.*');
      $this->db->from('products');
      $this->db->where("cat_id", $cat_id);
      $this->db->order_by("product_id", "desc");
      $query = $this->db->get();
      return $query->result();
   }
}
