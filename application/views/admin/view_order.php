<?php
$order_id = $this->uri->segment(3);
$order = $this->admin_model->get_order_by_id($order_id);

$user = $this->db->get_where('user', array('id' => $order->user_id), 1)->row();
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1>Invoice</h1>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Home</a></li>
                  <li class="breadcrumb-item active">Invoice</li>
               </ol>
            </div>
         </div>
      </div><!-- /.container-fluid -->
   </section>

   <section class="content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-12">
              
               <div class="invoice p-3 mb-3">
                  <!-- title row -->
                  <div class="row">
                     <div class="col-12">
                        <h4>
                           <i class="fas fa-globe"></i> Ezshield
                           <small class="float-right"><?php echo "Date : " . date('d-m-Y', $order->date); ?></small>
                        </h4>
                     </div>
                     <!-- /.col -->
                  </div>
                  <!-- info row -->
                  <div class="row invoice-info">
                     <div class="col-sm-4 invoice-col">
                        User Details
                        <address>
                           <?php if (empty($user->username)) { ?>
                              <strong></strong><br>
                           <?php } else { ?>
                              <strong><?php echo $user->username ?></strong><br>
                           <?php }  ?>

                           <?php if (empty($user->phone)) { ?>
                           <?php } else { ?>
                              Phone: <?php echo $user->phone ?><br>
                           <?php }  ?>

                           <?php if (empty($user->email)) { ?>
                           <?php } else { ?>
                              Email: <?php echo $user->email ?><br>
                           <?php }  ?>

                        </address>
                     </div>

                     <div class="col-sm-4 invoice-col">
                        <br>
                        <b>Order ID:</b> <?php echo $order->order_id; ?><br>
                        <b>Payment Mode:</b> <span class='badge badge-primary'><?php echo $order->payment_mode; ?></span><br>
                        <b>Shipping Address:</b> <?php echo $order->address; ?>
                     </div>
                     <!-- /.col -->
                  </div>
                  <!-- /.row -->

                  <!-- Table row -->
                  <div class="row">
                     <div class="col-12 table-responsive">
                        <table class="table table-striped">
                           <thead>
                              <tr>
                                 <th>SrNo</th>
                                 <th>Name</th>
                                 <th>Quantity</th>
                                 <th>Product Price</th>
                                 <th>Total Price</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php
                              $product = json_decode($order->items);
                              $no = 0;
                              foreach ($product as $key => $cart_item) {
                                 $no = $no + 1;
                              ?>
                                 <tr>
                                    <?php $product_nm = $this->db->get_where('products', array('product_id' => $cart_item->product_id), 1)->row(); ?>
                                    <td><?php echo $no; ?></td>

                                    <td>
                                       <?php
                                       if (!empty($product_nm->product_name)) {
                                          echo $product_nm->product_name;
                                       }
                                       ?>
                                    </td>

                                    <td><span class='badge badge-success'><?php echo $cart_item->quantity; ?></span></td>
                                    <td>
                                       <?php
                                       if (!empty($product_nm)) {

                                          echo $product_nm->product_price;
                                       } ?>

                                    </td>
                                    <td>
                                       <?php
                                       if (!empty($product_nm)) {

                                          echo $product_nm->product_price * $cart_item->quantity;
                                       } ?>

                                    </td>
                                 </tr>
                              <?php } ?>
                              <tr>
                                 <td></td>
                                 <td></td>
                                 <td></td>

                                 <td><Strong>Total</strong></td>
                                 <td><span class='badge badge-success' style="font-size: 14px;"><?php echo $order->total; ?></span></td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                    
                  </div>
               </div>
               
            </div>
         </div>
      </div>
   </section>
   
   <section class="content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-3">
            </div>
            <div class="col-6">
               <!-- Main content -->
               <div class="invoice p-3 mb-3">
                  <div class="row invoice-info">

                     <div class="col-md-12">
                        <div class="white-area-content content-separator">
                           <h4 class="media-title">Update Order Status</h4>
                           <form action="<?php echo base_url('admin/change-status'); ?>" class="form-horizontal" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                              
                              <input type="hidden" name="order_id" value="<?php echo $this->uri->segment(3); ?>">
                              <div id="file_block">
                                 <div class="form-group">
                                    <label for="p-in" class="col-md-4 label-heading">Select Status</label>
                                    <div class="col-md-12">
                                       <select name="status" id="status" class="form-control" required>
                                          <option value="">Select Status</option>
                                          <option value="0" <?php if ($order->order_status == 0) {
                                                               echo "selected='selected'";
                                                            }
                                                            ?>>Processing</option>
                                          <option value="1" <?php if ($order->order_status == 1) {
                                                               echo "selected='selected'";
                                                            }
                                                            ?>>Dispatch</option>
                                          <option value="2" <?php if ($order->order_status == 2) {
                                                               echo "selected='selected'";
                                                            }
                                                            ?>>Deliver</option>
                                            <option value="3" <?php if ($order->order_status == 3) {
                                                               echo "selected='selected'";
                                                            }
                                                            ?>>Cancel</option>
                                       </select>
                                    </div>
                                 </div>
                                 
                              </div>
                              <hr>
                              <center>
                                 
                                 <p><input type="submit" class="btn btn-primary btn-sm form-control" value="Change"></p>
                              </center>
                           </form>
                        </div>
                     </div>


                  </div>
                  <!-- /.invoice -->
               </div><!-- /.col -->
            </div><!-- /.row -->
         </div><!-- /.container-fluid -->
      </div>
   </section>

</div>