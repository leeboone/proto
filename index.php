<?php get_header(); ?>

	<div id="heart">
        <header id="pageHead">
        <h1 id="pageTitle">
        <?php if ( is_day() ) : ?>
                        <?php printf( __( 'Daily Archives: <span>%s</span>', 'twentyten' ), get_the_date() ); ?>
        <?php elseif ( is_month() ) : ?>
                        <?php printf( __( 'Monthly Archives: <span>%s</span>', 'twentyten' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'twentyten' ) ) ); ?>
        <?php elseif ( is_year() ) : ?>
                        <?php printf( __( 'Yearly Archives: <span>%s</span>', 'twentyten' ), get_the_date( _x( 'Y', 'yearly archives date format', 'twentyten' ) ) ); ?>
        <?php elseif ( is_category() ) : ?>
                        <?php printf( '%s', '<span>' . single_cat_title( '', false ) . '</span>' ); ?>
        <?php elseif ( is_tag() ) : ?>
                        <?php printf( '%s', '<span>' . single_tag_title( '', false ) . '</span>' ); ?>
        <?php elseif ( is_home() ) : ?>
                        <?php echo 'Blog'; ?>
        <?php else : ?>
                        <?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); 
                        $title = $term->name;
                        if($title != ''){
                                echo '<span>' . $title . '</span>' ;
                            }else{
                                echo "Archive";
                            }?>
        <?php endif; ?>
        </h1>
        </header>
	    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <article class="post<?php echo (get_post_format()) ? " ".get_post_format() : "" ?>">

         <?php /* Show full content for image, quote, and gallery post formats */ ?>
           <?php if(has_post_format( 'image' )||has_post_format( 'quote' )||has_post_format( 'gallery' )): ?>
        <header id="postHead">
            <div class="time"><span class="month"><?php the_time('F') ?></span><span class="day"><?php the_time('jS') ?></span><span class="year"><?php the_time('Y') ?></span></div>
            <hgroup>
                <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php bulletproof_title(); ?></a></h2>
                <h6>by: <?php the_author(); ?></h6>
            </hgroup>
            <?php if(has_post_thumbnail()){ the_post_thumbnail( "page-feature" );
                }?>
        <?php if(get_comments_number( )): ?>
        <?php comments_popup_link('No comments', 'One comment', '% comments', 'comments-link btn btn-small', 'Comments are closed'); ?>
        <?php endif; ?>
        </header>
            <div class="content"><?php the_content(); ?></div>

        <?php /* Aside */ ?>
        <?php elseif(has_post_format( 'aside' )): ?>
            <aside class="well"><?php the_content(); ?></aside>

        <?php /* no post format */ ?>
        <?php else: ?>
        <header id="postHead">
            <div class="time"><span class="month"><?php the_time('F') ?></span><span class="day"><?php the_time('jS') ?></span><span class="year"><?php the_time('Y') ?></span></div>
            <hgroup>
                <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php bulletproof_title(); ?></a></h2>
                <h6>by: <?php the_author(); ?></h6>
            </hgroup>
            <?php if(has_post_thumbnail()){ the_post_thumbnail( "page-feature" );
                }?>
        <?php if(get_comments_number( )): ?>
        <?php comments_popup_link('No comments', 'One comment', '% comments', 'comments-link btn btn-small', 'Comments are closed'); ?>
        <?php endif; ?>
        </header>
            <div class="content"><?php the_excerpt(); ?></div>
        <?php endif; ?>
        </article><!-- /.post -->
        <!-- Stop The Loop (but note the "else:" - see next line). -->
        <?php endwhile; ?>

        <?php
            if(function_exists('wp_pagenavi')){
                wp_pagenavi();
            }else{
                pagination_nav( 'blogPages' );
            }

        ?>

        <?php else: ?>
        <!-- The very first "if" tested to see if there were any Posts to -->
        <!-- display. This "else" part tells what do if there weren't any. -->
        <p class="text-error">Sorry, no posts are available at this time.</p>
        <!-- REALLY stop The Loop. -->
        <?php endif; ?>


	</div>
</div>

<?php get_sidebar(); ?>			
<?php get_footer(); ?>


