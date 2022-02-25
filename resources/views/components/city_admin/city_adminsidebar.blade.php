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



                <li class="treeview ct_meun ct_user_management_active ">
                    <a href="#">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>User Management</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        
                        <li class="s_meun ct_vendor_list_active"><a href="{{ route('cityadmin.view.vendor.list') }}"><i class="fa fa-picture-o"></i> <span>Vendors</span></a></li>
                        <li class="s_meun ct_delivery_boy_list_active"><a href="{{ route('cityadmin.view.delivery.boy.list') }}"><i class="fa fa-picture-o"></i> <span>Delivery Boy</span></a></li>
                        
                    </ul>
                </li>
            


                <!--Settings end-->
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>