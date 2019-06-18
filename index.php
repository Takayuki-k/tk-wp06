<?php get_header(); ?>
  <p class="font-italic lead border-dark border-bottom">New Topics</p>
  <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
      <article class="post">
        <a href="<?php the_permalink() ?>" class="thumbnail">
          <?php thumbnail_check($post->ID,'post-thumbnail'); ?>
        </a>
        <section>
          <h2><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo get_the_title(); ?></a></h2>
          <div class="post-meta">
            <span class="post-date"><?php echo get_the_date(); ?></span>
            <span><?php $category = get_the_category(); echo $category[0]->cat_name; ?></span>
          </div>
          <div class="article">
            <?php if (is_home()) {
              the_excerpt();
            } else {
              the_content();
            } ?>
          </div>
        </section>
      </article>
    <?php endwhile; ?>
    <!-- pager -->
    <?php get_template_part("format/pagination"); ?>
    <!-- /pager -->
  <?php else: ?>
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