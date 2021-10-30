<?php
// $id = $this->uri->segment(3);
// $id = $this->session->userdata('aid');
$restaurants = $this->admin_model->get_restaurants();
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1><i class="nav-icon fa fa-scribd"></i> Store </h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Home</a></li>
						<li class="breadcrumb-item active">Store </li>
					</ol>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>

	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">

					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Store List</h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<table id="list_table" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>Sr no</th>
										<!-- <th>Vendor Name</th> -->
										<th>Category</th>
										<!--<th>Sub Category</th>-->
										<th>Store Name</th>
										<th>Image</th>
										<th>Description</th>
										<th>Date</th>
										<th>Action</th>
									</tr>
								</thead>

								<tbody>

									<?php if (isset($restaurants)) {
										$cnt = 1; ?>
										<?php foreach ($restaurants as $listing) { ?>
											<tr>
												<td><?php echo $cnt++; ?></td>

												<!-- <?php
														$vendor = $this->db->get_where('vendor', array('id' => $listing['vid']), 1)->row(); ?>
												<?php if (empty($vendor)) { ?>
													<td></td>
												<?php } else { ?>
													<td><?php echo $vendor->username; ?></td>
												<?php } ?> -->

												<?php $cat_name = $this->admin_model->get_cat_details($listing['cat_id'])->c_name; ?>
												<td><?php echo $cat_name; ?></td>

												<td><?php echo $listing['res_name']; ?></td>

												<?php if ($listing['res_image'] != " ") { ?>
													<?php $image = explode('::::', $listing['res_image'])[0]; ?>
													<td><img src="<?php echo base_url(); ?>uploads/<?php echo $image; ?>" height="60" width="60"></td>
												<?php } else { ?>
													<td><?php echo "None"; ?></td>
												<?php } ?>

												<?php

												$string = strip_tags($listing['res_desc']);
												if (strlen($string) > 15) {

													// truncate string
													$stringCut = substr($string, 0, 10);
													$endPoint = strrpos($stringCut, ' ');

													//if the string doesn't contain any space then it will cut without word basis.
													$string = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
												}
												?>
												<td><?php echo $string . '...'; ?></td>

												<td><?php echo gmdate('d M Y', $listing['res_create_date']); ?></td>

												<td style="display: inline-flex;">
													<a class="btn btn-sm btn-info" href="<?php echo base_url('admin/edit-restaurants/' . $listing['res_id']); ?>"><i class="fa fa-edit"></i></a>
													<button data-i="<?php echo $listing['res_id']; ?>" class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i></button>
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
			<form method="post" action="<?php echo base_url('admin/trash-restaurants'); ?>" id="frmDel">
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