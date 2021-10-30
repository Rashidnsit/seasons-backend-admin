<?php
// $id = $this->uri->segment(3);
$id = $this->session->userdata('aid');

$product = $this->admin_model->get_all_product();
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1><i class="nav-icon fa fa-product-hunt"> Product</i></h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Home</a></li>
						<li class="breadcrumb-item active">Product</li>
					</ol>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>

	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">

					<!--  <?php if (!empty($this->session->flashdata('success'))) : ?>
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

					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Product List</h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<table id="list_table" class="table table-bordered">
								<thead>
									<tr>
										<th>ID</th>
										<th>Image</th>
										<th>Category</th>
										<th>Product Name</th>
										<th>Description</th>
										<th>Price</th>

										<th>Actions</th>
									</tr>
								</thead>

								<tbody>

									<?php if (isset($product)) {
										$cnt = 1; ?>
										<?php foreach ($product as $row) { ?>
											<tr>
												<td><?php echo $cnt++; ?></td>

												<?php $images = explode("::::", $row->product_image); ?>

												<td>
													<img src="<?php echo base_url('uploads/product_images/') . $images[0] ?>" class="image" height="50" width="50">
												</td>

												<?php
												$category = $this->db->get_where('product_category', array('id' => $row->cat_id), 1)->row(); ?>
												<?php if (empty($category)) { ?>
													<td></td>
												<?php } else { ?>
													<td><?php echo $category->c_name; ?></td> <?php } ?>

												<td><?php echo $row->product_name; ?></td>

												<?php
												$str = $row->product_description;

												if (strlen($row->product_description) > 15) {
													$str = explode("\n", wordwrap($row->product_description, 15));
													$str = $str[0] . '...';
												}
												?>
												<td><?php echo $str; ?></td>
												<td><?php echo $row->product_price; ?></td>

												<td style="display: inline-flex;">
													<a class="btn btn-sm btn-info margin-5" href="<?php echo base_url('admin/edit-product/' . $row->product_id); ?>"><i class="fa fa-edit"></i></a>
													<button data-i="<?php echo $row->product_id; ?>" class="btn btn-sm btn-danger delete margin-5">
														<i class="fa fa-trash"></i></button>
												</td>
											</tr>
										<?php } ?>
									<?php } ?>
								</tbody>
							</table>
						</div>
						<!-- /.card-body -->
					</div>
					<!-- /.card -->
				</div>
				<!-- /.col -->
			</div>
			<!-- /.row -->
		</div>
		<!-- /.container-fluid -->
	</section>

</div>
<div class="modal fade in" id="modalDel">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Delete Confirmation</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
			</div>
			<form method="post" action="<?php echo base_url('admin/trash-product'); ?>" id="frmDel">
				<div class="modal-body">
					<p>Are you sure you want to delete?</p>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="id" value="">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<input type="submit" class="btn btn-primary btnclass" value="Yes Delete!">
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script type="text/javascript" src="<?php echo base_url() ?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$(document).on('click', '.delete', function() {
			var i = $(this).data('i');
			$("#frmDel input[name='id']").val(i);
			$("#modalDel").modal('show');
		});
	});
</script>