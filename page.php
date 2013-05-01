<?php get_header(); ?>	

	<div id="heart">
	    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<hgroup id="pageHead">
			<h1><?php the_title(); ?></h1>
			<?php if(has_post_thumbnail()){ the_post_thumbnail( "page-feature" );
                }?>
        <?php if(get_comments_number( )): ?>
        <?php comments_popup_link('No comments', 'One comment', '% comments', 'comments-link btn', 'Comments are closed'); ?>
        <?php endif; ?>
		</hgroup>
        <article class="post single">
            <div class="content"><?php the_content(); ?></div>
       </article><!-- /.post -->
        <?php page_part_links(); ?>
        <?php comments_template( '/comments.php', true ); ?>
       <!-- Stop The Loop (but note the "else:" - see next line). -->
        <?php endwhile; else: ?>
        <!-- The very first "if" tested to see if there were any Posts to -->
        <!-- display. This "else" part tells what do if there weren't any. -->
        <p>Sorry, no posts are available at this time.</p>
        <!-- REALLY stop The Loop. -->
        <?php endif; ?>

	</div>
</div>


<?php get_sidebar(); ?>			
<?php get_footer(); ?>


