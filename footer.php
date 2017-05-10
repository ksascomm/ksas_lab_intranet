  <footer>
  	<div class="row hide-for-print">		
  		<?php //Check Theme Options for Quicklinks setting 
	  		$theme_option = flagship_sub_get_global_options(); 
	  		if ( $theme_option['flagship_sub_quicklinks']  == '1' ) {
	  				global $switched;
	  				$quicklinks_id = $theme_option['flagship_sub_quicklinks_id'];
	  				switch_to_blog($quicklinks_id); }  
	  		
	  		//Quicklinks Menu
	  		wp_nav_menu( array( 
				'theme_location' => 'quick_links', 
				'menu_class' => 'nav-bar', 
				'fallback_cb' => 'foundation_page_menu', 
				'container' => 'nav', 
				'container_id' => 'quicklinks',
				'container_class' => 'three columns', 
				'walker' => new foundation_navigation() ) ); 
			
			//Return to current site
			if ( $theme_option['flagship_sub_quicklinks']  == '1' ) { restore_current_blog(); }
			
			//Footer Links
			 wp_nav_menu( array( 
				'theme_location' => 'footer_links', 
				'menu_class' => 'inline-list', 
				'fallback_cb' => 'foundation_page_menu', 
				'container' => 'nav', 
				'container_class' => 'seven columns', 
				'walker' => new foundation_navigation() ) ); 
		 ?>
		<!-- Social Media -->
		<nav class="two columns">
			<a href="http://facebook.com/jhuksas" title="Facebook"><span class="fa fa-facebook-official fa-3x"></span><span class="screen-reader-text">Facebook</span></a>
			<a href="https://www.youtube.com/user/jhuksas" title="YouTube"><span class="fa fa-youtube-square fa-3x"></span><span class="screen-reader-text">YouTube</span></a>
		</nav>
		
		
  	</div>
  	<!-- Copyright and Address -->
  	<div class="row" id="copyright" role="content-info">
  		<p>&copy; <?php print date('Y'); ?> Johns Hopkins University, <?php echo $theme_option['flagship_sub_copyright'];?></p>
  	</div>
	<div class="row hide-for-print">
		<div class="four columns centered">
  				<a href="http://www.jhu.edu" title="Johns Hopkins University">
  					<img src="<?php echo get_template_directory_uri() ?>/assets/images/university.jpg" / alt="Johns Hopkins University logo">
  				</a>
		</div>
	</div>
  </footer>

  <?php locate_template('parts-script-initiators.php', true, false); ?>
  <?php wp_footer(); ?>
	</body>
</html>