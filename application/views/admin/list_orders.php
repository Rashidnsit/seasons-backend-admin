<?php
// $id = $this->uri->segment(3);
// $id = $this->session->userdata('aid');
$orders = $this->admin_model->get_all_orders();
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1><i class="fa fa-opencart" aria-hidden="true"> Orders</i></h1>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Home</a></li>
                  <li class="breadcrumb-item active">Orders</li>
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
                     <h3 class="card-title">Orders List</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                     <table id="list_table" class="table table-bordered table-striped">
                        <thead>
                           <tr>
                              <th>Id</th>
                              <th>Order date</th>
                              <th>Customer</th>
                              <th>Grand total</th>
                              <th>Payment</th>
                              <th>Status</th>
                              <th>Address</th>

                              <th>Actions</th>
                           </tr>
                        </thead>

                        <tbody>

                           <?php if (isset($orders)) {
                              $cnt = 1; ?>
                              <?php foreach ($orders as $row) { ?>
                                 <tr>

                                    <td><?php echo $cnt++; ?></td>

                                    <td><?php echo date("D, M j, Y,h:i a", $row->date); ?></td>

                                    <?php
                                    $user = $this->db->get_where('user', array('id' => $row->user_id), 1)->row(); ?>
                                    <?php if (empty($user)) { ?>
                                       <td></td>
                                    <?php } else { ?>
                                       <td><?php echo $user->username; ?></td> <?php } ?>

                                    <td><?php echo $row->total; ?></td>

                                    <td><?php if ($row->p_status == '') { ?>
                                          <span class="badge badge-danger">UNPAID</span>
                                       <?php } else { ?>
                                          <span class="badge badge-success">SUCCESS</span> <?php } ?>
                                    </td>
                                    </td>

                                    <td><?php if ($row->order_status == 0) {
                                          ?>
                                          <span class="badge badge-info">Processing</span>
                                       <?php
                                          } elseif ($row->order_status == 1) {
                                       ?>
                                          <span class="badge badge-warning">Dispatch</span>
                                       <?php
                                          } elseif ($row->order_status == 2) {
                                       ?>
                                          <span class="badge badge-success">Deliver</span>
                                       <?php
                                          } else { ?>
                                          <span class="badge badge-danger">Cancel</span>
                                          <?php } ?>
                                    </td>

                                    <?php
                                    $str = $row->address;

                                    if (strlen($row->address) > 10) {
                                       $str = explode("\n", wordwrap($row->address, 10));
                                       $str = $str[0] . '...';
                                    }
                                    ?>
                                    <td><?php echo $str; ?></td>

                                    <td style="display: inline-flex;">
                                       <a href="<?php echo base_url('admin/view-order/' . $row->order_id) ?>" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="View"><span class="fa fa-eye"></span></a>

                                       <button data-i="<?php echo $row->order_id; ?>" class="btn btn-sm btn-danger delete margin-5" data-toggle="tooltip" data-placement="bottom" data-original-title="Delete"><i class="fa fa-trash"></i></button>

                                       <!-- <a class="btn btn-sm btn-info margin-5" href="<?php echo base_url('admin/edit-orders/' . $row->id); ?>" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Invoice">Invoice</a> -->
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
         <form method="post" action="<?php echo base_url('admin/trash-orders'); ?>" id="frmDel">
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
<script>
   $(function() {
      bsCustomFileInput.init();
   });
   $(document).ready(function() {
      $('[data-toggle="tooltip"]').tooltip();
   });
</script>