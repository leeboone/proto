    <?php if(!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) : ?>  
    <?php die('What are you trying to pull?'); ?>
    <?php endif; ?>  
          
    <?php if(!empty($post->post_password)) : ?>  
        <?php if($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) : ?>  
            <p class="text-error">No soup for you!</p>
        <?php endif; ?>  
    <?php endif; ?>  
      
    <?php if($comments) : ?> 
        <h3 id="comments"><?php comments_number('', 'One comment', '% comments'); ?> </h3> 
        <ol id="commentsList">  
        <?php foreach($comments as $comment) : ?>  
            <li id="comment-<?php comment_ID(); ?>" class="comment">
                <?php echo get_avatar(get_comment_author_email(), 30 ); ?>    
                <?php if ($comment->comment_approved == '0') : ?>  
                    <p class="text-info">Your comment is awaiting approval</p>  
                <?php endif; ?>  
                <?php comment_text(); ?>  
                <cite><?php comment_type(); ?> by <?php comment_author_link(); ?> on <?php comment_date(); ?> at <?php comment_time(); ?></cite>  
            </li>  
        <?php endforeach; ?>  
        </ol>  
    <?php else : ?>  
    <?php endif; ?>   
      
    <?php if(comments_open()) : ?>  
    <?php comment_form(); ?>
    <?php elseif($comments) : ?>  
        <p>The comments are closed.</p>  
    <?php endif; ?>    