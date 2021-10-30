<?php
// $id = $this->uri->segment(3);
// $id = $this->session->userdata('aid');
// $profile = $this->admin_model->get_admin($id);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Edit Sub Category</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Home</a></li>
						<li class="breadcrumb-item active">Edit Sub Category</li>
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
							<h3 class="card-title">Edit Sub Category</h3>
						</div>
						<!-- /.card-header -->
						<!-- form start -->
						<form method="POST" enctype="multipart/form-data" action="<?php echo base_url('admin/update-sub-category'); ?>">
							<div class="col-md-12">
								<div class="box-body">

									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label>Category</label>
												<select class="form-control" name="cat_id" required>
													<option value="">Select Category</option>
													<?php $category = $this->admin_model->get_all_category(); ?>
													<?php foreach ($category as $listing) : ?>
														<option value="<?php echo $listing->id; ?>" <?php if ($listing->id == $subcategory->cat_id) echo "selected='selected'"; ?>><?php echo $listing->c_name; ?></option>
													<?php endforeach; ?>
												</select>
											</div>
										</div>

										<div class="col-sm-6">
											<div class="form-group">
												<label>Sub Category Name</label>
												<input type="text" name="c_name" value="<?php echo $subcategory->c_name; ?>" class="form-control" placeholder="Sub Category Name" autocomplete="off"><?php echo form_error('c_name'); ?>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label for="exampleInputFile">Sub Category Image</label>
												<input type="hidden" name="id" value="<?php echo $subcategory->id; ?>">
												<div class="input-group">
													<div class="custom-file">
														<input type="file" name="img" class="custom-file-input" id="exampleInputFile">
														<label class="custom-file-label" for="exampleInputFile">Choose file</label>
													</div>
												</div>
											</div>
											<img src="<?php echo base_url('uploads/') . $subcategory->img ?>" class="image" height="100" width="100" style="border: 2px solid #000;padding: 5px;">
										</div>

										<div class="col-sm-6">
											<div class="form-group">
												<label for="exampleInputFile">Sub Category Icon</label>
												<div class="input-group">
													<div class="custom-file">
														<input type="file" name="icon" class="custom-file-input" id="exampleInputFile">
														<label class="custom-file-label" for="exampleInputFile">Choose file</label>
													</div>
												</div>
											</div>
											<img src="<?php echo base_url('uploads/') . $subcategory->icon ?>" class="image" height="100" width="100" style="border: 2px solid #000;padding: 5px;">
										</div>
									</div>

									<div class="form-group">
										<label for="exampleInputFile">Category Type</label>
										<div class="radio">
											<label>
												<input type="radio" id="optionsRadios1" name="type" <?php echo ($subcategory->type == "vip" ? "checked" : "") ?> value="vip">
												VIP
											</label>
										</div>
										<div class="radio">
											<label>
												<input type="radio" id="optionsRadios2" name="type" <?php echo ($subcategory->type == "non_vip" ? "checked" : "") ?> value="non_vip">
												NON-VIP
											</label>
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