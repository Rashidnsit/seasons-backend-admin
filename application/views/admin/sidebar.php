<?php
$id = $this->session->userdata('aid');
$profile = $this->admin_model->get_admin($id);

$uri = $this->uri->segment(2);
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
	<a href="<?php echo base_url('admin/dashboard'); ?>" class="brand-link">
		<img src="<?php echo base_url(); ?>uploads/ez_logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
		<span class="brand-text font-weight-light">Seasons Cleaning</span>
	</a>

	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar user panel (optional) -->
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">

				<img src="<?php echo base_url();  ?>uploads/profile_pics/<?php echo $profile['img'] ?>" class="img-circle elevation-2" alt="User Image">
			</div>
			<div class="info">
				<a href="<?php echo base_url('admin/profile'); ?>" class="d-block"><?php echo $profile['name'] ?></a>
			</div>
			<div class="pull-right">
				<a href="<?php echo base_url('admin/logout'); ?>"><i class="nav-icon fa fa-sign-out pull-right" style="margin-left: 90px;margin-top: 11px;" data-toggle="tooltip" data-placement="top" title="Sign-out"></i></a>
			</div>
		</div>

		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				
				<li class="nav-item menu-open">
					<a href="<?php echo base_url('admin/dashboard'); ?>" class="nav-link active">
						<i class="nav-icon fas fa-tachometer-alt"></i>
						<p> Dashboard </p>
					</a>
				</li>

				<li class="nav-item">
					<a class="nav-link" href="<?php echo base_url('admin/user-list'); ?>">
						<i class="nav-icon fa fa-user-o"></i>
						<p>
							User
						</p>
					</a>
				</li>

				<li class="nav-item">
					<a href="#" class="nav-link">
						<i class="nav-icon fa fa-users"></i>
						<p>
							Vendor
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo base_url('admin/create-vendor'); ?>" class="nav-link">
								<i class="fa fa-plus nav-icon"></i>
								<p>Add Vendor</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url('admin/vendor-list'); ?>" class="nav-link">
								<i class="fa fa-list-ul nav-icon"></i>
								<p>Vendor List</p>
							</a>
						</li>
					</ul>
				</li>

				<li class="nav-item">
					<a href="#" class="nav-link">
						<i class="nav-icon fa fa-laptop"></i>
						<p>
							Service Category
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo base_url('admin/create-category'); ?>" class="nav-link">
								<i class="fa fa-plus nav-icon"></i>
								<p>Add Service Category</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url('admin/category-list'); ?>" class="nav-link">
								<i class="fa fa-list-ul nav-icon"></i>
								<p>Service Category List</p>
							</a>
						</li>
					</ul>
				</li>

				<!--<li class="nav-item">-->
				<!--	<a href="#" class="nav-link">-->
				<!--		<i class="nav-icon fa fa-list"></i>-->
				<!--		<p>-->
				<!--			Sub Category-->
				<!--			<i class="fas fa-angle-left right"></i>-->
				<!--		</p>-->
				<!--	</a>-->
				<!--	<ul class="nav nav-treeview">-->
				<!--		<li class="nav-item">-->
				<!--			<a href="<?php echo base_url('admin/create-sub-category'); ?>" class="nav-link">-->
				<!--				<i class="fa fa-plus nav-icon"></i>-->
				<!--				<p>Add Sub Category</p>-->
				<!--			</a>-->
				<!--		</li>-->
				<!--		<li class="nav-item">-->
				<!--			<a href="<?php echo base_url('admin/sub-category-list'); ?>" class="nav-link">-->
				<!--				<i class="fa fa-list-ul nav-icon"></i>-->
				<!--				<p>Sub Category List</p>-->
				<!--			</a>-->
				<!--		</li>-->
				<!--	</ul>-->
				<!--</li>-->

				<li class="nav-item">
					<a href="#" class="nav-link">
						<i class="nav-icon fa fa-scribd"></i>
						<p>
							Service
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo base_url('admin/create-restaurants'); ?>" class="nav-link">
								<i class="fa fa-plus nav-icon"></i>
								<p>Add Service</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url('admin/restaurants-list'); ?>" class="nav-link">
								<i class="fa fa-list-ul nav-icon"></i>
								<p>Service List</p>
							</a>
						</li>
					</ul>
				</li>

				<li class="nav-item">
					<a class="nav-link" href="<?php echo base_url('admin/likes-list'); ?>">
						<i class="nav-icon fa fa-heart"></i>
						<p>
							List Of Service Likes
						</p>
					</a>
				</li>

				<li class="nav-item">
					<a class="nav-link" href="<?php echo base_url('admin/reviews-list'); ?>">
						<i class="nav-icon fa fa-star"></i>
						<p>
							List Of Service Reviews
						</p>
					</a>
				</li>

				<li class="nav-item">
					<a href="#" class="nav-link">
						<i class="nav-icon fa fa-tumblr-square"></i>
						<p>
							Area Type
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo base_url('admin/create-type'); ?>" class="nav-link">
								<i class="fa fa-plus nav-icon"></i>
								<p>Add Area Type</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url('admin/type-list'); ?>" class="nav-link">
								<i class="fa fa-list-ul nav-icon"></i>
								<p>Area Type List</p>
							</a>
						</li>
					</ul>
				</li>

				<li class="nav-item">
					<a href="#" class="nav-link">
						<i class="nav-icon fa fa-btc"></i>
						<p>
							Banners
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo base_url('admin/create-banners'); ?>" class="nav-link">
								<i class="fa fa-plus nav-icon"></i>
								<p>Add Banners</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url('admin/banners-list'); ?>" class="nav-link">
								<i class="fa fa-list-ul nav-icon"></i>
								<p>Banners List</p>
							</a>
						</li>
					</ul>
				</li>

				<li class="nav-item">
					<a class="nav-link" href="<?php echo base_url('admin/booking-list'); ?>">
						<i class="nav-icon fa fa-bold"></i>
						<p>
							Booking History
						</p>
					</a>
				</li>

				<li class="nav-item">
					<a href="#" class="nav-link">
						<i class="nav-icon fa fa-list"></i>
						<p>
							Product Category
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo base_url('admin/create-product-category'); ?>" class="nav-link">
								<i class="fa fa-plus nav-icon"></i>
								<p>Add Product Category</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url('admin/product-category-list'); ?>" class="nav-link">
								<i class="fa fa-list-ul nav-icon"></i>
								<p>List Of Product Category</p>
							</a>
						</li>
					</ul>
				</li>

				<li class="nav-item">
					<a href="#" class="nav-link">
						<i class="nav-icon fa fa-product-hunt"></i>
						<p>
							Product
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo base_url('admin/create-product'); ?>" class="nav-link">
								<i class="fa fa-plus nav-icon"></i>
								<p>Add Product</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url('admin/product-list'); ?>" class="nav-link">
								<i class="fa fa-list-ul nav-icon"></i>
								<p>Product List</p>
							</a>
						</li>
					</ul>
				</li>

				<li class="nav-item">
					<a href="#" class="nav-link">
						<i class="nav-icon fa fa-cart-plus"></i>
						<p>
							Orders
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo base_url('admin/orders'); ?>" class="nav-link">
								<i class="fa fa-angle-double-right nav-icon"></i>
								<p>Orders List</p>
							</a>
						</li>
					</ul>
				</li>
				
				<li class="nav-item">
					<a class="nav-link" href="<?php echo base_url('admin/general-setting'); ?>">
						<i class="nav-icon fa fa-cogs"></i>
						<p>
							General Setting
						</p>
					</a>
				</li>

			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>