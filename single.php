<?php
get_header(); 
?>

	<div id="heart">
	    <?php 
	    	if ( have_posts() ) : while ( have_posts() ) : the_post();
	    ?>

                <?php get_template_part( 'content', get_post_format() ); ?>

         <?php comments_template( '/comments.php', true ); ?>
        

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


