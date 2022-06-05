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




				<li class="treeview s_meun withdrwal_request_active ">
					<a href="#">
						<i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Withdrwal Request</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li class="s_meun city_withdrwal_active"><a href="{{ url('/city-admin-withdrwal') }}"><i class="fa fa-picture-o"></i> <span>City Admin Withdrawal Request</span></a></li>
						<li class="s_meun vendor_withdrwal_active"><a href="{{ url('/vendor-withdrwal') }}"><i class="fa fa-picture-o"></i> <span>Vendor Withdrawal Request</span></a></li>
						<li class="s_meun delivery_withdrwal_active"><a href="{{ url('/delivery-boy-withdrwal') }}"><i class="fa fa-picture-o"></i> <span>Delivery Boy Withdrawal Request</span></a></li>
						
					</ul>
				</li>




				<li class="treeview s_meun account_settlement_active ">
					<a href="#">
						<i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Account Settlement</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li class="s_meun city_account_settlement_active"><a href="{{ url('/city-admin-account-settlement') }}"><i class="fa fa-picture-o"></i> <span>City Admin Account Settlement</span></a></li>
						<li class="s_meun vendor_account_settlement_active"><a href="{{ url('/vendor-account-settlement') }}"><i class="fa fa-picture-o"></i> <span>Vendor Account Settlement</span></a></li>
						<li class="s_meun delivery_account_settlement_active"><a href="{{ url('/delivery-boy-account-settlement') }}"><i class="fa fa-picture-o"></i> <span>Delivery Boy Account Settlement</span></a></li>
						
					</ul>
				</li>



				<li class="treeview s_meun orders_management_active ">
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



				<li class="treeview s_meun slot_master_section ">
					<a href="#">
						<i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Slot Master</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li class="s_meun bannet_slot_master_active"><a href="{{ route('banner.slot.master') }}"><i class="fa fa-picture-o"></i> <span>Vendor Banner Promotion Slot</span></a></li>
						<li class="s_meun vendor_slot_master_active"><a href="{{ route('vendor.promotion.slot.master') }}"><i class="fa fa-picture-o"></i> <span>Vendor Self Promotion slot</span></a></li>
						<li class="s_meun notification_slot_master_active"><a href="{{ route('notification.slot.master') }}"><i class="fa fa-picture-o"></i> <span>Notification Home Promotion slot</span></a></li>
						<li class="s_meun on_screen_notification_slot_master_active"><a href="{{ route('on.screen.notification.slot.master') }}"><i class="fa fa-picture-o"></i> <span>On Screen Notification Promotion slot</span></a></li>
						
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



				<li class="treeview s_meun onscreen_notification ">
					<a href="#">
						<i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>OnScreen Notifications</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li class="s_meun user_notification"><a href="{{route('user.notification')}}"><i class="fa fa-picture-o"></i> <span>User</span></a></li>
						<li class="s_meun vendor_notification"><a href="{{route('vendor.notification')}}"><i class="fa fa-picture-o"></i> <span>Vendor</span></a></li>
						<li class="s_meun delivery_boy_notification"><a href="{{route('delivery.boy.notification')}}"><i class="fa fa-picture-o"></i> <span>Delivery Boy</span></a></li>
						
					</ul>
				</li>



				<li class="treeview s_meun bell_icon_notification ">
					<a href="#">
						<i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Bell Icon Notifications</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li class="s_meun user_notification"><a href="{{route('user.bell.notification')}}"><i class="fa fa-picture-o"></i> <span>User</span></a></li>
						<li class="s_meun vendor_notification"><a href="{{route('vendor.bell.notification')}}"><i class="fa fa-picture-o"></i> <span>Vendor</span></a></li>
						<li class="s_meun delivery_boy_notification"><a href="{{route('delivery.boy.bell.notification')}}"><i class="fa fa-picture-o"></i> <span>Delivery Boy</span></a></li>
						
					</ul>
				</li>


				<li class="treeview s_meun reward_redeem_point ">
					<a href="#">
						<i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Reward/ Reedem Points</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li class="s_meun reward_point"><a href="{{route('reward.points')}}"><i class="fa fa-picture-o"></i> <span>Reward Points</span></a></li>
						<li class="s_meun redeem_point"><a href="{{ route('redeem.points')}}"><i class="fa fa-picture-o"></i> <span>Redeem Points</span></a></li>
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
						<li class="s_meun normal_plan_menu"><a href="{{route('wallet.normal.plan')}}"><i class="fa fa-picture-o"></i> <span>Normal Plan</span></a></li>
						<li class="s_meun offer_plan_active"><a href="{{route('offer.plan.page')}}"><i class="fa fa-picture-o"></i> <span>Offer Plan</span></a></li>
						
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