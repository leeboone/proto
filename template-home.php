<?php 
//Template Name: Home
?>
<?php get_header(); ?>	

	<div id="heart">
	    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <article class="post single">
            <div class="content"><?php the_content(); ?></div>
            <?php page_part_links(); ?>
       </article><!-- /.post -->
        <!-- Stop The Loop (but note the "else:" - see next line). -->
        <?php endwhile; else: ?>
        <!-- The very first "if" tested to see if there were any Posts to -->
        <!-- display. This "else" part tells what do if there weren't any. -->
        <p>Sorry, no posts are available at this time.</p>
        <!-- REALLY stop The Loop. -->
        <?php endif; ?>

	</div>
</div>


<?php get_footer(); ?>


