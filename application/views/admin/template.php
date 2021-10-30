<!-- not direct access -->
<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<!-- load header -->
<?php $this->load->view('admin/header');?>

<!-- load sidebar -->
<?php $this->load->view('admin/sidebar');?>

<!-- load content -->
<?php $this->load->view('admin/'.$page); ?>

<!-- load footer -->
<?php $this->load->view('admin/footer');?>
