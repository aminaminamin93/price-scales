<aside class="main-sidebar">

	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">

		<!-- Sidebar user panel (optional) -->
		<div class="user-panel">
			<div class="pull-left image">
				<img src="/admin-bootstrap/img/user2-160x160.jpg" class="img-circle" alt="User Image">
			</div>
			<div class="pull-left info">
				{!!  Auth::user()->user_firstname !!}<br/>
				{!! Html::link('admin/profile/'.Auth::user()->id , Auth::user()->user_email ) !!}<br/>
				<!-- Status -->
				<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
			</div>
		</div>

		<!-- search form (Optional) -->
		<form action="#" method="get" class="sidebar-form">
			<div class="input-group">
				<input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
			</div>
		</form>
		<!-- /.search form -->

		<!-- Sidebar Menu -->
		<ul class="sidebar-menu">
			<li class="active"><a href="#"><i class="fa fa-home"></i> <span>Dashboard</span></li>
			<!-- Optionally, you can add icons to the links -->
			<li><a href="#"><i class="fa fa-envelope"></i> <span>MailBox</span></a></li>
			<li class="treeview">
				<a href="#"><i class="fa fa-link"></i> <span>USER MANAGEMENT</span> <i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">
					<li>{!! Html::link('retailer/view', 'RETAILER') !!}</li>
					<li><a href="#">MEMBER</a></li>
					<li><a href="#">ADMIN</a></li>
				</ul>
			</li>
			<!-- <li class="treeview">
				<a href="#"><i class="fa fa-link"></i> <span>Multilevel</span> <i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">
					<li><a href="/view/products">PRODUCTS</a></li>
					<li><a href="#">Link in level 2</a></li>
				</ul>
			</li> -->
			<li id="li-logs_setting">
				<a href="/admin/logs_setting"><span class="glyphicon glyphicon-cog"></span><span>Logs & Settings</span></a>
			</li>
		</ul><!-- /.sidebar-menu -->
	</section>
	<!-- /.sidebar -->
</aside>
