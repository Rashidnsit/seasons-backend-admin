<?php
// $id = $this->uri->segment(3);
// $id = $this->session->userdata('aid');
$booking = $this->admin_model->get_booking();
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1><i class="nav-icon fa fa-bold"> Booking</i></h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Home</a></li>
						<li class="breadcrumb-item active">Booking</li>
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
							<h3 class="card-title">Booking List</h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<table id="list_table" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>Sr no</th>
										<th>UserName</th>
										<th>Slot</th>
										<th>Date</th>
										<th>Store</th>
										<th>Amount</th>
										<th>TXN ID</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>

								<tbody>

									<?php if (isset($booking)) {
										$cnt = 1; ?>
										<?php foreach ($booking as $row) { ?>
											<tr>
												<td><?php echo $cnt++; ?></td>

												<?php
												$user = $this->db->get_where('user', array('id' => $row->user_id), 1)->row(); ?>
												<?php if (empty($user)) { ?>
													<td></td>
												<?php } else { ?>
													<td><?php echo $user->username; ?></td>
												<?php } ?>

												<td><?php echo $row->slot; ?></td>
												<td><?php echo $row->date; ?></td>

												<?php
												$restaurants = $this->db->get_where('restaurants', array('res_id' => $row->res_id), 1)->row(); ?>
												<?php if (empty($restaurants)) { ?>
													<td></td>
												<?php } else { ?>
												
												    <?php
													$res_name = $restaurants->res_name;

													if (strlen($restaurants->res_name) > 10) {
														$res_name = explode("\n", wordwrap($restaurants->res_name, 10));
														$res_name = $res_name[0] . '...';
													}
													?>
													<td><?php echo $res_name; ?></td>
												
													<!--<td><?php echo $restaurants->res_name; ?></td>-->
												<?php } ?>

												<td><?php echo $row->amount; ?></td>
												
												<?php
												$str = $row->txn_id;

												if (strlen($row->txn_id) > 10) {
													$str = explode("\n", wordwrap($row->txn_id, 10));
													$str = $str[0] . '...';
												}
												?>
												<td><?php echo $str; ?></td>
												
												<!--<td><?php echo $row->txn_id; ?></td>-->
												
										        <td><?php if ($row->status == "Confirm") {
														?>
														<span class="badge badge-info">Confirm</span>
													<?php
														} elseif ($row->status == "On Way") {
													?>
														<span class="badge badge-warning">On Way</span>
													<?php
														} elseif ($row->status == "Completed") {
													?>
														<span class="badge badge-success">Completed</span>
													<?php
														} else { ?>
														<span class="badge badge-danger">Cancel</span>
													<?php } ?>
												</td>

												<td style="display: inline-flex;">
													<a class="btn btn-sm btn-warning" href="<?php echo base_url('admin/view-booking/' . $row->id); ?>"><i class="fa fa-eye"></i></a>
													<button data-i="<?php echo $row->id; ?>" class="btn btn-sm btn-danger delete">
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
			<form method="post" action="<?php echo base_url('admin/trash-booking'); ?>" id="frmDel">
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