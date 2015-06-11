<?php
/*
Template Name: List Children Links
*/
?>
<?php get_header(); ?>
<div class="row sidebar_bg radius10">
<?php locate_template('parts-nav-sidebar.php', true, false); ?>
	<div class="nine columns wrapper radius-right offset-topgutter">
		<?php locate_template('parts-nav-breadcrumbs.php', true, false); ?>	
		<section>
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<h2><?php the_title();?></h2>
				<?php the_content(); ?>
				<?php
				$parent_page = get_post($post->post_parent);
				$parent_name = $parent_page->post_title;
				$children = wp_list_pages('title_li=&child_of='.$post->ID.'&echo=0');
					if ($children) { ?>
					<div class="panel radius">
					<h5 class="grey">Also in <span class="bold"><?php echo $parent_name ?></span></h5>
						<ul>
							<?php echo $children; ?>
						</ul>
					</div>
			<?php } endwhile; endif; ?>
			
		</section>
	</div>
</div> 
<?php get_footer(); ?>