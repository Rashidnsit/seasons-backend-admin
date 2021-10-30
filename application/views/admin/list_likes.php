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
            <h1><i class="nav-icon fa fa-heart"></i> Likes</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Likes</li>
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
                  <h3 class="card-title">Likes List</h3>
               </div>
              <!-- /.card-header -->
               <div class="card-body">
                  <table id="list_table" class="table table-bordered table-striped">
                     <thead>
                     <tr>
                       <th>Sr no</th>
                       <th>Restaurant Name</th>
                       <th>Count</th>
                       <th>Actions</th>
                     </tr>
                     </thead>
                     
                     <tbody>
                   
                     <?php if(isset($restaurants)){ $cnt=1; ?>  
                     <?php foreach($restaurants as $listing) { ?>
                      <tr>
                        <td><?php echo $cnt++; ?></td>
                        <td><?php echo $listing['res_name']; ?></td>
                        <td><span class="badge badge-info">
                          <?php 
                        $lid=$listing['res_id'];
                        
                        $this->db->select('*');
                        $this->db->from('likes');
                        $this->db->where('res_id',$lid);
                        $query = $this->db->get();
                        echo $query->num_rows();
                        
                        ?></span></td>
                        <td>
                          <a href="<?php echo base_url('admin/like-view/'.$listing['res_id']); ?>" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="View"><span class="fa fa-eye"></span></a>
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
      <form method="post" action="<?php echo base_url('admin/trash-vendor'); ?>" id="frmDel">
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