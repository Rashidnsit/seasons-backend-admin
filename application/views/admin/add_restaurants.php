<?php
// $id = $this->uri->segment(3);
$id = $this->session->userdata('aid');
$profile = $this->admin_model->get_admin($id);
$type = $this->admin_model->get_type();
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Add Store</h1>
					<!-- <h1>Add Store</h1> -->
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Home</a></li>
						<li class="breadcrumb-item active">Add Store</li>
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
							<h3 class="card-title">Add Store</h3>
						</div>
						<!-- /.card-header -->
						<!-- form start -->
						<form method="POST" enctype="multipart/form-data" action="<?php echo base_url('admin/add-restaurants'); ?>">
							<div class="col-md-12">
								<div class="box-body">

									<div class="row">
										<div class="col-sm-12">
											<div class="form-group">
												<label>Category</label>
												<select class="form-control" name="cat_id" required>
													<?php $category = $this->admin_model->get_category(); ?>
													<option value="">Select Category</option>
													<?php foreach ($category as $listing) : ?>
														<option value="<?php echo $listing['id']; ?>"><?php echo $listing['c_name']; ?></option>
													<?php endforeach; ?>
												</select>
											</div>
										</div>

										<!--<div class="col-sm-6">-->
										<!--	<div class="form-group">-->
										<!--		<label>Sub Category</label>-->
										<!--		<select class="form-control" name="scat_id" required>-->
										<!--			<?php $sub_category = $this->admin_model->get_all_sub_category(); ?>-->
										<!--			<option value="">Select Sub Category</option>-->
										<!--			<?php foreach ($sub_category as $listing) : ?>-->
										<!--				<option value="<?php echo $listing->id; ?>"><?php echo $listing->c_name; ?></option>-->
										<!--			<?php endforeach; ?>-->
										<!--		</select>-->
										<!--	</div>-->
										<!--</div>-->
									</div>



									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label for="exampleInputEmail1">Store Name</label>
												<input type="text" name="res_name" class="form-control" id="exampleInputEmail1" placeholder="Enter Store Name" required>
											</div>
										</div>

										<div class="col-sm-6">
											<div class="form-group">
												<label>Description</label>
												<textarea class="form-control" name="res_desc" rows="3" placeholder="Enter ..." required></textarea>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-6">
											<label for="exampleInputfnm">Hours</label>
											<div class="input-group">
												<input type="text" class="form-control" id="exampleInputfnm" placeholder="e.g. 4 to 5 Hrs" name="hours" required>
											</div>
										</div>

										<div class="col-md-6">
											<label for="exampleInputfnm">Experts</label>
											<div class="input-group">
												<input type="text" class="form-control" id="exampleInputfnm" placeholder="e.g. 03 Experts" name="experts" required>
											</div>
										</div>
									</div>

									<div class="form-group">
										<label for="exampleInputFile">Store Logo</label>
										<div class="input-group">
											<div class="custom-file">
												<input type="file" name="logo" class="custom-file-input" id="exampleInputFile" required>
												<label class="custom-file-label" for="exampleInputFile">Choose file</label>
											</div>
										</div>
										<?php echo form_error('logo'); ?>
									</div>

									<div class="form-group">
										<label for="exampleInputFile">Store Images</label>
										<div class="input-group">
											<div class="custom-file">
												<input type="file" name="res_image[]" class="custom-file-input" id="exampleInputFile" required multiple>
												<label class="custom-file-label" for="exampleInputFile">Choose file</label>
											</div>
										</div>
										<?php echo form_error('res_image'); ?>
									</div>

									<div class="table-repsonsive">
										<span id="error"></span>
										<table class="table table-bordered" id="item_table">
											<thead>
												<tr>
													<th>Type</th>
													<th>Price</th>
													<th><button type="button" name="add" class="btn btn-sm btn-success add"><span class="fa fa-plus"></span></button></th>
												</tr>
											</thead>
											<tbody></tbody>
										</table>
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