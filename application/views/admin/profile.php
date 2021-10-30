<?php
// $id = $this->uri->segment(3);
$id = $this->session->userdata('aid');
  $profile = $this->admin_model->get_admin($id);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->

    <section class="content">
      <div class="container-fluid">
        <?php if(!empty($this->session->flashdata('success'))): ?>
          <div class="alert alert-success">
            <a href="javascript:void()" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <span> <?php echo $this->session->flashdata('success'); ?> </span>
          </div>
        <?php endif ?>
        <?php if($this->session->flashdata('error')): ?>
          <div class="alert alert-danger">
            <a href="javascript:void()" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <span><?php echo $this->session->flashdata('error') ?></span>
          </div>
        <?php endif ?>
        <div class="row">
          <!-- left column -->
          <div class="col-lg-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Profile Update</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" enctype="multipart/form-data" action="<?php echo base_url('admin/admin-edit'); ?>">
            <div class="col-md-12">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputfnm">Username</label>
                  <input type="text" class="form-control" id="exampleInputfnm" placeholder="Enter Username" name="name" value="<?php echo $profile['name'] ?>">
                  <?php echo form_error('name'); ?>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Email address</label>
                  <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" name="email" value="<?php echo $profile['email'] ?>">
                  <?php echo form_error('email'); ?>
                </div>
                <div class="form-group">
                  <label for="exampleInputimg">Profile Image</label>
                  <input type="file" class="form-control" id="exampleInputimg"  name="img">
                </div>
              </div>
              <div class="col-md-4">
                <img src="<?php echo base_url();  ?>/uploads/profile_pics/<?php echo $profile['img'] ?>" class="img-thumbnail" height="100" width="100">
              </div>
                <div class="card-footer">
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
            </form>
            </div>
          </div>

          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Change Password</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" enctype="multipart/form-data" action="<?php echo base_url('admin/change-password'); ?>">
              <div class="col-md-12">
                <div class="box-body">
                  <div class="form-group">
                    <label for="exampleInputfnm">Old Password</label>
                    <input type="password" class="form-control" id="exampleInputfnm" placeholder="Old Password" name="password">
                      <?php echo form_error('password'); ?>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputfnm">New Password</label>
                    <input type="password" class="form-control" id="exampleInputfnm" placeholder="New Password" name="npassword">
                      <?php echo form_error('npassword'); ?>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputfnm">Confirm Password</label>
                    <input type="password" class="form-control" id="exampleInputfnm" placeholder="Confirm Password" name="cpassword">
                      <?php echo form_error('cpassword'); ?>
                  </div>
                </div>
                  <div class="card-footer">
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                  </div>
              </div>
            </form>
            </div>
          </div>

        </div>
        <!-- /.row -->

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>