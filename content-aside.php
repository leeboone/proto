        <article class="post single aside">
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