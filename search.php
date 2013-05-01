<?php get_header(); ?>

	<div id="heart">
        <?php if ( have_posts() ) : ?>

            <header id="pageHead">
                <h1><?php
                $searchquery = get_search_query();
                 echo "Search results for &ldquo;$searchquery&rdquo;."
                ?></h1>
            </header>


            <?php /* Start the Loop */ ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <article class="searchresult post">
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
                 </article>
            <?php endwhile; ?>

        <?php
            if(function_exists('wp_pagenavi')){
                wp_pagenavi();
            }else{
                pagination_nav( 'blogPages' );
            }

        ?>

        <?php else : ?>

            <article id="post-0" class="post no-results not-found">
                <header class="entry-header">
                    <h1 class="entry-title"><?php _e( 'Nothing Found', 'twentytwelve' ); ?></h1>
                </header>

                <div class="entry-content">
                    <p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'twentytwelve' ); ?></p>
                    <?php get_search_form(); ?>
                </div><!-- .entry-content -->
            </article><!-- #post-0 -->

        <?php endif; ?>


	</div>
</div>

<?php get_sidebar(); ?>			
<?php get_footer(); ?>


