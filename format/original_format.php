<?php

function temp_init() {
  //canonical_url削除
  remove_action('wp_head', 'rel_canonical');

  //URLの正規表現
  define('URL_REG', '/(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)/');

  // タイトルタグ
  add_theme_support( 'title-tag' );

  // RSS2のfeedリンクを出力
  add_theme_support( 'automatic-feed-links' );

  //WordPressのバージョン表示を削除
  remove_action('wp_head', 'wp_generator');

  //「絵文字」のコードを削除
  remove_action('wp_head', 'print_emoji_detection_script', 7);
  remove_action('wp_print_styles', 'print_emoji_styles');
  remove_action('admin_print_scripts', 'print_emoji_detection_script');
  remove_action('admin_print_styles', 'print_emoji_styles');

  remove_filter('the_content_feed', 'wp_staticize_emoji');
  remove_filter('comment_text_rss', 'wp_staticize_emoji');
  remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
  add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
  remove_action('wp_head', 'wp_print_head_scripts', 9);
  add_action('wp_footer', 'wp_print_head_scripts', 5);
  remove_action('wp_head', 'parent_post_rel_link', 10, 0 );


  //「投稿ツール」のためのコードを削除
  remove_action('wp_head', 'rsd_link');
  remove_action('wp_head', 'wlwmanifest_link');

  //ヘッダーに以下のようなタグが挿入されるWP4.4からの機能を解除
  //<link rel='https://api.w.org/' href='http:/xxxx/wordpress/wp-json/' />
  remove_action( 'wp_head', 'rest_output_link_wp_head' );

  //検索ワードが0や未入力のときにもsearch.phpを使う
  function search_template_redirect() {
    global $wp_query;
    $wp_query->is_search = true;
    $wp_query->is_home = false;
    if (file_exists(TEMPLATEPATH . '/search.php')) {
      include(TEMPLATEPATH . '/search.php');
    }
    exit;
  }
  if (isset($_GET['s']) && $_GET['s'] == false) {
    add_action('template_redirect', 'search_template_redirect');
  }

  //「プロフィール欄でHTMLタグを使えるようにする
  remove_filter( 'pre_user_description', 'wp_filter_kses' );

  //カテゴリー説明文でHTMLタグを使う
  remove_filter( 'pre_term_description', 'wp_filter_kses' );

  //外部ファイルのURLに付加されるver=を取り除く
  function vc_remove_wp_ver_css_js( $src ) {
      if ( strpos( $src, 'ver=' ) )
          $src = remove_query_arg( 'ver', $src );
      return $src;
  }
  add_filter( 'style_loader_src', 'vc_remove_wp_ver_css_js', 9999 );
  add_filter( 'script_loader_src', 'vc_remove_wp_ver_css_js', 9999 );

  //投稿ページ以外ではhentryクラスを削除する関数
  function remove_hentry( $classes ) {
    if ( !is_single() ) {
      $classes = array_diff($classes, array('hentry'));
    }
    //これらのクラスが含まれたページではhentryを削除する
    $ng_classes = array('type-forum', 'type-topic');//ここに追加していく
    $is_include = false;
    foreach ($ng_classes as $ng_class) {
      //NGのクラス名が含まれていないか調べる
      if ( in_array($ng_class, $classes) ) {
        $is_include = true;
      }
    }
    //含まれていたらhentryを削除する
    if ($is_include) {
      $classes = array_diff($classes, array('hentry'));
    }
    return $classes;
  }
  add_filter('post_class', 'remove_hentry');

  //カテゴリIDクラスをbodyクラスに含める
  if ( !function_exists( 'add_category_id_classes_to_body_classes' ) ):
  function add_category_id_classes_to_body_classes($classes) {
    global $post;
    if ( is_single() ) {
      foreach((get_the_category($post->ID)) as $category)
        $classes[] = 'categoryid-'.$category->cat_ID;
    }
    return $classes;
  }
  endif;
  add_filter('body_class', 'add_category_id_classes_to_body_classes');

  //Wordpress管理画面でJavaScriptファイルも編集できるようにする
  if ( !function_exists( 'add_js_to_wp_theme_editor_filetypes' ) ):
  function add_js_to_wp_theme_editor_filetypes($default_types){
    $default_types[] = 'js';
    return $default_types;
  }
  endif;
  add_filter('wp_theme_editor_filetypes', 'add_js_to_wp_theme_editor_filetypes');

  //短縮URLの表示
  add_filter( 'get_shortlink', function( $shortlink ) {return $shortlink;} );

  //CSS、JSファイルに編集時間を付加(キャッシュ対策)
  add_filter( 'style_loader_src', 'add_file_ver_to_css_js_demo');
  add_filter( 'script_loader_src', 'add_file_ver_to_css_js_demo');
  if ( !function_exists( 'add_file_ver_to_css_js_demo' ) ):
  function add_file_ver_to_css_js_demo( $src ) {
    //サーバー内のファイルの場合
    if (strpos( $src, site_url() ) !== false) {
      // //Wordpressのバージョンを除去する場合
      if ( strpos( $src, 'ver=' ) )
        $src = remove_query_arg( 'ver', $src );

      //クエリーを削除したファイルURLを取得
      $removed_src = preg_replace('{\?.+$}i', '', $src);
      //URLをパスに変換
      $resource_file = str_replace(site_url('/'), ABSPATH, $removed_src );
      //ファイルの編集時間バージョンを追加
      $src = add_query_arg( 'fver', date('Ymdhis', filemtime($resource_file)), $src );
    }
    return $src;
  }
  endif;
}
add_action('init', 'temp_init');

?>