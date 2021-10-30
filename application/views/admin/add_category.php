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
					<h1>Add Category</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Home</a></li>
						<li class="breadcrumb-item active">Add Category</li>
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
							<h3 class="card-title">Add Category</h3>
						</div>
						<!-- /.card-header -->
						<!-- form start -->
						<form method="POST" enctype="multipart/form-data" action="<?php echo base_url('admin/add-category'); ?>">
							<div class="col-md-12">
								<div class="box-body">

									<div class="form-group">
										<label for="exampleInputfnm">Category Name</label>
										<input type="text" class="form-control" id="exampleInputfnm" placeholder="Enter Category" name="c_name">
										<?php echo form_error('c_name'); ?>
									</div>

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="exampleInputFile">Category Image</label>
												<div class="input-group">
													<div class="custom-file">
														<input type="file" name="img" class="custom-file-input" id="exampleInputFile" required>
														<label class="custom-file-label" for="exampleInputFile">Choose file</label>
													</div>
												</div>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<label for="exampleInputFile">Category Icon</label>
												<div class="input-group">
													<div class="custom-file">
														<input type="file" name="icon" class="custom-file-input" id="exampleInputFile">
														<label class="custom-file-label" for="exampleInputFile">Choose file</label>
													</div>
												</div>
											</div>
										</div>
									</div>

									<!--<div class="form-group">-->
									<!--	<label for="exampleInputfnm">Category Type</label>-->
									<!--	<div class="radio">-->
									<!--		<label>-->
									<!--			<input type="radio" id="optionsRadios1" name="type" value="vip">-->
									<!--			VIP-->
									<!--		</label>-->
									<!--	</div>-->
									<!--	<div class="radio">-->
									<!--		<label>-->
									<!--			<input type="radio" id="optionsRadios2" name="type" value="non_vip">-->
									<!--			NON-VIP-->
									<!--		</label>-->
									<!--	</div>-->
									<!--</div>-->

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