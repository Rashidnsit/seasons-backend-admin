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
					<h1>Add Product</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Home</a></li>
						<li class="breadcrumb-item active">Add Product</li>
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
							<h3 class="card-title">ADD PRODUCT</h3>
						</div>
						<!-- /.card-header -->
						<!-- form start -->
						<form method="POST" enctype="multipart/form-data" action="<?php echo base_url('admin/add-product'); ?>">
							<div class="col-md-12">
								<div class="box-body">

									<div class="form-group">
										<label>Category</label>
										<select class="form-control" name="cat_id">
											<option value="">Select Category</option>
											<?php $category = $this->admin_model->get_all_product_category(); ?>
											<?php foreach ($category as $listing) : ?>
												<option value="<?php echo $listing->id; ?>"><?php echo $listing->c_name; ?></option>
											<?php endforeach; ?>
										</select>
										<?php echo form_error('cat_id'); ?>
									</div>

									<div class="form-group">
										<label for="exampleInputfnm">Name</label>
										<input type="text" class="form-control" id="exampleInputfnm" placeholder="Enter Product Name" name="product_name">
										<?php echo form_error('product_name'); ?>
									</div>

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="exampleInputfnm">Description</label>
												<!-- <input type="text" class="form-control" id="exampleInputfnm" placeholder="Enter Product Name" name="product_description"> -->
												<textarea class="form-control" name="product_description" rows="3" placeholder="Start from here"></textarea>
												<?php echo form_error('product_description'); ?>
											</div>
										</div>

                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label for="exampleInputfnm">Price</label>
                                    <input type="number" class="form-control" id="exampleInputfnm" placeholder="Enter Price" name="product_price">
                                    <?php echo form_error('product_price'); ?>
                                 </div>
                              </div>
									</div>
                           
									<div class="form-group">
										<label for="exampleInputFile">Product Images</label>
										<div class="input-group">
											<div class="custom-file">
												<input type="file" name="product_image[]" class="custom-file-input" id="exampleInputFile" required multiple>
												<label class="custom-file-label" for="exampleInputFile">Choose file</label>
											</div>
										</div>
										<?php echo form_error('product_image'); ?>
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