<div id="wpbody-content" aria-label="メインコンテンツ" tabindex="0" style="overflow: hidden;">
  <div class="wrap">

    <h1 class="wp-heading-inline">OGPセッティング</h1>
    <hr class="wp-header-end">

      <form method="post" action="themes.php?page=ogp_setting.php">
        <?php
        genelate(
          'ツイッターのアカウント名（@はいりません）',
          'ttr_act'
        );
        genelate(
          'facebook向けアプリID（fb:app_id）',
          'fb_app_id'
        );

        submit_button(); ?>

      </form>

  </div><!-- /.wrap-->
<div class="clear"></div>
</div><!-- wpbody-content -->
<div class="clear"></div>