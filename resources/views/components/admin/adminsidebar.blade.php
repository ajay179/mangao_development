	<!-- Left side column. contains the logo and sidebar -->
	<aside class="main-sidebar scrollbar" id="style-7">
		<!-- sidebar: style can be found in sidebar.less -->
		<section class="sidebar">
			<!-- sidebar menu: : style can be found in sidebar.less -->
			<ul class="sidebar-menu" data-widget="tree">
				<!-- Dashboard start-->
				<li class="s_meun dashboard_active active">
					<a href="{{ url('admin-dashbord') }}">
						<i class="fa fa-dashboard"></i> <span>Dashboard</span>
					</a>
				</li>
				<!-- Dashboard end-->


				<li class="treeview s_meun city_cityadmin ">
					<a href="#">
						<i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>City/City Admin</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li class="s_meun city_menu"><a href="{{ url('/city') }}"><i class="fa fa-picture-o"></i> <span>City</span></a></li>
						<li class="s_meun city_admin_menu"><a href="{{ url('/city-admin') }}"><i class="fa fa-picture-o"></i> <span>City Admin</span></a></li>
						
					</ul>
				</li>




				<li class="treeview s_meun content_management_active ">
					<a href="#">
						<i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Withdrwal Request</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li class="s_meun cms_banner_active"><a href="<//?= site_url('admin/cms/banner') ?>"><i class="fa fa-picture-o"></i> <span>City Admin Withdrawal Request</span></a></li>
						<li class="s_meun cms_association_active"><a href="<//?= site_url('admin/cms/associations') ?>"><i class="fa fa-picture-o"></i> <span>Vendor Withdrawal Request</span></a></li>
						<li class="s_meun cms_association_active"><a href="<//?= site_url('admin/cms/associations') ?>"><i class="fa fa-picture-o"></i> <span>Delivery Boy Withdrawal Request</span></a></li>
						
					</ul>
				</li>




				<li class="treeview s_meun content_management_active ">
					<a href="#">
						<i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Account Settlement</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li class="s_meun cms_banner_active"><a href="<//?= site_url('admin/cms/banner') ?>"><i class="fa fa-picture-o"></i> <span>City Admin Account Settlement</span></a></li>
						<li class="s_meun cms_association_active"><a href="<//?= site_url('admin/cms/associations') ?>"><i class="fa fa-picture-o"></i> <span>Vendor Account Settlement</span></a></li>
						<li class="s_meun cms_association_active"><a href="<//?= site_url('admin/cms/associations') ?>"><i class="fa fa-picture-o"></i> <span>Delivery Boy Account Settlement</span></a></li>
						
					</ul>
				</li>



				<li class="treeview s_meun content_management_active ">
					<a href="#">
						<i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Orders</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li class="s_meun ongoing_order_menu"><a href="{{ url('/ongoing-orders') }}"><i class="fa fa-picture-o"></i> <span>Ongoing Orders</span></a></li>
						<li class="s_meun completed_order_menu"><a href="{{ url('/completed-orders') }}"><i class="fa fa-picture-o"></i> <span>Completed Orders</span></a></li>
						<li class="s_meun cancelled_order_menu"><a href="{{ url('/cancelled-orders') }}"><i class="fa fa-picture-o"></i> <span>Cancelled Orders</span></a></li>
						<li class="s_meun returned_order_menu"><a href="{{ url('/returned-orders') }}"><i class="fa fa-picture-o"></i> <span>Returned Orders</span></a></li>
						
					</ul>
				</li>



				<li class="treeview s_meun categories_banner_section ">
					<a href="#">
						<i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Categories/ Main Banner</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li class="s_meun categories_active"><a href="{{ route('main.categories') }}"><i class="fa fa-picture-o"></i> <span>Categories</span></a></li>
						<li class="s_meun cms_association_active"><a href="{{ route('main.banner') }}"><i class="fa fa-picture-o"></i> <span>Main Banner</span></a></li>
						
					</ul>
				</li>





				



				<li class="treeview s_meun content_management_active ">
					<a href="#">
						<i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>User Management</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li class="s_meun cms_banner_active"><a href="<//?= site_url('admin/cms/banner') ?>"><i class="fa fa-picture-o"></i> <span>All Users</span></a></li>
						<li class="s_meun cms_association_active"><a href="<//?= site_url('admin/cms/associations') ?>"><i class="fa fa-picture-o"></i> <span>All Vendors</span></a></li>
						<li class="s_meun cms_association_active"><a href="<//?= site_url('admin/cms/associations') ?>"><i class="fa fa-picture-o"></i> <span>All Delivery Boy</span></a></li>
						
					</ul>
				</li>



				<li class="treeview s_meun content_management_active ">
					<a href="#">
						<i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>OnScreen Notifications</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li class="s_meun cms_banner_active"><a href="{{route('user.notification')}}"><i class="fa fa-picture-o"></i> <span>User</span></a></li>
						<li class="s_meun cms_association_active"><a href="<//?= site_url('admin/cms/associations') ?>"><i class="fa fa-picture-o"></i> <span>Vendor</span></a></li>
						<li class="s_meun cms_association_active"><a href="<//?= site_url('admin/cms/associations') ?>"><i class="fa fa-picture-o"></i> <span>Delivery Boy</span></a></li>
						
					</ul>
				</li>



				<li class="treeview s_meun content_management_active ">
					<a href="#">
						<i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Bell Icon Notifications</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li class="s_meun cms_banner_active"><a href="<//?= site_url('admin/cms/banner') ?>"><i class="fa fa-picture-o"></i> <span>User</span></a></li>
						<li class="s_meun cms_association_active"><a href="<//?= site_url('admin/cms/associations') ?>"><i class="fa fa-picture-o"></i> <span>Vendor</span></a></li>
						<li class="s_meun cms_association_active"><a href="<//?= site_url('admin/cms/associations') ?>"><i class="fa fa-picture-o"></i> <span>Delivery Boy</span></a></li>
						
					</ul>
				</li>


				<li class="treeview s_meun content_management_active ">
					<a href="#">
						<i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Reward/ Reedem Points</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li class="s_meun cms_banner_active"><a href="<//?= site_url('admin/cms/banner') ?>"><i class="fa fa-picture-o"></i> <span>Reward Points</span></a></li>
						<li class="s_meun cms_association_active"><a href="<//?= site_url('admin/cms/associations') ?>"><i class="fa fa-picture-o"></i> <span>Redeem Points</span></a></li>
						<li class="s_meun cms_association_active"><a href="<//?= site_url('admin/cms/associations') ?>"><i class="fa fa-picture-o"></i> <span>App Refer</span></a></li>
						
					</ul>
				</li>



				<li class="treeview s_meun content_active ">
					<a href="#">
						<i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Content Management</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li class="s_meun term_condition_active"><a href="{{route('terms.condition')}}"><i class="fa fa-picture-o"></i> <span>Term & Conditions</span></a></li>
						<li class="s_meun about_us_active"><a href="{{route('about.us')}}"><i class="fa fa-picture-o"></i> <span>About Us</span></a></li>
						<li class="s_meun privacy_active"><a href="{{route('privacy.policy')}}"><i class="fa fa-picture-o"></i> <span>Privacy Policy</span></a></li>
						<li class="s_meun return_policy_active"><a href="<//?= site_url('admin/cms/associations') ?>"><i class="fa fa-picture-o"></i> <span>Return & Cancellation Policy</span></a></li>
						
					</ul>
				</li>



				<li class="treeview s_meun wallet_normal_admin ">
					<a href="#">
						<i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Wallet / Offers</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li class="s_meun normal_plan_menu"><a href="{{ route('wallet.normal.plan') }}"><i class="fa fa-picture-o"></i> <span>Normal Plan</span></a></li>
						<li class="s_meun cms_association_active"><a href="<//?= site_url('admin/cms/associations') ?>"><i class="fa fa-picture-o"></i> <span>Offer Plan</span></a></li>
						
					</ul>
				</li>



				


			

<!-- MAIN_SERVICES -->
				<li class="s_meun main_services_active">
					<a href="<//?= site_url('admin/main_services') ?>"><i class="fa fa-picture-o"></i> <span>Feedback/ Complaints</span></a>
				</li>

				<!-- SERVICES -->
				<li class="s_meun services_active">
					<a href="<//?= site_url('admin/services') ?>"><i class="fa fa-wrench"></i> <span>Global Settings</span></a>
				</li>

				



				<!--Settings end-->
			</ul>
		</section>
		<!-- /.sidebar -->
	</aside>