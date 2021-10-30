<?php
// $id = $this->uri->segment(3);
$id = $this->session->userdata('aid');
// $profile = $this->admin_model->get_admin($id);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Edit Vendor</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Home</a></li>
						<li class="breadcrumb-item active">Edit Vendor</li>
					</ol>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>
	<!-- <?php if (!empty($this->session->flashdata('success'))) : ?>
          <div class="alert alert-success">
            <a href="javascript:void()" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <span> <?php echo $this->session->flashdata('success'); ?> </span>
          </div>
        <?php endif ?>
        <?php if ($this->session->flashdata('error')) : ?>
          <div class="alert alert-danger">
            <a href="javascript:void()" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <span><?php echo $this->session->flashdata('error') ?></span>
          </div>
        <?php endif ?> -->
	<!-- Main content -->



	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<!-- left column -->
				<div class="col-lg-12">
					<!-- general form elements -->
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Edit Vendor</h3>
						</div>
						<!-- /.card-header -->
						<!-- form start -->
						<form method="POST" enctype="multipart/form-data" action="<?php echo base_url('admin/update-vendor'); ?>">
							<div class="col-md-12">
								<div class="box-body">

									<div class="form-group">
										<label>First Name</label>
										<input type="text" name="fname" value="<?php echo $vendor->fname; ?>" class="form-control" placeholder="First Name" autocomplete="off"><?php echo form_error('fname'); ?>
									</div>

									<div class="form-group">
										<label>Last Name</label>
										<input type="text" name="lname" value="<?php echo $vendor->lname; ?>" class="form-control" placeholder="Last Name" autocomplete="off"><?php echo form_error('lname'); ?>
									</div>

									<div class="form-group">
										<input type="hidden" name="id" value="<?php echo $vendor->id; ?>">
										<label>User Name</label>
										<input type="text" name="uname" value="<?php echo $vendor->uname; ?>" class="form-control" placeholder="Enter UserName" autocomplete="off"><?php echo form_error('uname'); ?>
									</div>

									<div class="form-group">
										<label>Email address</label>
										<input type="text" name="email" value="<?php echo $vendor->email; ?>" class="form-control" placeholder="Enter Email Id" autocomplete="off"><?php echo form_error('email'); ?>
									</div>

									<div class="form-group">
										<label for="exampleInputFile">Profile Image</label>
										<div class="input-group">
											<div class="custom-file">
												<input type="file" name="profile_image" class="custom-file-input" id="exampleInputFile">
												<label class="custom-file-label" for="exampleInputFile">Choose file</label>
											</div>
										</div>
									</div>

                           <div class="form-group">
                              <label for="exampleInputfnm">Password(Leave blank if not changed)</label>
                              <input type="password" name="password" class="form-control" placeholder="Enter Password" autocomplete="off"><?php echo form_error('password'); ?>
                           </div>

									<?php
									$profile = explode(":", $vendor->profile_image);
									if ($profile[0] == "https" || $profile[0] == "http") { ?>
										<img src="<?php echo $vendor->profile_image ?>" height="100" width="100">
									<?php } else { ?>
										<?php if (empty($vendor->profile_image)) { ?>
											<img src="<?php echo base_url('uploads/profile_pics/user.png') ?>" height="100" width="100">
										<?php } else { ?>
											<img src="<?php echo base_url('uploads/profile_pics/') . $vendor->profile_image ?>" height="100" width="100"> <?php } ?>
									<?php } ?>

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