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
					<h1>Edit Store</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Home</a></li>
						<li class="breadcrumb-item active">Edit Store</li>
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
							<h3 class="card-title">Edit Store</h3>
						</div>
						<!-- /.card-header -->
						<!-- form start -->
						<form method="POST" enctype="multipart/form-data" action="<?php echo base_url('admin/update-restaurants'); ?>">
							<div class="col-md-12">
								<div class="box-body">
									<input type="hidden" name="id" value="<?php echo $restaurant->res_id; ?>">

									<div class="row">
										<div class="col-sm-12">
											<div class="form-group">
												<label>Category</label>
												<select class="form-control" name="cat_id" required>
													<option value="">Select Category</option>
													<?php $category = $this->admin_model->get_category(); ?>
													<?php foreach ($category as $listing) : ?>
														<option value="<?php echo $listing['id']; ?>" <?php if ($listing['id'] == $restaurant->cat_id) echo "selected='selected'"; ?>><?php echo $listing['c_name']; ?></option>
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
														<!-- <option value="<?php echo $listing->id; ?>"><?php echo $listing->c_name; ?></option> -->

										<!--				<option value="<?php echo $listing->id; ?>" <?php if ($listing->id == $restaurant->scat_id) echo "selected='selected'"; ?>><?php echo $listing->c_name; ?></option>-->
										<!--			<?php endforeach; ?>-->
										<!--		</select>-->
										<!--	</div>-->
										<!--</div>-->
									</div>

									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label for="exampleInputEmail1">Store Name</label>
												<input type="text" name="res_name" class="form-control" id="exampleInputEmail1" value="<?php echo $restaurant->res_name; ?>" required>
											</div>
										</div>

										<div class="col-sm-6">
											<div class="form-group">
												<label>Description</label>
												<textarea class="form-control" name="res_desc" rows="3" required><?php echo $restaurant->res_desc; ?></textarea>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-6">
											<label for="exampleInputfnm">Hours</label>
											<div class="input-group">
												<input type="text" class="form-control" id="exampleInputfnm" placeholder="e.g. 4 to 5 Hrs" name="hours" value="<?php echo $restaurant->hours; ?>" required>
											</div>
										</div>

										<div class="col-md-6">
											<label for="exampleInputfnm">Experts</label>
											<div class="input-group">
												<input type="text" class="form-control" id="exampleInputfnm" placeholder="e.g. 03 Experts" name="experts" value="<?php echo $restaurant->experts; ?>" required>
											</div>
										</div>
									</div>

									<div class="form-group">
										<label for="exampleInputFile">Store Logo</label>
										<div class="input-group">
											<div class="custom-file">
												<input type="file" name="logo" class="custom-file-input" id="exampleInputFile">
												<label class="custom-file-label" for="exampleInputFile">Choose file</label>
											</div>
										</div>
										<p class="help-block"></p>
										<?php if ($restaurant->logo) { ?>
											<img src="<?php echo base_url('uploads/') . $restaurant->logo; ?>" class="res_image" height="70" width="70">
										<?php } ?>
									</div>

									<div class="form-group">
										<label for="exampleInputFile">Store Images</label>
										<div class="input-group">
											<div class="custom-file">
												<input type="file" name="res_image[]" class="custom-file-input" id="exampleInputFile" multiple>
												<label class="custom-file-label" for="exampleInputFile">Choose file</label>
											</div>
										</div>
										<p class="help-block"></p>
										<?php $images = explode("::::", $restaurant->res_image); ?>
										<?php foreach ($images as $key => $image) { ?>
											<img src="<?php echo base_url('uploads/') . $image ?>" class="res_image" height="70" width="70">
										<?php } ?>
									</div>

									<?php
									$imgsac = array();
									$imgsaca = array();
									$producta = unserialize($restaurant->structure);
									if (!empty($producta)) {

										for ($ja = 0; $ja < count($producta); $ja++) {
											$fee_details_ida = $producta[$ja];
											$explodea = explode(',', $fee_details_ida);

											$imgsaca['type'] = $explodea[0];

											$imgsaca['type_name'] = $this->db->get_where('type', array('id' => $imgsaca['type']))->row()->c_name;

											$imgsaca['price'] = $explodea[1];
											array_push($imgsac, $imgsaca);
										}
										// $res[$i]->type = $imgsac;
									}
									?>

									<!-- <div class="table-repsonsive">
										<span id="error"></span>
										<table class="table table-bordered" id="item_table">
											<thead>
												<tr>
													<th>Type</th>
													<th>Price</th>
													<th><button type="button" name="edit" class="btn btn-sm btn-success edit"><span class="fa fa-plus"></span></button></th>
												</tr>
											</thead>
											<tbody></tbody>
										</table>
									</div> -->

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

<script type="text/javascript" src="<?php echo base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script type="text/javascript" src="<?php echo base_url() ?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>

<?php $type = $this->admin_model->get_type(); ?>
<script>
	$(document).ready(function() {

		var count = 0;

		$(document).on('click', '.edit', function() {
			count++;
			var html = '';
			html += '<tr>';
			html += '<td><select name="type[]" class="form-control item_category" data-sub_category_id="' + count + '" required><option value="">Select Category</option><?php foreach ($type as $catat) { ?><option value="<?php echo $catat['id']; ?>"><?php echo $catat['c_name']; ?></option><?php } ?></select></td>';
			html += '<td><input type="number" name="price[]" class="form-control item_name" required/></td>';
			html += '<td><button type="button" name="remove" class="btn btn-sm btn-danger remove"><span class="fa fa-minus"></span></button></td>';
			$('tbody').append(html);
		});

		$(document).on('click', '.remove', function() {
			$(this).closest('tr').remove();
		});

	});
</script>