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
					<h1>Add Vendor</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Home</a></li>
						<li class="breadcrumb-item active">Add Vendor</li>
					</ol>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>
	<!-- Main content -->

	<section class="content">
		<div class="container-fluid">

			<?php if (!empty($this->session->flashdata('success'))) : ?>
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
			<?php endif ?>

			<div class="row">
				<!-- left column -->
				<div class="col-lg-12">
					<!-- general form elements -->
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Add Vendor</h3>
						</div>
						<!-- /.card-header -->
						<!-- form start -->
						<form method="POST" enctype="multipart/form-data" action="<?php echo base_url('admin/add-vendor'); ?>">
							<div class="col-md-12">
								<div class="box-body">

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="exampleInputfnm">First Name</label>
												<input type="text" class="form-control" id="exampleInputfnm" placeholder="Enter First Name" name="fname">
												<?php echo form_error('fname'); ?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="exampleInputfnm">Last Name</label>
												<input type="text" class="form-control" id="exampleInputfnm" placeholder="Enter Last Name" name="lname">
												<?php echo form_error('lname'); ?>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="exampleInputfnm">User Name</label>
												<input type="text" class="form-control" id="exampleInputfnm" placeholder="Enter User Name" name="uname">
												<?php echo form_error('uname'); ?>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<label for="exampleInputfnm">Email</label>
												<input type="text" class="form-control" id="exampleInputfnm" placeholder="Enter Email" name="email">
												<?php echo form_error('email'); ?>
											</div>
										</div>
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

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="exampleInputfnm">Password</label>
												<input type="password" class="form-control" id="exampleInputfnm" placeholder="Enter Password" name="password">
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<label for="exampleInputfnm">Confirm Password</label>
												<input type="password" class="form-control" id="exampleInputfnm" placeholder="Enter Confirm Password" name="cpassword">
											</div>
										</div>
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