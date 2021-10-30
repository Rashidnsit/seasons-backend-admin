<?php
$id = $this->uri->segment(3);
// $id = $this->session->userdata('aid');
  $get_review = $this->admin_model->get_review($id);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><i class="nav-icon fa fa-star"></i> Reviews</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?php echo base_url('admin/reviews-list'); ?>">Reviews List</a></li>
              <li class="breadcrumb-item active">Reviews</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

   <!-- <?php if(!empty($this->session->flashdata('success'))): ?>
          <div class="alert alert-success alert-dismissible fade show">
          <a href="javascript:void()" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <span> <?php echo $this->session->flashdata('success'); ?> </span>
          </div>
      <?php endif ?>
      <?php if($this->session->flashdata('error')): ?>
          <div class="alert alert-danger alert-dismissible fade show">
         <a href="javascript:void()" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <span><?php echo $this->session->flashdata('error') ?></span>
          </div>
      <?php endif ?> -->

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
           
            <div class="card card-primary">
               <div class="card-header">
                  <h3 class="card-title">Reviews View</h3>
               </div>
              <!-- /.card-header -->
               <div class="card-body">
                  <table id="list_table" class="table table-bordered table-striped">
                     <thead>
                     <tr>
                        <th>Sr no</th>
                        <th>User Name</th>
                        <th>Star</th>
                        <th>Text</th>
                        <th>Date</th>
                        <th>Action</th>
                     </tr>
                     </thead>
                     
                     <tbody>
                   
                     <?php if(isset($get_review)){ $cnt=1; ?>  
                     <?php foreach($get_review as $listing) { ?>
                      <tr>
                        <td><?php echo $cnt++; ?></td>
                        <?php 
                            $lid=$listing->rev_user;
                            
                            $query = $this->db->select('*')
                                      ->from('user')
                                      ->where('id',$lid)
                                      ->get();
                          $fetch=$query->row();  ?>

                          <?php if (empty($fetch)) { ?>
                            <td></td>
                          <?php } else { ?>
                            <td><?php 
                            echo $fetch->username; } ?></td>
                  
                        <td><?php echo $listing->rev_stars; ?></td>
                        <td><?php echo $listing->rev_text; ?></td>
                        <td><?php echo gmdate('d M Y', $listing->rev_date); ?></td>
                        <td>
                          <!-- <a href="<?php echo base_url('admin/delete_review/'.$listing->rev_id); ?>" class="btn btn-danger"><i class="fa fa-trash-o"></i></a> -->
                          <button data-i="<?php echo $listing->rev_id; ?>" class="btn btn-sm btn-danger delete">
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
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Delete Confirmation</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
      </div>
      <form method="post" action="<?php echo base_url('admin/trash-reviews'); ?>" id="frmDel">
        <div class="modal-body">
          <p>Are you sure you want to delete?</p>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="id" value="">
          <input type="hidden" name="review_id" value="<?php echo $id; ?>">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         <input type="submit" class="btn btn-primary btnclass" value="Yes Delete!">
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript" src="<?php echo base_url()?>assets/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script type="text/javascript" src="<?php echo base_url()?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript">
  
  $(document).ready(function(){
    $(document).on('click', '.delete', function(){
            var i = $(this).data('i');
            $("#frmDel input[name='id']").val(i);
            $("#modalDel").modal('show');
        });
    });
</script>