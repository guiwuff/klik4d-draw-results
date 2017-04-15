	<div class="container fb-con-fixedw">
		<div class="row">
			<div class="col-xs-12 fb-col-topbar">
				
				<div class="col-xs-12 col-sm-9">
					Untuk pengumuman penting yang ingin ditampilkan, dapat menggunakan running text
				</div>
				<?php dynamic_sidebar( 'top_bar_1' ); ?>
					
				
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 fb-col-logochat">
				<div class="row">
					<?php dynamic_sidebar( 'logo' ); ?>
					<?php dynamic_sidebar( 'header_right' ); ?>
				</div>
			</div>
		</div>
		<div class="row">
			<?php if (function_exists(custom_menus_header())) custom_menus_header(); ?>
		</div>
	</div>