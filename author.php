<?php get_header(); ?>
<?php get_sidebar('author'); ?>


<div class="col-8" id="main-author">
	<h1 style="text-align:center;-webkit-font-smoothing:antialiased;"><?php the_author(); ?></h1>
	<div class="res-cons">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<article class="post">
				<h4 class="post-title">
					<a href="<?php the_permalink() ?>"><?php the_title() ?></a>
				</h4>
				<ul class="post-meta">
					<li><?php the_time('F j, Y'); ?></li>
					<li class="comment-count"><?php comments_popup_link('0 条评论', ' 1 条评论', '% 条评论'); ?></li>
				</ul>
				<div class="post-content">
					<?php the_excerpt('阅读剩余部分 -'); ?>
				</div>
			</article>
		<?php endwhile; endif;?>
		<?php pagenavi();?>
	</div>
</div>

<?php get_footer(); ?>
