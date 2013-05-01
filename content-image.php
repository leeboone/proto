		<header id="postHead">
            <div class="time"><span class="month"><?php the_time('F') ?></span><span class="day"><?php the_time('jS') ?></span><span class="year"><?php the_time('Y') ?></span></div>
            <hgroup>
    			<h1><?php the_title(); ?></h1>
                <h6>by: <?php the_author(); ?></h6>
            </hgroup>
			<?php if(has_post_thumbnail()){ the_post_thumbnail( "page-feature" );
                }?>
        <?php if(get_comments_number( )): ?>
        <?php comments_popup_link('No comments', 'One comment', '% comments', 'comments-link btn', 'Comments are closed'); ?>
        <?php endif; ?>
		</header>
        <article class="post single">
            <div class="content"><?php the_content(); ?></div>
        </article><!-- /.post -->
         <?php page_part_links(); ?>
        <footer class="entry-meta well">
         <ul class="details">
         
         <?php the_terms( $post->ID, 'category', '<li><strong>Posted in</strong>: ', ', ', '</li> ' ); ?>
         <?php the_terms( $post->ID, 'post_tag', '<li><strong>Tagged</strong>: ', ', ', '</li> ' ); ?>
         <li><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php printf( 'View all posts by %s <span class="meta-nav">&rarr;</span>', get_the_author() ); ?></a></li>
         </ul>
        </footer>
