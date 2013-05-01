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
        <?php if(get_option('comment_registration') && !$user_ID) : ?>  
            <p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p><?php else : ?>  
            <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
                <fieldset>
                    <legend>Submit your comment:</legend>
                    <?php if($user_ID) : ?>  
                        <p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Log out &raquo;</a></p>  
                    <?php else : ?>  
                        <div class="rowElem"><label for="author"><small>Name <?php if($req) echo "(required)"; ?></small></label><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />  
                        </div>  
                        <div class="rowElem"><label for="email"><small>Mail (will not be published) <?php if($req) echo "(required)"; ?></small></label><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />  
                        </div>  
                        <div class="rowElem"><label for="url"><small>Website</small></label><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />  
                        </div>  
                    <?php endif; ?>  
                    <div class="rowElem">
                        <h5>Allowed Tags:</h5>
                        <pre><?php echo allowed_tags(); ?> </pre>
                        <textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea></div>  
                    <div class=-"rowElem"><input name="submit" type="submit" id="submit" class="btn" tabindex="5" value="Submit Comment" />  
                    <input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" /></div>  
                    <?php do_action('comment_form', $post->ID); ?>
                </fieldset>  
            </form>  
        <?php endif; ?>  
    <?php elseif($comments) : ?>  
        <p>The comments are closed.</p>  
    <?php endif; ?>    