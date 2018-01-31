<div id="sidebar">
	<div id="sidebar-wrapper">
		<div class="sidebar-title"><h2>Senyum Media</h2><span>Online</span></div>
		<ul class="sidebar-nav">
			<li class="sidebar-close"><a href="#"><i class="fa fa-fw fa-close"></i></a></li>
			<li><a href="{{ site_url('dashboard') }}"><i class="fa fa-fw fa-home"></i><span class="nav-label">Dashboard</span></a></li>
			<li class="nav-label">Etalase</li>
			<li><a href="{{ site_url('produk') }}"><i class="fa fa-fw fa-shopping-basket"></i><span class="nav-label">Produk</span></a></li>
			<li><a href="{{ site_url('kategori') }}"><i class="fa fa-fw fa-sitemap"></i><span class="nav-label">Kategori</span></a></li>
			<li><a href="{{ site_url('produsen') }}"><i class="fa fa-fw fa-dropbox"></i><span class="nav-label">Brand</span></a></li>
			<li><a href="{{ site_url('pesanan') }}"><i class="fa fa-fw fa-truck"></i><span class="nav-label">Pesanan</span></a></li>
			<li>
				<a href="#nav-1" data-toggle="collapse" aria-controls="nav-1">
					<i class="fa fa-fw fa-users"></i><span class="nav-label">Member</span><span class="nav-caret"><i class="fa fa-caret-down"></i></span>
				</a>
				<ul class="sidebar-nav-child collapse collapseable" id="nav-1">
					<li><a href="{{ site_url('auth/all') }}"><i class="fa fa-fw fa-user"></i><span class="nav-label">Daftar Member</span></a></li>
					<li><a href="{{ site_url('membership') }}"><i class="fa fa-fw fa-tags"></i><span class="nav-label">Jenis</span></a></li>
					<li><a href="{{ site_url('membership/users') }}"><i class="fa fa-fw fa-user"></i><span class="nav-label">Upgrade</span></a></li>
				</ul>
			</li>
			<li>
				<a href="#nav-reseller" data-toggle="collapse" aria-controls="nav-reseller">
					<i class="fa fa-fw fa-user-circle"></i><span class="nav-label">Reseller</span><span class="nav-caret"><i class="fa fa-caret-down"></i></span>
				</a>
				<ul class="sidebar-nav-child collapse collapseable" id="nav-reseller">
					<li><a href="{{ site_url('reseller') }}"><i class="fa fa-fw fa-user"></i><span class="nav-label">Daftar Reseller</span></a></li>
					<li><a href="{{ site_url('reseller/pengajuan') }}"><i class="fa fa-fw fa-tags"></i><span class="nav-label">Pengajuan Deposit</span></a></li>
				</ul>
			</li>
			<li>
				<a href="#nav-2" data-toggle="collapse" aria-controls="nav-2">
					<i class="fa fa-fw fa-credit-card"></i><span class="nav-label">Diskon</span><span class="nav-caret"><i class="fa fa-caret-down"></i></span>
				</a>
				<ul class="sidebar-nav-child collapse collapseable" id="nav-2">
					<li><a href="{{ site_url('diskon/kategori') }}"><i class="fa fa-fw fa-sitemap"></i><span class="nav-label">Kategori</span></a></li>
					<li><a href="{{ site_url('diskon/produk') }}"><i class="fa fa-fw fa-shopping-basket"></i><span class="nav-label">Produk</span></a></li>
				</ul>
			</li>
			<li><a href="{{ site_url('promo') }}"><i class="fa fa-fw fa-credit-card"></i><span class="nav-label">Promo/Voucher</span></a></li>
			<li><a href="{{ site_url('berita/index') }}"><i class="fa fa-fw fa-newspaper-o"></i><span class="nav-label">Newsletter</span></a></li>
			<li><a href="{{ site_url('subscriber/index') }}"><i class="fa fa-fw fa-envelope-o"></i><span class="nav-label">Subscriber</span></a></li>
			<li class="nav-label">Website</li>
			<li><a href="{{ site_url('pengaturan') }}"><i class="fa fa-fw fa-cog"></i><span class="nav-label">Pengaturan</span></a></li>
			<li><a href="{{ site_url('halaman') }}"><i class="fa fa-fw fa-newspaper-o"></i><span class="nav-label">Halaman</span></a></li>
		</ul>
		<div class="sidebar-footer"></div>
	</div>
</div>