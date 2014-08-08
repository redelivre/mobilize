<?php get_header(); ?>

	<div id="primary" class="site-content row">
		<div id="content" role="main" class="container">
			<div class="span12 miolo">
				<div class="span4 sid-int">
					<?php get_sidebar(); ?>
				</div>
					<?php the_post(); ?>
				<div class="quem-somos span7">
					<div class="cabecalho borda-cor-1">
						<h2><?php the_title(); ?></h2>
					</div>
						<?php the_content(); ?>
				<?php
			if( get_theme_mod('mobilize_display_fb_comments') == 1 )
			{  ?>
				<div class="fb-comments" data-href="<?php the_permalink(); ?>" data-numposts="5" data-colorscheme="light" data-width="100%"></div>
			<?php } ?>
				
					</div>
				</div>	
			</div><!-- #content -->		
		</div><!-- #primary -->


<?php get_footer(); ?>