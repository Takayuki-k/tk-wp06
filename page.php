<?php get_header(); ?>
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <article>
      <h2><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
      <div class="clearfix">
        <?php the_content(); ?>
      </div>
    </article>
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