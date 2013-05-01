<?php $theme_options = get_option('theme_options'); ?>		

		</div>
		<footer id="siteFooter" class="row">
<?php if( is_active_sidebar( 'footer-widgets' )): ?>
	<?php
		$widget_count = count_sidebar_widgets('footer-widgets');
		$col_count;
		if($widget_count===4){
			$col_count = "fourcol";
		}elseif($widget_count===5 || $widget_count%5 === 0 || $widget_count%5 === 4){
			$col_count = "fivecol";
		}elseif($widget_count===3 || $widget_count%3 === 0){
			$col_count = "threecol";
		}elseif($widget_count===2){
			$col_count = "twocol";
		}elseif($widget_count === 1){
			$col_count = "onecol";
		}else{
			$col_count = "fourcol";
		}
	?>
			<div class="fgroup widgetwrap span12 <?php echo $col_count; ?>">
<?php dynamic_sidebar( "footer-widgets" ); ?>
			</div>
<?php endif; ?>

<?php if(has_nav_menu( "footer" )): ?>
				<nav id="footerNav" class="navbar span12">
					<div class="navbar-inner">
					<ul class="nav "><?php 
				    wp_nav_menu( array(
				        'theme_location'       => 'footer',
				        'depth'      => 1,
				        'container'  => false,
				        'items_wrap' => '%3$s',
				        'walker' => new Unnested_Nav_Walker())
				    );
					?>
					</ul>
					</div>
				</nav>
<?php endif; ?>

			<div class="span12 fgroup">
				<p id="address"><?php echo $theme_options['addressline']; ?></p>
				<p id="ownership"><?php echo "&copy; " . date('Y') . " " . $theme_options['copyrightline']; ?></p>
			</div>
		</footer>
	<?php wp_footer(); ?>
	</body>
</html>		