 <?php
	$id = $this->uri->segment(3);
	$booking = $this->db->get_where('booking', array('id' => $id))->row();
	?>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
 <div class="content-wrapper">

 	<section class="content-header">
 		<div class="container-fluid">
 			<div class="row mb-2">
 				<div class="col-sm-6">
 					<h1>View Booking</h1>
 				</div>
 				<div class="col-sm-6">
 					<ol class="breadcrumb float-sm-right">
 						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Home</a></li>
 						<li class="breadcrumb-item active">View Booking</li>
 					</ol>
 				</div>
 			</div>
 		</div>
 	</section>

 	<section class="content">
 		<div class="container-fluid">
 			<div class="row">
 				<div class="col-12">
 					<?php

						$userid = $booking->user_id;
						$resid = $booking->res_id;

						$user = $this->db->get_where('user', array('id' => $userid))->row_array();

						$res = $this->db->get_where('restaurants', array('res_id' => $resid))->row_array();
						?>
 					<!-- Main content -->
 					<div class="invoice p-3 mb-3">
 						<!-- title row -->
 						<div class="row">
 							<div class="col-12">
 								<h4>
 									<img src="<?php echo base_url('uploads/profile_pics/') ?><?php echo $user['profile_pic']; ?>" alt="profile" class="img-lg rounded-circle mb-3">
 								</h4>

 							</div>
 							<!-- /.col -->
 						</div>
 						<!-- info row -->
 						<div class="row invoice-info">
 							<div class="col-sm-4 invoice-col">
 								<!-- User Details -->
 								<address>
 									<h3><?php echo $user['username']; ?></h3>
 									<p><strong>Email: </strong> <?php echo $user['email']; ?></p>
 									<p><strong>Phone Number: </strong> <?php echo $user['mobile']; ?></p>
 									<p><strong>Address: </strong> <?php echo $user['address']; ?></p>
 									<p><strong>City: </strong> <?php echo $user['city']; ?></p>
 									<p><strong>Country: </strong> <?php echo $user['country']; ?></p>
 								</address>
 							</div>
 							<div class="col-sm-4 invoice-col">
 								<br>
 								<p><b>Order ID: </b> <?php echo $booking->id; ?><br></p>
 								<p><b>ORDER TOTAL: </b> <?php echo $booking->amount; ?><br></p>
 								<p><b>PAYMENT Id: </b> <?php echo $booking->txn_id; ?><br></p>
 								<p><b>Booking Time Slot: </b> <?php echo $booking->slot; ?><br></p>
 								<p><b>Booking Date: </b> <?php echo $booking->date; ?><br></p>
 							</div>
 							<div class="col-sm-4 invoice-col">
 								<br>
 								<?php if (!empty($res['res_name'])) { ?>
 									<h3><strong>Store Name :</strong> <?php echo $res['res_name']; ?><br></h3>
 								<?php } else { ?>
 									<h3><strong>Store Name :</strong> <br></h3>
 								<?php } ?>

 								<?php if (!empty($res['cat_id'])) { ?>
 									<p><b>Category: </b>
 										<?php
											$catid = $res['cat_id'];
											$cat = $this->db->get_where('categories', array('id' => $catid))->row_array();
											echo $cat['c_name']; ?>
 										<br>
 									</p>
 								<?php } else { ?>
 									<p><b>Category: </b><br></p>
 								<?php } ?>

 								<?php if (!empty($res['scat_id'])) { ?>
 									<p><b>Sub Category: </b>
 										<?php
											$catida = $res['scat_id'];
											$cata = $this->db->get_where('sub_categories', array('id' => $catida))->row_array();
											echo $cata['c_name']; ?>
 										<br>
 									</p>
 								<?php } else { ?>
 									<p><b>Sub Category: </b><br></p>
 								<?php } ?>

 								<?php if (!empty($res['res_desc'])) { ?>
 									<p><b>Description: </b> <?php echo $res['res_desc']; ?><br></p>
 								<?php } else { ?>
 									<p><b>Description: </b> <br></p>
 								<?php } ?>

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
                           <h4 class="media-title">Update Booking Status</h4>
                           <form action="<?php echo base_url('admin/change-booking-status'); ?>" class="form-horizontal" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                              
                              <input type="hidden" name="id" value="<?php echo $this->uri->segment(3); ?>">
                              <div id="file_block">
                                 <div class="form-group">
                                    <label for="p-in" class="col-md-4 label-heading">Select Status</label>
                                    <div class="col-md-12">
                                       <select name="status" id="status" class="form-control" required>
                                          <option value="">Select Status</option>
                                          <option value="Confirm" <?php if ($booking->status == "Confirm") {
                                                               echo "selected='selected'";
                                                            }
                                                            ?>>Confirm</option>
                                          <option value="On Way" <?php if ($booking->status == "On Way") {
                                                               echo "selected='selected'";
                                                            }
                                                            ?>>On Way</option>
                                          <option value="Completed" <?php if ($booking->status == "Completed") {
                                                               echo "selected='selected'";
                                                            }
                                                            ?>>Completed</option>
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