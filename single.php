<?php get_header(); ?>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <article>
        <div class="post-meta">
          <span class="post-date"><?php echo get_the_date(); ?></span>
          <span><?php the_category(', '); ?><?php the_tags('Tag:', ' -'); ?></span>
          <?php breadcrumbs(); ?>
        </div>
        <h2><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
        <?php if(has_post_thumbnail()) {
          the_post_thumbnail('post-thumbnail');
        } ?>
        <div class="clearfix">
          <?php the_content(); ?>
        </div>
      </article>
      <div class="pager clearfix">
        <?php
        if (get_next_post()){
          echo '<div class="next-left">',next_post_link( '%link', '%title', false),'</div>';
        }
        if (get_previous_post()){
          echo '<div class="prev-right">',previous_post_link( '%link', '%title', false),'</div>';
        }
        ?>
      </div>
      <?php comments_template(); ?>
    <?php endwhile; else: ?>
    <div id="error404">
    <h2>404エラーページ</h2>
    <p>すみません。お探しのページは見つかりませんでした。</p>
    <p>再度検索をお願いします。</p>
    <?php get_search_form(); ?>
    <br>
    <a href="javascript:history.back();" class="bg-danger">&lt;前のページに戻る&gt;</a>
  </div>
    <?php endif; ?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>