<?php
	get_header();
	?>
	

	
	<div class="container fb-con-fixedw">
		<div class="row">
			<div class="col-xs-12 fb-col-content fb-col-single">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<h1><?php the_title();?></h1>
					<?php $subheading = get_post_meta( get_the_ID(), 'Subheading', true );
						if (! empty ($subheading) ) {
						?>
					<h2 class="subheading"><?php echo $subheading;?></h2>	
					<?php							
						}
					?>
					<?php the_content(); ?>
				<?php endwhile; else : ?>
					<p><?php _e( 'Halaman tidak ditemukan, silahkan gunakan form pencarian.' ); ?></p>
				<?php endif; ?>
				
			</div>
		</div>
	</div>


<?php
	get_footer();
	?>
	