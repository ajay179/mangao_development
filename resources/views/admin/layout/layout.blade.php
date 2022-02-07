
<x-admin.head />
<x-admin.header />
<x-admin.navbar />
<x-admin.adminsidebar />
@yield('content')

<x-admin.footer />
<x-admin.jsfiles  classname="{{!empty($class_name) ? $class_name: '';}}"/>

<!-- for datatables purpose  -->
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
   	<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

   	<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

@yield('js_section')


