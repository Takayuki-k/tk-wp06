<?php  get_header(); ?>
  <div id="error404">
    <h2>404エラーページ</h2>
    <p>すみません。お探しのページは見つかりませんでした。</p>
    <p>再度検索をお願いします。</p>
    <?php get_search_form(); ?>
    <br>
    <a href="javascript:history.back();" class="bg-danger">&lt;前のページに戻る&gt;</a>
  </div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>