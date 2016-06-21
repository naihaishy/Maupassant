
<div id="secondary-author">
  <section class="widget">
      <h2><?php the_author(); ?></h2>
      <h4>作者信息</h4>
    <p>描述:<?php the_author_description(); ?></p>
    <p>Email:<?php the_author_email(); ?></p>
    <p>Blog:<?php the_author_url(); ?></p>
    <p>已发表:<?php the_author_posts(); ?>篇</p>
    <p>所有文章:<?php  the_author_posts_link(); ?></p>
    <h4>文章</h4>
            <?php if(have_posts()): ?>
              <?php while(have_posts()):the_post(); ?>
                    <a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php the_title();?></a>
                    <p><?php the_time('Y-m-d H:i:s'); ?>  <?php the_category(', ') ?> <?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></p>
              <?php endwhile; ?>
            <?php endif; ?>
    <h4>收藏</h4>
    <h4>积分</h4>



  </section>


</div>
