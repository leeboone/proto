<?php 
//Template Name: News and Events
?>
<?php get_header(); ?>		

	<div id="heart">
	    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<hgroup id="siteHead">
			<h1><?php the_title(); ?></h1>
			<?php if(has_post_thumbnail()){ the_post_thumbnail( "page-feature" );
                }?>
		</hgroup>
		<?php if(get_the_content() == true): ?>
        <article class="post single newshead">
            <div class="content"><?php the_content(); ?></div>
        </article><!-- /.post -->
	    <?php endif; ?>
        <!-- Stop The Loop (but note the "else:" - see next line). -->
        <?php endwhile; else: ?>
        <!-- The very first "if" tested to see if there were any Posts to -->
        <!-- display. This "else" part tells what do if there weren't any. -->
        <p>Sorry, no posts are available at this time.</p>
        <!-- REALLY stop The Loop. -->
        <?php endif; ?>
		<?php
			$args = array(
					'post_type' => 'post', 'posts_per_page' => 5, 'paged' => get_query_var( 'paged' )
				);
			$news = new WP_Query($args);
			
			while ($news->have_posts()) : $news->the_post();
				?>
        <article class="post">
            <hgroup>
                <?php if(has_post_thumbnail()){ the_post_thumbnail( "post-thumbnail", array('class'	=> "attachment-$size alignleft") );
                }?>
                 <h4><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4>
            </hgroup>
            <div class="content"><?php the_excerpt(); ?></div>
        </article><!-- /.post -->
			<?php endwhile; ?>
		<?php
			if(function_exists('wp_pagenavi')):
			wp_pagenavi(array( 'query' => $news ) ); 
			endif;
		?>
		<?php wp_reset_query(); ?> 

	</div>
</div>


<?php get_sidebar(); ?>			
<?php get_footer(); ?>


