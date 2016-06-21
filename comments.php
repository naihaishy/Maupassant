<div id="comments">
    <?php
        if (isset($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
            die ('请不要直接加载该页面，谢谢！');
        
        if ( post_password_required() ) { ?>
            <p><?php _e('这篇文章需要密码，请输入密码访问'); ?></p> 
        <?php
            return;
        }
    ?>

    <?php if ( have_comments() ) : ?>
        <h3 class="widget-title"><?php comments_popup_link('暂无评论', '仅有 1 条评论', '已有 % 条评论'); ?></h3>
        <ol class="comment-list">
            <?php wp_list_comments('type=comment&callback=ms_comment'); ?>
        </ol>
        <?php paginate_comments_links('prev_text=«&next_text=»');?>
    <?php else : ?>
        <?php if ('open' != $post->comment_status) : ?>
            <p>抱歉，暂停评论。</p>
        <?php endif; ?>       
    <?php endif; ?>

    <?php if ( comments_open() ) : ?>
    <div id="respond" class="respond">
        <div class="cancel-comment-reply">
        <?php cancel_comment_reply_link() ?>
        </div>
    	<h3 id="response"><?php _e('添加新评论'); ?></h3>
    	<form method="post" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" id="comment_form">
			<div class="col1">
			<p>
                <textarea rows="8" cols="50" name="comment" class="textarea"></textarea>
            </p>
			</div>
			<div class="col2">
            <?php if ( is_user_logged_in() ) : ?>
    		<p><?php _e('登录身份：'); ?><?php printf(__('<a href="%1$s">%2$s</a>，'), get_option('siteurl') . '/wp-admin/profile.php', $user_identity); ?> <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e('Log out of this account'); ?>"><?php _e('退出  &raquo;'); ?></p>
            <?php else: ?>
    		<p>
                <label for="author" class="required"><?php _e('称呼'); ?></label>
    			<input type="text" name="author" id="author" class="text" value="<?php echo $comment_author; ?>" />
    		</p>
    		<p>
                <label for="mail" class="required"><?php _e('邮箱'); ?></label>
    			<input type="email" name="email" id="mail" class="text" value="<?php echo $comment_author_email; ?>" />
    		</p>
    		<p>
                <label for="url"><?php _e('网站'); ?></label>
    			<input type="url" name="url" id="url" class="text" placeholder="<?php _e('http://example.com'); ?>" value="<?php echo $comment_author_url; ?>" />
    		</p>
            <?php endif; ?>
    		<p>
                <button type="submit" name="submit" class="submit"><?php _e('提交评论'); ?></button>
            </p>
			</div>
			<div class="clear"></div>
            <?php comment_id_fields(); ?> 
            <?php do_action('comment_form', $post->ID); ?>            
    	</form>
    </div>
    <?php endif; ?>
</div>